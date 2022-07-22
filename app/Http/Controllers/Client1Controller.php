<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Insyoku;
use App\Models\Influ;

use App\Mail\ClientOuboMail;
use App\Mail\ClientKariMail;
use App\Mail\ClientPassReput;
use App\Mail\SelectedFromAdmin;
use Mail;
use DateTime;
use App\Mail\ClientRegistrationOkMail;
use App\Mail\ClientMessageMail;
use App\Mail\UserDecisionMail;
use App\Mail\PaymentInformationMail;
use App\Mail\PaymentOkMail;

// use Stripe\Stripe;
use Stripe;
use Stripe\Charge;
use Stripe\Customer;

require_once('laravel/app/tcpdf/tcpdf.php');
require_once('laravel/app/fpdi/autoload.php');
require_once('laravel/app/fpdi/Fpdi.php');
// require_once('laravel/app/test_pdf/tcpdf.php');
use setasign\Fpdi;
use setasign\Fpdi\TcpdfFpdi;
use Illuminate\Support\Facades\Storage;

class Client1Controller extends Controller
{
    //client_check
    

    //クライアント仮登録
    public function before_form(Request $request){
        //日時
        $today = date("Y-m-d H:i:s");

        $shop_mail=$request->email;

        $item=DB::table('insyokus')->where('shop_mail',$shop_mail)->count();

        if ($item!==0){
            $msgs="既に登録済みのメールアドレスです。";
            return redirect(Config::get('const.title.title47').'/first_form')->with('msgs', $msgs);
        }
        //token_email
        $token_email=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 50);

        $param=[
            'shop_id'=>$request->email,
            'shop_mail'=>$request->email,
            'shop_flag'=>'1',
            'shop_touroku'=>$today,
            'delete_flag'=>'0',
            'email_verify_token'=>$token_email,
        ];

        $mail_param=[
            'shop_mail'=>$shop_mail,
            'token_email'=>$token_email,
        ];

        DB::table('insyokus')->insert($param);
        Mail::to($shop_mail)->send(new ClientKariMail($mail_param));

