<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use App\Models\Influ;
use App\Models\Insyoku;
use App\Mail\InfluOuboMail;
use App\Mail\InfluKariMail;
use App\Mail\InfluPassReput;
use App\Mail\SelectedFromAdmin;
use App\Mail\MailTest;
use App\Mail\InfluRegistrationOkMail;
use App\Mail\ClientMessageMail;


use Illuminate\Support\Facades\Storage;

class Client2Controller extends Controller
{

    //インフルエンサー仮登録///////////////////////////////////////////////////////////
    public function before_form(Request $request){
    //     //日時
        $today = date("Y-m-d H:i:s");
        $user_mail=$request->email;
        $item=DB::table('influs')->where('user_mail',$user_mail)->count();
        if ($item!==0){
            $msgs="既に使用されているメールアドレスです。";
            return redirect(Config::get('const.title.title48').'/first_form')->with('msgs', $msgs);
        }
        $email=$request->email;
        //token_email
        $token_email=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 50);

        $param=[
            'user_id'=>$email,
            'user_mail'=>$email,
            'user_flag'=>"1",
            'user_touroku'=>$today,
            'delete_flag'=>'0',
            'email_verify_token'=>$token_email,
        ];

        $mail_param=[
            'email'=>$email,
            'token_email'=>$token_email,
        ];

        // メール
        Mail::to($email)->send(new InfluKariMail($mail_param));

