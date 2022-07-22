<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Insyoku;

use App\Mail\ClientOuboMail;
use App\Mail\ClientKariMail;
use App\Mail\ClientPassReput;
use App\Mail\SelectedFromAdmin;
use Mail;

use Illuminate\Support\Facades\Storage;

class InsyokuController extends Controller
{

    //クライアント事前登録
    public function before_form(Request $request){
        //日時
        $today = date("Y-m-d H:i:s");

        $shop_mail=$request->email;

        $item=DB::table('insyokus')->where('shop_mail',$shop_mail)->count();

        if ($item!==0){
            $msgs="既に登録済みのメールアドレスです。";
            return redirect('client/first_form')->with('msgs', $msgs);
        }

        $param=[
            'shop_name'=>$request->name,
            'shop_tantou'=>$request->client_name,
            'shop_phone'=>$request->tel01,
            'shop_mail'=>$request->email,
            'shop_address'=>$request->address,
            'shop_station'=>$request->station,
            'shop_tanka'=>$request->selector1,
            'shop_gender'=>$request->selector2,
            'shop_oubo'=>$today,
            'shop_flag'=>'0',
        ];

        $checkbox1=$request->input("checkbox1");
        $checkbox2=$request->input("checkbox2");
        $checkbox3=$request->input("checkbox3");
        $checkbox4=$request->input("checkbox4");
        $checkbox5=$request->input("checkbox5");

        for ($i=0;$i<6;$i++){
            if (!empty($checkbox1[$i])){
                $check_name="shop_age$checkbox1[$i]";
                $param[$check_name]="T";
            }
        }
        for ($i=0;$i<10;$i++){
            if (!empty($checkbox2[$i])){
                $check_name="shop_way$checkbox2[$i]";
                $param[$check_name]="T";
            }
        }

        for ($i=0;$i<7;$i++){
            if (!empty($checkbox3[$i])){
                $check_name="shop_purpose$checkbox3[$i]";
                $param[$check_name]="T";
            }
        }
        for ($i=0;$i<6;$i++){
            if (!empty($checkbox4[$i])){
                $check_name="shop_gather$checkbox4[$i]";
                $param[$check_name]="T";
            }
        }
        for ($i=0;$i<9;$i++){
            if (!empty($checkbox5[$i])){
                $check_name="shop_site$checkbox5[$i]";
                $param[$check_name]="T";
            }
        }

        if (!empty($request->client_url)){
            $param["shop_url"]=$request->client_url;
        }
        if (!empty($request->long_text)){
            $param["shop_question"]=$request->long_text;
        }


        DB::table('insyokus')->insert($param);
        Mail::to($request->email)->send(new ClientKariMail());

        return view("client.first_form", ["msg"=>'応募が完了しました。','msg2'=>'結果についてはご登録いただいたメールアドレスへ通知いたします。']);

    }

    //パスワード再発行
    public function pass_reput(Request $request){
        $item=DB::table('insyokus')
        ->where('shop_id',$request->id)
        ->where('shop_name',$request->client_name)
        ->where('shop_address',$request->client_address)
        ->first();

        if (empty($item)){
            $msg='ご入力いただいた登録情報は見つかりませんでした。';

        }else{
            $shop_id=$item->shop_id;
            $email=$item->shop_mail;

            //パスワード 8文字
            $password=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('insyokus')
            ->where('shop_id', $shop_id)
            ->update(['shop_pass'=>$password_hash]);

            $msg="ご登録いただいているメールアドレスへ仮パスワードを送付しました。";

            $param=[
                'shop_name'=>$item->shop_name,
                'shop_tantou'=>$item->shop_tantou,
                'password'=>$password,
            ];
            Mail::to($email)->send(new ClientPassReput($param));
        }
        return redirect('client/pass_forget')->with(['msg'=>$msg]);
    }

    //クライアント本登録準備
    public function after_form_pre(){
        if (session()->has("shop_id")){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect('client');
        }

        $config_param = Config::get('list.config_client');
        $item_config=DB::table('configs')->where('id','1')->first();

        $item=DB::table('insyokus')->where('shop_id',$shop_id)->first();

        $view_param=[
            'item_config'=>$item_config,
            'item'=>$item,
        ];
        return view("client.second_form", $view_param);

    }

