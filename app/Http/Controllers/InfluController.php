<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Models\Influ;
use App\Mail\InfluOuboMail;
use App\Mail\InfluKariMail;
use App\Mail\InfluPassReput;
use App\Mail\SelectedFromAdmin;
use Mail;

use Illuminate\Support\Facades\Storage;

class InfluController extends Controller
{

    //インフルエンサー事前登録
    public function before_form(Request $request){
        //日時
        $today = date("Y-m-d H:i:s");

        $user_mail=$request->email;

        $item=DB::table('influs')->where('user_mail',$user_mail)
        // ->where('user_status','T')
        ->count();

        if ($item!==0){
            $msgs="既に登録済みのメールアドレスです。";
            return redirect('influencer/first_form')->with('msgs', $msgs);
        }

        $year=$request->year;
        $month=$request->month;
        $days=$request->days;

        $birth="{$year}-{$month}-{$days}";

        $param=[
            'user_name'=>$request->name,
            'user_furigana'=>$request->furigana,
            'user_birth'=>$birth,
            'user_instagram_url'=>$request->instagram_url,
            'user_mail'=>$request->email,
            'user_follower_num'=>$request->follower,
            'user_oubo'=>$today,
            'user_flag'=>'0',
        ];

        $name=$request->name;
        $instagram_url=$request->instagram_url;
        $email=$request->email;

        if (!empty($request->taberogu)){
            $param["user_taberogu"]=$request->taberogu;
        }else{
            $param["user_taberogu"]='F';
        }

        if (!empty($request->google)){
            $param["user_google"]=$request->google;
        }else{
            $param["user_google"]='F';
        }

        if (!empty($request->other)){
            $param["user_other"]=$request->other;
        }else{
            $param["user_other"]='F';
        }

        if (!empty($request->message)){
            $param['user_comment']=$request->message;
        }

        $counts = DB::table('influs')->orderBy('id','desc')->first();
        $count_id=$counts->id;
        $ids=$count_id+1;

        $files=$request->file('upfile');
        $dir_path="public/insite/";
        $file_path="insite-$ids/";


        $i=1;
        foreach ($files as $file){
            if (!empty($file)){
                $file_kari= $file->getClientOriginalName();
                $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
                $file_name="insite{$i}.{$extension}";


                $file->storeAS('',$dir_path.$file_path.$file_name);
                $param["user_insite_img$i"]=$file_path.$file_name;

                $i+=1;
            }

        }
        $mail_param=[
            'name'=>$name,
            'instagram_url'=>$instagram_url,
            'email'=>$email,
        ];

        //メール
        Mail::to($email)->send(new InfluKariMail($mail_param));

        DB::table('influs')->insert($param);

        $msg2='審査を通過された方のみ、1週間以内にご登録いただいたメースアドレスへご連絡させていただきます。';

        return view("influencer.first_form", ["msg"=>'応募が完了しました。','msg2'=>$msg2]);

    }

    //採用・不採用
    public function judge(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $saiyou=$request->selector1;
        $id=$request->id;

        $item=DB::table('influs')->where('id',$id)->first();
        $email=$item->user_mail;


        //採用
        if ($saiyou==="T"){

            //IDはメアド
            $account=$email;
            // echo $account;

            //パスワード 8文字
            $password=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('influs')
                        ->where('id', $id)
                        ->update(['user_flag' => '1','user_id'=>$account,'user_pass'=>$password_hash]);

            $msg="採用しました。";
            $param=[
                'user_name'=>$item->user_name,
                'result'=>'採用',
                'account'=>$account,
                'password'=>$password,
            ];

            //採用時のみメール
            Mail::to($email)->send(new InfluOuboMail($param));

        }else{
            DB::table('influs')
                        ->where('id', $id)
                        ->update(['user_flag' => '3']);

            $account="なし";
            $password="なし";

            $param=[
                'user_name'=>$item->user_name,
                'result'=>'不採用',
                'account'=>$account,
                'password'=>$password,
            ];
            $msg="不採用にしました。";

        }


        return redirect('administrator/admin_influ_1')->with('msg', $msg);
    }

    //インフルエンサー本登録情報取得
    public function after_form_pre(){
        if (session()->has("user_id")){
            $user_id=session()->get("user_id");
        }else{
            return redirect('influencer');
        }

        $item=DB::table('influs')->where('user_id',$user_id)->first();

        $user_taberogu=$item->user_taberogu;
        $user_google=$item->user_google;
        $user_other=$item->user_other;

        if ($user_taberogu==="F"){
            $user_taberogu="";
        }
        if ($user_google==="F"){
            $user_google="";
        }
        if ($user_other==="F"){
            $user_other="";
        }

        $items=[
            'user_name'=>$item->user_name,
            'user_furigana'=>$item->user_furigana,
            'user_mail'=>$item->user_mail,
            'user_instagram_url'=>$item->user_instagram_url,
            'user_follower_num'=>$item->user_follower_num,
            'user_taberogu'=>$user_taberogu,
            'user_google'=>$user_google,
            'user_flag'=>$item->user_flag,
        ];

        $user_birth=$item->user_birth;
        $user_year=mb_substr($user_birth,0,4);
        $user_month=mb_substr($user_birth,5,2);
        $user_date=mb_substr($user_birth,8,2);



        $user_insite_img1=$item->user_insite_img1;
        $user_insite_img2=$item->user_insite_img2;
        $user_insite_img3=$item->user_insite_img3;

        $year=date('Y');
        $date_list=Config::get('list.date_list');
        $month_list=Config::get('list.month_list');

        $send_param=[
            'item'=>$items,
            'year'=>$year,
            'user_insite_img1'=>$user_insite_img1,
            'user_insite_img2'=>$user_insite_img2,
            'user_insite_img3'=>$user_insite_img3,
            'date_list'=>$date_list,
            'month_list'=>$month_list,
            'user_date'=>$user_date,
            'user_month'=>$user_month,
            'user_year'=>$user_year,
        ];

        return view("influencer.second_form", $send_param);

    }

