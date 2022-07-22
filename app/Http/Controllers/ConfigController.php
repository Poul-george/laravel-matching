<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
// use App\Models\Config;

class ConfigController extends Controller
{
    //必須有無と来店後アンケートの項目取得
    public function admin_index(){
        $item = DB::table('configs')->where('id','1')->first();

        $items=[
            'question1'=>$item->question1,
            'question2'=>$item->question2,
            'question3'=>$item->question3,
            'question4'=>$item->question4,
            'question5'=>$item->question5,
            'question6'=>$item->question6,
            'question7'=>$item->question7,
            'question8'=>$item->question8,
            'question9'=>$item->question9,
            'question10'=>$item->question10,
            'question11'=>$item->question11,
            'question12'=>$item->question12,
            'question13'=>$item->question13,
            'question14'=>$item->question14,
            'question15'=>$item->question15,
            'question16'=>$item->question16,
            'question17'=>$item->question17,
            'question18'=>$item->question18,
            'question19'=>$item->question19,
            'question20'=>$item->question20,
        ];



        $items2=[
            'story1'=>$item->story1,
            'story2'=>$item->story2,
            'story3'=>$item->story3,
            'taberogu'=>$item->taberogu,
            'google'=>$item->google,
            'blog'=>$item->blog,
        ];


        $param=[
            'story1'=>'ストーリーズ1',
            'story2'=>'ストーリーズ2',
            'story3'=>'ストーリーズ3',
            'taberogu'=>'食べログ',
            'google'=>'Google Map',
            'blog'=>'ブログ',
        ];
        return view("administrator.admin_config", ['item'=>$items,'item2'=>$items2,'param'=>$param]);
    }

    //必須有無と来店後アンケートの項目更新
    public function admin_config(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $hidden=$request->hidden;

        if ($hidden==="1"){  //来店後アンケートの質問項目
            $question_list=$request->question;
            $param=[];

            $i=1;
            foreach ($question_list as $key=>$value){
                $param["question$i"]=$value;
                $i+=1;
            }
            DB::table('configs')
            ->where('id', '1')
            ->update($param);

            $msgs="来店後アンケートの質問項目を更新しました。";
            return redirect("administrator/admin_config")->with('msgs', $msgs);

        }elseif ($hidden==="2"){  // 投稿必須有無
            $param=[
                'story1'=>$request->radio1,
                'story2'=>$request->radio2,
                'story3'=>$request->radio3,
                'taberogu'=>$request->radio4,
                'google'=>$request->radio5,
                'blog'=>$request->radio6,
            ];

            DB::table('configs')
            ->where('id', '1')
            ->update($param);

            $msgs="投稿必須有無を更新しました。";
            return redirect("administrator/admin_config")->with('msgs', $msgs);
        }
    }

    //来店後アンケートの項目取得
    public function make_questionaire($id){
        $item=DB::table('configs')->where('id','1')->first();

        $items=[
            'question1'=>$item->question1,
            'question2'=>$item->question2,
            'question3'=>$item->question3,
            'question4'=>$item->question4,
            'question5'=>$item->question5,
            'question6'=>$item->question6,
            'question7'=>$item->question7,
            'question8'=>$item->question8,
            'question9'=>$item->question9,
            'question10'=>$item->question10,
            'question11'=>$item->question11,
            'question12'=>$item->question12,
            'question13'=>$item->question13,
            'question14'=>$item->question14,
            'question15'=>$item->question15,
            'question16'=>$item->question16,
            'question17'=>$item->question17,
            'question18'=>$item->question18,
            'question19'=>$item->question19,
            'question20'=>$item->question20,
        ];

        return view("influencer.questionaire_form", ['item'=>$items,'id'=>$id]);
    }