    //クライアント本登録
    public function after_form(Request $request){

        $today = date("Y-m-d H:i:s");

        $checkbox1=$request->input("checkbox1");
        $checkbox2=$request->input("checkbox2");
        $checkbox3=$request->input("checkbox3");

        if (session()->has("shop_id")){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect('client');
        }

        $param=[
            'shop_name'=>$request->name,
            'shop_tantou'=>$request->client_name,
            'shop_phone'=>$request->tel01,
            'shop_mail'=>$request->email,
            'shop_area'=>$request->zip,
            'shop_address'=>$request->address,
            'shop_station'=>$request->train_station,
            'shop_open_time'=>$request->open_time,
            'shop_close_date'=>$request->close_date,
            'shop_single_space'=>$request->radio1,
            'shop_child'=>$request->radio2,
            'shop_pet'=>$request->radio3,
            'shop_flag'=>'2',
            'shop_touroku'=>$today,
        ];
        if (empty($request->selector1) && empty($request->checkbox1) && empty($request->checkbox2) && empty($request->checkbox3)){

        }else{

            $error="";
            $item_config=DB::table('configs')->where('id','1')->first();

            $param["shop_new"]="T";

            if ($item_config->new_tanka==="T"){
                if (empty($request->selector1)){
                    $error="店舗客単価は必須項目です。";
                }
            }


            if ($item_config->new_genre==="T"){
                if (empty($checkbox1)){
                    $error='ジャンル・カテゴリは一つは必須です。';
                }
            }
            if ($item_config->new_age==="T"){
                if (empty($checkbox2)){
                    $error='ターゲットの年齢層は一つは必須です。';
                }
            }
            if ($item_config->new_gender==="T"){
                if (empty($checkbox3)){
                    $error='ターゲットの性別は一つは必須です。';
                }
            }
            if ($item_config->new_concept==="T"){
                if (empty($request->message)){
                    $error='店舗or企業のコンセプトは必須です。';
                }
            }

            if ($error!==""){
                return redirect('client/second_form')->with('error', $error);
            }

            $param["shop_new_tanka"]=$request->selector1;

            for ($i=0;$i<10;$i++){
                if (!empty($checkbox1[$i])){
                    $check_name="shop_new_genre$checkbox1[$i]";
                    $param[$check_name]="T";
                }
            }
            for ($i=0;$i<6;$i++){
                if (!empty($checkbox2[$i])){
                    $check_name="shop_new_age$checkbox2[$i]";
                    $param[$check_name]="T";
                }
            }

            for ($i=0;$i<3;$i++){
                if (!empty($checkbox3[$i])){
                    $check_name="shop_new_gender$checkbox3[$i]";
                    $param[$check_name]="T";
                }
            }
            if (!empty($request->message)){
                $param["shop_comment"]=$request->message;
            }

        }

        //店舗イメージ画像
        $img_path="public/shop_img/";
        $shop_img=$request->file('shop_img');

        if (!empty($shop_img)){
            $file_kari= $shop_img->getClientOriginalName();
            $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
            $file_name="shop_img-{$shop_id}.{$extension}";


            $shop_img->storeAS('',$img_path.$file_name);
            $param['shop_img']=$file_name;
        }


        DB::table('insyokus')
                        ->where('shop_id', $shop_id)
                        ->update($param);

        return redirect('client/main')->with('flash_message', '本登録完了しました。');


    }

    //採用・不採用
    public function judge(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $saiyou=$request->selector1;
        $id=$request->id;

        $item=DB::table('insyokus')->where('id',$id)->first();
        $email=$item->shop_mail;

        //採用
        if ($saiyou==="T"){

            $account=$email;

            //パスワード 8文字
            $password=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('insyokus')
                        ->where('id', $id)
                        ->update(['shop_flag' => '1','shop_id'=>$account,'shop_pass'=>$password_hash]);

            $msg="採用しました。";

            $param=[
                'shop_name'=>$item->shop_name,
                'shop_tantou'=>$item->shop_tantou,
                'result'=>'採用',
                'account'=>$account,
                'password'=>$password,
            ];
            Mail::to($email)->send(new ClientOuboMail($param));
        }elseif ($saiyou==="F"){
            DB::table('insyokus')
                        ->where('id', $id)
                        ->update(['shop_flag' => '3']);

            $msg="不採用にしました。";

            $param=[
                'shop_name'=>$item->shop_name,
                'shop_tantou'=>$item->shop_tantou,
                'result'=>'不採用',
            ];
            Mail::to($email)->send(new ClientOuboMail($param));

        }else{  //検討中
            DB::table('insyokus')
                        ->where('id', $id)
                        ->update(['shop_flag' => '4']);

            $msg="検討中にしました。";
        }


        return redirect('administrator/admin_client_1')->with('msg', $msg);
    }

    //ログイン処理
    public function login(Request $request){

        $id=$request->id;
        $password_kari=$request->password;


        $item = DB::table('insyokus')->select('shop_name','shop_pass','shop_flag')->where('shop_id',$id)
        ->wherein('shop_flag',['1','2'])
        ->where('shop_status','0')
        ->first();

        if (empty($item)){
            return view("client.index", ["error"=>'IDまたはパスワードが一致しません。']);

        }elseif (!empty($item->shop_name)){
            $password=$item->shop_pass;
            $shop_flag=$item->shop_flag;
            if (password_verify($password_kari, $password)){
                // セッションIDの再発行
                $request->session()->regenerate();
                $request->session()->put('shop_id', $id);
                $request->session()->put('shop_name', $item->shop_name);

                if ($shop_flag==="1"){
                    // return redirect('client/second_form', 302, [], true);
                    return redirect('client/second_form');
                }else{
                    // return redirect('client/main', 302, [], true);
                    return redirect('client/main');
                }
            }else{
                return view("client.index", ["error"=>'IDまたはパスワードが一致しません。']);
            }
        }else{
            return view("client.index", ["error"=>'エラーが発生しました。']);
        }

    }