    //インフルエンサー本登録
    public function after_form(Request $request){

        $today = date("Y-m-d H:i:s");


        if (session()->has("user_id")){
            $user_id=session()->get("user_id");
        }else{
            return redirect('influencer');
        }

        $item=DB::table('influs')->where('user_id',$user_id)->first();
        $ids=$item->id;

        $year=$request->year;
        $month=$request->month;
        $days=$request->days;

        $birth="{$year}-{$month}-{$days}";

        $param=[
            'user_furigana'=>$request->name,
            'user_birth'=>$birth,
            'user_area'=>$request->area,
            'user_instagram_url'=>$request->instagram_url,
            'user_mail'=>$request->email,
            'user_address'=>$request->address,
            'user_phone'=>$request->tel01,
            'user_gender'=>$request->selector1,
            'user_child'=>$request->selector2,
            'user_pet'=>$request->selector3,
            'user_instagram_num'=>$request->instagram_num,
            'user_zimusyo'=>$request->selector6,
            'bank'=>$request->bank,
            'bank_type'=>$request->selector_bank,
            'bank_number'=>$request->bank_number,
            'cash_name'=>$request->cash_name,
            'user_flag'=>'2',
            'user_touroku'=>$today,
        ];

        if (!empty($request->google)){
            $param["user_google"]=$request->google;
        }else{
            $param["user_google"]='F';
        }
        if (!empty($request->taberogu)){
            $param["user_taberogu"]=$request->taberogu;
        }else{
            $param["user_taberogu"]='F';
        }
        if (!empty($request->sns_name1)){
            $param["user_sns_name1"]=$request->sns_name1;
        }else{
            $param["user_sns_name1"]='F';
        }
        if (!empty($request->sns_name2)){
            $param["user_sns_name2"]=$request->sns_name2;
        }else{
            $param["user_sns_name2"]='F';
        }
        if (!empty($request->sns_name3)){
            $param["user_sns_name3"]=$request->sns_name3;
        }else{
            $param["user_sns_name3"]='F';
        }

        $checkbox1=$request->checkbox1;
        $checkbox2=$request->checkbox2;

        foreach ($checkbox1 as $value){
            $param["user_genre$value"]="T";
        }

        foreach ($checkbox2 as $value){
            $param["todouhuken$value"]="T";
        }

        $files=$request->file('upfile');
        $dir_path="public/insite/";
        $file_path="insite-$ids/";


        if (!empty($files)){
            $i=1;
            foreach ($files as $file){
                if (!empty($file)){
                    $file_kari= $file->getClientOriginalName();
                    $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
                    $file_name="insite{$i}.{$extension}";


                    $file->storeAS('',$dir_path.$file_path.$file_name);
                    $param["user_insite_img$i"]=$file_path.$file_name;

                    $i+=1;
                }

            }
        }

        //アイコン画像
        $icon_path="public/icon/";
        $icon=$request->file('icon_img');

        if (!empty($icon)){
            $file_kari= $icon->getClientOriginalName();
            $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
            $file_name="icon-{$user_id}.{$extension}";


            $icon->storeAS('',$icon_path.$file_name);
        }

        DB::table('influs')
        ->where('user_id', $user_id)
        ->update($param);


        return redirect('influencer/second_form');


    }

    //パスワード再発行
    public function pass_reput(Request $request){
        $item=DB::table('influs')
        ->where('user_id',$request->id)
        ->where('user_name',$request->user_name)
        ->where('user_instagram_url',$request->user_instagram_url)
        ->first();

        if (empty($item)){
            $msg='ご入力いただいた登録情報は見つかりませんでした。';

        }else{
            $user_id=$item->user_id;
            $email=$item->user_mail;

            //パスワード 8文字
            $password=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('influs')
            ->where('user_id', $user_id)
            ->update(['user_pass'=>$password_hash]);

            $msg="ご登録いただいているメールアドレスへ仮パスワードを送付しました。";

            $param=[
                'user_name'=>$item->user_name,
                'password'=>$password,
            ];
            Mail::to($email)->send(new InfluPassReput($param));
        }
        return redirect('influencer/pass_forget')->with(['msg'=>$msg]);
    }

    //ログイン処理
    public function login(Request $request){

        $id=$request->id;
        $password_kari=$request->password;


        $item = DB::table('influs')->select('user_name','user_pass','user_flag')->where('user_id',$id)
        ->wherein('user_flag',['1','2'])
        // ->where('user_status','T')
        ->first();

        if (empty($item)){
            return view("influencer.index", ["error"=>'IDまたはパスワードが一致しません。']);

        }elseif (!empty($item->user_name)){
            $password=$item->user_pass;
            $user_flag=$item->user_flag;

            if (password_verify($password_kari, $password)){
                // セッションIDの再発行
                $request->session()->regenerate();
                $request->session()->put('user_id', $id);
                $request->session()->put('user_name', $item->user_name);

                if ($user_flag==="1"){
                    return redirect('influencer/second_form', 302, [], true);
                    // return redirect('influencer/second_form');
                }else{

                    return redirect('influencer/main', 302, [], true);
                    // return redirect('influencer/main');
                }
            }else{
                return view("influencer.index", ["error"=>'IDまたはパスワードが一致しません。']);
            }
        }else{
            return view("influencer.index", ["error"=>'エラーが発生しました。']);
        }

    }

