<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Matterstate;
use App\Models\Matter;
use App\Models\Influ;
use App\Models\Config1;

use App\Mail\MatterChatMail;
use App\Mail\MatterInfluJudgeMail;
use App\Mail\MatterClientJudgeMail;
use Mail;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MatterstateController extends Controller
{

    //運営者からの応募済み案件（店舗別）
    public function admin_client2_shopby(){
        $item=DB::table('matterstates')
        ->where('flag','0')
        ->get();

        $id_list=[];
        $name_list=[];
        foreach ($item as $value){
            $id_list[$value->matter_id]=$value->shop_id;
            $name_list[$value->matter_id]=$value->shop_name;
        }

        return view("administrator.admin_matter_shopby", ["id_list"=>$id_list,'name_list'=>$name_list]);
    }

    //運営者からの案件ステータス取得
    public function admin_client2($matter_id){
        $item = DB::table('matterstates')
        ->select('id','matter_id','influ_id','influ_name')
        ->where('flag','0')
        ->where('matter_id',$matter_id)
        ->get();

        $item2 = DB::table('matterstates')
        ->select('shop_id','shop_name')
        ->where('flag','0')
        ->where('matter_id',$matter_id)
        ->first();

        if (empty($item2)){
            return redirect("administrator/admin_matter_shopby");
        }

        return view("administrator.admin_matter", ["item"=>$item,"item2"=>$item2]);
    }

    //運営者のインフルエンサーの案件可否
    public function matter_judge(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $id=$request->hidden_id;
        $matter_id=$request->matter_id;
        $saiyou=$request->saiyou;

        $end="F";

        $item_matterstate=DB::table('matterstates')->where('id',$id)->first();
        $influ_id=$item_matterstate->influ_id;
        $influ_name=$item_matterstate->influ_name;

        $shop_id=$item_matterstate->shop_id;
        $shop_name=$item_matterstate->shop_name;

        $item_influ=DB::table('influs')->where('user_id',$influ_id)->first();
        $user_mail=$item_influ->user_mail;

        $item_client=DB::table('insyokus')->where('shop_id',$shop_id)->first();
        $shop_mail=$item_client->shop_mail;

        $item=DB::table('matters')->where('id',$matter_id)->first();
        $matter_name=$item->matter_name;

        //採用なら
        if ($saiyou==="T"){
            $result="採用";
            $msg="採用しました。";
            $flag="1";
            $subject="【".Config::get('const.title.title45')."】{$matter_name}に採用されました。";

            $matter_num=$item->matter_num;
            $matter_num_now=$item->matter_num_now;

            $matter_num_now_1=$matter_num_now+1;


            if ($matter_num===$matter_num_now_1){  //募集終了
                $end="T";
                DB::table('matters')->where('id', $matter_id)->update(['end_flag' => 'T','matter_num_now'=>$matter_num_now_1]);
            }elseif ($matter_num<$matter_num_now_1){
                $msg="既に採用人数に達しています。";
                return redirect("administrator/admin_matter/$matter_id")->with('msgs', $msg);
                exit;
            }else{

                DB::table('matters')->where('id', $matter_id)->update(['matter_num_now'=>$matter_num_now_1, 'flag'=>'2']);
            }

        }
        if ($saiyou==="F"){
            $result="不採用";
            $msg="不採用にしました。";
            $flag="2";
            $subject="【".Config::get('const.title.title45')."】{$matter_name}に不採用のご連絡。";
        }

        $mail_param=[
            'influ_name'=>$influ_name,
            'result'=>$result,
            'shop_name'=>$shop_name,
            'subject'=>$subject,
            'matter_name'=>$matter_name,
        ];
        Mail::to($user_mail)->send(new MatterInfluJudgeMail($mail_param));

        if ($result==="採用"){
            $subject_client="【".Config::get('const.title.title45')."】{$matter_name}に採用されました。";
            $mail_param=[
                'influ_name'=>$influ_name,
                'end'=>$end,
                'shop_name'=>$shop_name,
                'subject'=>$subject_client,
                'matter_name'=>$matter_name,
            ];
            Mail::to($shop_mail)->send(new MatterClientJudgeMail($mail_param));
        }

        DB::table('matters')->where('id', $matter_id)->update(['flag' => '2']);

        DB::table('matterstates')->where('id', $id)->update(['flag' => $flag]);
        return redirect("administrator/admin_matter/$matter_id")->with('msgs', $msg);
    }

    //店舗クライアントからの案件ごとの情報取得
    public function index($id){
        if (session()->has("shop_id")){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect(Config::get('const.title.title47'));
        }

        $matter_item=DB::table('matters')->where('id',$id)->first();
        $matter_flag=$matter_item->flag;
        $end_date=$matter_item->end_date;


        $item = DB::table('matterstates')->select('id','influ_name','flag','date_result','time_result','member_result')->whereIn('flag',[1,3,4,5])
                                                                                                                 ->where('matter_id',$id)
                                                                                                                 ->where('shop_id',$shop_id)
                                                                                                                 ->get();
        $flag_list=[
            '1'=>'採用',
            '3'=>'日程確定',
            '4'=>'投稿報告1完了',
            '5'=>'投稿報告2完了',
        ];

        return view(Config::get('const.title.title47').".matter_state", ["item"=>$item,'flag_list'=>$flag_list,'id'=>$id,'matter_flag'=>$matter_flag,'end_date'=>$end_date]);
    }

    //店舗クライアントの案件完了報告
    public function client1_finish(Request $request){
        $matter_id=$request->hidden_id;
        $today=date('Y-m-d');

        DB::table('matters')
        ->where('id',$matter_id)
        ->update(['end_date'=>$today]);

        $msg='案件の完了報告を行いました。';

        return redirect(Config::get('const.title.title47')."/matter_state/$matter_id")->with('msg',$msg);
    }


    //店舗クライアントからのインフルエンサーごとの情報取得
    public function index_detail($id){
        if (session()->has('shop_id')){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect(Config::get('const.title.title47'));
        }

        $item = DB::table('matterstates')->where('shop_id',$shop_id)
                                         ->where('influ_id',$id)
                                         ->first();

        $flag=$item->flag;

        $items=[
            'post_deadline1'=>$item->post_deadline1,
            'post_deadline2'=>$item->post_deadline2,

        ];

        $post1=[
            'instagram_url1'=>$item->instagram_url1,
            'instagram_url2'=>$item->instagram_url2,
            'instagram_url3'=>$item->instagram_url3,
            'instagram_url4'=>$item->instagram_url4,
            'instagram_url5'=>$item->instagram_url5,
            'insite_path1'=>$item->insite_path1,
            'insite_path2'=>$item->insite_path2,
            'insite_path3'=>$item->insite_path3,
            'insite_path4'=>$item->insite_path4,
            'insite_path5'=>$item->insite_path5,
            'story_url1'=>$item->story_url1,
            'story_url2'=>$item->story_url2,
            'story_url3'=>$item->story_url3,
            'taberogu_url'=>$item->taberogu_url,
            'google_url'=>$item->google_url,
            'blog_url'=>$item->blog_url,
        ];
    }

    //インフルエンサーの案件への応募
    public function client2_oubo(Request $request){

        $matter_id=$request->id;
        $shop_id=$request->shop_id;
        $shop_name=$request->shop_name;

        if (session()->has('user_id')){
            $influ_id=session()->get("user_id");
        }else{
            return redirect(Config::get('const.title.title48'));
        }
        $influ_name=session()->get("user_name");

        $item_count=DB::table('matterstates')->where('matter_id', $matter_id)
        ->where('influ_id',$influ_id)
        ->count();

        if ($item_count===0){
            $msg="応募完了しました。";
            //チャットのテキストファイルパス
            $chat_path="matter_chat/$matter_id-$influ_id.txt";
            touch($chat_path);
            $param=[
                'matter_id'=>$matter_id,
                'influ_id'=>$influ_id,
                'influ_name'=>$influ_name,
                'shop_id'=>$shop_id,
                'shop_name'=>$shop_name,
                'chat_path'=>$chat_path,
                'flag'=>'0',
            ];
            DB::table('matterstates')->insert($param);
        }else{
            $msg="既に応募済みです。";
        }

        return redirect(Config::get('const.title.title48').'/matter')->with('msgs', $msg);
    }

    //インフルエンサーからの応募済み案件一覧取得
    public function client2_index(){
        if (session()->has('user_id')){
            $influ_id=session()->get("user_id");
        }else{
            return redirect(Config::get('const.title.title48'));
        }

        $item = DB::table('matterstates')->select('id','matter_id','shop_name','flag','date_result','time_result')->whereIn('flag',['0','1','3','4','5'])
        ->where('influ_id',$influ_id)
        ->get();


        $flag_list=[
            '0'=>'応募中',
            '1'=>'採用',
            '3'=>'日程確定',
            '4'=>'投稿報告1完了',
            '5'=>'投稿報告2完了',
        ];


        return view(Config::get('const.title.title48').".matter_already", ["item"=>$item,'flag_list'=>$flag_list]);

    }

    //インフルエンサー案件チャット
    public function client2_chat($id){
        $item = DB::table('matterstates')->where('id',$id)->first();
        $chat_path=$item->chat_path;
        $whose=$item->whose;

        $f=file($chat_path);

        $matter_id=$item->matter_id;
        $shop_name=$item->shop_name;
        $flag=$item->flag;  //フラグを取得

        return view(Config::get('const.title.title48').".chat_matter",['flag'=>$flag,'msg'=>$f,'shop_name'=>$shop_name,'whose'=>$whose,'id'=>$id]);

    }

    //インフルエンサー案件報告取得
    public function matter_format($id){
        $item=DB::table('matterstates')
        ->where('id',$id)->first();
        $hurry="";

        $matter_id=$item->matter_id;
        $flag=$item->flag;
        $shop_name=$item->shop_name;
        $questionaire=$item->questionaire;

        //来店後アンケート項目
        $item_ques=DB::table('configs')->where('id','1')->first();

        $items_ques=[
            'question1'=>$item_ques->question1,
            'question2'=>$item_ques->question2,
            'question3'=>$item_ques->question3,
            'question4'=>$item_ques->question4,
            'question5'=>$item_ques->question5,
            'question6'=>$item_ques->question6,
            'question7'=>$item_ques->question7,
            'question8'=>$item_ques->question8,
            'question9'=>$item_ques->question9,
            'question10'=>$item_ques->question10,
            'question11'=>$item_ques->question11,
            'question12'=>$item_ques->question12,
            'question13'=>$item_ques->question13,
            'question14'=>$item_ques->question14,
            'question15'=>$item_ques->question15,
            'question16'=>$item_ques->question16,
            'question17'=>$item_ques->question17,
            'question18'=>$item_ques->question18,
            'question19'=>$item_ques->question19,
            'question20'=>$item_ques->question20,
        ];

        if ($flag==="3"){
            $hissu_item = DB::table('configs')->where('id','1')->first();
            $hissu_list=[
                'story1'=>$hissu_item->story1,
                'story2'=>$hissu_item->story2,
                'story3'=>$hissu_item->story3,
                'taberogu'=>$hissu_item->taberogu,
                'google'=>$hissu_item->google,
                'blog'=>$hissu_item->blog,
            ];

            $item_config = DB::table('configs')->where('id',1)->first();

            $item_configs=[
                'story1'=>$item_config->story1,
                'story2'=>$item_config->story2,
                'story3'=>$item_config->story3,
                'taberogu'=>$item_config->taberogu,
                'google'=>$item_config->google,
                'blog'=>$item_config->blog,
            ];

            $post_deadline1=$item->post_deadline1;
            $today = date("Y-m-d");

            if ($post_deadline1<$today){
                $hurry="投稿報告1の期限が過ぎています。";
            }
            return view(Config::get('const.title.title48').".matter_format", ['hurry'=>$hurry,'hissu_list'=>$hissu_list,'item_config'=>$item_configs,'questionaire'=>$questionaire,'item'=>$item,'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'post_deadline1'=>$post_deadline1,'item_ques'=>$items_ques]);

        }elseif ($flag==="4"){
            $post_deadline2=$item->post_deadline2;
            $today = date("Y-m-d");

            if ($post_deadline2<$today){
                $hurry="投稿報告2の期限が過ぎています。";
            }

            return view(Config::get('const.title.title48').".matter_format", ['hurry'=>$hurry,'questionaire'=>$questionaire,'item'=>$item,'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'post_deadline2'=>$post_deadline2,'item_ques'=>$items_ques]);
        }
    }

    //インフルエンサー案件進行
    public function influ_matterstate($id){
        $item = DB::table('matterstates')->where('id',$id)->first();

        $reserve_name=$item->reserve_name;

        $allergy_list=[
            'allergy1'=>$item->allergy1,
            'allergy2'=>$item->allergy2,
            'allergy3'=>$item->allergy3,
            'allergy4'=>$item->allergy4,
            'allergy5'=>$item->allergy5,
        ];

        $come=$item->come;

        $chat_path=$item->chat_path;
        $whose=$item->whose;

        $f=file($chat_path);

        $matter_id=$item->matter_id;
        $shop_name=$item->shop_name;

        $flag=$item->flag;  //フラグを取得

        if ($flag==="0"){  //応募段階
            return view(Config::get('const.title.title48').".matter_already_detail",['flag'=>$flag]);

        }elseif ($flag==="1"){  //採用のみ

            if (!empty($item->time1))
                $time1=date('H:i',  strtotime($item->time1));
            else{
                $time1="";
            }
            if (!empty($item->time2))
                $time2=date('H:i',  strtotime($item->time2));
            else{
                $time2="";
            }
            if (!empty($item->time3))
                $time3=date('H:i',  strtotime($item->time3));
            else{
                $time3="";
            }

            $items=[
                'date1'=>$item->date1,
                'time1'=>$time1,
                'member1'=>$item->member1,
                'date2'=>$item->date2,
                'time2'=>$time2,
                'member2'=>$item->member2,
                'date3'=>$item->date3,
                'time3'=>$time3,
                'member3'=>$item->member3,
            ];


            return view(Config::get('const.title.title48').".matter_already_detail", ['reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag]);
        }elseif ($flag==="3"){  //日程確定後
            $time_result=date('H:i',  strtotime($item->time_result));

            $items=[
                'reserve_name'=>$item->reserve_name,
                'date_result'=>$item->date_result,
                'time_result'=>$time_result,
                'member_result'=>$item->member_result,
                'post_deadline1'=>$item->post_deadline1,
            ];

            $param=[
                'reserve_name'=>'予約名',
                'date_result'=>'確定日',
                'time_result'=>'確定時間',
                'member_result'=>'確定同伴人数',
                'post_deadline1'=>'投稿報告1期限',
            ];

            $hissu_item = DB::table('configs')->where('id','1')->first();
            $hissu_list=[
                'story1'=>$hissu_item->story1,
                'story2'=>$hissu_item->story2,
                'story3'=>$hissu_item->story3,
                'taberogu'=>$hissu_item->taberogu,
                'google'=>$hissu_item->google,
                'blog'=>$hissu_item->blog,
            ];

            $questionaire=$item->questionaire;

            $item_config = DB::table('configs')->where('id',1)->first();

            $item_configs=[
                'story1'=>$item_config->story1,
                'story2'=>$item_config->story2,
                'story3'=>$item_config->story3,
                'taberogu'=>$item_config->taberogu,
                'google'=>$item_config->google,
                'blog'=>$item_config->blog,
            ];

            $post_deadline1=$item->post_deadline1;
            $today = date("Y-m-d");

            if ($post_deadline1<$today){
                $hurry="投稿報告1の期限が過ぎています。";
                return view(Config::get('const.title.title48').".matter_already_detail", ['come'=>$come,'hurry'=>$hurry,'hissu_list'=>$hissu_list,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item_config'=>$item_configs,'questionaire'=>$questionaire,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'param'=>$param]);
            }


            return view(Config::get('const.title.title48').".matter_already_detail", ['come'=>$come,'hissu_list'=>$hissu_list,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item_config'=>$item_configs,'questionaire'=>$questionaire,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'param'=>$param]);

        }elseif ($flag==="4"){  //投稿報告1完了
            $items=[
                'instagram_url1'=>$item->instagram_url1,
                'instagram_url2'=>$item->instagram_url2,
                'instagram_url3'=>$item->instagram_url3,
                'instagram_url4'=>$item->instagram_url4,
                'instagram_url5'=>$item->instagram_url5,
                'story_url1'=>$item->story_url1,
                'story_url2'=>$item->story_url2,
                'story_url3'=>$item->story_url3,
                'taberogu_url'=>$item->taberogu_url,
                'google_url'=>$item->google_url,
                'blog_url'=>$item->blog_url,
                'other_url1'=>$item->other_url1,
                'other_url2'=>$item->other_url2,
                'other_url3'=>$item->other_url3,
            ];

            $param=[
                'instagram_url1'=>'インスタグラムURL1',
                'instagram_url2'=>'インスタグラムURL2',
                'instagram_url3'=>'インスタグラムURL3',
                'instagram_url4'=>'インスタグラムURL4',
                'instagram_url5'=>'インスタグラムURL5',
                'story_url1'=>'ストーリーズURL1',
                'story_url2'=>'ストーリーズURL2',
                'story_url3'=>'ストーリーズURL3',
                'taberogu_url'=>'食べログURL',
                'google_url'=>'Google Map URL',
                'blog_url'=>'ブログURL',
                'other_url1'=>'その他URL1',
                'other_url2'=>'その他URL2',
                'other_url3'=>'その他URL3',
            ];

            $post_deadline2=$item->post_deadline2;
            $questionaire=$item->questionaire;

            $today = date("Y-m-d");
            if ($post_deadline2<$today){
                $hurry="投稿報告2の期限が過ぎています。";
                return view(Config::get('const.title.title48').".matter_already_detail", ['hurry'=>$hurry,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'post_deadline2'=>$post_deadline2,'questionaire'=>$questionaire,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'param'=>$param]);
            }
            return view(Config::get('const.title.title48').".matter_already_detail", ['reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'post_deadline2'=>$post_deadline2,'questionaire'=>$questionaire,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'param'=>$param]);

        }elseif ($flag==="5"){
            $items=[
                'instagram_url1'=>$item->instagram_url1,
                'instagram_url2'=>$item->instagram_url2,
                'instagram_url3'=>$item->instagram_url3,
                'instagram_url4'=>$item->instagram_url4,
                'instagram_url5'=>$item->instagram_url5,
                'story_url1'=>$item->story_url1,
                'story_url2'=>$item->story_url2,
                'story_url3'=>$item->story_url3,
                'taberogu_url'=>$item->taberogu_url,
                'google_url'=>$item->google_url,
                'blog_url'=>$item->blog_url,
                'other_url1'=>$item->other_url1,
                'other_url2'=>$item->other_url2,
                'other_url3'=>$item->other_url3,
            ];

            $param=[
                'instagram_url1'=>'インスタグラムURL1',
                'instagram_url2'=>'インスタグラムURL2',
                'instagram_url3'=>'インスタグラムURL3',
                'instagram_url4'=>'インスタグラムURL4',
                'instagram_url5'=>'インスタグラムURL5',
                'story_url1'=>'ストーリーズURL1',
                'story_url2'=>'ストーリーズURL2',
                'story_url3'=>'ストーリーズURL3',
                'taberogu_url'=>'食べログURL',
                'google_url'=>'Google Map URL',
                'blog_url'=>'ブログURL',
                'other_url1'=>'その他URL1',
                'other_url2'=>'その他URL2',
                'other_url3'=>'その他URL3',
            ];

            $items2=[
                'insite_path1'=>$item->insite_path1,
                'insite_path2'=>$item->insite_path2,
                'insite_path3'=>$item->insite_path3,
                'insite_path4'=>$item->insite_path4,
                'insite_path5'=>$item->insite_path5,
            ];
            return view(Config::get('const.title.title48').".matter_already_detail", ['reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item'=>$items,'item2'=>$items2,'id'=>$id,'matter_id'=>$matter_id,'shop_name'=>$shop_name,'flag'=>$flag,'param'=>$param]);

        }else{
            $msgs="何らかの不具合が発生しています。";
            return redirect(Config::get('const.title.title48')."/matter_already_detail/$id")->with('msgs', $msgs);
        }
    }

    //インフルエンサーによる案件進行時のPOST処理
    public function client2_post(Request $request){
        if (!session()->has("user_id")){
            return redirect(Config::get('const.title.title48'));
        }

        $hidden=$request->hidden;
        $id=$request->hidden_id;


        $item_already = DB::table('matterstates')->where('id', $id)->first();
        $matter_id=$item_already->matter_id;

        $mail_name=$item_already->shop_name;
        $mail_id=$item_already->shop_id;
        $item_insyoku = DB::table('insyokus')->where('shop_id', $mail_id)->first();
        $mail_email=$item_insyoku->shop_mail;

        $mail_param=[
            'mail_name'=>$mail_name,
            'hidden'=>$hidden,
            'from'=>'I',
        ];



        if ($hidden==="1"){  //チャットの処理

            $today=date('m-d');

            $whose_kari=$request->whose;
            $whose="{$whose_kari}0";

            $comment=$request->comment;

            $item = DB::table('matterstates')->where('id', $id)->first();
            $chat_path=$item->chat_path;

            DB::table('matterstates')
                            ->where('id', $id)
                            ->update(['whose'=>$whose]);

            $f = fopen($chat_path, "a+");  //追記モードで開く
            flock($f, LOCK_EX); // ファイルをロックする

            // fwrite($f, "<>{$today}\n".$comment."\n");  //<>で追記
            fwrite($f, $comment."\n");  //<>で追記
            fwrite($f, "<>$today"."\n");  //<>で追記
            fclose($f);

            $msgs="送信しました。";



        }elseif ($hidden==="2"){  //アレルギー・予約名登録
            $reserve_name=$request->reserve_name;
            $allergy=$request->allergy;

            $param=[
                'reserve_name'=>$reserve_name,
            ];

            $i=1;
            foreach ($allergy as $value){
                if (!empty($value)){
                    $param["allergy$i"]=$value;
                    $i+=1;
                }
            }
            DB::table('matterstates')
            ->where('id', $id)
            ->update($param);

            $msgs="更新しました。";

        }elseif ($hidden==="3"){  //投稿報告1

            $today = date("Y-m-d");
            $deadline2=date("Y-m-d",strtotime("$today +7 day"));


            $param=[
                'instagram_url1'=>$request->instagram1,
                'instagram_url2'=>$request->instagram2,
                'instagram_url3'=>$request->instagram3,
                'instagram_url4'=>$request->instagram4,
                'instagram_url5'=>$request->instagram5,
                'story_url1'=>$request->story1,
                'story_url2'=>$request->story2,
                'story_url3'=>$request->story3,
                'taberogu_url'=>$request->taberogu,
                'google_url'=>$request->google,
                'blog_url'=>$request->blog,
                'other_url1'=>$request->other1,
                'other_url2'=>$request->other2,
                'other_url3'=>$request->other3,
                'flag'=>'4',
                'post_deadline2'=>$deadline2,
            ];



            DB::table('matterstates')
            ->where('id', $id)
            ->update($param);

            //案件ステータスを4に
            DB::table('matters')
            ->where('id', $matter_id)
            ->update(['flag'=>'4']);

            $msgs="投稿報告1を完了しました。";

        }elseif ($hidden==="4"){  //投稿報告2
            $files=$request->file('insite');
            $dir_path="public/matterstate/";
            $file_path="matter-$id/";


            $i=1;
            foreach ($files as $file){
                if (!empty($file)){
                    $file_kari= $file->getClientOriginalName();
                    $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
                    $file_name="insite{$i}.{$extension}";


                    $file->storeAS('',$dir_path.$file_path.$file_name);
                    $param["insite_path$i"]=$file_path.$file_name;

                    $i+=1;
                }

            }
            $param['flag']='5';

            DB::table('matterstates')
            ->where('id', $id)
            ->update($param);

            $msgs="投稿報告2を完了しました。";
        }elseif ($hidden==="5"){  //来店後アンケート（メールなし）
            $param=[
                'menu1'=>$request->menu1,
                'menu2'=>$request->menu2,
                'service_value'=>$request->selector1,
                'service_value_memo'=>$request->service_value_memo,
                'price_value'=>$request->selector2,
                'notice_memo'=>$request->notice_memo,
                'notice_other'=>$request->notice_other,
                'questionaire'=>'1',
            ];

            $notice=$request->notice;
            $i=1;
            foreach ($notice as $value){
                $param["notice$i"]=$value;
                $i+=1;
            }



            DB::table('matterstates')->where('id',$id)
            ->update($param);

            $msgs='来店後アンケートを提出しました。';
            return redirect(Config::get('const.title.title48')."/matter/$id")->with('msgs', $msgs);
        }


        Mail::to($mail_email)->send(new MatterChatMail($mail_param));

        if ($hidden==="1"){
            return redirect(Config::get('const.title.title48')."/chat_matter/$id")->with('msgs', $msgs);
        }
        return redirect(Config::get('const.title.title48')."/matter")->with('msgs', $msgs);

    }

    //店舗クライアントによる案件進行時のGET処理
    public function client1_matterstate($id){
        $item = DB::table('matterstates')->where('id',$id)->first();

        $reserve_name=$item->reserve_name;

        $allergy_list=[
            'allergy1'=>$item->allergy1,
            'allergy2'=>$item->allergy2,
            'allergy3'=>$item->allergy3,
            'allergy4'=>$item->allergy4,
            'allergy5'=>$item->allergy5,
        ];

        $bikou=$item->bikou;

        $come=$item->come;

        $chat_path=$item->chat_path;
        $whose=$item->whose;

        $f=file($chat_path);

        $matter_id=$item->matter_id;
        $influ_name=$item->influ_name;
        $influ_id=$item->influ_id;

        $flag=$item->flag;  //フラグを取得


        if ($flag==="1"){  //採用段階

            if (!empty($item->time1))
                $time1=date('H:i',  strtotime($item->time1));
            else{
                $time1="";
            }
            if (!empty($item->time2))
                $time2=date('H:i',  strtotime($item->time2));
            else{
                $time2="";
            }
            if (!empty($item->time3))
                $time3=date('H:i',  strtotime($item->time3));
            else{
                $time3="";
            }

            $items=[
                'date1'=>$item->date1,
                'time1'=>$time1,
                'member1'=>$item->member1,
                'date2'=>$item->date2,
                'time2'=>$time2,
                'member2'=>$item->member2,
                'date3'=>$item->date3,
                'time3'=>$time3,
                'member3'=>$item->member3,
            ];

            return view(Config::get('const.title.title47').".matter_state_detail", ['bikou'=>$bikou,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'influ_name'=>$influ_name,'influ_id'=>$influ_id,'flag'=>$flag]);

        }elseif ($flag==="3"){  //日程確定後
            $time_result=date('H:i',  strtotime($item->time_result));

            $items=[
                'reserve_name'=>$item->reserve_name,
                'date_result'=>$item->date_result,
                'time_result'=>$time_result,
                'member_result'=>$item->member_result,
                'post_deadline1'=>$item->post_deadline1,
            ];




            $param=[
                'reserve_name'=>'予約名',
                'date_result'=>'確定日',
                'time_result'=>'確定時間',
                'member_result'=>'確定同伴人数',
                'post_deadline1'=>'投稿報告1期限',
            ];

            $post_deadline1=$item->post_deadline1;
            $questionaire=$item->questionaire;


            return view(Config::get('const.title.title47').".matter_state_detail", ['come'=>$come,'bikou'=>$bikou,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'influ_name'=>$influ_name,'influ_id'=>$influ_id,'flag'=>$flag,'param'=>$param,'questionaire'=>$questionaire,'post_deadline1'=>$post_deadline1]);

        }elseif ($flag==='4'){  //投稿1完了
            $items=[
                'instagram_url1'=>$item->instagram_url1,
                'instagram_url2'=>$item->instagram_url2,
                'instagram_url3'=>$item->instagram_url3,
                'instagram_url4'=>$item->instagram_url4,
                'instagram_url5'=>$item->instagram_url5,
                'story_url1'=>$item->story_url1,
                'story_url2'=>$item->story_url2,
                'story_url3'=>$item->story_url3,
                'taberogu_url'=>$item->taberogu_url,
                'google_url'=>$item->google_url,
                'blog_url'=>$item->blog_url,
                'other_url1'=>$item->other_url1,
                'other_url2'=>$item->other_url2,
                'other_url3'=>$item->other_url3,
            ];

            $param=[
                'instagram_url1'=>'インスタグラムURL1',
                'instagram_url2'=>'インスタグラムURL2',
                'instagram_url3'=>'インスタグラムURL3',
                'instagram_url4'=>'インスタグラムURL4',
                'instagram_url5'=>'インスタグラムURL5',
                'story_url1'=>'ストーリーズURL1',
                'story_url2'=>'ストーリーズURL2',
                'story_url3'=>'ストーリーズURL3',
                'taberogu_url'=>'食べログURL',
                'google_url'=>'Google Map URL',
                'blog_url'=>'ブログURL',
                'other_url1'=>'その他URL1',
                'other_url2'=>'その他URL2',
                'other_url3'=>'その他URL3',
            ];

            $post_deadline2=$item->post_deadline2;
            $questionaire=$item->questionaire;

            return view(Config::get('const.title.title47').".matter_state_detail", ['bikou'=>$bikou,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item'=>$items,"msg"=>$f,'whose'=>$whose, 'id'=>$id,'matter_id'=>$matter_id,'influ_name'=>$influ_name,'influ_id'=>$influ_id,'flag'=>$flag,'param'=>$param,'questionaire'=>$questionaire,'post_deadline2'=>$post_deadline2]);

        }elseif ($flag==="5"){  //全行程完了
            $items=[
                'instagram_url1'=>$item->instagram_url1,
                'instagram_url2'=>$item->instagram_url2,
                'instagram_url3'=>$item->instagram_url3,
                'instagram_url4'=>$item->instagram_url4,
                'instagram_url5'=>$item->instagram_url5,
                'story_url1'=>$item->story_url1,
                'story_url2'=>$item->story_url2,
                'story_url3'=>$item->story_url3,
                'taberogu_url'=>$item->taberogu_url,
                'google_url'=>$item->google_url,
                'blog_url'=>$item->blog_url,
                'other_url1'=>$item->other_url1,
                'other_url2'=>$item->other_url2,
                'other_url3'=>$item->other_url3,
            ];

            $param=[
                'instagram_url1'=>'インスタグラムURL1',
                'instagram_url2'=>'インスタグラムURL2',
                'instagram_url3'=>'インスタグラムURL3',
                'instagram_url4'=>'インスタグラムURL4',
                'instagram_url5'=>'インスタグラムURL5',
                'story_url1'=>'ストーリーズURL1',
                'story_url2'=>'ストーリーズURL2',
                'story_url3'=>'ストーリーズURL3',
                'taberogu_url'=>'食べログURL',
                'google_url'=>'Google Map URL',
                'blog_url'=>'ブログURL',
                'other_url1'=>'その他URL1',
                'other_url2'=>'その他URL2',
                'other_url3'=>'その他URL3',
            ];

            $items2=[
                'insite_path1'=>$item->insite_path1,
                'insite_path2'=>$item->insite_path2,
                'insite_path3'=>$item->insite_path3,
                'insite_path4'=>$item->insite_path4,
                'insite_path5'=>$item->insite_path5,
            ];

            $questionaire=$item->questionaire;

            return view(Config::get('const.title.title47').".matter_state_detail", ['questionaire'=>$questionaire,'bikou'=>$bikou,'reserve_name'=>$reserve_name,'allergy_list'=>$allergy_list,'item'=>$items, 'item2'=>$items2, 'id'=>$id,'matter_id'=>$matter_id,'influ_name'=>$influ_name,'influ_id'=>$influ_id,'flag'=>$flag,'param'=>$param]);

        }else{
            $msgs="何らかの不具合が発生しています。";
            return redirect(Config::get('const.title.title47')."/matter_state_detail/$id")->with('msgs', $msgs);
        }
    }

    //クライアントによる案件進行時のPOST処理
    public function client1_post(Request $request){
        if (!session()->has("shop_id")){
            return redirect(Config::get('const.title.title47'));
        }

        $hidden=$request->hidden;
        $id=$request->hidden_id;

        $item_already = DB::table('matterstates')->where('id', $id)->first();
        $mail_name=$item_already->influ_name;
        $mail_id=$item_already->influ_id;
        $item_influ = DB::table('influs')->where('user_id', $mail_id)->first();
        $mail_email=$item_influ->user_mail;

        $mail_param=[
            'mail_name'=>$mail_name,
            'hidden'=>$hidden,
            'from'=>'C',
        ];

        if ($hidden==="1"){  //チャットの処理
            $today=date('m-d');

            $whose_kari=$request->whose;
            $whose="{$whose_kari}1";

            $comment=$request->comment;

            $item = DB::table('matterstates')->where('id', $id)->first();
            $chat_path=$item->chat_path;

            DB::table('matterstates')
                            ->where('id', $id)
                            ->update(['whose'=>$whose]);

            $f = fopen($chat_path, "a+");  //追記モードで開く
            flock($f, LOCK_EX); // ファイルをロックする

            fwrite($f, $comment."\n");  //<>で追記
            fwrite($f, "<>$today"."\n");  //<>で追記
            fclose($f);

            $msgs="送信しました。";


        }elseif ($hidden==="2"){  //希望日程
            $where=$request->selector1;

            $mail_param['date']=$request->dates;
            $mail_param['time']=$request->times;
            $mail_param['member']=$request->members;
            $mail_param['where']=$where;

            if ($where==="1"){
                $param=[
                    'date1'=>$request->dates,
                    'time1'=>$request->times,
                    'member1'=>$request->members,
                ];
                $msgs="希望1を更新しました。";
            }elseif ($where==="2"){
                $param=[
                    'date2'=>$request->dates,
                    'time2'=>$request->times,
                    'member2'=>$request->members,
                ];
                $msgs="希望2を更新しました。";
            }elseif ($where==="3"){
                $param=[
                    'date3'=>$request->dates,
                    'time3'=>$request->times,
                    'member3'=>$request->members,
                ];
                $msgs="希望3を更新しました。";
            }elseif ($where==="4"){
                $param=[
                    'date_result'=>$request->dates,
                    'time_result'=>$request->times,
                    'member_result'=>$request->members,
                    'flag'=>'3',
                ];

                //投稿報告1の期限設定
                $result_dates=strtotime($request->dates);
                $result_dates=date('Y-m-d',$result_dates);


                $item_matter_id = DB::table('matterstates')->where('id', $id)->first();
                $matter_id=$item_matter_id->matter_id;

                $item_deadline = DB::table('matters')->where('id', $matter_id)->first();
                $post_deadline=$item_deadline->post_deadline;

                if ($post_deadline==="A"){
                    $deadline1=date("Y-m-d",strtotime("$result_dates +3 day"));
                }elseif ($post_deadline==="B"){
                    $deadline1=date("Y-m-d",strtotime("$result_dates +5 day"));
                }elseif ($post_deadline==="C"){
                    $deadline1=date("Y-m-d",strtotime("$result_dates +7 day"));
                }else{
                    $msgs="エラー";
                    return redirect(Config::get('const.title.title47')."/matter_state_detail/$id")->with('msgs', $msgs);
                }

                $param['post_deadline1']=$deadline1;

                $msgs="予約内容を確定しました。";
            }else{
                $msgs="エラー";
                return redirect(Config::get('const.title.title47')."/matter_state_detail/$id")->with('msgs', $msgs);
            }
            DB::table('matterstates')
            ->where('id', $id)
            ->update($param);

        }elseif ($hidden==="raiten"){  //来店確認時
            $item_matter = DB::table('matterstates')->where('id', $id)->first();
            $matter_id=$item_matter->matter_id;

            DB::table('matterstates')
            ->where('id', $id)
            ->update(['come'=>'T']);

            DB::table('matters')
            ->where('id', $matter_id)
            ->update(['flag'=>'3']);

            $msgs="来店確認を登録しました。";


        }elseif ($hidden==="kihon"){

            $allergy=$request->input("allergy");

            $param=[
                'reserve_name'=>$request->reserve_name,
                'bikou'=>$request->bikou,
            ];
            for ($i=1;$i<=5;$i++){
                $param["allergy$i"]=null;
            }
            $i=1;
            foreach ($allergy as $value){
                $param["allergy$i"]=$value;
                $i+=1;
            }

            DB::table('matterstates')
            ->where('id',$id)
            ->update($param);

            $msgs="予約名・アレルギー情報を更新しました。";
        }



        Mail::to($mail_email)->send(new MatterChatMail($mail_param));

        return redirect(Config::get('const.title.title47')."c/matter_state_detail/$id")->with('msgs', $msgs);

    }

    //アンケート結果確認
    public function question_result($id){

        $item=DB::table('matterstates')->where('id',$id)->first();

        $items=[
            'menu1'=>$item->menu1,
            'menu2'=>$item->menu2,
            'service_value'=>$item->service_value,
            'price_value'=>$item->price_value,
        ];
        $param=[
            'menu1'=>'美味しかったメニュー',
            'menu2'=>'美味しくなかったメニュー',
            'service_value'=>'接客評価（10段階評価）',
            'price_value'=>'価格への満足度（5段階評価）',
        ];

        $items2=[
            'notice1'=>$item->notice1,
            'notice2'=>$item->notice2,
            'notice3'=>$item->notice3,
            'notice4'=>$item->notice4,
            'notice5'=>$item->notice5,
            'notice6'=>$item->notice6,
            'notice7'=>$item->notice7,
            'notice8'=>$item->notice8,
            'notice9'=>$item->notice9,
            'notice10'=>$item->notice10,
            'notice11'=>$item->notice11,
            'notice12'=>$item->notice12,
            'notice13'=>$item->notice13,
            'notice14'=>$item->notice14,
            'notice15'=>$item->notice15,
            'notice16'=>$item->notice16,
            'notice17'=>$item->notice17,
            'notice18'=>$item->notice18,
            'notice19'=>$item->notice19,
            'notice20'=>$item->notice20,
        ];

        $service_value_memo=$item->service_value_memo;
        $notice_memo=$item->notice_memo;
        $notice_other=$item->notice_other;

        return view(Config::get('const.title.title47').".matter_questionaire", ['id'=>$id,'item'=>$items,'item2'=>$items2,'param'=>$param,'notice_other'=>$notice_other,'notice_memo'=>$notice_memo,'service_value_memo'=>$service_value_memo]);

    }

    //クライアント向け報告フォーマット
    public function client1_format($id){
        // $shop_id=session()->get("shop_id");
        $item = DB::table('matterstates')
        ->where('matter_id',$id)
        ->get();


        $items=array();
        $i=0;
        foreach ($item as $value){
            foreach ($value as $key=>$values){
                $items[$i][$key]=$values;
            }
            $i+=1;
        }


        $param=[
            // 'influ_name'=>'インフルエンサー名',
            'instagram_url1'=>'インスタグラムURL1',
            'instagram_url2'=>'インスタグラムURL2',
            'instagram_url3'=>'インスタグラムURL3',
            'instagram_url4'=>'インスタグラムURL4',
            'instagram_url5'=>'インスタグラムURL5',
            'taberogu_url'=>'食べログURL',
            'google_url'=>'Google Map URL',
            'blog_url'=>'ブログURL',
            'other_url1'=>'その他URL1',
            'other_url2'=>'その他URL2',
            'other_url3'=>'その他URL3',
        ];

        // $items2=[
        //     'influ_name'=>$item->influ_name,
        //     'insite_path1'=>$item->insite_path1,
        //     'insite_path2'=>$item->insite_path2,
        //     'insite_path3'=>$item->insite_path3,
        //     'insite_path4'=>$item->insite_path4,
        //     'insite_path5'=>$item->insite_path5,
        // ];

        $param2=[
            // 'influ_name'=>'インフルエンサー名',
            'insite_path1'=>'インサイト画像1',
            'insite_path2'=>'インサイト画像2',
            'insite_path3'=>'インサイト画像3',
            'insite_path4'=>'インサイト画像4',
            'insite_path5'=>'インサイト画像5',
        ];

        $param4=[
            'menu1'=>'美味しかったメニュー',
            'menu2'=>'美味しくなかったメニュー',
            'service_value'=>'接客評価（10段階評価）',
            'price_value'=>'価格への満足度（5段階評価）',
        ];



        $item_matter = DB::table('matters')
        ->where('id',$id)
        ->first();

        $survey=$item_matter->survey;

        $items3=[
            'survey1'=>$item_matter->survey1,
            'survey2'=>$item_matter->survey2,
            'survey3'=>$item_matter->survey3,
            'survey4'=>$item_matter->survey4,
        ];
        $param3=[
            'survey1'=>'接客',
            'survey2'=>'料理',
            'survey3'=>'価格',
            'survey4'=>'その他',
        ];




        return view(Config::get('const.title.title47').".client_form", ['item'=>$items,'param'=>$param,'param2'=>$param2,'survey'=>$survey,'item3'=>$items3,'param3'=>$param3,'param4'=>$param4]);


    }

    //クライアント向け報告フォーマット詳細情報取得
    public function client1_format_detail($id){
        $matter_id=$id;
        $item = DB::table('matterstates')->where('matter_id',$matter_id)->get();

        $item_matter = DB::table('matters')->where('id',$matter_id)->first();

        foreach ($item as $value){
            echo $value;
        }
        exit;

        $items=[
            'influ_name'=>$item->influ_name,
            'instagram_url1'=>$item->instagram_url1,
            'instagram_url2'=>$item->instagram_url2,
            'instagram_url3'=>$item->instagram_url3,
            'instagram_url4'=>$item->instagram_url4,
            'instagram_url5'=>$item->instagram_url5,
            'taberogu_url'=>$item->taberogu_url,
            'google_url'=>$item->google_url,
            'blog_url'=>$item->blog_url,
            'other_url1'=>$item->other_url1,
            'other_url2'=>$item->other_url2,
            'other_url3'=>$item->other_url3,
        ];

        $param=[
            'influ_name'=>Config::get('const.title.title2').'名',
            'instagram_url1'=>'インスタグラムURL1',
            'instagram_url2'=>'インスタグラムURL2',
            'instagram_url3'=>'インスタグラムURL3',
            'instagram_url4'=>'インスタグラムURL4',
            'instagram_url5'=>'インスタグラムURL5',
            'taberogu_url'=>'食べログURL',
            'google_url'=>'Google Map URL',
            'blog_url'=>'ブログURL',
            'other_url1'=>'その他URL1',
            'other_url2'=>'その他URL2',
            'other_url3'=>'その他URL3',
        ];

        $items2=[
            'influ_name'=>$item->influ_name,
            'insite_path1'=>$item->insite_path1,
            'insite_path2'=>$item->insite_path2,
            'insite_path3'=>$item->insite_path3,
            'insite_path4'=>$item->insite_path4,
            'insite_path5'=>$item->insite_path5,
        ];

        $param2=[
            'influ_name'=>Config::get('const.title.title2').'名',
            'insite_path1'=>'インサイト画像1',
            'insite_path2'=>'インサイト画像2',
            'insite_path3'=>'インサイト画像3',
            'insite_path4'=>'インサイト画像4',
            'insite_path5'=>'インサイト画像5',
        ];

        $survey=$item_matter->survey;

        $items3=[
            'survey1'=>$item_matter->survey1,
            'survey2'=>$item_matter->survey2,
            'survey3'=>$item_matter->survey3,
            'survey4'=>$item_matter->survey4,
        ];
        $items3=[
            'survey1'=>'接客',
            'survey2'=>'料理',
            'survey3'=>'価格',
            'survey4'=>'その他',
        ];
    }


    //運営者案件（店舗・インフルエンサーごと）
    public function admin_index2($id,$flag){
        $matter_flag=$flag;

        $item = DB::table('matterstates')
        ->select('id','influ_id','influ_name','flag','questionaire')
        ->where('matter_id',$id)
        ->whereIn('flag', ['1','3','4','5'])
        ->get();

        $item_client = DB::table('matterstates')
        ->where('matter_id',$id)
        ->first();

        $item_matter = DB::table('matters')
        ->where('id',$id)
        ->first();

        $survey=$item_matter->survey;

        $survey_list=[
            'survey1'=>$item_matter->survey1,
            'survey2'=>$item_matter->survey2,
            'survey3'=>$item_matter->survey3,
            'survey4'=>$item_matter->survey4,
        ];

        $survey_list2=[
            'survey1'=>'接客',
            'survey2'=>'料理',
            'survey3'=>'価格',
            'survey4'=>'その他',
        ];

        $shop_name=$item_matter->shop_name;

        $flag_list=[
            '0'=>'応募中',
            '1'=>'採用',
            '3'=>'日程確定',
            '4'=>'投稿報告1完了',
            '5'=>'投稿報告2完了',
        ];

        $questionaire_list=[
            '0'=>'未提出',
            '1'=>'未審査',
            '2'=>'審査済み',
        ];

        $matter_list=[
            '0'=>'未公開',
            '1'=>'公開済み',
            '2'=>'来店前',
            '3'=>'来店済み',
            '4'=>'提出済み',
            '5'=>'清算済み',
        ];

        return view("administrator.matter_member", ['id'=>$id,'shop_name'=>$shop_name,'item'=>$item,'flag_list'=>$flag_list,'questionaire_list'=>$questionaire_list,'matter_flag'=>$matter_flag,'matter_list'=>$matter_list,'survey'=>$survey,'survey_list'=>$survey_list,'survey_list2'=>$survey_list2]);

    }

    //運営者案件ステータス（インフルエンサーごと）
    public function admin_index3($id){
        $item=DB::table('matterstates')->where('id',$id)->first();

        $flag=$item->flag;
        $questionaire=$item->questionaire;
        $come=$item->come;

        $today = date("Y-m-d");

        $flag_list=[
            '0'=>'応募中',
            '1'=>'採用',
            '3'=>'日程確定',
            '4'=>'投稿報告1完了',
            '5'=>'投稿報告2完了',
        ];

        $questionaire_list=[
            '0'=>'未提出',
            '1'=>'未審査',
            '2'=>'審査済み',
        ];

        if ($flag==="0"){  //未採用
            return view("administrator.matter_member_detail",['id'=>$id,'flag'=>$flag,'flag_list'=>$flag_list]);

        }elseif($flag==="1"){  //採用
            return view("administrator.matter_member_detail",['id'=>$id,'flag'=>$flag,'flag_list'=>$flag_list]);
        }elseif ($flag==="3"){  //日程確定後
            $time_result=date('H:i',  strtotime($item->time_result));

            $items=[
                'reserve_name'=>$item->reserve_name,
                'date_result'=>$item->date_result,
                'time_result'=>$time_result,
                'member_result'=>$item->member_result,
                'post_deadline1'=>$item->post_deadline1,
            ];

            $param=[
                'reserve_name'=>'予約名',
                'date_result'=>'確定日',
                'time_result'=>'確定時間',
                'member_result'=>'確定同伴人数',
                'post_deadline1'=>'投稿報告1期限',
            ];

            $hissu_item = DB::table('configs')->where('id','1')->first();
            $hissu_list=[
                'story1'=>$hissu_item->story1,
                'story2'=>$hissu_item->story2,
                'story3'=>$hissu_item->story3,
                'taberogu'=>$hissu_item->taberogu,
                'google'=>$hissu_item->google,
                'blog'=>$hissu_item->blog,
            ];

            $post_deadline1=$item->post_deadline1;


            $hurry="";
            if ($post_deadline1<$today){
                $hurry="投稿報告1の期限が過ぎています。";
            }

            return view("administrator.matter_member_detail",['id'=>$id,'flag'=>$flag,'flag_list'=>$flag_list,'item'=>$items,'param'=>$param,'hissu_list'=>$hissu_list,'hurry'=>$hurry,'questionaire'=>$questionaire,'questionaire_list'=>$questionaire_list,'come'=>$come]);

        }elseif ($flag==="4"){  //投稿報告1完了
            $items=[
                'post_deadline2'=>$item->post_deadline2,
                'instagram_url1'=>$item->instagram_url1,
                'instagram_url2'=>$item->instagram_url2,
                'instagram_url3'=>$item->instagram_url3,
                'instagram_url4'=>$item->instagram_url4,
                'instagram_url5'=>$item->instagram_url5,
                'story_url1'=>$item->story_url1,
                'story_url2'=>$item->story_url2,
                'story_url3'=>$item->story_url3,
                'taberogu_url'=>$item->taberogu_url,
                'google_url'=>$item->google_url,
                'blog_url'=>$item->blog_url,
                'other_url1'=>$item->other_url1,
                'other_url2'=>$item->other_url2,
                'other_url3'=>$item->other_url3,
            ];

            $param=[
                'post_deadline2'=>'投稿報告2期限',
                'instagram_url1'=>'インスタグラムURL1',
                'instagram_url2'=>'インスタグラムURL2',
                'instagram_url3'=>'インスタグラムURL3',
                'instagram_url4'=>'インスタグラムURL4',
                'instagram_url5'=>'インスタグラムURL5',
                'story_url1'=>'ストーリーズURL1',
                'story_url2'=>'ストーリーズURL2',
                'story_url3'=>'ストーリーズURL3',
                'taberogu_url'=>'食べログURL',
                'google_url'=>'Google Map URL',
                'blog_url'=>'ブログURL',
                'other_url1'=>'その他URL1',
                'other_url2'=>'その他URL2',
                'other_url3'=>'その他URL3',
            ];

            $post_deadline2=$item->post_deadline2;

            $hurry="";
            if ($post_deadline2<$today){
                $hurry="投稿報告2の期限が過ぎています。";
            }

            return view("administrator.matter_member_detail",['id'=>$id,'flag'=>$flag,'flag_list'=>$flag_list,'item'=>$items,'param'=>$param,'hurry'=>$hurry,'questionaire'=>$questionaire,'questionaire_list'=>$questionaire_list,'post_deadline2'=>$post_deadline2]);

        }elseif ($flag==="5"){  //投稿報告2完了
            $items=[
                'instagram_url1'=>$item->instagram_url1,
                'instagram_url2'=>$item->instagram_url2,
                'instagram_url3'=>$item->instagram_url3,
                'instagram_url4'=>$item->instagram_url4,
                'instagram_url5'=>$item->instagram_url5,
                'story_url1'=>$item->story_url1,
                'story_url2'=>$item->story_url2,
                'story_url3'=>$item->story_url3,
                'taberogu_url'=>$item->taberogu_url,
                'google_url'=>$item->google_url,
                'blog_url'=>$item->blog_url,
                'other_url1'=>$item->other_url1,
                'other_url2'=>$item->other_url2,
                'other_url3'=>$item->other_url3,
            ];

            $param=[
                'instagram_url1'=>'インスタグラムURL1',
                'instagram_url2'=>'インスタグラムURL2',
                'instagram_url3'=>'インスタグラムURL3',
                'instagram_url4'=>'インスタグラムURL4',
                'instagram_url5'=>'インスタグラムURL5',
                'story_url1'=>'ストーリーズURL1',
                'story_url2'=>'ストーリーズURL2',
                'story_url3'=>'ストーリーズURL3',
                'taberogu_url'=>'食べログURL',
                'google_url'=>'Google Map URL',
                'blog_url'=>'ブログURL',
                'other_url1'=>'その他URL1',
                'other_url2'=>'その他URL2',
                'other_url3'=>'その他URL3',
            ];

            $items2=[
                'insite_path1'=>$item->insite_path1,
                'insite_path2'=>$item->insite_path2,
                'insite_path3'=>$item->insite_path3,
                'insite_path4'=>$item->insite_path4,
                'insite_path5'=>$item->insite_path5,
            ];

            return view("administrator.matter_member_detail",['id'=>$id,'flag'=>$flag,'flag_list'=>$flag_list,'item'=>$items,'item2'=>$items2,'param'=>$param,'questionaire'=>$questionaire,'questionaire_list'=>$questionaire_list]);
        }else{
            $msgs="何らかの不具合が生じています。";
            return redirect("administrator/matter_member_detail/$id")->with('msgs', $msgs);
        }
    }

    //来店後アンケート提出
    public function submit_questionaire(Request $request){
        $id=$request->hidden_id;
        if (!session()->has("user_id")){
            return redirect("influencer");
        }

        $param=[
            'menu1'=>$request->menu1,
            'menu2'=>$request->menu2,
            'service_value'=>$request->selector1,
            'service_value_memo'=>$request->service_value_memo,
            'price_value'=>$request->selector2,
            'notice_memo'=>$request->notice_memo,
            'notice_other'=>$request->notice_other,
            'questionaire'=>'1',
        ];

        $notice=$request->notice;
        $i=1;
        foreach ($notice as $value){
            $param["notice$i"]=$value;
            $i+=1;
        }



        DB::table('matterstates')->where('id',$id)
        ->update($param);

        $msgs='来店後アンケートを提出しました。';

        return redirect(Config::get('const.title.title48')."/matter_already_detail/$id")->with('msgs', $msgs);
    }

    //運営側来店後アンケート取得
    public function admin_questionaire($id,$questionaire){
        $item=DB::table('matterstates')->where('id',$id)->first();

        $items=[
            'menu1'=>$item->menu1,
            'menu2'=>$item->menu2,
            'service_value'=>$item->service_value,
            'price_value'=>$item->price_value,
        ];
        $param=[
            'menu1'=>'美味しかったメニュー',
            'menu2'=>'美味しくなかったメニュー',
            'service_value'=>'接客評価（10段階評価）',
            'price_value'=>'価格への満足度（5段階評価）',
        ];

        $items2=[
            'notice1'=>$item->notice1,
            'notice2'=>$item->notice2,
            'notice3'=>$item->notice3,
            'notice4'=>$item->notice4,
            'notice5'=>$item->notice5,
            'notice6'=>$item->notice6,
            'notice7'=>$item->notice7,
            'notice8'=>$item->notice8,
            'notice9'=>$item->notice9,
            'notice10'=>$item->notice10,
            'notice11'=>$item->notice11,
            'notice12'=>$item->notice12,
            'notice13'=>$item->notice13,
            'notice14'=>$item->notice14,
            'notice15'=>$item->notice15,
            'notice16'=>$item->notice16,
            'notice17'=>$item->notice17,
            'notice18'=>$item->notice18,
            'notice19'=>$item->notice19,
            'notice20'=>$item->notice20,
        ];

        $service_value_memo=$item->service_value_memo;
        $notice_memo=$item->notice_memo;
        $notice_other=$item->notice_other;

        return view("administrator.matter_member_questionaire",['id'=>$id,'item'=>$items,'item2'=>$items2,'param'=>$param,'questionaire'=>$questionaire,'notice_other'=>$notice_other,'notice_memo'=>$notice_memo,'service_value_memo'=>$service_value_memo]);

    }

    //運営来店後アンケートチェック
    public function admin_questionaire_check(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $id=$request->hidden_id;
        $selector1=$request->selector1;
        $questionaire="2";

        if ($selector1==="1"){  //そのまま登録
            DB::table('matterstates')->where('id',$id)
            ->update(['questionaire'=>'2']);

            $msgs="そのまま登録しました。";

        }elseif ($selector1==="2"){  //変更して登録

            $item_list=[
                'menu1',
                'menu2',
                'service_value',
                'price_value',
            ];

            $param=[
                'questionaire'=>'2',
            ];

            $question=$request->question;
            $notice=$request->notice;

            $i=0;
            foreach ($question as $value){
                $param[$item_list[$i]]=$value;
                $i+=1;
            }

            $j=1;
            foreach ($notice as $value){
                $param["notice$j"]=$value;
                $j+=1;
            }
            for ($m=0;$m<20;$m++){
                $param["notice$j"]='F';
                $j+=1;
                if ($j>20){
                    break;
                }
            }

            if (empty($request->notice_memo)){
                $param['notice_memo']=NULL;
            }else{
                $param['notice_memo']=$request->notice_memo;
            }
            if (empty($request->notice_other)){
                $param['notice_other']=NULL;
            }else{
                $param['notice_other']=$request->notice_other;
            }
            if (empty($request->service_value_memo)){
                $param['service_value_memo']=NULL;
            }else{
                $param['service_value_memo']=$request->service_value_memo;
            }



            DB::table('matterstates')->where('id',$id)
            ->update($param);

            $msgs="変更して登録しました。";

        }else{
            $msgs="何らかのエラーが発生しました。";
            $questionaire="1";
        }
        return redirect("administrator/matter_member_questionaire/$id/$questionaire")->with('msgs', $msgs);
    }

    //運営側ー請求情報取得
    public function admin_payment(Request $request){
        //リクエストなければ現在の年月
        if (empty($request->dates)){
            $dates=date('Y-m');
        }else{
            $dates=$request->dates;
        }

        $first_date = date('Y-m-d', strtotime('first day of ' . $dates));
        $last_date = date('Y-m-d', strtotime('last day of ' . $dates));


        //案件ごと
        $item=DB::table('matters')
        ->where('end_date','>=',$first_date)
        ->where('end_date','<=',$last_date)
        ->where('flag','4')
        ->get();

        $reward_list=[];
        $matter_id_list=[];
        $pay_all=0;
        foreach ($item as $key=>$value){
            $reward_list[$value->shop_id]=$value->reward;
            $matter_id_list[]=$value->id;
        }


        //店舗クライアントごと
        $item_shop=DB::table('matterstates')
        ->whereIn('matter_id',$matter_id_list)
        ->where('flag','5')
        ->get();

        // var_dump($item_shop);
        // exit;

        $param_shop=[];
        $shop_id_kari=[];

        $influ_id_list=[];
        foreach ($item_shop as $key=>$value){


            if (in_array($value->shop_id,$shop_id_kari)){
                $param_shop[$value->shop_id]['member_num']+=1;
                $param_shop[$value->shop_id]['matter_num']+=1;
                $param_shop[$value->shop_id]['pay_all']+=$reward_list[$value->shop_id];
            }else{
                $param_shop[$value->shop_id]['member_num']=1;
                $param_shop[$value->shop_id]['matter_num']=1;
                $param_shop[$value->shop_id]['pay_all']=$reward_list[$value->shop_id];
                $param_shop[$value->shop_id]['shop_name']=$value->shop_name;
                $influ_id_list[]=$value->influ_id;
                $shop_id_kari[]=$value->shop_id;
            }
        }

        // foreach ($param_shop as $ke=>$value){
        //     // var_dump($value->shop_name);
        //     var_dump($value['shop_name']);
        // }
        // exit;

        // var_dump($influ_id_list);
        // exit;

        //インフルエンサーごと
        // $item_influ=DB::table('matterstates')
        // // ->whereIn('influ_id',$influ_id_list)
        // ->whereIn('matter_id',$matter_id_list)
        // ->where('flag','5')
        // ->get();

        // $param_influ=[];
        // $influ_id_kari=[];
        // foreach ($item_influ as $key=>$value){
        //     if (in_array($value->influ_id,$influ_id_kari)){
        //         $param_influ[$value->influ_id]['matter_num']+=1;
        //         $param_influ[$value->influ_id]['pay_all']+=$reward_list[$value->shop_id];
        //     }else{
        //         $param_influ[$value->influ_id]['influ_name']=$value->influ_name;
        //         $param_influ[$value->influ_id]['matter_num']=1;
        //         $param_influ[$value->influ_id]['pay_all']=$reward_list[$value->shop_id];
        //         $influ_id_kari[]=$value->influ_id;
        //     }
        // }

        return view("administrator.payment",['dates'=>$dates,'item'=>$item,'param_shop'=>$param_shop]);

    }
    //運営側ー請求情報取得
    public function admin_payment_client2(Request $request){
        //リクエストなければ現在の年月
        if (empty($request->dates)){
            $dates=date('Y-m');
        }else{
            $dates=$request->dates;
        }

        $first_date = date('Y-m-d', strtotime('first day of ' . $dates));
        $last_date = date('Y-m-d', strtotime('last day of ' . $dates));


        //案件ごと
        $item=DB::table('matters')
        ->where('end_date','>=',$first_date)
        ->where('end_date','<=',$last_date)
        ->where('flag','4')
        ->get();

        $reward_list=[];
        $matter_id_list=[];
        $pay_all=0;
        foreach ($item as $key=>$value){
            $reward_list[$value->shop_id]=$value->reward;
            $matter_id_list[]=$value->id;
        }


        //インフルエンサーごと
        $item_influ=DB::table('matterstates')
        // ->whereIn('influ_id',$influ_id_list)
        ->whereIn('matter_id',$matter_id_list)
        ->where('flag','5')
        ->get();

        $param_influ=[];
        $influ_id_kari=[];
        foreach ($item_influ as $key=>$value){
            if (in_array($value->influ_id,$influ_id_kari)){
                $param_influ[$value->influ_id]['matter_num']+=1;
                $param_influ[$value->influ_id]['pay_all']+=$reward_list[$value->shop_id];
            }else{
                $param_influ[$value->influ_id]['influ_name']=$value->influ_name;
                $param_influ[$value->influ_id]['matter_num']=1;
                $param_influ[$value->influ_id]['pay_all']=$reward_list[$value->shop_id];
                $influ_id_kari[]=$value->influ_id;
            }
        }

        return view("administrator.payment_influ",['dates'=>$dates,'item'=>$item,'param_influ'=>$param_influ]);

    }

    //請求情報をCSVダウンロード
    public function admin_payment_csv($id,$dates){

        $first_date = date('Y-m-d', strtotime('first day of ' . $dates));
        $last_date = date('Y-m-d', strtotime('last day of ' . $dates));



        //案件ごと
        $item=DB::table('matters')
        ->where('end_date','>=',$first_date)
        ->where('end_date','<=',$last_date)
        ->where('flag','4')
        ->get();

        $reward_list=[];
        $matter_id_list=[];
        $pay_all=0;
        foreach ($item as $key=>$value){
            $reward_list[$value->shop_id]=$value->reward;
            $matter_id_list[]=$value->id;
        }

        //案件ごと
        if ($id==="1"){
            $filename="matter-$dates.csv";

            $csv_list=[
                '案件ID','店舗名','郵便番号','住所','会社名','担当者名','案件完了日','単価','採用人数','合計請求額',
            ];


            $required_list=[];
            $i=1;
            foreach ($item as $key=>$value){
                $required_list[$i][]=$value->id;
                $required_list[$i][]=$value->shop_name;
                $required_list[$i][]=$value->shop_area;
                $required_list[$i][]=$value->shop_address;
                $required_list[$i][]=$value->shop_tantou;
                $required_list[$i][]=$value->end_date;
                $required_list[$i][]=$value->reward;
                $required_list[$i][]=$value->matter_num_now;
                $pay_all=$value->reward * $value->matter_num_now;
                $required_list[$i][]=$pay_all;
                $i+=1;
            }


        }elseif ($id==="2"){
            $filename="client-$dates.csv";

            $csv_list=[
                'ID','店舗名','郵便番号','住所','会社名','担当者名','採用人数','案件数','合計請求額',
            ];

            $reward_list=[];
            $matter_id_list=[];
            $pay_all=0;
            foreach ($item as $key=>$value){
                $reward_list[$value->shop_id]=$value->reward;
                $matter_id_list[]=$value->id;
            }


            //店舗クライアントごと
            $item_shop=DB::table('matterstates')
            ->whereIn('matter_id',$matter_id_list)
            ->where('flag','5')
            ->get();

            $param_shop=[];
            $shop_id_kari=[];

            $influ_id_list=[];
            foreach ($item_shop as $key=>$value){
                $item_shop2=DB::table('matters')
                ->where('shop_id',$value->shop_id)
                ->first();


                if (in_array($value->shop_id,$shop_id_kari)){
                    $required_list[$value->shop_id]['member_num']+=1;
                    $required_list[$value->shop_id]['matter_num']+=1;
                    $required_list[$value->shop_id]['pay_all']+=$reward_list[$value->shop_id];
                }else{
                    $required_list[$value->shop_id][]=$value->shop_id;
                    $required_list[$value->shop_id][]=$value->shop_name;
                    $required_list[$value->shop_id][]=$item_shop2->shop_area;
                    $required_list[$value->shop_id][]=$item_shop2->shop_address;
                    $required_list[$value->shop_id][]=$item_shop2->shop_tantou;
                    $required_list[$value->shop_id]['member_num']=1;
                    $required_list[$value->shop_id]['matter_num']=1;
                    $required_list[$value->shop_id]['pay_all']=$reward_list[$value->shop_id];
                    $shop_id_kari[]=$value->shop_id;

                }
            }


        }elseif ($id==="3"){
            $filename="influencer-$dates.csv";

            $csv_list=[
                'ID','名前','名前（フリガナ）','銀行名','口座種別','口座番号','口座名義','案件数','合計支給額',
            ];

                //インフルエンサーごと
            $item_influ=DB::table('matterstates')
            ->whereIn('matter_id',$matter_id_list)
            ->where('flag','5')
            ->get();

            $param_influ=[];
            $influ_id_kari=[];
            foreach ($item_influ as $key=>$value){
                $item_influ2=DB::table('influs')
                ->where('user_id',$value->influ_id)
                ->first();

                if (in_array($value->influ_id,$influ_id_kari)){
                    $required_list[$value->influ_id]['matter_num']+=1;
                    $required_list[$value->influ_id]['pay_all']+=$reward_list[$value->shop_id];
                }else{
                    $required_list[$value->influ_id][]=$item_influ2->user_id;
                    $required_list[$value->influ_id][]=$item_influ2->user_name;
                    $required_list[$value->influ_id][]=$item_influ2->user_furigana;
                    $required_list[$value->influ_id][]=$item_influ2->bank;
                    $required_list[$value->influ_id][]=$item_influ2->bank_type;
                    $required_list[$value->influ_id][]=$item_influ2->bank_number;
                    $required_list[$value->influ_id][]=$item_influ2->cash_name;
                    $required_list[$value->influ_id]['matter_num']=1;
                    $required_list[$value->influ_id]['pay_all']=$reward_list[$value->shop_id];
                    $influ_id_kari[]=$value->influ_id;
                }
            }

        }else{
            exit;
        }

        // 書き込み用ファイルを開く
        $f = fopen($filename, 'w');
        if ($f) {
            // カラムの書き込み
            mb_convert_variables('SJIS', 'UTF-8', $csv_list);
            fputcsv($f, $csv_list);
            // データの書き込み
            foreach ($required_list as $value) {
                mb_convert_variables('SJIS', 'UTF-8', $value);
                fputcsv($f, $value);
            }
        }
        // ファイルを閉じる
        fclose($f);

        // HTTPヘッダ
        header("Content-Type: application/octet-stream");
        header('Content-Length: '.filesize($filename));
        header("Content-Disposition: attachment; filename=$filename");
        readfile($filename);

    }

    //インフルエンサー支払通知書
    public function client2_payment($all){
        if (!session()->has("user_id")){
            return redirect("influencer");
        }
        $influ_id=session()->get('user_id');

        $item=DB::table('matterstates')
        ->select('matter_id')
        ->where('influ_id',$influ_id)
        ->where('flag','5')
        ->get();

        $matter_list=[];

        foreach ($item as $key=>$value){
            $matter_list[]=$value->matter_id;
        }

        $item_influ=DB::table('matters')
        ->whereIn('id',$matter_list)
        ->whereNotNull('end_date')
        ->orderBy('end_date','desc')
        ->get();

        $month_list=[];


        if ($all==="0"){
            $i=0;
            foreach ($item_influ as $key=>$value){
                $dates=date('Y-m',strtotime($value->end_date));
                if (!in_array($dates,$month_list)){
                    $month_list[]=$dates;
                    $i+=1;
                }
                if ($i>=5){
                    break;
                }
            }
        }else{
            foreach ($item_influ as $key=>$value){
                $dates=date('Y-m',strtotime($value->end_date));
                if (!in_array($dates,$month_list)){
                    $month_list[]=$dates;
                }
            }
        }


        return view(Config::get('const.title.title48').".payment",['month_list'=>$month_list]);
    }

    //インフルエンサー支払通知書詳細
    public function client2_payment2($month){
        if (!session()->has("user_id")){
            return redirect(Config::get('const.title.title48'));
        }
        $influ_id=session()->get('user_id');

        $item=DB::table('matterstates')
        ->select('matter_id')
        ->where('influ_id',$influ_id)
        ->where('flag','5')
        ->get();

        $matter_list=[];

        foreach ($item as $key=>$value){
            $matter_list[]=$value->matter_id;
        }

        $first_date = date('Y-m-d', strtotime('first day of ' . $month));
        $last_date = date('Y-m-d', strtotime('last day of ' . $month));
        $month_only = date('m', strtotime($month));

        $item_influ=DB::table('matters')
        ->whereIn('id',$matter_list)
        ->where('end_date','>=',$first_date)
        ->where('end_date','<=',$last_date)
        ->get();

        $reward_all=0;
        foreach ($item_influ as $value){
            $reward_all+=$value->reward;  //全額
        }
        $tax=$reward_all * 0.1021;  //源泉徴収
        $reward_result=$reward_all - $tax;

        $item2=DB::table('influs')
        ->select('bank','bank_type','bank_number','cash_name')
        ->where('user_id',$influ_id)
        ->first();

        $last_date2=date('Y年m月d日',strtotime($last_date));

        $param=[
            'item_influ'=>$item_influ,
            'reward_all'=>$reward_all,
            'tax'=>$tax,
            'reward_result'=>$reward_result,
            'item2'=>$item2,
            'last_date'=>$last_date2,
            'month_only'=>$month_only,
        ];

        return view(Config::get('const.title.title48').".payment_detail",$param);

    }
}