        DB::table('influs')->insert($param);
        $msg2='仮登録メールが送信されました。メールボックスをご確認ください。';
        return view(Config::get('const.title.title48').".first_form", ["msg"=>'応募が完了しました。','msg2'=>$msg2]);
    }

    //インフルエンサー本登録情報取得//////////////////////
    public function after_form_pre(){
        $year=date('Y');
        $date_list=Config::get('list.date_list');
        $month_list=Config::get('list.month_list');
        $national=Config::get('list.national');

        $send_param=[
            'year'=>$year,
            'date_list'=>$date_list,
            'month_list'=>$month_list,
            'national'=>$national,
        ];
        return view(Config::get('const.title.title48').".second_form", $send_param);
    }

    //インフルエンサー本登録
    public function after_form(Request $request){
        $today = date("Y-m-d H:i:s");
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
        $birth="{$year}-{$month}-{$days}";
        //user_address
        $address_47=$request->address_tdfk;
        $address_city=$request->address_city;
        $address_banti=$request->address_banti;
        $address_building=$request->address_building;
        if (empty($address_building)) {
            $user_address = "{$address_47}={$address_city}={$address_banti}";
        } else {
            $user_address = "{$address_47}={$address_city}={$address_banti}={$address_building}";
        }

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
        $item=DB::table('influs')->where('delete_flag','0')->where('user_flag','1')->where('user_mail',$email)->first();
        if (empty($item)) {
            $msgs="仮メール登録時のメールアドレスを入力してください。";
            return redirect(url()->full())->with('msgs', $msgs);
        }
        $token = $request->email_url_hash;
        if ($item->email_verify_token !== $token) {
            $msgs="無効なURLです。";
            return redirect(url()->full())->with('msgs', $msgs);
        }

        $param=[
            'user_name'=>$name,
            'user_furigana'=>$name_furi,
            'user_seibetu'=>$request->selector1,
            'user_birth'=>$birth,
            'user_national'=>$request->national,
            'moyori_eki'=>$request->near_station,
            'user_mail'=>$request->email,
            'user_address'=>$user_address,
            'address_number'=>$request->address_number,
            'user_phone'=>$request->tel01,
            'user_pass'=>$password_hash,
            'user_flag'=>'2',
            'delete_flag'=>'0',
            'user_touroku'=>$today,
        ];

        DB::table('influs')
        ->where('delete_flag','0')
        ->where('user_id', $email)
        ->where('email_verify_token', $token)
        ->update($param);

        $mail_param=[
            'email'=>$email,
        ];

        // メール
        Mail::to($email)->send(new InfluRegistrationOkMail($mail_param));

        $msgs="登録が完了いたしました。";
        return redirect(Config::get('const.title.title48'))->with('msgs', $msgs);
    }

    //パスワード再発行
    public function pass_reput(Request $request){
        $item=DB::table('influs')
        ->where('delete_flag','0')
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
            ->where('delete_flag','0')
            ->update(['user_pass'=>$password_hash]);

            $msg="ご登録いただいているメールアドレスへ仮パスワードを送付しました。";

            $param=[
                'delete_flag'=>'0',
                'user_name'=>$item->user_name,
                'password'=>$password,
            ];
            Mail::to($email)->send(new InfluPassReput($param));
        }
        return redirect(Config::get('const.title.title48').'/pass_forget')->with(['msg'=>$msg]);
    }

    //ログイン処理
    public function login(Request $request){
        $id=$request->id;
        $password_kari=$request->password;

        $item = DB::table('influs')->select('user_name','user_pass','user_flag')->where('delete_flag','0')->where('user_id',$id)
        ->wherein('user_flag',['2'])
        ->first();

        if (empty($item)){
            return view(Config::get('const.title.title48').".index", ["error"=>'IDまたはパスワードが一致しません。']);

        }elseif (!empty($item->user_name)){
            $password=$item->user_pass;
            $user_flag=$item->user_flag;

            if (password_verify($password_kari, $password)){
                // セッションIDの再発行
                $request->session()->regenerate();
                $request->session()->put('user_id', $id);
                $request->session()->put('user_name', $item->user_name);

                if ($user_flag==="1"){
                    return redirect(Config::get('const.title.title48').'/second_form', 302, [], true);
                    // return redirect(Config::get('const.title.title48').'/second_form');
                }else{

                    return redirect(Config::get('const.title.title48').'/user_account');
                    // return redirect(Config::get('const.title.title48').'/main');
                }
            }else{
                $aaa = "oi";
                return view(Config::get('const.title.title48').".index", ["error"=>'IDまたはパスワードが一致しません。'])->with('item',$item);
            }
        }else{
            return view(Config::get('const.title.title48').".index", ["error"=>'エラーが発生しました。']);
        }
    }

    // mypage_データ取得////////////////////////////////////////////////////////////////////////////////////////////
    public function mypage_get(){
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        $skill_lists = Influ::skill_list_get();
        $experience_check_lists = Influ::skill_lists_db_get($item);
        $experience_skill_check = $experience_check_lists[1];

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'skill_lists'=>$skill_lists,
            'experience_skill_check'=>$experience_skill_check,
        ];

        return view(Config::get('const.title.title48').".user_account", $send_param);

    }

    //アカウント基本情報
    public function account_get(){
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        //生年月日分割
        $birth = explode("-", $item->user_birth);-
        $birth_y = $birth[0];
        $birth_m = $birth[1];
        $birth_d = $birth[2];
        //住所分割
        $user_address = explode("=", $item->user_address);
        $user_address1 = $user_address[0];
        $user_address2 = $user_address[1];
        $user_address3 = $user_address[2];
        if (empty($user_address[3])) {
            $user_address4 = "";
        } else {
            $user_address4 = $user_address[3];
        }
        $year=date('Y');
        $date_list=Config::get('list.date_list');
        $month_list=Config::get('list.month_list');
        $national=Config::get('list.national');

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'year'=>$year,
            'date_list'=>$date_list,
            'month_list'=>$month_list,
            'national'=>$national,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'name_fri1'=>$data[2],
            'name_fri2'=>$data[3],
            'user_image'=>$data[4],
            'birth_y'=>$birth_y,
            'birth_m'=>$birth_m,
            'birth_d'=>$birth_d,
            'user_address1'=>$user_address1,
            'user_address2'=>$user_address2,
            'user_address3'=>$user_address3,
            'user_address4'=>$user_address4,
        ];
        return view(Config::get('const.title.title48')."/edit_form/user_account_edit", $send_param)->with('item',$item);
    }

    //アカウント基本情報edit情報編集
    public function account_edit(Request $request){
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");
        $file_delete = $request->file_delete_check;
        $now_img_name = $request->user_now_img;
        // 画像ファイル処理
        if ($file = $request->user_thumbnail) {
            $fileName = $today . "_" . $file->getClientOriginalName();
            $target_path = 'user_images/';
            // 既存画像削除
            if ($now_img_name !== null) {
                unlink($target_path.$now_img_name);
            }
            $file->move($target_path, $fileName);
        } elseif ($file_delete === "削除") {
            $target_path = 'user_images/';
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
        $birth="{$year}-{$month}-{$days}";
        //user_address
        $address_47=$request->address_tdfk;
        $address_city=$request->address_city;
        $address_banti=$request->address_banti;
        $address_building=$request->address_building;
        if (empty($address_building)) {
            $user_address = "{$address_47}={$address_city}={$address_banti}";
        } else {
            $user_address = "{$address_47}={$address_city}={$address_banti}={$address_building}";
        }
        $param=[
            'user_name'=>$name,
            'user_furigana'=>$name_furi,
            'user_seibetu'=>$request->selector1,
            'user_birth'=>$birth,
            'user_national'=>$request->national,
            'moyori_eki'=>$request->near_station,
            'user_address'=>$user_address,
            'address_number'=>$request->address_number,
            'user_phone'=>$request->tel01,
            'user_image'=>$fileName,
            'delete_flag'=>'0',
            'updated_at'=>$today,
        ];
        DB::table('influs')
        ->where('user_id', $user_id)
        ->where('delete_flag','0')
        ->update($param);
        $msgs="変更しました。";
        return redirect(Config::get('const.title.title48').'/user_account/edit')->with('msgs',$msgs);
    }

    //アカウント情報自己紹介＿取得
    public function self_introduction_get(Request $request) {
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        // 卒業年ど
        if (empty($item->zinbutu_user)) {
            $zinbutu_user1 = "";
            $zinbutu_user2 = "";
            $zinbutu_user3 = "";
        } else {
            $zinbutu_user = explode("/", $item->zinbutu_user);
            if (empty($zinbutu_user[0])) {
                $zinbutu_user1 = "";
                $zinbutu_user2 = $zinbutu_user[1];
                $zinbutu_user3 = $zinbutu_user[2];
            } elseif (empty($zinbutu_user[1])) {
                $zinbutu_user1 = $zinbutu_user[0];
                $zinbutu_user2 = "";
                $zinbutu_user3 = $zinbutu_user[2];
            } elseif (empty($zinbutu_user[2])) {
                $zinbutu_user1 = $zinbutu_user[0];
                $zinbutu_user2 = $zinbutu_user[1];
                $zinbutu_user3 = "";
            } else {
                $zinbutu_user1 = $zinbutu_user[0];
                $zinbutu_user2 = $zinbutu_user[1];
                $zinbutu_user3 = $zinbutu_user[2];
            }
        }
        // 人物
        if (empty($item->univ_last_year_month)) {
            $univ_last_year = "";
            $univ_last_month = "";
        } else {
            $univ_last_year_month = explode("/", $item->univ_last_year_month);
            if (empty($univ_last_year_month[0])) {
                $univ_last_year = "";
                $univ_last_month = $univ_last_year_month[1];
            } elseif (empty($univ_last_year_month[1])) {
                $univ_last_month = "";
                $univ_last_year = $univ_last_year_month[0];
            } else {
                $univ_last_year = $univ_last_year_month[0];
                $univ_last_month = $univ_last_year_month[1];
            }
        }
        // list取得
        $jobs=Config::get('form_list.jobs');
        $zinbutu_user=Config::get('form_list.zinbutu_user');
        $language=Config::get('form_list.language');
        $last_education=Config::get('form_list.last_education');
        
        $new_messages = Influ::new_messages_alert($user_id);

        $language_level=Config::get('form_list.language_level');
        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'univ_last_month'=>$univ_last_month,
            'univ_last_year'=>$univ_last_year,
            'language_level'=>$language_level,
            'last_education'=>$last_education,
            'language'=>$language,
            'zinbutu_user'=>$zinbutu_user,
            'jobs'=>$jobs,
            'zinbutu_user3'=>$zinbutu_user3,
            'zinbutu_user2'=>$zinbutu_user2,
            'zinbutu_user1'=>$zinbutu_user1,
        ];
        return view(Config::get('const.title.title48')."/edit_form/user_self_introduction_edit", $send_param)->with('item',$item);
    }

    ////アカウント自己紹介edit情報編集
    public function self_introduction_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");
        // 卒業年ど
        $univ_last_year_month = "{$request->year}/{$request->month}";
        //人物像
        if (isset($request->zinbutu_user[0])) {
            $zinbutu_user = "{$request->zinbutu_user[0]}";
        } else {
            $zinbutu_user = "";
        }
        if (isset($request->zinbutu_user[1])) {
            $zinbutu_user = $zinbutu_user ."/{$request->zinbutu_user[1]}";
        }else {
            $zinbutu_user = $zinbutu_user . "/";
        }
        if (isset($request->zinbutu_user[2])) {
            $zinbutu_user = $zinbutu_user ."/{$request->zinbutu_user[2]}";
        } else {
            $zinbutu_user = $zinbutu_user . "/";
        }

        $param=[
            'it_job'=>$request->it_job,
            'Industry_experience'=>$request->Industry_experience,
            'user_forte'=>$request->user_forte,
            'self_introduction_text'=>$request->self_introduction_text,
            'description_text'=>$request->description_text,
            'allowance'=>$request->allowance,
            'last_education'=>$request->last_education,
            'user_univ_name'=>$request->user_univ_name,
            'univ_last_year_month'=>$univ_last_year_month,
            'language_level'=>$request->language_level,
            'toeic'=>$request->toeic,
            'language1'=>$request->language1,
            'language_level1'=>$request->language_level1,
            'language2'=>$request->language2,
            'language_level2'=>$request->language_level2,
            'zinbutu_user'=>$zinbutu_user,
            'delete_flag'=>'0',
            'updated_at'=>$today,
        ];
        DB::table('influs')
        ->where('delete_flag','0')
        ->where('user_id', $user_id)
        ->update($param);
        $msgs="変更しました。";
        return redirect(Config::get('const.title.title48').'/user_account/self_introduction/edit')->with('msgs',$msgs);
    }

    //アカウント情報経歴・作品＿取得
    public function biography_works_get() {
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
        ];

        return view(Config::get('const.title.title48')."/edit_form/biography_works", $send_param)->with('item',$item);
    }

    //アカウント情報経歴・作品＿編集
    public function biography_works_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");
        $target_path = 'biography_works_files/';
        // ボタン区別
        if (isset($request->file_download_btn_1)) {
            $pdfFilePath = $request->user_now_file1;
            $file_path = $target_path.$pdfFilePath;
             return response()->download($file_path);
        }
        if (isset($request->file_download_btn_2)) {
            $pdfFilePath = $request->user_now_file2;
            $file_path = $target_path.$pdfFilePath;
             return response()->download($file_path);
        }
        if (isset($request->input_submit)) {
            $file_top = ["スキルシート", "ポートフォリオ"];
            if (isset($request->biography_works_file)) {
                for ($i = 0; $i <= 1; $i++) {
                    if (isset($request->biography_works_file[$i])) {
                        $file = $request->biography_works_file[$i];
                    // 拡張子の確認
                        $f_ex = $file->getClientOriginalExtension();
                        if ($f_ex === "xls" || $f_ex === "xlsx" || $f_ex === "doc" || $f_ex === "docx" || $f_ex === "ppt" || $f_ex === "pptx" || $f_ex === "txt"|| $f_ex === "pdf" || $i === 1) {
                            $fileName = $file_top[$i] . "_" . $today. "." .$f_ex;
                            //現在のfile名
                            $num = $i + 1;
                            if($i === 0) {
                                $now_file = $request->user_now_file1;
                            } elseif ($i === 1) {
                                $now_file = $request->user_now_file2;
                            }
                            // 既存画像削除
                            if ($now_file !== null) {
                                unlink($target_path.$now_file);
                            }
                            //フォルダ保存
                            $file->move($target_path, $fileName);
                            $param=[
                                'biography_works_file_'.$num=>$fileName,
                                'biography_works_file_'.$num.'_day'=>$today,
                                'delete_flag'=>'0',
                                'updated_at'=>$today,
                            ];
                            DB::table('influs')
                            ->where('delete_flag','0')
                            ->where('user_id', $user_id)
                            ->update($param);
                        } else {
                            $msgs="職務経歴書・スキルシートの拡張子はxls / xlsx / doc / docx / ppt / pptx / txt / pdfでお願い致します。";
                            return redirect(Config::get('const.title.title48').'/user_account/biography_works/edit')->with('msgs',$msgs);
                        }
                    }
                }
            }
            // 削除処理
            if (isset($request->biography_works_file_delete1)) {
                //現在のfile名
                    $now_file = $request->user_now_file1;
                // 既存画像削除
                if ($now_file !== null) {
                    unlink($target_path.$now_file);
                }
                //DB更新
                $param=[
                    'biography_works_file_1'=>null,
                    'biography_works_file_1_day'=>null,
                    'delete_flag'=>'0',
                    'updated_at'=>$today,
                ];
                DB::table('influs')
                ->where('delete_flag','0')
                ->where('user_id', $user_id)
                ->update($param);
            }
            if (isset($request->biography_works_file_delete2)) {
                //現在のfile名
                    $now_file = $request->user_now_file2;
                // 既存画像削除
                if ($now_file !== null) {
                    unlink($target_path.$now_file);
                }
                //DB更新
                $param=[
                    'biography_works_file_2'=>null,
                    'biography_works_file_2_day'=>null,
                    'delete_flag'=>'0',
                    'updated_at'=>$today,
                ];
                DB::table('influs')
                ->where('delete_flag','0')
                ->where('user_id', $user_id)
                ->update($param);
            }
            $msgs="変更しました。";
            return redirect(Config::get('const.title.title48').'/user_account/biography_works/edit')->with('msgs',$msgs);
        }
    }

    ////アカウント経験企業-情報取得
    public function experienced_companies_get(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        //月list
        $month_list=Config::get('list.month_list');
        $contract_form_list=Config::get('form_list.contract_form');
        $year=date('Y');

        $item2=DB::table('influ_companies')->where('user_id',$user_id)->select('id','company_name','year1','month1','year2','month2','ex_companies_check','contract_form','job_description','business_description')->get();
        if(count($item2) == 0) {
            $count = 0;
        } else {
            $count = count($item2);
        }

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'box_count'=>$count,
            'month_list'=>$month_list,
            'year'=>$year,
            'contract_form_list'=>$contract_form_list,
        ];

        return view(Config::get('const.title.title48')."/edit_form/experienced_companies", $send_param)->with('item',$item)->with('item2',$item2);
    }

    ////アカウント経験企業edit情報編集
    public function experienced_companies_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $item2=DB::table('influ_companies')->where('user_id',$user_id)->select('id','company_name','year1','month1','year2','month2','ex_companies_check','contract_form','job_description','business_description')->get();
        //月list
        $month_list=Config::get('list.month_list');
        $contract_form_list=Config::get('form_list.contract_form');
        $year=date('Y');

        // 追加ボタン押されたら
        if (isset($request->add_btn_div)) {
            $data = Influ::edit_get_same($item);
            
            $new_messages = Influ::new_messages_alert($user_id);

            $count = $request->box_form_count +1;
            $send_param=[
                'new_messages'=>$new_messages,
                'name1'=>$data[0],
                'name2'=>$data[1],
                'user_image'=>$data[4],
                'box_count'=>$count,
                'month_list'=>$month_list,
                'year'=>$year,
                'contract_form_list'=>$contract_form_list,
            ];
            return view(Config::get('const.title.title48')."/edit_form/experienced_companies", $send_param)->with('item',$item)->with('item2',$item2);
        }
        // 変更ボタン押されたら
        if (isset($request->input_submit)) {
            for ($i = 1; $i <= $request->box_form_count; $i++) {
                $delete_ex = "ex_companies_check_delete".$i;
                $company_name = "company_name".$i;
                $year1 = "year".$i."_1";
                $month1 = "month".$i."_1";
                $year2 = "year".$i."_2";
                $month2 = "month".$i."_2";
                $contract_form = "contract_form".$i;
                $job_description = "job_description".$i;
                $business_description = "business_description".$i;
                $ex_companies_box_id = "ex_companies_box_id".$i;
                $ex_companies_check = "ex_companies_check".$i;

                // 削除処理
                if (isset($request->$delete_ex)) {
                    if ($request->$ex_companies_box_id !== 0) {
                        DB::table('influ_companies')
                        ->where([['id', $request->$ex_companies_box_id], ['user_id', $user_id]])
                        ->delete();
                    }
                } else {
                    //DB更新
                    $param=[
                        'user_id'=>$user_id,
                        'company_name'=>$request->$company_name,
                        'year1'=>$request->$year1,
                        'month1'=>$request->$month1,
                        'year2'=>$request->$year2,
                        'month2'=>$request->$month2,
                        'ex_companies_check'=>$request->$ex_companies_check,
                        'contract_form'=>$request->$contract_form,
                        'job_description'=>$request->$job_description,
                        'business_description'=>$request->$business_description,
                        'created_at'=>$today,
                    ];
                    if ($request->$ex_companies_box_id == 0) {
                        DB::table('influ_companies')->insert($param);
                    } else {
                        DB::table('influ_companies')
                        ->where([['id', $request->$ex_companies_box_id], ['user_id', $user_id]])
                        ->update($param);
                    }
                }
            }
            $msgs="変更しました。";
            return redirect(Config::get('const.title.title48').'/user_account/experienced_companies/edit')->with('msgs',$msgs);
        }
    }

    //アカウント情報スキル取得
    public function experienced_skill_get() {
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        // スキルリスト
        $lists = Influ::skill_list_get();
        // skill_title
        $skill_lists = Influ::skill_title_get();
        // skill_list_db
        $experience_check_lists = Influ::skill_lists_db_get($item);
        $experience_position_check = $experience_check_lists[0];
        $experience_skill_check = $experience_check_lists[1];
        $experience_industry_check = $experience_check_lists[2];

        $experience_technology_prosess = $experience_check_lists[3];
        $qualifications_held = $experience_check_lists[4];
        // var_dump($db_skill_lists);

       $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'lists'=>$lists,
            'skill_lists'=>$skill_lists,
            'experience_position_check'=>$experience_position_check,
            'experience_skill_check'=>$experience_skill_check,
            'experience_industry_check'=>$experience_industry_check,
            'experience_technology_prosess'=>$experience_technology_prosess,
            'qualifications_held'=>$qualifications_held,
        ];

        return view(Config::get('const.title.title48')."/edit_form/experienced_skill", $send_param)->with('item',$item);
    }

    //アカウント経験スキル編集
    public function experienced_skill_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");

        if (isset($request->input_submit)) {

            //経験ポジ
            $experience_position = "";
            if ($request->skill_posi === null) {
                $experience_position = null;
            } elseif (isset($request->skill_posi)) {
                foreach ($request->skill_posi as $value) {
                    $experience_position = $experience_position . $value . "/";
                }
            }

            //経験スキル
            $experience_skill = "";
            if ($request->skill_skl === null) {
                $experience_skill = null;
            } elseif (isset($request->skill_skl)) {
                foreach ($request->skill_skl as $value) {
                    $experience_skill = $experience_skill . $value . "/";
                }
            }

            //経験業
            $experience_industry = "";
            if ($request->skill_industry === null) {
                $experience_industry = null;
            } elseif (isset($request->skill_industry)) {
                foreach ($request->skill_industry as $value) {
                    $experience_industry = $experience_industry . $value . "/";
                }
            }

            $experience_technology = "";
            if ($request->experience_technology === null) {
                $experience_technology = null;
            } elseif (isset($request->experience_technology)) {
                foreach ($request->experience_technology as $technology_val) {
                    $experience_technology = $experience_technology . $technology_val . "/";
                }
            }

            $experience_process = "";
            if ($request->experience_process === null) {
                $experience_process = null;
            } elseif (isset($request->experience_process)) {
                foreach ($request->experience_process as $process_val) {
                    $experience_process = $experience_process . $process_val . "/";
                }
            }

            $qualifications_held = "";
            if ($request->qualifications_held === null) {
                $qualifications_held = null;
            } elseif (isset($request->qualifications_held)) {
                foreach ($request->qualifications_held as $held_val) {
                    $qualifications_held = $qualifications_held . $held_val . "/";
                }
            }

            $param=[
                'experience_position'=>$experience_position,
                //
                'experience_skill'=>$experience_skill,
                //
                'experience_industry'=>$experience_industry,
                //
                'experience_technology'=>$experience_technology,
                'experience_process'=>$experience_process,
                'qualifications_held'=>$qualifications_held,
                //
                'experience_tokuhitu_text'=>$request->tokuhitu_textarea,
                'delete_flag'=>'0',
                'updated_at'=>$today,
            ];

            DB::table('influs')
                ->where('delete_flag','0')
                ->where('user_id', $user_id)
                ->update($param);

            $msgs="変更しました。";
            return redirect(Config::get('const.title.title48').'/user_account/experienced_skill/edit')->with('msgs',$msgs);
        }
    }

    //アカウント希望条件取得
    public function desired_conditions_get(Request $request) {
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        $item_list = Influ::desired_lists_db_get($item);
        

        //form_list
        $priority_form_list=Config::get('form_list.priority');
        $current_status_list=Config::get('form_list.current_status');
        $contract_form_list=Config::get('form_list.contract_form');
        $interview_list=Config::get('form_list.interview');

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'priority_form_list'=>$priority_form_list,
            'current_status_list'=>$current_status_list,
            'interview_list'=>$interview_list,
            'contract_form_list'=>$contract_form_list,
            //
            'kadou_kaisibi_y'=>$item_list[0],
            'kadou_kaisibi_m'=>$item_list[1],
            'kadou_kaisibi_d'=>$item_list[2],
            'priority'=>$item_list[3],
            'interview_place'=>$item_list[4],
            'desired_money'=>$item_list[5],
            'desired_contract_form'=>$item_list[6],
        ];

        return view(Config::get('const.title.title48')."/edit_form/desired_conditions", $send_param)->with('item',$item);
    }
    
    //アカウント希望条件編集
    public function desired_conditions_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");
        $kadou_kaisibi = "{$request->year}/{$request->month}/{$request->month}";
        $interview_place = "";
        if ( isset($request->interview_check) ) {
            foreach($request->interview_check as $check) {
                $interview_place = $interview_place . $check. "/";
            }
        }

        $param=[
            'desired_priority1'=>$request->priority1,
            'desired_priority2'=>$request->priority2,
            'desired_priority3'=>$request->priority3,
            'desired_priority4'=>$request->priority4,
            'desired_money1'=>$request->money1,
            'desired_money2'=>$request->money2,
            'current_situation'=>$request->current_situation,
            'kadou_kaisibi'=>$kadou_kaisibi,
            'desired_contract_form1'=>$request->desired_contract_form1,
            'desired_contract_form2'=>$request->desired_contract_form2,
            'desired_contract_form3'=>$request->desired_contract_form3,
            'desired_contract_form4'=>$request->desired_contract_form4,
            'desired_contract_form5'=>$request->desired_contract_form5,
            'interview_place'=>$interview_place,
            'job_place'=>$request->job_place,
            'job_home_check'=>$request->job_place_check,
            'commuting_work_minute'=>$request->commuting_work_minute,
            'uptime_month'=>$request->uptime_month,
            'desired_textarea'=>$request->desired_textarea,

            'delete_flag'=>'0',
            'updated_at'=>$today,
        ];

        DB::table('influs')
        ->where('delete_flag','0')
            ->where('user_id', $user_id)
            ->update($param);

        $msgs="変更しました。";
        return redirect(Config::get('const.title.title48').'/user_account/desired_conditions/edit')->with('msgs',$msgs);
    }

    //アカウント希望スキル取得
    public function desired_skills_get(Request $request) {
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        // $lists = Influ::skill_list_get();
        //test
        $lists = Influ::test_skill_list_get();
        // skill_title
        $skill_lists = Influ::skill_title_get();
        // skill_title
        $desired_check_lists = Influ::desired_skill_lists_db_get($item);
        $desired_position_check = $desired_check_lists[0];
        $desired_skill_check = $desired_check_lists[1];
        $desired_industry_check = $desired_check_lists[2];
        $desired_technology_prosess = $desired_check_lists[3];
        // var_dump($db_skill_lists);

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'lists'=>$lists,
            'skill_lists'=>$skill_lists,
            'desired_position_check'=>$desired_position_check,
            'desired_skill_check'=>$desired_skill_check,
            'desired_industry_check'=>$desired_industry_check,
            'desired_technology_prosess'=>$desired_technology_prosess,
        ];

        return view(Config::get('const.title.title48')."/edit_form/desired_skills", $send_param)->with('item',$item);
    }

    //アカウント希望スキル編集
    public function desired_skills_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");

        if (isset($request->input_submit)) {

            //希望ポジ
            $desired_position = $request->skill_posi;
            for ($i = 1; $i <= 3 - count($request->skill_posi);$i++) {
                array_push($desired_position, null);
            }
            
            //希望スキル
            $desired_skill = $request->skill_skl;
            for ($i = 1; $i <= 7 - count($request->skill_skl);$i++) {
                array_push($desired_skill, null);
            }
            
            //希望業
            $desired_industry = $request->skill_industry;
            for ($i = 1; $i <= 3 - count($request->skill_industry);$i++) {
                array_push($desired_industry, null);
            }
            
            //テクノロジー
            $desired_technology = $request->experience_technology;
            if (empty($request->experience_technology)) {
                $desired_technology = [];
                for ($i = 1; $i <= 3;$i++) {
                    array_push($desired_technology, null);
                }
            } else {
                for ($i = 1; $i <= 3 - count($request->experience_technology);$i++) {
                    array_push($desired_technology, null);
                }
            }
            
            //テクノロジー
            $desired_process = $request->experience_process;
            if (empty($request->experience_process)) {
                $desired_process = [];
                for ($i = 1; $i <= 5 ;$i++) {
                    array_push($desired_process, null);
                }
            } else {
                for ($i = 1; $i <= 5 - count($request->experience_process);$i++) {
                    array_push($desired_process, null);
                }
            }

            $param=[
                'desired_position1'=>$desired_position[0],
                'desired_position2'=>$desired_position[1],
                'desired_position3'=>$desired_position[2],
                //
                'desired_skill1'=>$desired_skill[0],
                'desired_skill2'=>$desired_skill[1],
                'desired_skill3'=>$desired_skill[2],
                'desired_skill4'=>$desired_skill[3],
                'desired_skill5'=>$desired_skill[4],
                'desired_skill6'=>$desired_skill[5],
                'desired_skill7'=>$desired_skill[6],
                //
                'desired_industry1'=>$desired_industry[0],
                'desired_industry2'=>$desired_industry[1],
                'desired_industry3'=>$desired_industry[2],
                //
                'desired_technology1'=>$desired_technology[0],
                'desired_technology2'=>$desired_technology[1],
                'desired_technology3'=>$desired_technology[2],
                'desired_process1'=>$desired_process[0],
                'desired_process2'=>$desired_process[1],
                'desired_process3'=>$desired_process[2],
                'desired_process4'=>$desired_process[3],
                'desired_process5'=>$desired_process[4],
                // /////////////////////////////////////////////
                'position_tokuhitu_text'=>$request->position_tokuhitu_text,
                'skill_tokuhitu_text'=>$request->skill_tokuhitu_text,
                'industry_tokuhitu_text'=>$request->industry_tokuhitu_text,
                'technology_tokuhitu_text'=>$request->technology_tokuhitu_text,
                'process_tokuhitu_text'=>$request->process_tokuhitu_text,
                'delete_flag'=>'0',
                'updated_at'=>$today,
            ];

            DB::table('influs')
            ->where('delete_flag','0')
                ->where('user_id', $user_id)
                ->update($param);

            $msgs="変更しました。";
            return redirect(Config::get('const.title.title48').'/user_account/desired_skills/edit')->with('msgs',$msgs);
        }

    }

    //アカウントこだわり条件取得
    public function user_conditions_get(Request $request) {
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $data = Influ::edit_get_same($item);
        $user_conditions_check_lists = Influ::user_conditions_db($item);
        $user_conditions_list = Influ::test_user_conditions_list_get();

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'user_conditions_list'=>$user_conditions_list[0],
            'user_conditions_title'=>$user_conditions_list[1],
            'user_conditions_check_lists'=>$user_conditions_check_lists,
        ];

        return view(Config::get('const.title.title48')."/edit_form/user_conditions", $send_param)->with('item',$item);
    }

    //アカウントこだわり条件編集
    public function user_conditions_edit(Request $request) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y-m-d-H:i:s");

        if (isset($request->input_submit)) {
            $desired_sonota = $request->user_conditions;
            if (empty($request->user_conditions)) {
                $desired_sonota = [];
                for ($i = 1; $i <= 20 ;$i++) {
                    array_push($desired_sonota, null);
                }
            } else {
                for ($i = 1; $i <= 20 - count($request->user_conditions);$i++) {
                    array_push($desired_sonota, null);
                }
            }

            $param=[
                'desired_sonota1'=>$desired_sonota[0],
                'desired_sonota2'=>$desired_sonota[1],
                'desired_sonota3'=>$desired_sonota[2],
                'desired_sonota4'=>$desired_sonota[3],
                'desired_sonota5'=>$desired_sonota[4],
                'desired_sonota6'=>$desired_sonota[5],
                'desired_sonota7'=>$desired_sonota[6],
                'desired_sonota8'=>$desired_sonota[7],
                'desired_sonota9'=>$desired_sonota[8],
                'desired_sonota10'=>$desired_sonota[9],
                'desired_sonota11'=>$desired_sonota[10],
                'desired_sonota12'=>$desired_sonota[11],
                'desired_sonota13'=>$desired_sonota[12],
                'desired_sonota14'=>$desired_sonota[13],
                'desired_sonota15'=>$desired_sonota[14],
                'desired_sonota16'=>$desired_sonota[15],
                'desired_sonota17'=>$desired_sonota[16],
                'desired_sonota18'=>$desired_sonota[17],
                'desired_sonota19'=>$desired_sonota[18],
                'desired_sonota20'=>$desired_sonota[19],
                'delete_flag'=>'0',
                'updated_at'=>$today,
            ];

            DB::table('influs')
            ->where('delete_flag','0')
                ->where('user_id', $user_id)
                ->update($param);

            $msgs="変更しました。";
            return redirect(Config::get('const.title.title48').'/user_account/user_conditions/edit')->with('msgs',$msgs);
        }
    }

    ////////////////
    //メインページ
    public function main_page_view(Request $request) {
        // $user_id=session()->get('user_id');
        // if (!session()->has('user_id')){
        //     return redirect(Config::get('const.title.title48'));
        // }
        session()->forget('search_session');

        // $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();

        // $data = Influ::edit_get_same($item);
        //list
        $contract_form_list=Config::get('form_list.contract_form');
        $dress_list=Config::get('form_list.dress');
        $todouhuken_list=Config::get('list.todouhuken');

        $lists = Influ::matching_list_get();
        $list_title = Influ::matching_list_title_get();

        // $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            // 'new_messages'=>$new_messages,
            // 'name1'=>$data[0],
            // 'name2'=>$data[1],
            // 'user_image'=>$data[4],
            'contract_form_list'=>$contract_form_list,
            'dress_list'=>$dress_list,
            'todouhuken_list'=>$todouhuken_list,
            'lists'=>$lists,
            'list_title'=>$list_title,
        ];

        return view(Config::get('const.title.title48')."/main", $send_param);
    }

    //検索結果ページへ
    public function main_page_search(Request $request) {
        // $user_id=session()->get('user_id');
        // if (!session()->has('user_id')){
        //     return redirect(Config::get('const.title.title48'));
        // }

        if (isset($request->submit)) {
            // var_dump($request->all());
            session()->put('search_session', $request->all());
        }
        if (isset($request->search_word_submit)) {
            session()->put('search_session', $request->all());
        }

        return redirect(Config::get('const.title.title48').'/search_list');
    }

    //案件応募状況 応募一覧取得
    public function user_apply_all(){
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $item2=DB::table('apply_contacts')->where('delete_flag','0')->where('user_id',$user_id)->where('apply_flag','!=','2')->get();
        $item3=DB::table('matters')->where('delete_flag','0')->get();
        $data = Influ::edit_get_same($item);
        $lists = Influ::matching_list_get();

        //応募した案件取得
        $apply_matters = [];
        foreach ($item2 as $item_apply) {
            foreach ($item3 as $item_matter) {
                if($item_matter->id == $item_apply->issue_id) {
                    array_push($apply_matters, $item_matter);
                }
            }
        }


        $m_lists = Insyoku::matching_skill_lists_db_get($apply_matters);

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'matching_position'=>$m_lists[0],
            'matching_skill'=>$m_lists[1],
            'matching_industry'=>$m_lists[2],
            'lists'=>$lists,
        ];

        return view(Config::get('const.title.title48')."/user_apply_all", $send_param)->with('item2',$apply_matters);
    }

    //案件応募状況 見送り応募一覧取得
    public function user_apply_defeated_all(){
        $user_id=session()->get('user_id');
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();
        $item2=DB::table('apply_contacts')->where('delete_flag','0')->where('user_id',$user_id)->where('apply_flag','2')->get();
        $item3=DB::table('matters')->where('delete_flag','0')->where('flag',"1")->get();
        $data = Influ::edit_get_same($item);
        $lists = Influ::matching_list_get();

        //応募した案件取得
        $apply_matters = [];
        foreach ($item2 as $item_apply) {
            foreach ($item3 as $item_matter) {
                if($item_matter->id == $item_apply->issue_id) {
                    array_push($apply_matters, $item_matter);
                }
            }
        }

        $m_lists = Insyoku::matching_skill_lists_db_get($apply_matters);

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'matching_position'=>$m_lists[0],
            'matching_skill'=>$m_lists[1],
            'matching_industry'=>$m_lists[2],
            'lists'=>$lists,
        ];

        return view(Config::get('const.title.title48')."/user_apply_defeated_all", $send_param)->with('item2',$apply_matters);
    }

    //応募案件詳細ページ
    public function user_apply_detail($id) {
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $item2 = DB::table('matters')->where('delete_flag','0')->where('id',$id)->first();
        if (empty($item2)) {
          return redirect(Config::get('const.title.title48').'/'.'user_account');
        }
        $item3 = DB::table('apply_contacts')->where('delete_flag','0')->where('issue_id',$id)->where('user_id',$user_id)->first();
        //すでに応募していたら
        if (!empty($item3)) {
            $apply_check = 1;
        } else {
            $apply_check = 0;
            return redirect(Config::get('const.title.title48').'/'.'user_account/user_apply');
        }
        //企業の名前取得
        $company_item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$item2->shop_id)->first();
        //設立年月日分割
        if (isset($company_item->year_of_establishment)) {
            $birth = explode("-", $company_item->year_of_establishment);
            $birth_y = $birth[0];
            $birth_m = $birth[1];
            $birth_d = $birth[2];
        } else {
            $birth_y = "";
            $birth_m = "";
            $birth_d = "";
        }
        //住所分割
        $shop_address = explode("=", $company_item->shop_address);
        $shop_address1 = $shop_address[0];
        $shop_address2 = $shop_address[1];
        $shop_address3 = $shop_address[2];
        if (empty($shop_address[3])) {
            $shop_address4 = "";
        } else {
            $shop_address4 = $shop_address[3];
        }
    
        //list
        $contract_form_list=Config::get('form_list.contract_form');
        $dress_list=Config::get('form_list.dress');
        $todouhuken_list=Config::get('list.todouhuken');
        $lists = Influ::matching_list_get();
        $m_lists = Insyoku::one_matching_skill_lists_db_get($item2);
    
        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'contract_form_list'=>$contract_form_list,
            'dress_list'=>$dress_list,
            'todouhuken_list'=>$todouhuken_list,
            'matching_position'=>$m_lists[0],
            'matching_skill'=>$m_lists[1],
            'matching_industry'=>$m_lists[2],
            'matching_technology_prosess_sonota'=>$m_lists[3],
            'apply_check'=>$apply_check,
            'lists'=>$lists,
            'shop_address1'=>$shop_address1,
            'shop_address2'=>$shop_address2,
            'shop_address3'=>$shop_address3,
            'shop_address4'=>$shop_address4,
            'birth_y'=>$birth_y,
            'birth_m'=>$birth_m,
            'birth_d'=>$birth_d,
        ];
    
        return view(Config::get('const.title.title48')."/apply_issues_detail",  $send_param)->with(["item2"=>$item2,'company_item'=>$company_item]);
      }

    //企業情報詳細ページ
    public function client_detail_detail($id){
        if (session()->has('user_id')){
            $user_id=session()->get('user_id');
        }
        $company_item = DB::table('insyokus')->where('delete_flag','0')->where('id',$id)->first();
        $data = Insyoku::edit_get_same($company_item);
        $company_rate_list = Influ::company_rate_list($company_item);

        //設立年月日分割
        if (isset($company_item->year_of_establishment)) {
            $birth = explode("-", $company_item->year_of_establishment);
            $birth_y = $birth[0];
            $birth_m = $birth[1];
            $birth_d = $birth[2];
        } else {
            $birth_y = "";
            $birth_m = "";
            $birth_d = "";
        }
        //住所分割
        $shop_address = explode("=", $company_item->shop_address);
        $shop_address1 = $shop_address[0];
        $shop_address2 = $shop_address[1];
        $shop_address3 = $shop_address[2];
        if (empty($shop_address[3])) {
            $shop_address4 = "";
        } else {
            $shop_address4 = $shop_address[3];
        }

        //list
        $interview_list=Config::get('form_list.interview');
        $qualifications_held_list=Config::get('form_list.qualifications_held');//保有資格
        $industry_list=Config::get('form_list.industry');//業界
        $industry_kind_list=Config::get('form_list.industry_kind');//業種

        // $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            // 'new_messages'=>$new_messages,
            'shop_address1'=>$shop_address1,
            'shop_address2'=>$shop_address2,
            'shop_address3'=>$shop_address3,
            'shop_address4'=>$shop_address4,
            'birth_y'=>$birth_y,
            'birth_m'=>$birth_m,
            'birth_d'=>$birth_d,
            'interview_format'=>$data[6],
            'interview_list'=>$interview_list,
            'qualifications_held_list'=>$qualifications_held_list,
            'industry_list'=>$industry_list,
            'industry_kind_list'=>$industry_kind_list,

            'relation_industry1'=>$company_rate_list[0],
            'relation_industry2'=>$company_rate_list[1],
            'company_qualification'=>$company_rate_list[2],
            'relation_industry_rate_1'=>$company_rate_list[3],
            'relation_industry_rate_2'=>$company_rate_list[4],
            'company_qualification_rate_1'=>$company_rate_list[5],
            
            'rate_1'=>$company_rate_list[6],
            'rate_2'=>$company_rate_list[7],
            'rate_3'=>$company_rate_list[8],
        ];

        return view(Config::get('const.title.title48')."/client_detail",  $send_param)->with('company_item',$company_item);
    }

    ////メッセージ機能 
    //メッセージ一覧表示
    public function message_user_all(){
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();  
        $data = Influ::edit_get_same($item);

        //room 
        $room_data = DB::table('message_room')->where('delete_flag','0')->where('user_id',$user_id)->orderBy('update_at', 'desc')->get();
        //roomのuserを配列
        $room_shop = [];
        $room_id = [];
        $room_comments = [];
        $room_midoku_comments = [];
        if (isset($room_data)) {
            foreach ($room_data as $room_one) {
                $room_shop_one = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$room_one->shop_id)->select("shop_id","shop_name","client_image")->first();
                array_push($room_shop, $room_shop_one);
                array_push($room_id, $room_one->id);
                // /roomのコメント数
                $room_comment = DB::table('message')->where('delete_flag','0')->where('room_id',$room_one->id)->get();
                if (!empty($room_comment)) {
                    array_push($room_comments, $room_comment);
                    //未読の数
                    $room_midoku_comment=[];
                    foreach ($room_comment as $midoku_comment) {
                        if ($midoku_comment->show_flag == 0 && $midoku_comment->destination_id == $user_id) {
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
            // var_dump($room_comments);
        } else {
            $room_data = [];
        }

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'name1'=>$data[0],
            'name2'=>$data[1],
            'user_image'=>$data[4],
            'user_name'=>$item->user_name,
            'room_data'=>$room_data,
            'room_shop'=>$room_shop,
            'room_id'=>$room_id,
            'room_comments'=>$room_comments,
            'room_midoku_comments'=>$room_midoku_comments,
        ];

        return view(Config::get('const.title.title48')."/messages_all", $send_param);
    }

    //メッセージroom
    public function message_talk_room($id){
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $item=DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();  
        $data = Influ::edit_get_same($item);
        $room_data = DB::table('message_room')->where('delete_flag','0')->where('id',$id)->where('user_id',$user_id)->first();
        if (empty($room_data)) {
            //自分のルームじゃない場合
            return redirect(Config::get('const.title.title48').'/'.'user_account/messages');
        }
        $shop_data = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$room_data->shop_id)->select("shop_id","shop_name","client_image")->first();

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

        DB::table('message')->where('delete_flag','0')->where('room_id', $id)->where('destination_id', $user_id)->update($param);

        $new_messages = Influ::new_messages_alert($user_id);

        $send_param=[
            'new_messages'=>$new_messages,
            'user_id'=>$user_id,
            'user_image'=>$data[4],
            'user_name'=>$item->user_name,
            'room_data'=>$room_data,
            'shop_data'=>$shop_data,
            'room_comments'=>$room_comments,
        ];
        return view(Config::get('const.title.title48')."/message_talk_room", $send_param);
    }

    //メッセージroom_post
    public function message_talk_room_post(Request $request,$id){
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $today = date("Y年m月d日 H:i");
        $day_time = date("H:i");
        $today_time = date("Y-m-d H:i:s");

        if (isset($request->post_message)) {

            $param=[
                'room_id'=>$id,
                'user_id'=>$user_id,
                'comment'=>$request->message_post_textarea,
                'destination_id'=>$request->shop_id,
                'show_flag'=>"0",
                'day_time'=>$day_time,
                'delete_flag'=>'0',
                'created_at'=>$today,
            ];
            $param2=[
                'update_at'=>$today_time,
                'delete_flag'=>'0',
            ];
            DB::table('message_room')->where('delete_flag','0')->where('id',$id)->update($param2);
            DB::table('message')->insert($param);

            $item = DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();

            $mail_param=[
                'form_name'=>$item->user_name,
                'send_client'=>"1",
            ];
            $email = $request->shop_id;
    
            // メール
            Mail::to($email)->send(new ClientMessageMail($mail_param));
        }

        return redirect(Config::get('const.title.title48').'/'.'user_account/message/'.$id);
    }

    //パスワード変更
    public function client2_pass_edit(Request $request){
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $password=$request->password;
        $password_confirmation=$request->password_confirmation;
        if (isset($request->input_submit)) {
            if ($password===$password_confirmation){
                //暗号化
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
                DB::table('influs')
                ->where('delete_flag','0')
                ->where('user_id', $user_id)
                ->update(['user_pass'=>$password_hash]);
    
                $msgs="パスワードを変更しました。";
                return redirect(Config::get('const.title.title48').'/user_account')->with('msgs',$msgs);
            }elseif (strlen($password)<8){
                $msgs="パスワードには8文字以上を設定してください。";
                return redirect(Config::get('const.title.title48').'/user_account_password')->with('msgs',$msgs);
            }else{
                $msgs="確認用パスワードが異なります。";
                return redirect(Config::get('const.title.title48').'/user_account_password')->with('msgs',$msgs);
            }
        }
    }

    //ログアウト
    public function client2_logout(){
        session()->forget('user_id');
        session()->forget('user_name');
        return redirect(Config::get('const.title.title48').'/main');
    }

}
//1684