    //未登録インフルエンサー取得
    public function index1(){
        $item = DB::table('influs')->select('id','user_name','user_oubo')->where('user_flag',0)->get();

        return view("administrator.admin_influ_1", ["item"=>$item]);

    }
    //登録済みインフルエンサー取得
    public function index2(Request $request){

        $user_name_s=$request->user_name_s;
        $user_address_s=$request->user_address_s;
        $user_instagram_num1_s=$request->user_instagram_num1_s;
        $user_instagram_num2_s=$request->user_instagram_num2_s;
        $checkbox1=$request->checkbox1;
        $checkbox2=$request->checkbox2;

        $todouhuken = Config::get('list.todouhuken');
        $user_genre = Config::get('list.user_genre');

        $query = Influ::query();


        if(!empty($user_name_s)){
            $query->where('user_name', 'like', '%'.$user_name_s.'%');
        }
        if(!empty($user_address_s)){
            $query->where('user_address', 'like', '%'.$user_address_s.'%');
        }
        if(!empty($user_instagram_num1_s)){
            $query->where('user_instagram_num', '>=', $user_instagram_num1_s);
        }
        if(!empty($user_instagram_num2_s)){
            $query->where('user_instagram_num', '<=', $user_instagram_num2_s);
        }

        if (!empty($checkbox1)){
            foreach ($checkbox1 as $value){
                $query->where($value, 'T');
            }
        }

        if (!empty($checkbox2)){
            foreach ($checkbox2 as $value){
                $query->where($value, 'T');
            }
        }

        //テンプレート取得
        $filename="laravel/public/storage/admin_template/admin_influ_template.txt";
        //ファイルがなければ作る
        if (!file_exists($filename)){
            touch($filename);
        }

        $f=file($filename);
        $template_list=[];
        $fword="";
        if (!empty($f)){
            $i=0;
            foreach ($f as $value){
                if ($value[0]==="<" && $value[1]===">"){
                    $template_list[$i]=$fword;
                    $i+=1;
                    $fword="";
                }else{
                    $fword=$fword.$value;
                }
            }
        }

        // var_dump($user_address_s);
        // exit;

        $param=[
            'user_name_s'=>$user_name_s,
            'user_address_s'=>$user_address_s,
            'user_instagram_num1_s'=>$user_instagram_num1_s,
            'user_instagram_num2_s'=>$user_instagram_num2_s,
        ];

        //メール送信履歴取得
        $filename="laravel/public/storage/admin_mail_history/admin_influ_history.txt";
        //ファイルがなければ作る
        if (!file_exists($filename)){
            touch($filename);
        }

        $f=file($filename);
        $id_list=[];
        $subject_list=[];
        $comment_list=[];
        $date_list=[];
        $fword="";
        if (!empty($f)){
            $i=0;
            $type='id';
            foreach ($f as $value){
                if ($value[0]==="<" && $value[1]===">"){
                    $comment_list[$i]=$fword;
                    $i+=1;
                    $fword="";
                    $type="id";
                }else{
                    if ($type==="subject"){
                        $subject_list[$i]=$value;
                        $type="comment";
                    }elseif ($type==="id"){
                        $id_kari=explode("<>",$value);
                        array_pop($id_kari);
                        $id_list[$i]=$id_kari;
                        $type="dates";
                    }elseif ($type==="dates"){
                        $date_list[$i]=$value;
                        $type="subject";
                    }else{
                        $fword=$fword.$value;
                    }

                }
            }

        }
        // var_dump($id_list);
        // exit;

        $item = $query
        ->select('user_id','user_name','user_touroku','user_instagram_num','user_status')
        ->where('user_flag',2)
        ->Paginate(20);

        $send_param=[
            "item"=>$item,
            'param'=>$param,
            'todouhuken'=>$todouhuken,
            'user_genre'=>$user_genre,
            'checkbox1'=>$checkbox1,
            'checkbox2'=>$checkbox2,
            'template_list'=>$template_list,
            'id_list'=>$id_list,
            'subject_list'=>$subject_list,
            'comment_list'=>$comment_list,
            'date_list'=>$date_list,
        ];

        return view("administrator.admin_influ_2", $send_param);

    }

    //運営者インフルエンサーへのメール送信テンプレート取得
    public function admin_influ_template(){
        $filename="laravel/public/storage/admin_template/admin_influ_template.txt";
        //ファイルがなければ作る
        if (!file_exists($filename)){
            touch($filename);
        }

        $f=file($filename);
        $template_list=[];
        $fword="";
        if (!empty($f)){
            $i=0;
            foreach ($f as $value){
                if ($value[0]==="<" && $value[1]===">"){
                    $template_list[$i]=$fword;
                    $i+=1;
                    $fword="";
                }else{
                    $fword=$fword.$value;
                }
            }
        }

        return view("administrator.admin_influ_template",["template_list"=>$template_list]);
    }

    public function admin_influ_template_edit(Request $request){
        $filename="laravel/public/storage/admin_template/admin_influ_template.txt";

        $text_list=$request->template;
        $f = fopen($filename, "w+");  //書き込みモードで開く
        flock($f, LOCK_EX); // ファイルをロックする

        foreach ($text_list as $value){
            if (!empty($value)){
                fwrite($f, $value."\n<>\n");  //<>で追記
            }
        }

        fclose($f);
        // var_dump($text_list);
        // exit;
        $msg="テンプレートを編集しました。";
        return redirect('administrator/admin_influ_2')->with(['msg'=>$msg]);
    }