    //クライアント登録項目必須有無
    public function client1_form_get(){
        $item=DB::table('configs')->where('id','1')->first();

        $items=[
            'client_name'=>$item->client_name,
            'client_tantou'=>$item->client_tantou,
            'client_phone'=>$item->client_phone,
            'client_mail'=>$item->client_mail,
            'client_area'=>$item->client_area,
            'client_address'=>$item->client_address,
            'client_station'=>$item->client_station,
            'client_url'=>$item->client_url,
            'client_img'=>$item->client_img,
            'open_time'=>$item->open_time,
            'close_date'=>$item->close_date,
            'new_genre'=>$item->new_genre,
            'new_tanka'=>$item->new_tanka,
            'new_age'=>$item->new_age,
            'new_gender'=>$item->new_gender,
            'new_concept'=>$item->new_concept,
        ];

        $items2=[
            'request_area'=>$item->request_area,
            'request_address'=>$item->request_address,
            'request_name'=>$item->request_name,
            'request_tantou'=>$item->request_tantou,
        ];

        $items3=[
            'matter_name'=>$item->matter_name,
            'gather_before'=>$item->gather_before,
            'gather_after'=>$item->gather_after,
            'able_date1'=>$item->able_date1,
            'least_follower'=>$item->least_follower,
            'matter_img'=>$item->matter_img,
            'matter_genre'=>$item->matter_genre,
            'reward'=>$item->reward,
            'serve_menu'=>$item->serve_menu,
            'intro_text'=>$item->intro_text,
            'serve_value'=>$item->serve_value,
            'companion_num'=>$item->companion_num,
            'post_sns'=>$item->post_sns,
            'term'=>$item->term,
            'hashtag'=>$item->hashtag,
            'tag_account'=>$item->tag_account,
            'location'=>$item->location,
            'post_deadline'=>$item->post_deadline,
            'story_url'=>$item->story_url,
            'notice'=>$item->notice,
        ];

        $param = Config::get('list.config_client');

        // $param=[
        //     'client_name'=>'企業名',
        //     'client_tantou'=>'担当者氏名',
        //     'client_phone'=>'電話番号',
        //     'client_mail'=>'メールアドレス',
        //     'client_address'=>'店舗所在地',
        //     'client_station'=>'店舗最寄り駅',
        //     'request_area'=>'請求書送付先郵便番号',
        //     'request_address'=>'請求書送付先住所',
        //     'request_name'=>'請求書送付先会社名',
        //     'request_tantou'=>'請求書送付先担当者名',
        //     'able_date1'=>'予約可能日時',
        //     'least_follower'=>'最低フォロワー数',
        //     'reward'=>'報酬',
        //     'serve_menu'=>'提供メニュー',
        //     'intro_text'=>'店舗紹介文',
        //     'serve_value'=>'メニュー料金',
        //     'companion_num'=>'同伴者人数',
        //     'post_sns'=>'投稿SNS',
        //     'term'=>'投稿条件',
        //     'hashtag'=>'ハッシュタグ',
        //     'tag_account'=>'タグ付け用アカウント',
        //     'location'=>'位置情報',
        //     'post_deadline'=>'投稿期限',
        //     'story_url'=>'ストーリーズ用URL',
        //     'notice'=>'注意事項',
        //     'new_genre'=>'ジャンル・カテゴリ（新規オープン）',
        //     'new_tanka'=>'客単価（新規オープン）',
        //     'new_age'=>'ターゲットの年齢層（新規オープン）',
        //     'new_gender'=>'ターゲットの性別（新規オープン）',
        //     'new_concept'=>'コンセプト（新規オープン）',
        // ];

        return view("administrator.admin_config_client", ['item'=>$items,'item2'=>$items2,'item3'=>$items3,'param'=>$param]);
    }

    //クライアント登録項目必須変更
    public function client1_form_post(Request $request){
        $hidden=$request->hidden;

        if ($hidden==="1"){

            $items=[
                '',
                'client_name',
                'client_tantou',
                'client_phone',
                'client_mail',
                'client_area',
                'client_address',
                'client_station',
                'client_url',
                'client_img',
                'open_time',
                'close_date',
                'new_genre',
                'new_tanka',
                'new_age',
                'new_gender',
                'new_concept',
                'request_area',
                'request_address',
                'request_name',
                'request_tantou',
                'matter_name',
                'gather_before',
                'gather_after',
                'able_date1',
                'least_follower',
                'matter_img',
                'matter_genre',
                'reward',
                'serve_menu',
                'intro_text',
                'serve_value',
                'companion_num',
                'post_sns',
                'term',
                'hashtag',
                'tag_account',
                'location',
                'post_deadline',
                'story_url',
                'notice',
            ];

            $param=[];
            for ($i=1;$i<count($items);$i++){
                $param[$items[$i]]=$request->{"radio$i"};
            }

            DB::table('configs')->where('id','1')
            ->update($param);

            $msgs="項目の必須有無の変更を行いました。";
            return redirect("administrator/admin_config_client")->with('msgs', $msgs);


        }
    }
}