    //未登録店舗クライアント取得
    public function index1(){
        $item = DB::table('insyokus')->select('id','shop_name','shop_oubo','shop_flag')
        ->whereIn('shop_flag',[0,4])->get();

        return view("administrator.admin_client_1", ["item"=>$item]);

    }
    //登録済み店舗クライアント取得
    public function index2(Request $request){

        $shop_status = Config::get('list.shop_status');
        $todouhuken = Config::get('list.todouhuken');

        $shop_address_s=$request->shop_address_s;
        $shop_status_s=$request->shop_status_s;

        $query = Insyoku::query();


        if(!empty($shop_address_s)){
            $query->where('shop_address', 'like', '%'.$shop_address_s.'%');
        }
        if(!empty($shop_status_s)){
            $query->where('shop_status',$shop_status_s);
        }

        //テンプレート取得
        $filename="laravel/public/storage/admin_template/admin_client_template.txt";
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

        $param=[
            'shop_address_s'=>$shop_address_s,
            'shop_status_s'=>$shop_status_s,
        ];

        //メール送信履歴取得
        $filename="laravel/public/storage/admin_mail_history/admin_client_history.txt";
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
        ->select('shop_id','shop_name','shop_touroku','shop_status')
        ->whereIn('shop_flag',[1,2])
        ->Paginate(20);

        $send_param=[
            "item"=>$item,
            'param'=>$param,
            'shop_status'=>$shop_status,
            'todouhuken'=>$todouhuken,
            'template_list'=>$template_list,
            'id_list'=>$id_list,
            'subject_list'=>$subject_list,
            'comment_list'=>$comment_list,
            'date_list'=>$date_list,
        ];

        return view("administrator.admin_client_2", $send_param);

    }

    //運営者クライアントへのメール送信テンプレート取得
    public function admin_client_template(){
        $filename="laravel/public/storage/admin_template/admin_client_template.txt";
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

        return view("administrator.admin_client_template",["template_list"=>$template_list]);
    }

    public function admin_client_template_edit(Request $request){
        $filename="laravel/public/storage/admin_template/admin_client_template.txt";

        $text_list=$request->template;
        $f = fopen($filename, "w+");  //書き込みモードで開く
        flock($f, LOCK_EX); // ファイルをロックする

        foreach ($text_list as $value){
            if (!empty($value)){
                echo $value;
                fwrite($f, $value."\n<>\n");  //<>で追記
            }
        }

        fclose($f);
        // var_dump($text_list);
        // exit;
        $msg="テンプレートを編集しました。";
        return redirect('administrator/admin_client_2')->with(['msg'=>$msg]);
    }