    //運営側インフルエンサーリストダウンロード
    public function influ_csv($user_name_s,$user_address_s,$user_instagram_num1_s,$user_instagram_num2_s,$checkbox1,$checkbox2){

        $todouhuken = Config::get('list.todouhuken');
        $user_genre = Config::get('list.user_genre');
        $user_status = Config::get('list.user_status');

        $query = Influ::query();


        if($user_name_s!=="<>"){
            $query->where('user_name', 'like', '%'.$user_name_s.'%');
        }
        if($user_address_s!=="<>"){
            $query->where('user_address', 'like', '%'.$user_address_s.'%');
        }
        if($user_instagram_num1_s!=="<>"){
            $query->where('user_instagram_num', '>=', $user_instagram_num1_s);
        }
        if($user_instagram_num2_s!=="<>"){
            $query->where('user_instagram_num', '<=', $user_instagram_num2_s);
        }


        if ($checkbox1!=="<>"){
            parse_str($checkbox1,$checkbox1);
            foreach ($checkbox1 as $value){
                $query->where($value, 'T');
            }
        }

        if ($checkbox2!="<>"){
            parse_str($checkbox2,$checkbox2);
            foreach ($checkbox2 as $value){
                $query->where($value, 'T');
            }
        }


        $item = $query
        ->where('user_flag',2)
        ->get();

        $filename="influencer_list.csv";

        $csv_list=[
            'ID',
            '名前',
            '名前（フリガナ）',
            '生年月日',
            '郵便番号',
            '住所',
            'メールアドレス',
            '電話番号',
            '性別',
            '子供の有無',
            'ペットの有無',
            'インスタグラムURL',
            'インスタグラムフォロワー数',
            'Google Map',
            '食べログ',
            '事務所への所属',
            'ステータス',
        ];

        $j=1;
        foreach ($user_genre as $keys=>$values){
            $csv_list[]="得意なジャンル（{$values}）";
            $j+=1;
        }
        $j=1;
        foreach ($todouhuken as $keys=>$values){
            $csv_list[]="主な活動エリア（{$values}）";
            $j+=1;
        }

        $arinashi=[
            'T'=>'有',
            'F'=>'無',
        ];

        $kahi=[
            'T'=>'○',
            'F'=>'',
        ];

        $genre_num=0;
        $todouhuken_num=0;

        $required_list=[];
        $i=1;
        foreach ($item as $key=>$value){
            $required_list[$i][]=$value->user_id;
            $required_list[$i][]=$value->user_name;
            $required_list[$i][]=$value->user_furigana;
            $required_list[$i][]=$value->user_birth;
            $required_list[$i][]=$value->user_area;
            $required_list[$i][]=$value->user_address;
            $required_list[$i][]=$value->user_mail;
            $required_list[$i][]=$value->user_phone;
            $required_list[$i][]=$value->user_gender;
            $required_list[$i][]=$arinashi[$value->user_child];
            $required_list[$i][]=$arinashi[$value->user_pet];
            $required_list[$i][]=$value->user_instagram_url;
            $required_list[$i][]=$value->user_instagram_num;
            if ($value->user_google==="F"){
                $value->user_google="";
            }
            if ($value->user_blog==="F"){
                $value->user_blog="";
            }
            $required_list[$i][]=$value->user_google;
            $required_list[$i][]=$value->user_blog;
            $required_list[$i][]=$arinashi[$value->user_zimusyo];
            $required_list[$i][]=$user_status[$value->user_status];

            foreach ($user_genre as $keys=>$values){
                $required_list[$i][]=$kahi[$value->{$keys}];
            }


            foreach ($todouhuken as $keys=>$values){
                $required_list[$i][]=$kahi[$value->{$keys}];
            }

            $i+=1;
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

    //運営側のインフルエンサーへのメール送信
    public function mail_to_selected_influ(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $check=$request->check;

        $item=DB::table('influs')
        ->select('user_mail')
        ->whereIn('user_id',$check)
        ->get();

        $mail_list=[];
        foreach($item as $value){
            $mail_list[]=$value->user_mail;
        }

        $param=[
            'whose'=>'I',
            'comment'=>$request->comment,
            'subject'=>$request->subject,
        ];

        foreach ($mail_list as $value){
            Mail::to($value)->send(new SelectedFromAdmin($param));
        }

        // メール送信の履歴確認
        $filename="laravel/public/storage/admin_mail_history/admin_influ_history.txt";

        $f = fopen($filename, "a+");  //追記モードで開く
        flock($f, LOCK_EX); // ファイルをロックする

        foreach ($check as $value){
            if (!empty($value)){
                fwrite($f, $value."<>");  //<>で追記
            }
        }

        $today=date("Y/m/d H:i:s");

        fwrite($f, "\n".$today."\n".$request->subject."\n".$request->comment."\n<>\n");

        fclose($f);


        $msg="メールを送信しました。";

        return redirect('administrator/admin_influ_2')->with('msg',$msg);
    }

    //未登録インフルエンサー詳細情報
    public function index1_detail($id){
        $item = DB::table('influs')->where('id',$id)->first();

        $user_comment=$item->user_comment;

        $items_1=[
            'user_name'=>$item->user_name,
            'user_furigana'=>$item->user_furigana,
            'user_mail'=>$item->user_mail,
            'user_birth'=>$item->user_birth,
            // 'user_instagram_url'=>$item->user_instagram_url,
            'user_follower_num'=>$item->user_follower_num,
            // 'user_taberogu'=>$item->user_taberogu,
            // 'user_google'=>$item->user_google,
            // 'user_other'=>$item->user_other,
        ];

        $items_2=[
            'user_instagram_url'=>$item->user_instagram_url,
            'user_taberogu'=>$item->user_taberogu,
            'user_google'=>$item->user_google,
            'user_other'=>$item->user_other,
        ];

        $influ_column_1=[
            'user_name'=>'名前',
            'user_furigana'=>'フリガナ',
            'user_mail'=>'メールアドレス',
            'user_birth'=>'生年月日',
            // 'user_instagram_url'=>'インスタグラムURL',
            'user_follower_num'=>'フォロワー数',
            // 'user_taberogu'=>'食べログ',
            // 'user_google'=>'Google',
            // 'user_other'=>'その他',
        ];

        $influ_column_2=[
            'user_instagram_url'=>'インスタグラムURL',
            'user_taberogu'=>'食べログURL',
            'user_google'=>'Google Map URL',
            'user_other'=>'その他',
        ];

        $insite=[
            'user_insite_img1'=>$item->user_insite_img1,
            'user_insite_img2'=>$item->user_insite_img2,
            'user_insite_img3'=>$item->user_insite_img3,
        ];

        // $toukou=[
        //     ''=>'',
        //     'T'=>'投稿可',
        //     'F'=>'投稿不可',
        // ];

        return view("administrator.admin_influ_1_detail", ['insite'=>$insite,"param"=>$influ_column_1,"param_2"=>$influ_column_2,"item"=>$items_1,"item_2"=>$items_2,"id"=>$id,'user_comment'=>$user_comment]);
    }

    //登録済みインフルエンサー詳細情報
    public function index2_detail($user_id){
        $item = DB::table('influs')->where('user_id',$user_id)->first();
        $user_name = DB::table('influs')->select('user_name')->where('user_id',$user_id)->first();

        $todouhuken = Config::get('list.todouhuken');
        $user_status_list = Config::get('list.user_status');


        foreach ($todouhuken as $value){
            if (strpos($item->user_address,$value)===0){
                $user_address1=$value;
                $user_address2=str_replace($value,'',$item->user_address);
            }
        }

        if (empty($user_address1) && empty($user_address2)){
            $user_address1=$item->user_address;
            $user_address2="";
        }

        $items=[
            "user_name"=>$item->user_name,
            "user_furigana"=>$item->user_furigana,
            "user_touroku"=>$item->user_touroku,
            "user_birth"=>$item->user_birth,
            "user_area"=>$item->user_area,
            "user_address1"=>$user_address1,
            "user_address2"=>$user_address2,
            "user_mail"=>$item->user_mail,
            "user_phone"=>$item->user_phone,
            "user_gender"=>$item->user_gender,
            "user_child"=>$item->user_child,
            "user_pet"=>$item->user_pet,
            "user_instagram_url"=>$item->user_instagram_url,
            "user_instagram_num"=>$item->user_instagram_num,
            'user_taberogu'=>$item->user_taberogu,
            'user_google'=>$item->user_google,
            'user_taberogu'=>$item->user_taberogu,
            'user_google'=>$item->user_google,
            // 'user_other'=>$item->user_other,
            "user_zimusyo"=>$item->user_zimusyo,
            "bank"=>$item->bank,
            "bank_type"=>$item->bank_type,
            "bank_number"=>$item->bank_number,
            "cash_name"=>$item->cash_name,
        ];

        $items2=[
            'user_genre1'=>$item->user_genre1,
            'user_genre2'=>$item->user_genre2,
            'user_genre3'=>$item->user_genre3,
            'user_genre4'=>$item->user_genre4,
            'user_genre5'=>$item->user_genre5,
            'user_genre6'=>$item->user_genre6,
            'user_genre7'=>$item->user_genre7,
            'user_genre8'=>$item->user_genre8,
            'user_genre9'=>$item->user_genre9,
            'user_genre10'=>$item->user_genre10,
            'user_genre11'=>$item->user_genre11,
            'user_genre12'=>$item->user_genre12,
            'user_genre13'=>$item->user_genre13,
            'user_genre14'=>$item->user_genre14,
            'user_genre15'=>$item->user_genre15,
            'user_genre16'=>$item->user_genre16,
            'user_genre17'=>$item->user_genre17,
            'user_genre18'=>$item->user_genre18,
            'user_genre19'=>$item->user_genre19,
            'user_genre20'=>$item->user_genre20,
            'user_genre21'=>$item->user_genre21,
            'user_genre22'=>$item->user_genre22,
            'user_genre23'=>$item->user_genre23,
        ];

        $items3=[
            'todouhuken1'=>$item->todouhuken1,
            'todouhuken2'=>$item->todouhuken2,
            'todouhuken3'=>$item->todouhuken3,
            'todouhuken4'=>$item->todouhuken4,
            'todouhuken5'=>$item->todouhuken5,
            'todouhuken6'=>$item->todouhuken6,
            'todouhuken7'=>$item->todouhuken7,
            'todouhuken8'=>$item->todouhuken8,
            'todouhuken9'=>$item->todouhuken9,
            'todouhuken10'=>$item->todouhuken10,
            'todouhuken11'=>$item->todouhuken11,
            'todouhuken12'=>$item->todouhuken12,
            'todouhuken13'=>$item->todouhuken13,
            'todouhuken14'=>$item->todouhuken14,
            'todouhuken15'=>$item->todouhuken15,
            'todouhuken16'=>$item->todouhuken16,
            'todouhuken17'=>$item->todouhuken17,
            'todouhuken18'=>$item->todouhuken18,
            'todouhuken19'=>$item->todouhuken19,
            'todouhuken20'=>$item->todouhuken20,
            'todouhuken21'=>$item->todouhuken21,
            'todouhuken22'=>$item->todouhuken22,
            'todouhuken23'=>$item->todouhuken23,
            'todouhuken24'=>$item->todouhuken24,
            'todouhuken25'=>$item->todouhuken25,
            'todouhuken26'=>$item->todouhuken26,
            'todouhuken27'=>$item->todouhuken27,
            'todouhuken28'=>$item->todouhuken28,
            'todouhuken29'=>$item->todouhuken29,
            'todouhuken30'=>$item->todouhuken30,
            'todouhuken31'=>$item->todouhuken31,
            'todouhuken32'=>$item->todouhuken32,
            'todouhuken33'=>$item->todouhuken33,
            'todouhuken34'=>$item->todouhuken34,
            'todouhuken35'=>$item->todouhuken35,
            'todouhuken36'=>$item->todouhuken36,
            'todouhuken37'=>$item->todouhuken37,
            'todouhuken38'=>$item->todouhuken38,
            'todouhuken39'=>$item->todouhuken39,
            'todouhuken40'=>$item->todouhuken40,
            'todouhuken41'=>$item->todouhuken41,
            'todouhuken42'=>$item->todouhuken42,
            'todouhuken43'=>$item->todouhuken43,
            'todouhuken44'=>$item->todouhuken44,
            'todouhuken45'=>$item->todouhuken45,
            'todouhuken46'=>$item->todouhuken46,
            'todouhuken47'=>$item->todouhuken47,
        ];


        $user_sns_name1=$item->user_sns_name1;
        $user_sns_name2=$item->user_sns_name2;
        $user_sns_name3=$item->user_sns_name3;


        $influ_column_2=[
            "user_name"=>'名前',
            "user_furigana"=>'フリガナ',
            "user_touroku"=>'本登録日',
            "user_birth"=>'生年月日',
            "user_area"=>'郵便番号',
            "user_address1"=>'住所1',
            "user_address2"=>'住所2',
            "user_mail"=>'メールアドレス',
            "user_phone"=>'電話番号',
            "user_gender"=>'性別',
            "user_child"=>'子供の有無',
            "user_pet"=>'ペット（犬・猫）の有無',
            "user_instagram_url"=>'instagram URL',
            "user_instagram_num"=>'instagram フォロワー数',
            'user_taberogu'=>'食べログ URL',
            'user_google'=>'Google Map URL',
            // "user_google_num"=>'Google Mapのフォロワー数',
            // "user_taberogu_num"=>'食べログのフォロワー数',
            // "user_sns_num1"=>"{$user_sns_name1}のフォロワー数",
            // "user_sns_num2"=>"{$user_sns_name2}のフォロワー数",
            // "user_sns_num3"=>"{$user_sns_name3}のフォロワー数",
            "user_zimusyo"=>'事務所への所属',
            "bank"=>'銀行名',
            "bank_type"=>'口座種別',
            "bank_number"=>'口座番号',
            "cash_name"=>'口座名義',
        ];

        $sns_name=[
            // 'user_taberogu'=>$item->user_taberogu,
            // 'user_google'=>$item->user_google,
            // 'user_blog'=>$item->user_blog,
            'user_sns_name1'=>$item->user_sns_name1,
            'user_sns_name2'=>$item->user_sns_name2,
            'user_sns_name3'=>$item->user_sns_name3,
        ];
        $param2=[
            'user_taberogu'=>'食べログ',
            'user_google'=>'Google Map',
            'user_blog'=>'ブログ',
        ];


        $follower=[
            ""=>'',
            "A"=>'～4,999',
            "B"=>'～9,999',
            "C"=>'～14,999',
            "D"=>'15,000～',
        ];

        $insite=[
            'user_insite_img1'=>$item->user_insite_img1,
            'user_insite_img2'=>$item->user_insite_img2,
            'user_insite_img3'=>$item->user_insite_img3,
        ];
        $arinashi=[
            'T'=>'あり',
            'F'=>'なし',
        ];

        $status_magazine=[
            // 'user_status'=>$item->user_status,
            'mail_magazine'=>$item->mail_magazine,
        ];
        $status_magazine_name=[
            'user_status'=>'ステータス',
            'mail_magazine'=>'メルマガ配信',
        ];


        $send_param=[
            'param2'=>$param2,
            'insite'=>$insite,
            'sns_name'=>$sns_name,
            "param"=>$influ_column_2,
            "item"=>$items,
            "item3"=>$items3,
            "item2"=>$items2,
            "user_id"=>$user_id,
            "follower"=>$follower,
            "arinashi"=>$arinashi,
            "status_magazine"=>$status_magazine,
            "status_magazine_name"=>$status_magazine_name,
            'user_status'=>$item->user_status,
            'user_status_list'=>$user_status_list,
        ];

        return view("administrator.admin_influ_2_detail", $send_param);
    }

    //運営者　登録済みインフルエンサーのステータス・メルマガ
    public function index2_post(Request $request){

        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $user_id=$request->user_id;

        $param=[
            'user_status'=>$request->user_status,
            'mail_magazine'=>$request->mail_magazine,
        ];

        DB::table('influs')->where('user_id',$user_id)
        ->update($param);

        $msg=Config::get('const.title.title2')."情報を更新しました。";

        return redirect("administrator/admin_influ_2_detail/$user_id")->with('msg',$msg);
    }

    //インフルエンサーアカウント情報
    public function account_get(){

        if (!session()->has('user_id')){
            return redirect('influencer');
        }

        $user_id=session()->get('user_id');

        $item=DB::table('influs')->where('user_id',$user_id)->first();

        $todouhuken = Config::get('list.todouhuken');

        $user_address=$item->user_address;


        foreach ($todouhuken as $value){
            if (strpos($item->user_address,$value)===0){
                $user_address1=$value;
                $user_address2=str_replace($value,'',$item->user_address);
            }
        }

        if (empty($user_address1) && empty($user_address2)){
            $user_address1=$item->user_address;
            $user_address2="";
        }

        $items=[
            "user_name"=>$item->user_name,
            "user_furigana"=>$item->user_furigana,
            "user_touroku"=>$item->user_touroku,
            "user_birth"=>$item->user_birth,
            "user_area"=>$item->user_area,
            "user_address1"=>$user_address1,
            "user_address2"=>$user_address2,
            "user_mail"=>$item->user_mail,
            "user_phone"=>$item->user_phone,
            "user_gender"=>$item->user_gender,
            "user_child"=>$item->user_child,
            "user_pet"=>$item->user_pet,
            "user_instagram_url"=>$item->user_instagram_url,
            "user_instagram_num"=>$item->user_instagram_num,
            'user_taberogu'=>$item->user_taberogu,
            'user_google'=>$item->user_google,
            'user_taberogu'=>$item->user_taberogu,
            'user_google'=>$item->user_google,
            // 'user_other'=>$item->user_other,
            "user_zimusyo"=>$item->user_zimusyo,
            "bank"=>$item->bank,
            "bank_type"=>$item->bank_type,
            "bank_number"=>$item->bank_number,
            "cash_name"=>$item->cash_name,
        ];

        $items2=[
            'user_genre1'=>$item->user_genre1,
            'user_genre2'=>$item->user_genre2,
            'user_genre3'=>$item->user_genre3,
            'user_genre4'=>$item->user_genre4,
            'user_genre5'=>$item->user_genre5,
            'user_genre6'=>$item->user_genre6,
            'user_genre7'=>$item->user_genre7,
            'user_genre8'=>$item->user_genre8,
            'user_genre9'=>$item->user_genre9,
            'user_genre10'=>$item->user_genre10,
            'user_genre11'=>$item->user_genre11,
            'user_genre12'=>$item->user_genre12,
            'user_genre13'=>$item->user_genre13,
            'user_genre14'=>$item->user_genre14,
            'user_genre15'=>$item->user_genre15,
            'user_genre16'=>$item->user_genre16,
            'user_genre17'=>$item->user_genre17,
            'user_genre18'=>$item->user_genre18,
            'user_genre19'=>$item->user_genre19,
            'user_genre20'=>$item->user_genre20,
            'user_genre21'=>$item->user_genre21,
            'user_genre22'=>$item->user_genre22,
            'user_genre23'=>$item->user_genre23,
        ];

        $items3=[
            'todouhuken1'=>$item->todouhuken1,
            'todouhuken2'=>$item->todouhuken2,
            'todouhuken3'=>$item->todouhuken3,
            'todouhuken4'=>$item->todouhuken4,
            'todouhuken5'=>$item->todouhuken5,
            'todouhuken6'=>$item->todouhuken6,
            'todouhuken7'=>$item->todouhuken7,
            'todouhuken8'=>$item->todouhuken8,
            'todouhuken9'=>$item->todouhuken9,
            'todouhuken10'=>$item->todouhuken10,
            'todouhuken11'=>$item->todouhuken11,
            'todouhuken12'=>$item->todouhuken12,
            'todouhuken13'=>$item->todouhuken13,
            'todouhuken14'=>$item->todouhuken14,
            'todouhuken15'=>$item->todouhuken15,
            'todouhuken16'=>$item->todouhuken16,
            'todouhuken17'=>$item->todouhuken17,
            'todouhuken18'=>$item->todouhuken18,
            'todouhuken19'=>$item->todouhuken19,
            'todouhuken20'=>$item->todouhuken20,
            'todouhuken21'=>$item->todouhuken21,
            'todouhuken22'=>$item->todouhuken22,
            'todouhuken23'=>$item->todouhuken23,
            'todouhuken24'=>$item->todouhuken24,
            'todouhuken25'=>$item->todouhuken25,
            'todouhuken26'=>$item->todouhuken26,
            'todouhuken27'=>$item->todouhuken27,
            'todouhuken28'=>$item->todouhuken28,
            'todouhuken29'=>$item->todouhuken29,
            'todouhuken30'=>$item->todouhuken30,
            'todouhuken31'=>$item->todouhuken31,
            'todouhuken32'=>$item->todouhuken32,
            'todouhuken33'=>$item->todouhuken33,
            'todouhuken34'=>$item->todouhuken34,
            'todouhuken35'=>$item->todouhuken35,
            'todouhuken36'=>$item->todouhuken36,
            'todouhuken37'=>$item->todouhuken37,
            'todouhuken38'=>$item->todouhuken38,
            'todouhuken39'=>$item->todouhuken39,
            'todouhuken40'=>$item->todouhuken40,
            'todouhuken41'=>$item->todouhuken41,
            'todouhuken42'=>$item->todouhuken42,
            'todouhuken43'=>$item->todouhuken43,
            'todouhuken44'=>$item->todouhuken44,
            'todouhuken45'=>$item->todouhuken45,
            'todouhuken46'=>$item->todouhuken46,
            'todouhuken47'=>$item->todouhuken47,
        ];


        $user_sns_name1=$item->user_sns_name1;
        $user_sns_name2=$item->user_sns_name2;
        $user_sns_name3=$item->user_sns_name3;


        $influ_column_2=[
            "user_name"=>'名前',
            "user_furigana"=>'フリガナ',
            "user_touroku"=>'本登録日',
            "user_birth"=>'生年月日',
            "user_area"=>'郵便番号',
            "user_address1"=>'住所1',
            "user_address2"=>'住所2',
            "user_mail"=>'メールアドレス',
            "user_phone"=>'電話番号',
            "user_gender"=>'性別',
            "user_child"=>'子供の有無',
            "user_pet"=>'ペット（犬・猫）の有無',
            "user_instagram_url"=>'instagram URL',
            "user_instagram_num"=>'instagram フォロワー数',
            'user_taberogu'=>'食べログ URL',
            'user_google'=>'Google Map URL',
            // "user_google_num"=>'Google Mapのフォロワー数',
            // "user_taberogu_num"=>'食べログのフォロワー数',
            // "user_sns_num1"=>"{$user_sns_name1}のフォロワー数",
            // "user_sns_num2"=>"{$user_sns_name2}のフォロワー数",
            // "user_sns_num3"=>"{$user_sns_name3}のフォロワー数",
            "user_zimusyo"=>'事務所への所属',
            "bank"=>'銀行名',
            "bank_type"=>'口座種別',
            "bank_number"=>'口座番号',
            "cash_name"=>'口座名義',
        ];

        $sns_name=[
            // 'user_taberogu'=>$item->user_taberogu,
            // 'user_google'=>$item->user_google,
            // 'user_blog'=>$item->user_blog,
            'user_sns_name1'=>$item->user_sns_name1,
            'user_sns_name2'=>$item->user_sns_name2,
            'user_sns_name3'=>$item->user_sns_name3,
        ];
        $param2=[
            'user_taberogu'=>'食べログ',
            'user_google'=>'Google Map',
            'user_blog'=>'ブログ',
        ];


        $follower=[
            ""=>'',
            "A"=>'～4,999',
            "B"=>'～9,999',
            "C"=>'～14,999',
            "D"=>'15,000～',
        ];

        $insite=[
            'user_insite_img1'=>$item->user_insite_img1,
            'user_insite_img2'=>$item->user_insite_img2,
            'user_insite_img3'=>$item->user_insite_img3,
        ];
        $arinashi=[
            'T'=>'あり',
            'F'=>'なし',
        ];

        $url=url()->previous();
        $keys = parse_url($url); //パース処理
        $path = explode("/", $keys['path']); //分割処理
        $last = end($path); //最後の要素を取得

        if ($last==="user_account"){
            return view("influencer.user_account_edit", ['param2'=>$param2,'insite'=>$insite,'sns_name'=>$sns_name,"param"=>$influ_column_2,"item"=>$items,"item2"=>$items2,"item3"=>$items3,"user_id"=>$user_id,"follower"=>$follower,"arinashi"=>$arinashi,'user_address'=>$user_address]);
        }else{
            return view("influencer.user_account", ['param2'=>$param2,'insite'=>$insite,'sns_name'=>$sns_name,"param"=>$influ_column_2,"item"=>$items,"item2"=>$items2,"item3"=>$items3,"user_id"=>$user_id,"follower"=>$follower,"arinashi"=>$arinashi]);
        }
    }

    //インフルエンサーアカウント情報編集
    public function account_edit(Request $request){
        if (!session()->has('user_id')){
            return redirect('influencer');
        }


        $user_id=session()->get('user_id');

        $param=[
            "user_name"=>$request->user_name,
            "user_furigana"=>$request->user_furigana,
            "user_area"=>$request->user_area,
            "user_address"=>$request->user_address,
            "user_mail"=>$request->user_mail,
            "user_phone"=>$request->user_phone,
            "user_child"=>$request->user_child,
            "user_pet"=>$request->user_pet,
            "user_instagram_url"=>$request->user_instagram_url,
            "user_instagram_num"=>$request->user_instagram_num,
            "user_zimusyo"=>$request->user_zimusyo,
            "bank"=>$request->bank,
            "bank_type"=>$request->bank_type,
            "bank_number"=>$request->bank_number,
            "cash_name"=>$request->cash_name,
        ];

        if (!empty($request->user_google)){
            $param["user_google"]=$request->user_google;
        }else{
            $param["user_google"]='F';
        }
        if (!empty($request->user_taberogu)){
            $param["user_taberogu"]=$request->user_taberogu;
        }else{
            $param["user_taberogu"]='F';
        }
        if (!empty($request->user_sns_name1)){
            $param["user_sns_name1"]=$request->user_sns_name1;
        }else{
            $param["user_sns_name1"]='F';
        }
        if (!empty($request->user_sns_name2)){
            $param["user_sns_name2"]=$request->user_sns_name2;
        }else{
            $param["user_sns_name2"]='F';
        }
        if (!empty($request->user_sns_name3)){
            $param["user_sns_name3"]=$request->user_sns_name3;
        }else{
            $param["user_sns_name3"]='F';
        }

        $checkbox=$request->checkbox;
        $checkbox2=$request->checkbox2;

        $genre_list = Config::get('list.user_genre');
        $todouhukien_list = Config::get('list.todouhuken');


        //一旦全てFに
        for ($i=1;$i<=count($genre_list);$i++){
            $param["user_genre$i"]="F";
        }


        foreach ($checkbox as $value){
            $param["user_genre$value"]="T";
        }

        //都道府県
        foreach ($todouhukien_list as $key=>$value){
            $param[$key]="F";
        }

        foreach ($checkbox2 as $value){
            $param["todouhuken$value"]="T";
        }

        //チャット部分
        $item_contact=DB::table('contacts')
        ->where('contact_id',$user_id)
        ->where('contact_from','I')
        ->count();

        if ($item_contact>0){
            $contact_param=[
                "contact_name"=>$request->user_name,
                "contact_mail"=>$request->user_mail,
                "contact_phone"=>$request->user_phone,
            ];

            DB::table('contacts')
            ->where('contact_from','I')
            ->where('contact_id',$user_id)
            ->update($contact_param);
        }


        // $files=$request->file('upfile');
        // $dir_path="public/insite/";
        // $file_path="insite-$ids/";


        // if (!empty($files)){
        //     $i=1;
        //     foreach ($files as $file){
        //         if (!empty($file)){
        //             $file_kari= $file->getClientOriginalName();
        //             $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
        //             $file_name="insite{$i}.{$extension}";


        //             $file->storeAS('',$dir_path.$file_path.$file_name);
        //             $param["user_insite_img$i"]=$file_path.$file_name;

        //             $i+=1;
        //         }

        //     }
        // }

        //アイコン画像
        $icon_path="public/icon/";
        $icon=$request->file('icon_img');



        if (!empty($icon)){
            //一旦可能性あるものを削除
            Storage::delete("{$icon_path}icon-{$user_id}.png");
            Storage::delete("{$icon_path}icon-{$user_id}.jpg");
            Storage::delete("{$icon_path}icon-{$user_id}.jpeg");
            $file_kari= $icon->getClientOriginalName();
            $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
            $file_name="icon-{$user_id}.{$extension}";


            $icon->storeAS('',$icon_path.$file_name);
        }

        DB::table('influs')
        ->where('user_id', $user_id)
        ->update($param);

        $msgs="アカウント情報を編集しました。";

        return redirect('influencer/user_account')->with('msgs',$msgs);
    }

    //パスワード変更
    public function influ_pass_edit(Request $request){
        if (!session()->has('user_id')){
            return redirect('influencer');
        }

        $user_id=session()->get('user_id');

        $password=$request->password;
        $password2=$request->password2;

        if ($password===$password2){
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('influs')
            ->where('user_id', $user_id)
            ->update(['user_pass'=>$password_hash]);

            $msgs="パスワードを変更しました。";
            return redirect('influencer/user_account')->with('msgs',$msgs);
        }elseif (strlen($password)<8){
            $msgs="パスワードには8文字以上を設定してください。";
            return redirect('influencer/user_account_password')->with('msgs',$msgs);
        }else{
            $msgs="確認用パスワードが異なります。";
            return redirect('influencer/user_account_password')->with('msgs',$msgs);
        }
    }
}