        return view(Config::get('const.title.title47').".first_form", ["msg"=>'仮登録メールが送信されました。','msg2'=>'メールボックスをご確認ください。']);

    }

    //パスワード再発行
    public function pass_reput(Request $request){
        $item=DB::table('insyokus')
        ->where('delete_flag','0')
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
            ->where('delete_flag','0')
            ->update(['shop_pass'=>$password_hash]);

            $msg="ご登録いただいているメールアドレスへ仮パスワードを送付しました。";

            $param=[
                'shop_name'=>$item->shop_name,
                'shop_tantou'=>$item->shop_tantou,
                'password'=>$password,
                'delete_flag'=>'0',
            ];
            Mail::to($email)->send(new ClientPassReput($param));
        }
        return redirect(Config::get('const.title.title47').'/pass_forget')->with(['msg'=>$msg]);
    }

    //クライアント本登録準備
    public function after_form_pre(){

        $view_param=[
            // 'item_config'=>$item_config,
            // 'item'=>$item,
        ];
        return view(Config::get('const.title.title47').".second_form", $view_param);
    }

    //クライアント本登録
    public function after_form(Request $request){

        $today = date("Y-m-d H:i:s");

        // password
        $password = $request->password;
        $password_again = $request->password_again;
        if (mb_strlen($password) >= 8 && mb_strwidth($password) === mb_strlen($password)) {
            if ($password === $password_again) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $msgs="確認用のパスワードが違います。";
                return redirect(url()->full())->with('msgs', $msgs);
            }
        } else {
            $msgs="パスワードは半角英数字8文字以上で設定してください。";
            return redirect(url()->full())->with('msgs', $msgs);
        }

        //ユーザー確認
        $email = $request->email;
        $item=DB::table('insyokus')->where('shop_flag','1')->where('delete_flag','0')->where('shop_mail',$email)->first();
        if (empty($item)) {
            $msgs="仮メール登録時のメールアドレスを入力してください。";
            return redirect(url()->full())->with('msgs', $msgs);
        }
        $token = $request->email_url_hash;
        if ($item->email_verify_token !== $token) {
            $msgs="無効なURLです。";
            return redirect(url()->full())->with('msgs', $msgs);
        }

        //name
        $name_1=$request->name_1;
        $name_2=$request->name_2;
        $name_furi_1=$request->furigana_1;
        $name_furi_2=$request->furigana_2;
        $name = "{$name_1} {$name_2}";
        $name_furi = "{$name_furi_1} {$name_furi_2}";
        
        //shop_address
        $address_47=$request->address_tdfk;
        $address_city=$request->address_city;
        $address_banti=$request->address_banti;
        $address_building=$request->address_building;
        if (empty($address_building)) {
            $shop_address = "{$address_47}={$address_city}={$address_banti}";
        } else {
            $shop_address = "{$address_47}={$address_city}={$address_banti}={$address_building}";
        }

        $param=[
            'shop_name'=>$request->company_name,
            'tantou_name'=>$name,
            'tantou_name_fri'=>$name_furi,
            'shop_phone'=>$request->tel01,
            'shop_mail'=>$request->email,
            'address_number'=>$request->address_number,
            'shop_address'=>$shop_address,
            'shop_station'=>$request->near_station,
            'shop_pass'=>$password_hash,
            'shop_flag'=>'2',
            'delete_flag'=>'0',
            'shop_touroku'=>$today,
        ];
        
        DB::table('insyokus')
            ->where('delete_flag','0')
            ->where('shop_id', $email)
            ->where('email_verify_token', $token)
            ->update($param);

        $mail_param=[
            'email'=>$email,
        ];

        // メール
        Mail::to($email)->send(new ClientRegistrationOkMail($mail_param));
    

        return redirect(Config::get('const.title.title47'));


    }

    //ログイン処理
    public function login(Request $request){

        $id=$request->id;
        $password_kari=$request->password;


        $item = DB::table('insyokus')->select('shop_name','shop_pass','shop_flag')->where('delete_flag','0')->where('shop_id',$id)
        ->wherein('shop_flag',['2'])
        ->first();

        if (empty($item)){
            return view(Config::get('const.title.title47').".index", ["error"=>'IDまたはパスワードが一致しません。']);

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
                    return redirect(Config::get('const.title.title47').'/second_form');
                }else{
                    // return redirect('client/main', 302, [], true);
                    return redirect(Config::get('const.title.title47').'/client_account');
                }
            }else{
                return view(Config::get('const.title.title47').".index", ["error"=>'IDまたはパスワードが一致しません。']);
            }
        }else{
            return view(Config::get('const.title.title47').".index", ["error"=>'エラーが発生しました。']);
        }

    }

    //店舗クライアントmypage情報取得
    public function mypage_get(){
        $shop_id=session()->get("shop_id");
        if (!session()->has("shop_id")){
            return redirect(Config::get('const.title.title47'));
        }
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);

        $issue_item_count=count(DB::table('matters')->where('shop_id',$shop_id)->where('delete_flag','0')->where('flag','0')->get());
        $contacts_item = $get_contacts_item=DB::table('contacts')->where('shop_id',$shop_id)->where('delete_flag','0')->orderBy('contacts_id', 'desc')->get();

        //満了三日以内
        $contacts_within_three_days_count = 0;
        $contacts_expiration_one_week_count = 0;
        $payment_term_out = 0;
        foreach ($contacts_item as $select_item) {
            $three_month_Date = new DateTime(date("{$select_item->contract_expiration_3month}"));
            $payment_term_Date = new DateTime(date("{$select_item->payment_term}"));

            $todayDate = new DateTime(date("Y-m-d"));
            $intvl = $three_month_Date->diff($todayDate);

            if ($three_month_Date > $todayDate){
                //3monthがtodayより未来
                if ($intvl->days <= 3 && $intvl->days >= 1) {
                    //三日以内当日の前日以内
                    $contacts_within_three_days_count++;
                }
            }

            //契約満了：未払：未人材確認１週間経過
            if ($three_month_Date <= $todayDate){
                //3monthが今日を含む過去
                if ($select_item->payment_judge == null && $select_item->user_judge == '0') {
                    //未払い：未人材確認
                    $one_week_progress = date("Y-m-d",strtotime($select_item->contract_expiration_3month . "+1 week"));
                    if ($one_week_progress <= date("Y-m-d")) {
                        //１週間けいか
                        $contacts_expiration_one_week_count++;
                    }
                }
            }

            if ($select_item->payment_judge == null) {
                $one_item_judge = "1";
                //支払期限超過
                if ($payment_term_Date <= $todayDate){
                    $payment_term_out++;
                }
            }
        }

        $new_messages = Insyoku::new_messages_alert($shop_id);
        $send_param=[
            'new_messages'=>$new_messages,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'issue_item_count'=>$issue_item_count,
            'contacts_within_three_days_count'=>$contacts_within_three_days_count,
            'contacts_expiration_one_week_count'=>$contacts_expiration_one_week_count,
            'payment_term_out'=>$payment_term_out,
        ];

        return view(Config::get('const.title.title47').".company_account", $send_param);
    }

    //クライアントアカウント取得(基本情報)
    public function account_get(){
        $shop_id=session()->get("shop_id");
        if (!session()->has("shop_id")){
            return redirect(Config::get('const.title.title47'));
        }
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        // var_dump($data);
        $year=date('Y');

        //設立年月日分割
        if (isset($item->year_of_establishment)) {
            $birth = explode("-", $item->year_of_establishment);
            $birth_y = $birth[0];
            $birth_m = $birth[1];
            $birth_d = $birth[2];
        } else {
            $birth_y = "";
            $birth_m = "";
            $birth_d = "";
        }

        //住所分割
        $shop_address = explode("=", $item->shop_address);
        $shop_address1 = $shop_address[0];
        $shop_address2 = $shop_address[1];
        $shop_address3 = $shop_address[2];
        if (empty($shop_address[3])) {
            $shop_address4 = "";
        } else {
            $shop_address4 = $shop_address[3];
        }

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'year'=>$year,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'name_fri1'=>$data[2],
            'name_fri2'=>$data[3],
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'shop_address1'=>$shop_address1,
            'shop_address2'=>$shop_address2,
            'shop_address3'=>$shop_address3,
            'shop_address4'=>$shop_address4,
            'birth_y'=>$birth_y,
            'birth_m'=>$birth_m,
            'birth_d'=>$birth_d,
        ];

        return view(Config::get('const.title.title47')."/edit_form/client_account_edit", $send_param)->with('item',$item);
    }

    //クライアントアカウント基本情報編集
    public function account_edit(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $today = date("Y-m-d-H:i:s");
        //
        $file_delete = $request->file_delete_check;
        $now_img_name = $request->user_now_img;
        // 画像ファイル処理
        if ($file = $request->user_thumbnail) {
            $fileName = $today . "_" . $file->getClientOriginalName();
            $target_path = 'client_images/';
            // 既存画像削除
            if ($now_img_name !== null) {
                unlink($target_path.$now_img_name);
            }
            $file->move($target_path, $fileName);
        } elseif ($file_delete === "削除") {
            $target_path = 'client_images/';
            // 既存画像削除
            if ($now_img_name !== null) {
                unlink($target_path.$now_img_name);
            }
            $fileName = "";
        } else {
            $fileName = $now_img_name;
        }

        //name
        $name_1=$request->name_1;
        $name_2=$request->name_2;
        $name_furi_1=$request->furigana_1;
        $name_furi_2=$request->furigana_2;
        $name = "{$name_1} {$name_2}";
        $name_furi = "{$name_furi_1} {$name_furi_2}";
        //day
        $year=$request->year;
        $month=$request->month;
        $days=$request->days;
        $year_of_establishment="{$year}-{$month}-{$days}";
        //user_address
        $address_47=$request->address_tdfk;
        $address_city=$request->address_city;
        $address_banti=$request->address_banti;
        $address_building=$request->address_building;
        if (empty($address_building)) {
            $client_address = "{$address_47}={$address_city}={$address_banti}";
        } else {
            $client_address = "{$address_47}={$address_city}={$address_banti}={$address_building}";
        }

        $param=[
            'shop_name'=>$request->company_name,
            'tantou_name'=>$name,
            'tantou_name_fri'=>$name_furi,
            'shop_station'=>$request->near_station,
            'address_number'=>$request->address_number,
            'shop_address'=>$client_address,
            'shop_phone'=>$request->tel01,
            'client_image'=>$fileName,
            'business_bescription'=>$request->business_bescription,
            'year_of_establishment'=>$year_of_establishment,
            'capital'=>$request->capital,
            'sales'=>$request->sales,
            'ceo_name'=>$request->ceo_name,
            'number_employees'=>$request->number_employees,
            'total_number_employees'=>$request->total_number_employees,
            'license_text'=>$request->license_text,
            'majo_business_partners'=>$request->majo_business_partners,
            'delete_flag'=>'0',
            'updated_at'=>$today,
        ];

        DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)
        ->update($param);

        $msgs="アカウント情報を編集しました。";

        return redirect(Config::get('const.title.title47').'/'.'client_account/edit')->with('msgs',$msgs);
    }

    //クライアントアカウント取得(特徴・会社紹介)
    public function account_get_2(){
        $shop_id=session()->get("shop_id");
        if (!session()->has("shop_id")){
            return redirect(Config::get('const.title.title47'));
        }
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $year=date('Y');
        //list
        $interview_list=Config::get('form_list.interview');
        $qualifications_held_list=Config::get('form_list.qualifications_held');//保有資格
        $industry_list=Config::get('form_list.industry');//業界
        $industry_kind_list=Config::get('form_list.industry_kind');//業種
        //業種、業界、保有資格、％データベース配列
        $db_data_lists = Insyoku::company_db_list_get($item);

        $new_messages = Insyoku::new_messages_alert($shop_id);
        $send_param=[
            'new_messages'=>$new_messages,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'interview_list'=>$interview_list,
            'qualifications_held_list'=>$qualifications_held_list,
            'industry_list'=>$industry_list,
            'industry_kind_list'=>$industry_kind_list,
            'interview_format'=>$data[6],
            'relation_industry'=>$db_data_lists[0],
            'relation_industry_rate'=>$db_data_lists[1],
            'relation_industry2'=>$db_data_lists[2],
            'relation_industry_rate_2'=>$db_data_lists[3],
            'company_qualification'=>$db_data_lists[4],
            'company_qualification_rate'=>$db_data_lists[5],
        ];

        return view(Config::get('const.title.title47')."/edit_form/client_self_introduction", $send_param)->with('item',$item);
    }

    //クライアントアカウント特徴・会社紹介情報編集
    public function account_edit_2(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $today = date("Y-m-d-H:i:s");
        //
        //面談・商談方法
        $interview_place = "";
        if ( isset($request->interview_check) ) {
            foreach($request->interview_check as $check) {
                $interview_place = $interview_place . $check. "/";
            }
        }

        $param=[
            'relation_industry1_1'=>$request->relation_industry1_1,
            'relation_industry1_2'=>$request->relation_industry1_2,
            'relation_industry1_3'=>$request->relation_industry1_3,
            'relation_industry1_4'=>$request->relation_industry1_4,
            'relation_industry_rate_1_1'=>$request->relation_industry_rate_1_1,
            'relation_industry_rate_1_2'=>$request->relation_industry_rate_1_2,
            'relation_industry_rate_1_3'=>$request->relation_industry_rate_1_3,
            'relation_industry_rate_1_4'=>$request->relation_industry_rate_1_4,
            'relation_industry2_1'=>$request->relation_industry2_1,
            'relation_industry2_2'=>$request->relation_industry2_2,
            'relation_industry2_3'=>$request->relation_industry2_3,
            'relation_industry2_4'=>$request->relation_industry2_4,
            'relation_industry_rate_2_1'=>$request->relation_industry_rate_2_1,
            'relation_industry_rate_2_2'=>$request->relation_industry_rate_2_2,
            'relation_industry_rate_2_3'=>$request->relation_industry_rate_2_3,
            'relation_industry_rate_2_4'=>$request->relation_industry_rate_2_4,
            'company_qualification1'=>$request->company_qualification1,
            'company_qualification2'=>$request->company_qualification2,
            'company_qualification3'=>$request->company_qualification3,
            'company_qualification4'=>$request->company_qualification4,
            'company_qualification_rate_1'=>$request->company_qualification_rate_1,
            'company_qualification_rate_2'=>$request->company_qualification_rate_2,
            'company_qualification_rate_3'=>$request->company_qualification_rate_3,
            'company_qualification_rate_4'=>$request->company_qualification_rate_4,
            'company_introduction'=>$request->company_introduction,
            'pr_comment'=>$request->pr_comment,
            'company_type'=>$request->company_type,
            'interview_format'=>$interview_place,//
            'member_text'=>$request->member_text,
            'characteristics_of_holding'=>$request->characteristics_of_holding,
            'business_partner_trends'=>$request->business_partner_trends,
            'payment_site_info'=>$request->payment_site_info,
            'trends_in_human_resources'=>$request->trends_in_human_resources,
            'delete_flag'=>'0',
            'updated_at'=>$today,
        ];

        DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)
        ->update($param);

        $msgs="アカウント情報を編集しました。";
        return redirect(Config::get('const.title.title47').'/'.'client_account/self_introduction/edit')->with('msgs',$msgs);
    }


    ///////ユーザー情報詳細
    public function apply_user_detail($id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $user_item=DB::table('influs')->where('delete_flag','0')->where('id',$id)->first();
        if (empty($user_item)){
            return redirect(Config::get('const.title.title47').'/client_account/apply_issue');
        }
        $item_list = Influ::desired_lists_db_get($user_item);

        //アカウント情報加工
        //生年月日分割
        $birth = explode("-", $user_item->user_birth);
        $birth_y = $birth[0]; $birth_m = $birth[1]; $birth_d = $birth[2];
        //住所分割
        $user_address = explode("=", $user_item->user_address);
        $user_address1 = $user_address[0];

        //list
        $national=Config::get('list.national');
        $jobs=Config::get('form_list.jobs');
        $language=Config::get('form_list.language');
        $last_education=Config::get('form_list.last_education');
        $language_level=Config::get('form_list.language_level');
        $priority_form_list=Config::get('form_list.priority');
        $current_status_list=Config::get('form_list.current_status');
        $contract_form_list=Config::get('form_list.contract_form');
        $interview_list=Config::get('form_list.interview');

        // スキルリスト
        $lists = Influ::skill_list_get();
        // skill_list_db
        $experience_check_lists = Influ::skill_lists_db_get($user_item);
        $experience_position_check = $experience_check_lists[0];
        $experience_skill_check = $experience_check_lists[1];
        $experience_industry_check = $experience_check_lists[2];
        $experience_technology_prosess = $experience_check_lists[3];

        $desired_check_lists = Influ::desired_skill_lists_db_get($user_item);
        $desired_position_check = $desired_check_lists[0];
        $desired_skill_check = $desired_check_lists[1];
        $desired_industry_check = $desired_check_lists[2];
        $desired_technology_prosess = $desired_check_lists[3];

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'national'=>$national,
            'birth_y'=>$birth_y,
            'birth_m'=>$birth_m,
            'birth_d'=>$birth_d,
            'user_address1'=>$user_address1,
            'national'=>$national,
            'language_level'=>$language_level,
            'last_education'=>$last_education,
            'language'=>$language,
            'priority_form_list'=>$priority_form_list,
            'current_status_list'=>$current_status_list,
            'interview_list'=>$interview_list,
            'contract_form_list'=>$contract_form_list,
            'jobs'=>$jobs,
            'lists'=>$lists,
            'experience_position_check'=>$experience_position_check,
            'experience_skill_check'=>$experience_skill_check,
            'experience_industry_check'=>$experience_industry_check,
            'experience_technology_prosess'=>$experience_technology_prosess,

            'desired_position_check'=>$desired_position_check,
            'desired_skill_check'=>$desired_skill_check,
            'desired_industry_check'=>$desired_industry_check,
            'desired_technology_prosess'=>$desired_technology_prosess,

            'item'=>$user_item,

            'kadou_kaisibi_y'=>$item_list[0],
            'kadou_kaisibi_m'=>$item_list[1],
            'kadou_kaisibi_d'=>$item_list[2],
            'priority'=>$item_list[3],
            'interview_place'=>$item_list[4],
            'desired_money'=>$item_list[5],
            'desired_contract_form'=>$item_list[6],
        ];

        return view(Config::get('const.title.title47')."/user_detail", $send_param);
    }

    ///////ユーザー情報詳細_post
    public function apply_user_detail_post(Request $request,$id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $user_item=DB::table('influs')->where('delete_flag','0')->where('id',$id)->first();

        $target_path = 'biography_works_files/';


        // ボタン区別
        if (isset($request->file_download_btn_1)) {
            $pdfFilePath = $user_item->biography_works_file_1;
            $file_path = $target_path.$pdfFilePath;
            return response()->download($file_path);
        }
        if (isset($request->file_download_btn_2)) {
            $pdfFilePath = $user_item->biography_works_file_2;
            $file_path = $target_path.$pdfFilePath;
             return response()->download($file_path);
        }
    }

    ////メッセージ機能 
    //メッセージ一覧表示
    public function message_user_all(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        //room
        $room_data = DB::table('message_room')->where('delete_flag','0')->where('shop_id',$shop_id)->orderBy('update_at', 'desc')->get();

        //roomのuserを配列
        $room_user = [];
        $room_id = [];
        $room_comments = [];
        $room_midoku_comments = [];
        
        if (isset($room_data)) {
            foreach ($room_data as $room_one) {
                $room_user_one = DB::table('influs')->where('delete_flag','0')->where('user_id',$room_one->user_id)->select("user_id","user_name","user_image")->first();
                array_push($room_user, $room_user_one);
                array_push($room_id, $room_one->id);
                // /roomのコメント数
                $room_comment = DB::table('message')->where('delete_flag','0')->where('room_id',$room_one->id)->get();
                if (!empty($room_comment)) {
                    array_push($room_comments, $room_comment);
                    //未読の数
                    $room_midoku_comment=[];
                    foreach ($room_comment as $midoku_comment) {
                        if ($midoku_comment->show_flag == 0 && $midoku_comment->destination_id == $shop_id) {
                            array_push($room_midoku_comment, $midoku_comment);
                        }
                    }
                    array_push($room_midoku_comments, $room_midoku_comment);
                }
                if (empty($room_comment)) {
                    array_push($room_comments, "");
                    array_push($room_midoku_comments, "");
                }
            }
            // var_dump($room_user);
        } else {
            $room_data = [];
        }

        $administrator_room_data = DB::table('mg_message_room')->where('delete_flag','0')->where('shop_id',$shop_id)->orderBy('update_at', 'desc')->first();

        $administrator_room_id = $administrator_room_data;
        $administrator_room_comments = "";
        $administrator_room_midoku_comments = "";

        if (isset($administrator_room_data)) {
            // /roomのコメント数
            $administrator_room_comment = DB::table('mg_message')->where('delete_flag','0')->where('room_id',$administrator_room_data->id)->get();

            if (count($administrator_room_comment) !== 0) {
                $administrator_room_comments = $administrator_room_comment;
                //未読の数
                $administrator_room_midoku_comment=[];
                foreach ($administrator_room_comment as $administrator_midoku_comment) {
                    if ($administrator_midoku_comment->show_flag == 0 && $administrator_midoku_comment->destination_shop_id == $shop_id) {
                        array_push($administrator_room_midoku_comment, $administrator_midoku_comment);
                    }
                }
                $administrator_room_midoku_comments = $administrator_room_midoku_comment;
            }
            if (empty($administrator_room_comment)) {
                array_push($administrator_room_comments, "");
                array_push($administrator_room_midoku_comments, "");
            }
            // var_dump($room_user);
        } else {
            $room_data = [];
        }

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'item'=>$item,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'room_data'=>$room_data,
            'room_user'=>$room_user,
            'room_id'=>$room_id,
            'room_comments'=>$room_comments,
            'room_midoku_comments'=>$room_midoku_comments,
            'administrator_room_id'=>$administrator_room_id,
            'administrator_room_comments'=>$administrator_room_comments,
            'administrator_room_midoku_comments'=>$administrator_room_midoku_comments,
        ];

        return view(Config::get('const.title.title47')."/messages_all", $send_param);
    }

    //管理者メッセージルーム作成
    public function administrator_message_room_create(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');

        $msgs="";
        if (isset($request->submit_msg)) {
            $today = date("Y-m-d-H:i:s");

            if (empty($request->shop_number_id) || empty($request->shop_id)) {
                $msgs="管理者ルームを作成できません。";
            }

            if (!empty($request->shop_id) && !empty($request->shop_number_id)) {
                //ルームは作成済みか
                $mg_message_room = DB::table('mg_message_room')
                                ->where('shop_id',$request->shop_id)
                                ->where('delete_flag','0')
                                ->first();
                
                //ルームがなかったら
                if (empty($mg_message_room)) {
                    $param_m=[
                        'shop_id'=>$request->shop_id,
                        'delete_flag'=>'0',
                        'created_at'=>$today,
                    ];

                    DB::table('mg_message_room')->insert($param_m);
                }

                $meg_room_id = DB::table('mg_message_room')
                            ->where('shop_id',$request->shop_id)
                            ->where('delete_flag','0')
                            ->first();
                if (empty($meg_room_id)) {
                    return redirect(Config::get('const.title.title47').'/'.'client_account/messages')->with('msgs',$msgs);
                } else {
                    return redirect(Config::get('const.title.title47').'/'.'client_account/message/'.$meg_room_id->id)->with('msgs',$msgs);
                }
            }

        }
    }



    //メッセージroom
    public function message_talk_room($id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $room_data = DB::table('message_room')->where('delete_flag','0')->where('id',$id)->where('shop_id',$shop_id)->first();
        if (empty($room_data)) {
            //自分のルームじゃない場合
            return redirect(Config::get('const.title.title47').'/'.'client_account/messages');
        }
        $user_data = DB::table('influs')->where('delete_flag','0')->where('user_id',$room_data->user_id)->select("user_id","user_name","user_image")->first();
        
        //room_comments
        $room_comments = DB::table('message')->where('delete_flag','0')->where('room_id',$id)->get();
        if (empty($room_comments)) {
            $room_comments = [];
        }

        //未読メッセージを既読にする
        $param=[
            'show_flag'=>"1",
            'delete_flag'=>'0',
        ];

        DB::table('message')->where('delete_flag','0')->where('room_id', $id)->where('destination_id', $shop_id)->update($param);

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_id'=>$shop_id,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'room_data'=>$room_data,
            'user_data'=>$user_data,
            'room_comments'=>$room_comments,
        ];
        return view(Config::get('const.title.title47')."/message_talk_room", $send_param);
    }


    //メッセージroom_post
    public function message_talk_room_post(Request $request,$id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $today = date("Y年m月d日 H:i");
        $today_time = date("Y-m-d H:i:s");
        $day_time = date("H:i");

        if (isset($request->post_message)) {

            $param=[
                'room_id'=>$id,
                'shop_id'=>$shop_id,
                'comment'=>$request->message_post_textarea,
                'destination_id'=>$request->user_id,
                'show_flag'=>"0",
                'day_time'=>$day_time,
                'delete_flag'=>'0',
                'created_at'=>$today,
            ];
            $param2=[
                'delete_flag'=>'0',
                'update_at'=>$today_time,
            ];
            DB::table('message')->insert($param);
            DB::table('message_room')->where('delete_flag','0')->where('id',$id)->update($param2);

            $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

            $mail_param=[
                'form_name'=>$item->shop_name,
                'send_user'=>"1",
            ];
            $email = $request->user_id;
    
            // メール
            Mail::to($email)->send(new ClientMessageMail($mail_param));
        }


        return redirect(Config::get('const.title.title47').'/'.'client_account/message/'.$id);
    }


    //メッセージroom
    public function mg_message_talk_room($id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $room_data = DB::table('mg_message_room')->where('delete_flag','0')->where('id',$id)->where('shop_id',$shop_id)->first();
        if (empty($room_data)) {
            //自分のルームじゃない場合
            return redirect(Config::get('const.title.title47').'/'.'client_account/messages');
        }
        
        //room_comments
        $room_comments = DB::table('mg_message')->where('delete_flag','0')->where('room_id',$id)->get();
        if (empty($room_comments)) {
            $room_comments = [];
        }

        //未読メッセージを既読にする
        $param=[
            'show_flag'=>"1",
            'delete_flag'=>'0',
        ];

        DB::table('mg_message')->where('delete_flag','0')->where('room_id', $id)->where('destination_shop_id', $shop_id)->update($param);

        $send_param=[
            'shop_id'=>$shop_id,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'room_data'=>$room_data,
            'room_comments'=>$room_comments,
        ];

        return view(Config::get('const.title.title47')."/mg_message_talk_room", $send_param);
    }


    //メッセージroom_post
    public function mg_message_talk_room_post(Request $request,$id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $today = date("Y年m月d日 H:i");
        $today_time = date("Y-m-d H:i:s");
        $day_time = date("H:i");

        if (isset($request->post_message)) {

            $param=[
                'room_id'=>$id,
                'shop_id'=>$shop_id,
                'comment'=>$request->message_post_textarea,
                'destination_mg'=>'administrator',
                'show_flag'=>"0",
                'day_time'=>$day_time,
                'delete_flag'=>'0',
                'created_at'=>$today,
            ];
            $param2=[
                'delete_flag'=>'0',
                'update_at'=>$today_time,
            ];
            DB::table('mg_message')->insert($param);
            DB::table('mg_message_room')->where('delete_flag','0')->where('id',$id)->update($param2);

            $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

            $mail_param=[
                'form_name'=>$item->shop_name,
                'send_administrator'=>"1",
            ];
            $email = "ago.kilon@gmail.com";
    
            // メール
            Mail::to($email)->send(new ClientMessageMail($mail_param));
        }


        return redirect(Config::get('const.title.title47').'/'.'client_account/mg_message/'.$id);
    }


    //人選定
    public function contract_form_view($id) {
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $issue_item = DB::table('matters')->where('delete_flag','0')->where('id',$id)->where('shop_id',$shop_id)->first();
        $issue_apply_users = DB::table('apply_contacts')->where('delete_flag','0')->where('issue_id',$id)->where('apply_flag','1')->get();

        if (empty($issue_item)) {
            $msgs="案件がありません。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/apply_issue')->with('msgs',$msgs);;
        }

        $item_users = [];
        foreach ($issue_apply_users as $ap_issue) {
            //お気に入りのみ
            $item_user = DB::table('influs')->where('delete_flag','0')->where('user_id',$ap_issue->user_id)->first();
            array_push($item_users, $item_user);
        }
        if (count($item_users) == 0) {
            $msgs="案件での応募がありません。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/apply_issue')->with('msgs',$msgs);;
        }

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'issue_id'=>$issue_item->id,
            'shop_id'=>$shop_id,
            'issue_users'=>$item_users,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/contract_form", $send_param)->with('shop_item',$item);
    }

    //人選定session 確認ページへ
    public function contract_form_session(Request $request,$id) {
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        //送信データをsessionに保持
        $post_data = $request->all();
        //sessionほじ
        session()->put('user_select_contract_form_data', $post_data);


        return redirect(Config::get('const.title.title47').'/'.'client_account/contract_form_confirmation/'.$id);
    }

    //人選定確認ページ
    public function contract_form_confirmation_view($id) {
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
  
        //sessionデータを表示 input hiddenに挿入＋表示
        if (!session()->has("user_select_contract_form_data")){
            return redirect(Config::get('const.title.title47').'/client_account');
        }
        $session_data = session()->get('user_select_contract_form_data');

        //選択人材
        $item_users = [];
        foreach ($session_data['user_select'] as $select_user) {
            //お気に入りのみ
            $item_user = DB::table('influs')->where('delete_flag','0')->where('id',$select_user)->first();
            array_push($item_users, $item_user);
        }
        if (count($item_users) == 0) {
            $msgs="ユーザーが選択されていません";
            return redirect(Config::get('const.title.title47').'/'.'client_account/contract_form'.$id)->with('msgs',$msgs);
        }

        $send_param=[
            'session_data'=>$session_data,
            'item_users'=>$item_users,
        ];
        
        return view(Config::get('const.title.title47')."/contract_form_confirmation", $send_param);
    }
    
    //人選定db保存
    public function contract_form_post(Request $request,$id) {
        
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        if (!session()->has("user_select_contract_form_data")){
            return redirect(Config::get('const.title.title47').'/client_account');
        }
        //戻るボタン
        if (isset($request->return_sub)) {
            return redirect(Config::get('const.title.title47').'/'.'client_account/contract_form/'.$id);
        }
        
        //sessionデータを表示 input hiddenに挿入＋表示
        if (!session()->has("user_select_contract_form_data")){
            return redirect(Config::get('const.title.title47').'/client_account');
        }
        $session_data = session()->get('user_select_contract_form_data');
        $shop_id=session()->get('shop_id');
        
        if (isset($request->post_sub)) {
            $item_contacts = DB::table('contacts')->where('delete_flag','0')->where('issue_id',$id)->first();
            if (!empty($item_contacts)) {
                $msgs="すでに人材確定を行なっています";
                return redirect(Config::get('const.title.title47').'/'.'client_account/apply_issue')->with('msgs',$msgs);
            }

            if (empty($item_contacts)) {
                if (isset($session_data)) {
                    $today_time = date("Y-m-d H:i:s");
                    $operation_start_at = "{$session_data['year']}-{$session_data['month']}-{$session_data['days']}";

                    $shop_item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

                    $issue_item = DB::table('matters')->where('delete_flag','0')->where('id',$id)->first();

                    //user情報保存
                    $item_users = [];
                    foreach ($session_data['user_select'] as $select_user) {
                        //お気に入りのみ
                        $item_user = DB::table('influs')->where('delete_flag','0')->where('id',$select_user)->first();
                        array_push($item_users, $item_user);
                    }
                    $users_name = "";
                    $users_id = "";
                    $users_count = count($item_users);
                    $contacts_num_plus = 1;
                    ////////////////////////////////////////////////
                    $mail_param_contacts_id = [];
                    $mail_param_users_name = [];
                    foreach ($item_users as $user) {
                        //お気に入りのみ
                        $users_name = $user->user_name;
                        $users_id = $user->user_id;
                        $user_number_id = $user->id;

                        $all_contacts = count(DB::table('contacts')->where('delete_flag','0')->get());

                        //contacts_id
                        $int_id = intval($all_contacts);
                        $contacts_id = strval( 1000000 + $int_id + $contacts_num_plus );

                        $input_date = "{$session_data['year']}-{$session_data['month']}-{$session_data['days']}";
                        $contract_expiration_3month =  date("Y-m-d",strtotime($input_date . "+3 month"));
    
                        $param=[
                            'contacts_id'=>$contacts_id,
                            'issue_id'=>$id,
                            'shop_number_id'=>$shop_item->id,
                            'shop_id'=>$session_data['shop_mail'],
                            'shop_name'=>$session_data['shop_name'],
                            'shop_mail'=>$session_data['shop_mail'],
                            'shop_tantou_name'=>$session_data['tantou_name'],
                            'operation_start_at'=>$operation_start_at,
                            'contract_users_number'=>$users_count,
                            'contract_users_name'=>$users_name,
                            'user_number_id'=>$user_number_id,
                            'contract_users_id'=>$users_id,
                            'user_judge'=>'0',
                            'delete_flag'=>'0',
                            'contract_expiration_3month'=>$contract_expiration_3month,
                            'created_at'=>$today_time,
                            
                        ];
                        $param2=[
                            'flag'=>'2',
                            'updated_at'=>$today_time,
                            
                        ];
                        array_push($mail_param_contacts_id, $contacts_id);
                        array_push($mail_param_users_name, $users_name);
                    
                        DB::table('contacts')->insert($param);
                        DB::table('matters')
                        ->where('id', $id)
                        ->where('delete_flag','0')
                        ->update($param2);
                    }
                    $mail_param=[
                        'form_name'=>$issue_item->matter_name,
                        'users_count'=>$users_count,
                        'all_contacts_id'=>$mail_param_contacts_id,
                        'all_users_name'=>$mail_param_users_name,
                    ];
                    $email = $shop_id;
            
                    // メール
                    Mail::to($email)->send(new UserDecisionMail($mail_param));

                    session()->forget('user_select_contract_form_data');
                    $msgs="人材を確定しました";
                }
            }
            
        }

        return redirect(Config::get('const.title.title47').'/'.'client_account/apply_issue')->with('msgs',$msgs);
    }

    //契約情報///////////////////////////////////////////////////////////////////////////
    //契約一覧取得
    public function all_contracts_get(){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $contracts_item = DB::table('contacts')->where('delete_flag','0')->where('shop_id',$shop_id)->orderBy('contacts_id', 'desc')->get();
        $data = Insyoku::edit_get_same($item);

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_id'=>$shop_id,
            'contracts_item'=>$contracts_item,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/my_contracts_all", $send_param);
    }

    //人材稼働確認一覧
    public function contracts_user_confirmation(){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        session()->forget('contacts_user_judge_input');
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        //未払：未人材確認
        $contracts_item = DB::table('contacts')->where('delete_flag','0')->where('shop_id',$shop_id)->where('payment_judge',null)->where('user_judge','0')->orderBy('contacts_id', 'desc')->get();
        $data = Insyoku::edit_get_same($item);

        $user_jydge_contracts_item = [];
        foreach ($contracts_item as $c_item) {
            $three_month_Date = new DateTime(date("{$c_item->contract_expiration_3month}"));

            $todayDate = new DateTime(date("Y-m-d"));
            $intvl = $three_month_Date->diff($todayDate);

            if ($three_month_Date <= $todayDate){ 
                array_push($user_jydge_contracts_item,$c_item);
            }
        }

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_id'=>$shop_id,
            'contracts_item'=>$user_jydge_contracts_item,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/contracts_user_confirmation", $send_param);
    }

    //人材稼働確認ページ
    public function contracts_user_confirmation_check($id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        //未払：未人材確認
        $contracts_item = DB::table('contacts')->where('id',$id)->where('delete_flag','0')->where('shop_id',$shop_id)->where('payment_judge',null)->where('user_judge','0')->orderBy('contacts_id', 'desc')->first();
        if (empty($contracts_item)) {
            $msgs="人材確定が存在しません。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
        }
        $three_month_Date = new DateTime(date("{$contracts_item->contract_expiration_3month}"));
        $todayDate = new DateTime(date("Y-m-d"));
        $intvl = $three_month_Date->diff($todayDate);
        if ($three_month_Date > $todayDate){ 
            $msgs="人材確定が存在しません。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
        }

        $user_item=DB::table('influs')->where('delete_flag','0')->where('user_id',$contracts_item->contract_users_id)->first();

        $data = Insyoku::edit_get_same($item);

        $new_messages = Insyoku::new_messages_alert($shop_id);

        if (session()->has('contacts_user_judge_input')) {
            $session_contacts_user_judge_input = session()->get('contacts_user_judge_input');
        } else {
            $session_contacts_user_judge_input = "";
        }

        $send_param=[
            'new_messages'=>$new_messages,
            'session_contacts_user_judge_input'=>$session_contacts_user_judge_input,
            'shop_id'=>$shop_id,
            'contracts_item'=>$contracts_item,
            'user_item'=>$user_item,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/contracts_user_confirmation_check", $send_param);
    }

    //人材稼働確認　確認画面&session
    public function contracts_user_confirmation_check_post(Request $request,$id){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        if (isset($request->input_submit)) {
            $shop_id=session()->get('shop_id');
            //未払：未人材確認
            $contracts_item = DB::table('contacts')->where('id',$request->contract_id)->where('delete_flag','0')->where('shop_id',$shop_id)->where('payment_judge',null)->where('user_judge','0')->orderBy('contacts_id', 'desc')->first();
            if (empty($contracts_item)) {
                $msgs="人材確定が存在しません。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
            }
            $three_month_Date = new DateTime(date("{$contracts_item->contract_expiration_3month}"));
            $todayDate = new DateTime(date("Y-m-d"));
            $intvl = $three_month_Date->diff($todayDate);
            if ($three_month_Date > $todayDate){ 
                $msgs="人材確定が存在しません。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
            }

            session()->put('contacts_user_judge_input', $request->all());    
            if (session()->has('contacts_user_judge_input')) {
                return redirect(Config::get('const.title.title47').'/'.'client_account/contracts_user_judge_confirmation_view');
            } else {
                $msgs="エラーが発生しました。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
            }
        }
    }

    //人材稼働確認がめん
    public function contracts_user_judge_confirmation_view(){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $new_messages = Insyoku::new_messages_alert($shop_id);
        
        if (session()->has('contacts_user_judge_input')) {
            $session_contacts_user_judge_input = session()->get('contacts_user_judge_input');
            $user_item=DB::table('influs')->where('delete_flag','0')->where('id',$session_contacts_user_judge_input["user_id"])->first();

            $send_param=[
                'new_messages'=>$new_messages,
                'shop_id'=>$shop_id,
                'user_item'=>$user_item,
                'session_contacts_user_judge_input'=>$session_contacts_user_judge_input,
                'shop_name'=>$data[4],
                'shop_image'=>$data[5],
            ];

            return view(Config::get('const.title.title47')."/contracts_user_judge_confirmation_view", $send_param);
        } else {
            $msgs="エラーが発生しました。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
        }
    }

    //人材稼働確認登録&&支払情報登録
    public function contracts_user_judge_confirmation_view_post(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

        
        if (session()->has('contacts_user_judge_input')) {
            $session_contacts_user_judge_input = session()->get('contacts_user_judge_input');

            if (isset($request->return_sub)) {
                return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation_check/'."{$session_contacts_user_judge_input["contract_id"]}");
            }

            if (isset($request->post_sub)) {
                //
                $contacts_item=DB::table('contacts')->where('delete_flag','0')->where('shop_id',$shop_id)->where('id',$session_contacts_user_judge_input["contract_id"])->first();
                if (empty($contacts_item)) {
                    $msgs="エラーが発生しました。";
                    return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
                }
                $today = date("Y-m-d-H:i:s");
                $today2 = date("Y-m-d");
                if ($session_contacts_user_judge_input["selector1"] == '2') {
                    $payment_term = date("Y-m-d",strtotime($today2 . "+8 day"));
                }else {
                    $payment_term = NULL;
                }

                if (empty($session_contacts_user_judge_input["user_judge_textarea"])) {
                    $reason_textarea = NULL;
                } else {
                    $reason_textarea = $session_contacts_user_judge_input["user_judge_textarea"];
                }

                //契約情報編集
                $contacts_param=[
                    'user_judge'=>$session_contacts_user_judge_input["selector1"],
                    'reason_textarea'=>$reason_textarea,
                    'payment_term'=>$payment_term,
                    'updated_at'=>$today,
                ];
                DB::table('contacts')
                ->where('id',$session_contacts_user_judge_input["contract_id"])
                ->where('delete_flag','0')
                ->where('shop_id', $shop_id)
                ->update($contacts_param);

                //支払情報
                if ($session_contacts_user_judge_input["selector1"] == '2') {
                    $payment_information_param=[
                        'contacts_number_id'=>$contacts_item->id,
                        'contacts_id'=>$contacts_item->contacts_id,
                        'shop_number_id'=>$contacts_item->shop_number_id,
                        'shop_id'=>$contacts_item->shop_id,
                        'shop_name'=>$contacts_item->shop_name,
                        'payment_money'=>50000 * 1.1,
                        'delete_flag'=>"0",
                        'payment_term'=>$payment_term,
                        'created_at'=>$today,
                    ];
                    DB::table('payment_information')->insert($payment_information_param);
    
                    $mail_param=[
                        'form_name'=>$contacts_item->contacts_id,
                        'payment_term'=>$payment_term,
                        'contract_user_name'=>$contacts_item->contract_users_name,
                        'payment_money'=>"50,000",
                        'reason_textarea'=>$reason_textarea,
                        'user_judge'=>$session_contacts_user_judge_input["selector1"],
                    ];
                    $email = $shop_id;
            
                    // メール
                    Mail::to($email)->send(new PaymentInformationMail($mail_param));
                } else {
                    $mail_param=[
                        'form_name'=>$contacts_item->contacts_id,
                        'payment_term'=>"",
                        'contract_user_name'=>$contacts_item->contract_users_name,
                        'payment_money'=>"",
                        'reason_textarea'=>$reason_textarea,
                        'user_judge'=>$session_contacts_user_judge_input["selector1"],
                    ];
                    $email = $shop_id;
            
                    // メール
                    Mail::to($email)->send(new PaymentInformationMail($mail_param));
                }

                $msgs="人材稼働確認を行いました。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
            }

        } else {
            $msgs="エラーが発生しました。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/user_confirmation')->with('msgs',$msgs);
        }
    }

    //未払いページ
    public function contracts_payment(){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        //未払：支払情報取得
        $payment_item = DB::table('payment_information')->where('delete_flag','0')->where('shop_id',$shop_id)->where('payment_judge',null)->get();
        $data = Insyoku::edit_get_same($item);

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $stripe_pk_key = config('stripe.pk_key');
        // var_dump($stripe_pk_key);

        // secret key (支払いが発生した時の決済時に必要)
        $stripe_sk_key = config('stripe.sk_key');
        // var_dump($stripe_sk_key);
        $money = 50000;

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_id'=>$shop_id,
            'payment_item'=>$payment_item,
            'money'=>$money,
            'stripe_sk_key'=>$stripe_sk_key,
            'stripe_pk_key'=>$stripe_pk_key,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/client_payment", $send_param);
    }

    //支払処理
    public function charge_payment(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $today = date("Y-m-d-H:i:s");
        $shop_id=session()->get('shop_id');
        $get_payment_item=DB::table('payment_information')->where('contacts_id',$request->payment_contacts_id)->where('delete_flag','0')->orderBy('contacts_id', 'desc')->first();
        $get_contacts_item=DB::table('contacts')->where('contacts_id',$request->payment_contacts_id)->where('delete_flag','0')->orderBy('contacts_id', 'desc')->first();

        if (!empty($get_payment_item) && !empty($get_contacts_item)) {

            $stripe_sk_key = config('stripe.sk_key');
            \Stripe\Stripe::setApiKey($stripe_sk_key);//シークレットキー

            $charge = \Stripe\Charge::create(array(
                'amount' => 50000,
                'currency' => 'jpy',
                'source'=> $request->stripeToken,
            ));

            if ($charge) {
                $contacts_param = [
                    'payment_judge'=>'1',
                    'updated_at'=>$today,
                ];
                
                $payment_param = [
                    'payment_judge'=>'1',
                    'payment_day'=>$today,
                    'updated_at'=>$today,
                ];

                DB::table('contacts')
                ->where('contacts_id', $request->payment_contacts_id)
                ->where('delete_flag','0')
                ->update($contacts_param);

                DB::table('payment_information')
                ->where('contacts_id', $request->payment_contacts_id)
                ->where('delete_flag','0')
                ->update($payment_param);

                //管理者、企業側に支払い完了メール
                $mail_param=[
                    'form_name'=>$request->payment_contacts_id,
                    'payment_term'=>$get_payment_item->payment_term,
                    'payment_day'=>$today,
                    'contract_user_name'=>$get_contacts_item->contract_users_name,
                    'payment_money'=>"50,000",
                ];
                $email = $shop_id;
        
                // メール
                Mail::to($email)->send(new PaymentOkMail($mail_param));

                $msgs="お支払いが完了いたしました。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/payment')->with('msgs',$msgs);
            } else {
                $msgs="お支払いを完了できませんでした。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/payment')->with('msgs',$msgs);
            }

        } else {
            $msgs="お支払いを完了できませんでした。";
            return redirect(Config::get('const.title.title47').'/'.'client_account/payment')->with('msgs',$msgs);
        }

    }

    //支払完了一覧
    public function contracts_payment_completion(){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        //支払済み：支払情報取得
        $payment_item = DB::table('payment_information')->where('delete_flag','0')->where('shop_id',$shop_id)->where('payment_judge',"1")->get();
        $data = Insyoku::edit_get_same($item);

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_id'=>$shop_id,
            'payment_item'=>$payment_item,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/payment_completion", $send_param);
    }

    //領収書発行 receipt_flag
    public function payment_completion_receipt(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $today = date("Y-m-d-H:i:s");
        $shop_id=session()->get('shop_id');

        if (isset($request->receipt_submit)) {
            $get_payment_item=DB::table('payment_information')->where('contacts_id',$request->contacts_id)->where('delete_flag','0')->first();
            $shop_item=DB::table('insyokus')->where('shop_id',$shop_id)->where('delete_flag','0')->first();

            if (empty($get_payment_item)) {
                $msgs="エラーが発生しました。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/payment_completion')->with('msgs',$msgs);
            }

            if ($get_payment_item->receipt_flag == "1") {
                $msgs="すでに領収書は発行されています。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/payment_completion')->with('msgs',$msgs);
            } else {
                $payment_param = [
                    'receipt_flag'=>'1',
                    'updated_at'=>$today,
                ];
    
                DB::table('payment_information')
                ->where('contacts_id', $request->contacts_id)
                ->where('delete_flag','0')
                ->update($payment_param);

                $target_pdf = 'template_file/receipt_template.pdf';
                $pdf = new TcpdfFpdi();
                $pdf->SetMargins(0, 0, 0);
                $pdf->SetCellPadding(0);
                $pdf->SetAutoPageBreak(false);
                $pdf->setPrintHeader(false);    
                $pdf->setPrintFooter(false);
                // テンプレート読み込み
                $pdf->setSourceFile('template_file/receipt_template.pdf');
                $pdf->AddPage();
                $pdf->useTemplate($pdf->importPage(1));
    
                $contract_id = $get_payment_item->contacts_id; // ID
                $today = date("Y年m月d日"); // 発行日
                $company_name = $get_payment_item->shop_name."様"; // 会社名
                $company_tel = $shop_item->shop_phone; // 会社tel
                $company_address_num = $shop_item->address_number; // 会社郵便
                //住所分割
                $shop_address = explode("=", $shop_item->shop_address);
                $shop_address1 = $shop_address[0];
                $shop_address2 = $shop_address[1];
                $shop_address3 = $shop_address[2];
                if (empty($shop_address[3])) {
                    $shop_address4 = "";
                } else {
                    $shop_address4 = $shop_address[3];
                }
                $company_address = $shop_address1." ".$shop_address2." ".$shop_address3." ".$shop_address4; // 会社住所
    
                $pdf->SetTextColor(0, 0, 0);
                $font = 'kozminproregular';
    
                //契約ID
                $pdf->SetFont($font,'',11);
                $pdf->SetXY(31, 19);
                // 文字列を書き込む
                $pdf->Write(0, $contract_id);
    
                //発行日
                $pdf->SetFont($font,'',11);
                $pdf->SetXY(144, 19);
                // 文字列を書き込む
                $pdf->Write(0, $today);
    
                //会社名
                $pdf->SetFont($font,'',16);
                $pdf->SetXY(20, 29);
                // 文字列を書き込む
                $pdf->Write(0, $company_name);
    
                //会社郵便番号
                $pdf->SetFont($font,'',11);
                $pdf->SetXY(33, 40);
                // 文字列を書き込む
                $pdf->Write(0, $company_address_num);
    
                //会社住所
                $pdf->SetFont($font,'',11);
                $pdf->SetXY(26, 45);
                // 文字列を書き込む
                $pdf->Write(0, $company_address);
    
                //会社電話番号
                $pdf->SetFont($font,'',11);
                $pdf->SetXY(33, 51);
                // 文字列を書き込む
                $pdf->Write(0, $company_tel);
    
                //支払完了日
                $pdf->SetFont($font,'',12);
                $pdf->SetXY(45, 58.5);
                // 文字列を書き込む
                $pdf->Write(0, $today);
    
                $pdf->Output(sprintf("MyResume_%s.pdf", time()), 'I');
            }
    
        }
    }

    public function test_pdf(){
        $pdf = new TcpdfFpdi();
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetCellPadding(0);
        $pdf->SetAutoPageBreak(false);
        $pdf->setPrintHeader(false);    
        $pdf->setPrintFooter(false);
        // テンプレート読み込み
        $pdf->setSourceFile('template_file/receipt_template.pdf');
        $pdf->AddPage();
        $pdf->useTemplate($pdf->importPage(1));

        $contract_id = "12345678"; // ID
        $today = date("Y年m月d日"); // 発行日
        $company_name = "Life Can Change株式会社"."様"; // 会社名
        $company_tel = "09088581212"; // 会社tel
        $company_address_num = "1110000"; // 会社郵便
        $company_address = "東京都 台東区 谷中町13-5 Tokyoビル25F"; // 会社住所

        $pdf->SetTextColor(0, 0, 0);
        $font = 'kozminproregular';

        //契約ID
        $pdf->SetFont($font,'',11);
        $pdf->SetXY(31, 19);
        // 文字列を書き込む
        $pdf->Write(0, $contract_id);

        //発行日
        $pdf->SetFont($font,'',11);
        $pdf->SetXY(144, 19);
        // 文字列を書き込む
        $pdf->Write(0, $today);

        //会社名
        $pdf->SetFont($font,'',16);
        $pdf->SetXY(20, 29);
        // 文字列を書き込む
        $pdf->Write(0, $company_name);

        //会社郵便番号
        $pdf->SetFont($font,'',11);
        $pdf->SetXY(33, 40);
        // 文字列を書き込む
        $pdf->Write(0, $company_address_num);

        //会社住所
        $pdf->SetFont($font,'',11);
        $pdf->SetXY(26, 45);
        // 文字列を書き込む
        $pdf->Write(0, $company_address);

        //会社電話番号
        $pdf->SetFont($font,'',11);
        $pdf->SetXY(33, 51);
        // 文字列を書き込む
        $pdf->Write(0, $company_tel);

        //支払完了日
        $pdf->SetFont($font,'',12);
        $pdf->SetXY(45, 58.5);
        // 文字列を書き込む
        $pdf->Write(0, $today);

        $pdf->Output(sprintf("MyResume_%s.pdf", time()), 'I');
    }


    //パスワード変更
    public function client_account_password(){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

        $data = Insyoku::edit_get_same($item);

        $new_messages = Insyoku::new_messages_alert($shop_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_id'=>$shop_id,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
        ];

        return view(Config::get('const.title.title47')."/client_account_password", $send_param);
    }
    public function client_account_password_post(Request $request){
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }

        $shop_id=session()->get('shop_id');

        $password=$request->password;
        $password_confirmation=$request->password_confirmation;

        if ($password===$password_confirmation){
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            DB::table('insyokus')
            ->where('shop_id', $shop_id)
            ->where('delete_flag','0')
            ->update(['shop_pass'=>$password_hash]);

            $msgs="パスワードを変更しました。";
            return redirect(Config::get('const.title.title47').'/client_account')->with('msgs',$msgs);
        }elseif (strlen($password)<8){
            $msgs="パスワードには8文字以上を設定してください。";
            return redirect(Config::get('const.title.title47').'/client_account_password')->with('msgs',$msgs);
        }else{
            $msgs="確認用パスワードが異なります。";
            return redirect(Config::get('const.title.title47').'/client_account_password')->with('msgs',$msgs);
        }
    }


    //ログアウト
    public function client1_logout(){
        session()->forget('shop_id');
        session()->forget('shop_name');
        return redirect(Config::get('const.title.title47').'/');
    }

}
//1220