    //運営側インフルエンサーリストダウンロード
    public function client_csv($shop_status_s,$shop_address_s){

        $todouhuken = Config::get('list.todouhuken');
        $shop_status = Config::get('list.shop_status');
        $age = Config::get('list.age');
        $way = Config::get('list.way');
        $purpose = Config::get('list.purpose');
        $gather = Config::get('list.gather');
        $site = Config::get('list.site');
        $tanka = Config::get('list.tanka');
        $gender = Config::get('list.gender');

        $query = Insyoku::query();


        if($shop_status_s!=="<>"){
            $query->where('shop_status', $shop_status_s);
        }
        if($shop_address_s!=="<>"){
            $query->where('shop_address', 'like', '%'.$shop_address_s.'%');
        }


        $item = $query
        ->where('shop_flag',2)
        ->get();

        $filename="client_list.csv";

        $csv_list=[
            'ID',
            '店舗名',
            '担当者',
            '電話番号',
            'メールアドレス',
            '郵便番号',
            '店舗住所',
            '最寄り駅',
            '開店時間',
            '定休日',
            '個室',
            '子供同伴',
            'ペット同伴',
            '客単価',
            '男女比',
            '自社URL',
            'ステータス',
        ];

        $j=1;
        foreach ($age as $keys=>$values){
            $csv_list[]="年齢層（{$values}）";
            $j+=1;
        }
        $j=1;
        foreach ($way as $keys=>$values){
            $csv_list[]="用途（{$values}）";
            $j+=1;
        }
        foreach ($purpose as $keys=>$values){
            $csv_list[]="PRのご利用目的（{$values}）";
            $j+=1;
        }
        foreach ($gather as $keys=>$values){
            $csv_list[]="これまでの集客方法（{$values}）";
            $j+=1;
        }
        foreach ($site as $keys=>$values){
            $csv_list[]="予約サイトのご利用状況（{$values}）";
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


        $required_list=[];
        $i=1;
        foreach ($item as $key=>$value){
            $required_list[$i][]=$value->shop_id;
            $required_list[$i][]=$value->shop_name;
            $required_list[$i][]=$value->shop_tantou;
            $required_list[$i][]=$value->shop_phone;
            $required_list[$i][]=$value->shop_mail;
            $required_list[$i][]=$value->shop_area;
            $required_list[$i][]=$value->shop_address;
            $required_list[$i][]=$value->shop_station;
            $required_list[$i][]=$value->shop_open_time;
            $required_list[$i][]=$value->shopclose_date;
            $required_list[$i][]=$arinashi[$value->shop_single_space];
            $required_list[$i][]=$kahi[$value->shop_child];
            $required_list[$i][]=$kahi[$value->shop_pet];
            $required_list[$i][]=$tanka[$value->shop_tanka];
            $required_list[$i][]=$gender[$value->shop_gender];
            $required_list[$i][]=$shop_status[$value->shop_status];

            foreach ($age as $keys=>$values){
                $required_list[$i][]=$kahi[$value->{$keys}];
            }
            foreach ($way as $keys=>$values){
                $required_list[$i][]=$kahi[$value->{$keys}];
            }
            foreach ($purpose as $keys=>$values){
                $required_list[$i][]=$kahi[$value->{$keys}];
            }
            foreach ($gather as $keys=>$values){
                $required_list[$i][]=$kahi[$value->{$keys}];
            }
            foreach ($site as $keys=>$values){
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

    //運営側のクライアントへのメール送信
    public function mail_to_selected_client(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }


        $check=$request->check;

        $item=DB::table('insyokus')
        ->select('shop_mail')
        ->whereIn('shop_id',$check)
        ->get();

        $mail_list=[];
        foreach($item as $value){
            $mail_list[]=$value->shop_mail;
        }

        $param=[
            'whose'=>'C',
            'comment'=>$request->comment,
            'subject'=>$request->subject,
        ];

        foreach ($mail_list as $value){
            Mail::to($value)->send(new SelectedFromAdmin($param));
        }

        // メール送信の履歴確認
        $filename="laravel/public/storage/admin_mail_history/admin_client_history.txt";

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

        return redirect('administrator/admin_client_2')->with('msg',$msg);
    }

    //未登録店舗クライアント詳細情報
    public function index1_detail($id){
        $item = DB::table('insyokus')->where('id',$id)->first();
        // echo $id;
        // exit;
        $shop_flag=$item->shop_flag;
        $shop_question=$item->shop_question;

        $items=[
            'shop_name'=>$item->shop_name,
            'shop_tantou'=>$item->shop_tantou,
            'shop_phone'=>$item->shop_phone,
            'shop_mail'=>$item->shop_mail,
            // 'shop_address'=>$item->shop_address,
            // 'shop_station'=>$item->shop_station,
            'shop_tanka'=>$item->shop_tanka,
            'shop_gender'=>$item->shop_gender,
            'shop_url'=>$item->shop_url,
        ];

        $items_2=[
            'shop_age1'=>$item->shop_age1,
            'shop_age2'=>$item->shop_age2,
            'shop_age3'=>$item->shop_age3,
            'shop_age4'=>$item->shop_age4,
            'shop_age5'=>$item->shop_age5,
            'shop_age6'=>$item->shop_age6,
        ];

        $items_3=[
            'shop_way1'=>$item->shop_way1,
            'shop_way2'=>$item->shop_way2,
            'shop_way3'=>$item->shop_way3,
            'shop_way4'=>$item->shop_way4,
            'shop_way5'=>$item->shop_way5,
            'shop_way6'=>$item->shop_way6,
            'shop_way7'=>$item->shop_way7,
            'shop_way8'=>$item->shop_way8,
            'shop_way9'=>$item->shop_way9,
            'shop_way10'=>$item->shop_way10,
        ];

        $items_4=[
            'shop_purpose1'=>$item->shop_purpose1,
            'shop_purpose2'=>$item->shop_purpose2,
            'shop_purpose3'=>$item->shop_purpose3,
            'shop_purpose4'=>$item->shop_purpose4,
            'shop_purpose5'=>$item->shop_purpose5,
            'shop_purpose6'=>$item->shop_purpose6,
            'shop_purpose7'=>$item->shop_purpose7,
        ];

        $items_5=[
            'shop_gather1'=>$item->shop_gather1,
            'shop_gather2'=>$item->shop_gather2,
            'shop_gather3'=>$item->shop_gather3,
            'shop_gather4'=>$item->shop_gather4,
            'shop_gather5'=>$item->shop_gather5,
            'shop_gather6'=>$item->shop_gather6,
        ];

        $items_6=[
            'shop_site1'=>$item->shop_site1,
            'shop_site2'=>$item->shop_site2,
            'shop_site3'=>$item->shop_site3,
            'shop_site4'=>$item->shop_site4,
            'shop_site5'=>$item->shop_site5,
            'shop_site6'=>$item->shop_site6,
            'shop_site7'=>$item->shop_site7,
            'shop_site8'=>$item->shop_site8,
        ];


        $param=[
            'shop_name'=>'企業名',
            'shop_tantou'=>'担当者名',
            'shop_phone'=>'連絡先',
            'shop_mail'=>'メールアドレス',
            'shop_tanka'=>'客単価',
            'shop_gender'=>'男女比',
            'shop_url'=>'自社ホームページURL',
        ];

        $param_2 = Config::get('list.age');
        $param_3 = Config::get('list.way');
        $param_4 = Config::get('list.purpose');
        $param_5 = Config::get('list.gather');
        $param_6 = Config::get('list.site');
        $tanka = Config::get('list.tanka');
        $gender = Config::get('list.gender');


        return view("administrator.admin_client_1_detail", ["item"=>$items,"item_2"=>$items_2,"item_3"=>$items_3,"item_4"=>$items_4,"item_5"=>$items_5,"item_6"=>$items_6,"param"=>$param,"param_2"=>$param_2,"param_3"=>$param_3,"param_4"=>$param_4,"param_5"=>$param_5,"param_6"=>$param_6,"id"=>$id,'shop_question'=>$shop_question,'gender'=>$gender,'tanka'=>$tanka,'shop_flag'=>$shop_flag]);
    }

    public function index2_detail($shop_id){
        $item = DB::table('insyokus')->where('shop_id',$shop_id)->first();

        $shop_new=$item->shop_new;

        $shop_new_tanka=$item->shop_new_tanka;
        $shop_comment=$item->shop_comment;

        $items_new=[
            'shop_new_genre1'=>$item->shop_new_genre1,
            'shop_new_genre2'=>$item->shop_new_genre2,
            'shop_new_genre3'=>$item->shop_new_genre3,
            'shop_new_genre4'=>$item->shop_new_genre4,
            'shop_new_genre5'=>$item->shop_new_genre5,
            'shop_new_genre6'=>$item->shop_new_genre6,
            'shop_new_genre7'=>$item->shop_new_genre7,
            'shop_new_genre8'=>$item->shop_new_genre8,
            'shop_new_genre9'=>$item->shop_new_genre9,
            'shop_new_genre10'=>$item->shop_new_genre10,
        ];

        $items_new2=[
            'shop_new_gender1'=>$item->shop_new_gender1,
            'shop_new_gender2'=>$item->shop_new_gender2,
            'shop_new_gender3'=>$item->shop_new_gender3,
        ];

        $items_new3=[
            'shop_new_age1'=>$item->shop_new_age1,
            'shop_new_age2'=>$item->shop_new_age2,
            'shop_new_age3'=>$item->shop_new_age3,
            'shop_new_age4'=>$item->shop_new_age4,
            'shop_new_age5'=>$item->shop_new_age5,
            'shop_new_age6'=>$item->shop_new_age6,
        ];

        $param_new = Config::get('list.new_genre');
        $param_new2 = Config::get('list.new_gender');
        $param_new3 = Config::get('list.new_age');

        $todouhuken = Config::get('list.todouhuken');


        foreach ($todouhuken as $value){
            if (strpos($item->shop_address,$value)===0){
                $shop_address1=$value;
                $shop_address2=str_replace($value,'',$item->shop_address);
            }
        }

        if (empty($shop_address1) && empty($shop_address2)){
            $shop_address1=$item->shop_address;
            $shop_address2="";
        }

        $items=[
            'shop_name'=>$item->shop_name,
            'shop_tantou'=>$item->shop_tantou,
            'shop_phone'=>$item->shop_phone,
            'shop_mail'=>$item->shop_mail,
            'shop_address1'=>$shop_address1,
            'shop_address2'=>$shop_address2,
            'shop_station'=>$item->shop_station,
            'shop_tanka'=>$item->shop_tanka,
            'shop_gender'=>$item->shop_gender,
            'shop_url'=>$item->shop_url,
        ];

        $items_2=[
            'shop_age1'=>$item->shop_age1,
            'shop_age2'=>$item->shop_age2,
            'shop_age3'=>$item->shop_age3,
            'shop_age4'=>$item->shop_age4,
            'shop_age5'=>$item->shop_age5,
            'shop_age6'=>$item->shop_age6,
        ];

        $items_3=[
            'shop_way1'=>$item->shop_way1,
            'shop_way2'=>$item->shop_way2,
            'shop_way3'=>$item->shop_way3,
            'shop_way4'=>$item->shop_way4,
            'shop_way5'=>$item->shop_way5,
            'shop_way6'=>$item->shop_way6,
            'shop_way7'=>$item->shop_way7,
            'shop_way8'=>$item->shop_way8,
            'shop_way9'=>$item->shop_way9,
            'shop_way10'=>$item->shop_way10,
        ];

        $items_4=[
            'shop_purpose1'=>$item->shop_purpose1,
            'shop_purpose2'=>$item->shop_purpose2,
            'shop_purpose3'=>$item->shop_purpose3,
            'shop_purpose4'=>$item->shop_purpose4,
            'shop_purpose5'=>$item->shop_purpose5,
            'shop_purpose6'=>$item->shop_purpose6,
            'shop_purpose7'=>$item->shop_purpose7,
        ];

        $items_5=[
            'shop_gather1'=>$item->shop_gather1,
            'shop_gather2'=>$item->shop_gather2,
            'shop_gather3'=>$item->shop_gather3,
            'shop_gather4'=>$item->shop_gather4,
            'shop_gather5'=>$item->shop_gather5,
            'shop_gather6'=>$item->shop_gather6,
        ];

        $items_6=[
            'shop_site1'=>$item->shop_site1,
            'shop_site2'=>$item->shop_site2,
            'shop_site3'=>$item->shop_site3,
            'shop_site4'=>$item->shop_site4,
            'shop_site5'=>$item->shop_site5,
            'shop_site6'=>$item->shop_site6,
            'shop_site7'=>$item->shop_site7,
            'shop_site8'=>$item->shop_site8,
        ];


        $param=[
            'shop_name'=>'企業名',
            'shop_tantou'=>'担当者名',
            'shop_phone'=>'連絡先',
            'shop_mail'=>'メールアドレス',
            'shop_address1'=>'店舗住所1',
            'shop_address2'=>'店舗住所2',
            'shop_station'=>'最寄り駅',
            'shop_tanka'=>'客単価',
            'shop_gender'=>'男女比',
            'shop_url'=>'自社ホームページURL',
        ];

        $param_2 = Config::get('list.age');
        $param_3 = Config::get('list.way');
        $param_4 = Config::get('list.purpose');
        $param_5 = Config::get('list.gather');
        $param_6 = Config::get('list.site');
        $tanka = Config::get('list.tanka');
        $gender = Config::get('list.gender');

        $shop_status=$item->shop_status;

        if ($item->shop_flag==="1"){
            return view("administrator.admin_client_2_detail");
        }
        if ($item->shop_flag==="4"){
            return view("administrator.admin_client_2_detail",['shop_id'=>$shop_id]);
        }

        $send_param=[
            "item"=>$items,
            "item_2"=>$items_2,
            "item_3"=>$items_3,
            "item_4"=>$items_4,
            "item_5"=>$items_5,
            "item_6"=>$items_6,
            "param"=>$param,
            "param_2"=>$param_2,
            "param_3"=>$param_3,
            "param_4"=>$param_4,
            "param_5"=>$param_5,
            "param_6"=>$param_6,
            "shop_id"=>$shop_id,
            'gender'=>$gender,
            'tanka'=>$tanka,
            'item_new'=>$items_new,
            'item_new2'=>$items_new2,
            'item_new3'=>$items_new3,
            'param_new'=>$param_new,
            'param_new2'=>$param_new2,
            'param_new3'=>$param_new3,
            'shop_new_tanka'=>$shop_new_tanka,
            'shop_new'=>$shop_new,
            'shop_comment'=>$shop_comment,
            'shop_status'=>$shop_status,
        ];

        return view("administrator.admin_client_2_detail", $send_param);

    }

    //運営側の店舗クライアントステータス変更
    public function index2_post(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        if (isset($hidden)){
            $shop_id=$request->hidden_id;
            $saiyou=$request->selector1;

        $item=DB::table('insyokus')->where('shop_id',$shop_id)->first();
        $email=$item->shop_mail;

        //採用
        if ($saiyou==="T"){

            $account=$email;

            //パスワード 8文字
            $password=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('insyokus')
                        ->where('id', $id)
                        ->update(['shop_flag' => '1','shop_id'=>$account,'shop_pass'=>$password_hash]);

            $msg="採用しました。";

            $param=[
                'shop_name'=>$item->shop_name,
                'shop_tantou'=>$item->shop_tantou,
                'result'=>'採用',
                'account'=>$account,
                'password'=>$password,
            ];
            Mail::to($email)->send(new ClientOuboMail($param));
        }else{
            DB::table('insyokus')
                        ->where('id', $id)
                        ->update(['shop_flag' => '3']);

            $msg="不採用にしました。";

            $param=[
                'shop_name'=>$item->shop_name,
                'shop_tantou'=>$item->shop_tantou,
                'result'=>'不採用',
            ];
            Mail::to($email)->send(new ClientOuboMail($param));

        }

        }else{

            $shop_id=$request->hidden_id;
            $shop_status=$request->shop_status;

            DB::table('insyokus')
            ->where('shop_id',$shop_id)
            ->update(['shop_status'=>$shop_status]);

            $msg="ステータスを更新しました。";
        }
        return redirect("administrator/admin_client_2_detail/$shop_id")->with('msg',$msg);

    }

    //店舗クライアント情報取得
    public function account_get(){
        if (session()->has("shop_id")){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect('client');
        }

        $item = DB::table('insyokus')->where('shop_id',$shop_id)->first();

        $shop_new=$item->shop_new;

        $shop_new_tanka=$item->shop_new_tanka;
        $shop_comment=$item->shop_comment;

        $items_new=[
            'shop_new_genre1'=>$item->shop_new_genre1,
            'shop_new_genre2'=>$item->shop_new_genre2,
            'shop_new_genre3'=>$item->shop_new_genre3,
            'shop_new_genre4'=>$item->shop_new_genre4,
            'shop_new_genre5'=>$item->shop_new_genre5,
            'shop_new_genre6'=>$item->shop_new_genre6,
            'shop_new_genre7'=>$item->shop_new_genre7,
            'shop_new_genre8'=>$item->shop_new_genre8,
            'shop_new_genre9'=>$item->shop_new_genre9,
            'shop_new_genre10'=>$item->shop_new_genre10,
        ];

        $items_new2=[
            'shop_new_gender1'=>$item->shop_new_gender1,
            'shop_new_gender2'=>$item->shop_new_gender2,
            'shop_new_gender3'=>$item->shop_new_gender3,
        ];


        $items_new3=[
            'shop_new_age1'=>$item->shop_new_age1,
            'shop_new_age2'=>$item->shop_new_age2,
            'shop_new_age3'=>$item->shop_new_age3,
            'shop_new_age4'=>$item->shop_new_age4,
            'shop_new_age5'=>$item->shop_new_age5,
            'shop_new_age6'=>$item->shop_new_age6,
        ];

        $param_new = Config::get('list.new_genre');
        $param_new2 = Config::get('list.new_gender');
        $param_new3 = Config::get('list.new_age');

        $todouhuken = Config::get('list.todouhuken');


        foreach ($todouhuken as $value){
            if (strpos($item->shop_address,$value)===0){
                $shop_address1=$value;
                $shop_address2=str_replace($value,'',$item->shop_address);
            }
        }

        if (empty($shop_address1) && empty($shop_address2)){
            $shop_address1=$item->shop_address;
            $shop_address2="";
        }

        $items=[
            'shop_name'=>$item->shop_name,
            'shop_tantou'=>$item->shop_tantou,
            'shop_phone'=>$item->shop_phone,
            'shop_mail'=>$item->shop_mail,
            'shop_area'=>$item->shop_area,
            'shop_address1'=>$shop_address1,
            'shop_address2'=>$shop_address2,
            'shop_station'=>$item->shop_station,
            'shop_tanka'=>$item->shop_tanka,
            'shop_gender'=>$item->shop_gender,
            'shop_url'=>$item->shop_url,
            'shop_open_time'=>$item->shop_open_time,
            'shop_close_date'=>$item->shop_close_date,
            'shop_single_space'=>$item->shop_single_space,
            'shop_child'=>$item->shop_child,
            'shop_pet'=>$item->shop_pet,
        ];

        $items_2=[
            'shop_age1'=>$item->shop_age1,
            'shop_age2'=>$item->shop_age2,
            'shop_age3'=>$item->shop_age3,
            'shop_age4'=>$item->shop_age4,
            'shop_age5'=>$item->shop_age5,
            'shop_age6'=>$item->shop_age6,
        ];

        $items_3=[
            'shop_way1'=>$item->shop_way1,
            'shop_way2'=>$item->shop_way2,
            'shop_way3'=>$item->shop_way3,
            'shop_way4'=>$item->shop_way4,
            'shop_way5'=>$item->shop_way5,
            'shop_way6'=>$item->shop_way6,
            'shop_way7'=>$item->shop_way7,
            'shop_way8'=>$item->shop_way8,
            'shop_way9'=>$item->shop_way9,
            'shop_way10'=>$item->shop_way10,
        ];

        $items_4=[
            'shop_purpose1'=>$item->shop_purpose1,
            'shop_purpose2'=>$item->shop_purpose2,
            'shop_purpose3'=>$item->shop_purpose3,
            'shop_purpose4'=>$item->shop_purpose4,
            'shop_purpose5'=>$item->shop_purpose5,
            'shop_purpose6'=>$item->shop_purpose6,
            'shop_purpose7'=>$item->shop_purpose7,
        ];

        $items_5=[
            'shop_gather1'=>$item->shop_gather1,
            'shop_gather2'=>$item->shop_gather2,
            'shop_gather3'=>$item->shop_gather3,
            'shop_gather4'=>$item->shop_gather4,
            'shop_gather5'=>$item->shop_gather5,
            'shop_gather6'=>$item->shop_gather6,
        ];

        $items_6=[
            'shop_site1'=>$item->shop_site1,
            'shop_site2'=>$item->shop_site2,
            'shop_site3'=>$item->shop_site3,
            'shop_site4'=>$item->shop_site4,
            'shop_site5'=>$item->shop_site5,
            'shop_site6'=>$item->shop_site6,
            'shop_site7'=>$item->shop_site7,
            'shop_site8'=>$item->shop_site8,
        ];


        $param=[
            'shop_name'=>'企業名',
            'shop_tantou'=>'担当者名',
            'shop_phone'=>'連絡先',
            'shop_mail'=>'メールアドレス',
            'shop_area'=>'郵便番号',
            'shop_address1'=>'店舗住所1',
            'shop_address2'=>'店舗住所2',
            'shop_station'=>'最寄り駅',
            'shop_tanka'=>'客単価',
            'shop_gender'=>'男女比',
            'shop_url'=>'自社ホームページURL',
            'shop_open_time'=>'営業時間',
            'shop_close_date'=>'定休日',
            'shop_single_space'=>'個室の有無',
            'shop_child'=>'お子様同伴',
            'shop_pet'=>'ペット同伴',
        ];

        $param_2 = Config::get('list.age');
        $param_3 = Config::get('list.way');
        $param_4 = Config::get('list.purpose');
        $param_5 = Config::get('list.gather');
        $param_6 = Config::get('list.site');
        $tanka = Config::get('list.tanka');
        $gender = Config::get('list.gender');

        $arinashi=[
            'T'=>'あり',
            'F'=>'なし',
        ];

        $able=[
            'T'=>'可',
            'F'=>'不可',
        ];

        $url=url()->previous();
        $keys = parse_url($url); //パース処理
        $path = explode("/", $keys['path']); //分割処理
        $last = end($path); //最後の要素を取得

        if ($last==="client_account"){
            return view("client.client_account_edit", ["item"=>$items,"item_2"=>$items_2,"item_3"=>$items_3,"item_4"=>$items_4,"item_5"=>$items_5,"item_6"=>$items_6,"param"=>$param,"param_2"=>$param_2,"param_3"=>$param_3,"param_4"=>$param_4,"param_5"=>$param_5,"param_6"=>$param_6,"shop_id"=>$shop_id,'gender'=>$gender,'tanka'=>$tanka,'item_new'=>$items_new,'item_new2'=>$items_new2,'item_new3'=>$items_new3,'param_new'=>$param_new,'param_new2'=>$param_new2,'param_new3'=>$param_new3,'shop_new_tanka'=>$shop_new_tanka,'shop_new'=>$shop_new,'shop_comment'=>$shop_comment,'arinashi'=>$arinashi,'able'=>$able,'shop_address'=>$item->shop_address]);
        }else{
            return view("client.client_account", ["item"=>$items,"item_2"=>$items_2,"item_3"=>$items_3,"item_4"=>$items_4,"item_5"=>$items_5,"item_6"=>$items_6,"param"=>$param,"param_2"=>$param_2,"param_3"=>$param_3,"param_4"=>$param_4,"param_5"=>$param_5,"param_6"=>$param_6,"shop_id"=>$shop_id,'gender'=>$gender,'tanka'=>$tanka,'item_new'=>$items_new,'item_new2'=>$items_new2,'item_new3'=>$items_new3,'param_new'=>$param_new,'param_new2'=>$param_new2,'param_new3'=>$param_new3,'shop_new_tanka'=>$shop_new_tanka,'shop_new'=>$shop_new,'shop_comment'=>$shop_comment,'arinashi'=>$arinashi,'able'=>$able]);
        }


    }

    //クライアントアカウント情報編集
    public function account_edit(Request $request){
        if (!session()->has('shop_id')){
            return redirect('client');
        }


        $shop_id=session()->get('shop_id');

        $param=[
            'shop_name'=>$request->shop_name,
            'shop_tantou'=>$request->shop_tantou,
            'shop_phone'=>$request->shop_phone,
            'shop_mail'=>$request->shop_mail,
            'shop_area'=>$request->shop_area,
            'shop_address'=>$request->shop_address,
            'shop_station'=>$request->shop_station,
            'shop_url'=>$request->shop_url,
            'shop_open_time'=>$request->shop_open_time,
            'shop_close_date'=>$request->shop_close_date,
            'shop_single_space'=>$request->shop_single_space,
            'shop_child'=>$request->shop_child,
            'shop_pet'=>$request->shop_pet,
            'shop_tanka'=>$request->shop_tanka,
            'shop_gender'=>$request->shop_gender,
        ];

        $age = Config::get('list.age');
        $way = Config::get('list.way');
        $purpose = Config::get('list.purpose');
        $gather = Config::get('list.gather');
        $site = Config::get('list.site');

        $checkbox=$request->checkbox;
        $checkbox2=$request->checkbox2;
        $checkbox3=$request->checkbox3;
        $checkbox4=$request->checkbox4;
        $checkbox5=$request->checkbox5;

        //一旦全てFに
        for ($i=1;$i<=count($age);$i++){
            $param["shop_age$i"]="F";
        }
        for ($i=1;$i<=count($way);$i++){
            $param["shop_way$i"]="F";
        }
        for ($i=1;$i<=count($purpose);$i++){
            $param["shop_purpose$i"]="F";
        }
        for ($i=1;$i<=count($gather);$i++){
            $param["shop_gather$i"]="F";
        }
        for ($i=1;$i<=count($site);$i++){
            $param["shop_site$i"]="F";
        }


        foreach ($checkbox as $value){
            $param["shop_age$value"]="T";
        }
        foreach ($checkbox2 as $value){
            $param["shop_way$value"]="T";
        }
        foreach ($checkbox3 as $value){
            $param["shop_purpose$value"]="T";
        }
        foreach ($checkbox4 as $value){
            $param["shop_gather$value"]="T";
        }
        foreach ($checkbox5 as $value){
            $param["shop_site$value"]="T";
        }


        if ($request->hidden_new==="T"){
            $new_gender = Config::get('list.new_gender');
            $new_genre = Config::get('list.new_genre');
            $new_age = Config::get('list.new_age');

            $param["shop_comment"]=$request->shop_comment;
            $param["shop_new_tanka"]=$request->shop_new_tanka;

            //一旦全てFに
            for ($i=1;$i<=count($new_genre);$i++){
                $param["shop_new_genre$i"]="F";
            }
            for ($i=1;$i<=count($new_gender);$i++){
                $param["shop_new_gender$i"]="F";
            }
            for ($i=1;$i<=count($new_age);$i++){
                $param["shop_new_age$i"]="F";
            }

            $checkbox6=$request->checkbox6;
            $checkbox7=$request->checkbox7;
            $checkbox8=$request->checkbox8;

            foreach ($checkbox6 as $value){
                $param["shop_new_genre$value"]="T";
            }
            foreach ($checkbox7 as $value){
                $param["shop_new_gender$value"]="T";
            }
            foreach ($checkbox8 as $value){
                $param["shop_new_age$value"]="T";
            }
        }

        //チャット部分
        $item_contact=DB::table('contacts')
        ->where('contact_id',$shop_id)
        ->where('contact_from','C')
        ->count();

        if ($item_contact>0){
            $contact_param=[
                "contact_name"=>$request->shop_name,
                "contact_tantou"=>$request->shop_tantou,
                "contact_mail"=>$request->shop_mail,
                "contact_phone"=>$request->shop_phone,
                "contact_address"=>$request->shop_address,
                "contact_station"=>$request->shop_station,
            ];

            DB::table('contacts')
            ->where('contact_from','C')
            ->where('contact_id',$shop_id)
            ->update($contact_param);
        }

        //アイコン画像
        $icon_path="public/shop_img/";
        $icon=$request->file('icon_img');



        if (!empty($icon)){
            //一旦可能性あるものを削除
            Storage::delete("{$icon_path}shop_img-{$shop_id}.png");
            Storage::delete("{$icon_path}shop_img-{$shop_id}.jpg");
            Storage::delete("{$icon_path}shop_img-{$shop_id}.jpeg");
            $file_kari= $icon->getClientOriginalName();
            $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
            $file_name="shop_img-{$shop_id}.{$extension}";


            $icon->storeAS('',$icon_path.$file_name);
        }

        DB::table('insyokus')->where('shop_id',$shop_id)
        ->update($param);

        $msgs="アカウント情報を編集しました。";

        return redirect('client/client_account')->with('msgs',$msgs);
    }

    //パスワード変更
    public function client_pass_edit(Request $request){
        if (!session()->has('shop_id')){
            return redirect('client');
        }

        $shop_id=session()->get('shop_id');

        $password=$request->password;
        $password2=$request->password2;

        if ($password===$password2){
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('insyokus')
            ->where('shop_id', $shop_id)
            ->update(['shop_pass'=>$password_hash]);

            $msgs="パスワードを変更しました。";
            return redirect('client/client_account')->with('msgs',$msgs);
        }elseif (strlen($password)<8){
            $msgs="パスワードには8文字以上を設定してください。";
            return redirect('client/client_account_password')->with('msgs',$msgs);
        }else{
            $msgs="確認用パスワードが異なります。";
            return redirect('client/client_account_password')->with('msgs',$msgs);
        }
    }
}
