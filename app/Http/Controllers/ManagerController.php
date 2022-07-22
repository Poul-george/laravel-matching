<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Manager;
use App\Models\Influ;
use App\Models\Insyoku;
use Illuminate\Support\Facades\Config;

use DateTime;

use App\Mail\AdminCreateMail;
use App\Mail\ClientMessageMail;
use App\Mail\IssuePermissionMail;
use App\Mail\IssueMatchMail;
use Mail;

class ManagerController extends Controller
{
    
    //ログイン処理
    public function login(Request $request){

        $id=$request->id;
        $password_kari=$request->password;
        // echo $id;
        //検索結果削除
        session()->forget('user_search_word');
        session()->forget('issue_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');

        $item = DB::table('managers')->select('manager_name','manager_pass')->where('manager_id',$id)->where('delete_flag','0')->first();

        if (!empty($item)){
            $manager_name=$item->manager_name;
            $password=$item->manager_pass;
            if (password_verify($password_kari, $password)){
                // セッションIDの再発行
                $request->session()->regenerate();
                $request->session()->put('manager_id', $id);
                $request->session()->put('manager_name', $manager_name);
                return redirect(Config::get('const.title.title49').'/main');
            }else{
                return view(Config::get('const.title.title49').".index", ["error"=>'IDまたはパスワードが一致しません。']);
            }
        }else{
            return view(Config::get('const.title.title49').".index", ["error"=>'IDまたはパスワードが一致しません。']);
        }
    }


    //運営者logout
    public function administrator_logout(){
        session()->forget('manager_id');
        session()->forget('manager_name');
        return redirect(Config::get('const.title.title49').'/');
    } 
    //運営者main
    public function administrator_main(Request $request){
        //検索結果削除
        session()->forget('user_search_word');
        session()->forget('issue_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');

        $issue_item_count=count(DB::table('matters')->where('delete_flag','0')->where('flag','0')->get());
        $contacts_item = $get_contacts_item=DB::table('contacts')->where('delete_flag','0')->orderBy('contacts_id', 'desc')->get();

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

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'issue_item_count'=>$issue_item_count,
            'contacts_within_three_days_count'=>$contacts_within_three_days_count,
            'contacts_expiration_one_week_count'=>$contacts_expiration_one_week_count,
            'payment_term_out'=>$payment_term_out,
        ];

        return view(Config::get('const.title.title49').".main", $send_param);
    }

    //運営者ページ (管理者情報)
    public function administrator_account(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
         //検索結果削除
         session()->forget('user_search_word');
         session()->forget('issue_search_word');
         session()->forget('shop_search_word');
         session()->forget('contacts_search_word');
        $item = DB::table('managers')->where('delete_flag','0')->get();
        $session_manager_name = session()->get('manager_name');

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'item'=>$item,
            'manager_name'=>$session_manager_name,
        ];

        return view(Config::get('const.title.title49').".administrator_account", $send_param);
    }

    //管理者削除
    public function administrator_account_delete(Request $request) {
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        $today = date("Y-m-d-H:i:s");
         //検索結果削除
         session()->forget('user_search_word');
         session()->forget('issue_search_word');
         session()->forget('shop_search_word');
         session()->forget('contacts_search_word');
        $msgs="";
        if (isset($request->submit_d)) {
            $param=[
                'delete_flag'=>'1',
            ];

            DB::table('managers')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="削除しました";
        }
        return redirect(Config::get('const.title.title49').'/account_all')->with('msgs',$msgs);
    }


    //アカウント作成
    public function administrator_account_create() {
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
         //検索結果削除
         session()->forget('user_search_word');
         session()->forget('issue_search_word');
         session()->forget('shop_search_word');
         session()->forget('contacts_search_word');
        $item = DB::table('managers')->where('delete_flag','0')->get();
        $session_manager_name = session()->get('manager_name');

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'item'=>$item,
            'manager_name'=>$session_manager_name,
        ];
        return view(Config::get('const.title.title49').".admin_create", $send_param);
    }

    //アカウント作成登録
    public function administrator_account_create_post(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        //検索結果削除
        session()->forget('user_search_word');
        session()->forget('issue_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');

        if (isset($request->input_submit)) {
            //レコード数取得
            $counts = DB::table('managers')->count();

            $num=$counts+1;
            //五文字の乱数
            $account_kari=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 5);
            $account=$account_kari.$num;
            // echo $account;

            //パスワード 8文字
            $password=$account_kari=substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            //暗号化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            // echo $password;
            // exit;

            $manager_name=$request->account_name;
            $manager_mail=$request->email_ad;
            $manager_phone=$request->tel01;




            DB::table('managers')->insert([
                'manager_id' => $account,
                'manager_pass' => $password_hash,
                'manager_name' => $manager_name,
                'manager_mail' => $manager_mail,
                'manager_phone' => $manager_phone,
            ]);

            $param=[
                'manager_name'=>$manager_name,
                'account'=>$account,
                'password'=>$password,
            ];

            // Mail::to($manager_mail)->send(new AdminCreateMail($param));

            return view(Config::get('const.title.title49').".admin_create", ['account'=>$account,'password'=>$password]);
        }
    }

    //運営者ユーザーページ (ユーザー情報検索)
    public function administrator_user_account(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('issue_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');

        //全ユーザー取得
        $user_item = [];
        $get_user_item=DB::table('influs')->where('delete_flag','0')->where('user_flag','2')->select('id','user_id','user_phone','user_name')->get();

        if (session()->has('user_search_word')){
            $session_user_search_word= session()->get('user_search_word');
            //全悟空白
            $session_user_search_word = trim($session_user_search_word);
            if (empty($session_user_search_word)) {
                $user_item = $get_user_item;
            }
            if (!empty($session_user_search_word)) {
                foreach ($get_user_item as $item) {
                    $judge_num1 = 0;

                    if (preg_match( '{'.$session_user_search_word.'}', $item->user_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_user_search_word.'}', $item->user_phone )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_user_search_word.'}', $item->user_name )) {$judge_num1 = 1;}

                    if ($judge_num1 == 1) {
                        array_push($user_item, $item);
                    }
                }
            }
        } else {
            $user_item = $get_user_item;
        }

        //ページない５つ処理
        $page_num = 0;
        $item_10 = [];
        $count_10 = 0;
        foreach ($user_item as $item_one) {
            //初めのページ
            if (!isset($request->page)) {
                if ($count_10 < 10) {
                array_push($item_10, $item_one);
                }
            }

            //2ページ目以降
            if (isset($request->page)) {
                $page_plus_10_down = ($request->page * 10) - 10;
                $page_plus_10_up = ($request->page * 10) - 1;
                if ($count_10 >= $page_plus_10_down && $count_10 <= $page_plus_10_up) {
                array_push($item_10, $item_one);
                }
            }
            $count_10++;
        }

        //ページネーション
        $pege_10_count = count($user_item) / 10;
        $pege_10_count = floor ( $pege_10_count + 0.99) ;

        if (isset($request->page)) {
        $prev = $request->page - 1;
        $next = $request->page + 1;
        } 
        if (!isset($request->page) && $pege_10_count !== 1) {
        $prev = 0;
        $next = 2;
        }
        if (!isset($request->page) && $pege_10_count == 1) {
        $prev = 0;
        $next = 0;
        }
        if ($pege_10_count == $request->page) {
        $next = 0;
        } 

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'user_item'=>$item_10,
            'prev'=>$prev,
            'next'=>$next,
        ];

        return view(Config::get('const.title.title49').".user_account", $send_param);
    }

    //運営者ユーザーページ (ユーザー情報検索&削除)
    public function administrator_user_account_search(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        if (isset($request->search_word_submit)) {
            //sessionに検索ワード挿入
            session()->put('user_search_word', $request->search_word);
        }

        $msgs="";
        if (isset($request->submit_d)) {
            $item_user = DB::table('influs')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->first();
            $today = date("Y-m-d-H:i:s");
            $param=[
                'delete_flag'=>'1',
            ];
            DB::table('apply_contacts')
            ->where('user_id', $item_user->user_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('message')
            ->where('user_id', $item_user->user_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('message_room')
            ->where('user_id', $item_user->user_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('influs')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="削除しました";
        }

        return redirect(Config::get('const.title.title49').'/user_account')->with('msgs',$msgs);
    }


    ///////ユーザー情報詳細
    public function administrator_user_account_detail($id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('issue_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');
        $user_item=DB::table('influs')->where('delete_flag','0')->where('id',$id)->first();
        if (empty($user_item)) {
            $msgs="ユーザーが存在しません";
            return redirect(Config::get('const.title.title49').'/user_account')->with('msgs',$msgs);
        }
        $item_list = Influ::desired_lists_db_get($user_item);

        //アカウント情報加工
        //生年月日分割
        if (empty($user_item->user_birth)) {
            $msgs="不正なユーザーです。";
            return redirect(Config::get('const.title.title49').'/user_account')->with('msgs',$msgs);
        }
        $birth = explode("-", $user_item->user_birth);
        $birth_y = $birth[0]; $birth_m = $birth[1]; $birth_d = $birth[2];
        if (empty($user_item->user_address)) {
            $msgs="不正なユーザーです。";
            return redirect(Config::get('const.title.title49').'/user_account')->with('msgs',$msgs);
        }
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

        $new_messages = Manager::new_messages_alert();

        $send_param=[
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
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

        return view(Config::get('const.title.title49')."/user_account_detail", $send_param);
    }

    
    ///////ユーザー情報詳細_post/////////////
    public function administrator_user_account_detail_post(Request $request,$id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
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




    ////////////////////
    //運営者企業ページ (企業情報検索)////////////////////
    public function administrator_company_account(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('issue_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');

        //全企業取得
        $shop_item = [];
        $get_shop_item=DB::table('insyokus')->where('delete_flag','0')->where('shop_flag','2')->select('id','shop_id','shop_phone','shop_name',)->get();

        if (session()->has('shop_search_word')){
            $session_shop_search_word= session()->get('shop_search_word');
            //全悟空白
            $session_shop_search_word = trim($session_shop_search_word);
            if (empty($session_shop_search_word)) {
                $shop_item = $get_shop_item;
            }
            if (!empty($session_shop_search_word)) {
                foreach ($get_shop_item as $item) {
                    $judge_num1 = 0;

                    if (preg_match( '{'.$session_shop_search_word.'}', $item->shop_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_shop_search_word.'}', $item->shop_phone )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_shop_search_word.'}', $item->shop_name )) {$judge_num1 = 1;}

                    if ($judge_num1 == 1) {
                        array_push($shop_item, $item);
                    }
                }
            }
        } else {
            $shop_item = $get_shop_item;
        }

        //ページない５つ処理
        $page_num = 0;
        $item_10 = [];
        $count_10 = 0;
        foreach ($shop_item as $item_one) {
            //初めのページ
            if (!isset($request->page)) {
                if ($count_10 < 10) {
                array_push($item_10, $item_one);
                }
            }

            //2ページ目以降
            if (isset($request->page)) {
                $page_plus_10_down = ($request->page * 10) - 10;
                $page_plus_10_up = ($request->page * 10) - 1;
                if ($count_10 >= $page_plus_10_down && $count_10 <= $page_plus_10_up) {
                array_push($item_10, $item_one);
                }
            }
            $count_10++;
        }

        //ページネーション
        $pege_10_count = count($shop_item) / 10;
        $pege_10_count = floor ( $pege_10_count + 0.99) ;

        if (isset($request->page)) {
        $prev = $request->page - 1;
        $next = $request->page + 1;
        } 
        if (!isset($request->page) && $pege_10_count !== 1) {
        $prev = 0;
        $next = 2;
        }
        if (!isset($request->page) && $pege_10_count == 1) {
        $prev = 0;
        $next = 0;
        }
        if ($pege_10_count == $request->page) {
        $next = 0;
        } 

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'shop_item'=>$item_10,
            'prev'=>$prev,
            'next'=>$next,
        ];

        return view(Config::get('const.title.title49').".company_account", $send_param);
    }

    //運営者企業ページ (企業情報検索&削除&メッセージ)
    public function administrator_company_account_search(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        if (isset($request->search_word_submit)) {
            //sessionに検索ワード挿入
            session()->put('shop_search_word', $request->search_word);
        }

        $msgs="";
        if (isset($request->submit_msg)) {
            $today = date("Y-m-d-H:i:s");

            if (empty($request->shop_number_id) || empty($request->shop_id)) {
                $msgs="不正な企業です。";
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
                    return redirect(Config::get('const.title.title49').'/company_account')->with('msgs',$msgs);
                } else {
                    return redirect(Config::get('const.title.title49').'/message/'.$meg_room_id->id)->with('msgs',$msgs);
                }
            }

        }

        if (isset($request->submit_d)) {
            $item_company = DB::table('insyokus')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->first();
            $today = date("Y-m-d-H:i:s");
            $param=[
                'delete_flag'=>'1',
            ];
            DB::table('apply_contacts')
            ->where('shop_id', $item_company->shop_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('message')
            ->where('shop_id', $item_company->shop_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('message_room')
            ->where('shop_id', $item_company->shop_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('matters')
            ->where('shop_id', $item_company->shop_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('insyokus')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="削除しました";
        }

        return redirect(Config::get('const.title.title49').'/company_account')->with('msgs',$msgs);
    }

    ///////企業情報詳細
    public function administrator_company_account_detail($id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('issue_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');
        $shop_item=DB::table('insyokus')->where('delete_flag','0')->where('id',$id)->first();

        if (empty($shop_item)) {
            $msgs="企業が存在しません";
            return redirect(Config::get('const.title.title49').'/company_account')->with('msgs',$msgs);
        }

        //アカウント情報加工
        //生年月日分割
        if (empty($shop_item->year_of_establishment)) {
            $msgs="不正な企業です。";
            return redirect(Config::get('const.title.title49').'/company_account')->with('msgs',$msgs);
        }
        $birth = explode("-", $shop_item->year_of_establishment);
        $birth_y = $birth[0]; $birth_m = $birth[1]; $birth_d = $birth[2];

        if (empty($shop_item->shop_address)) {
            $msgs="不正な企業です。";
            return redirect(Config::get('const.title.title49').'/company_account')->with('msgs',$msgs);
        }

        $data = Insyoku::edit_get_same($shop_item);
        $company_rate_list = Influ::company_rate_list($shop_item);

        //住所分割
        $shop_address = explode("=", $shop_item->shop_address);
        if (empty($shop_address[3])) {
            $shop_address[3] = "";
        }

        //list
        $interview_list=Config::get('form_list.interview');
        $qualifications_held_list=Config::get('form_list.qualifications_held');//保有資格
        $industry_list=Config::get('form_list.industry');//業界
        $industry_kind_list=Config::get('form_list.industry_kind');//業種

        $new_messages = Manager::new_messages_alert();

        $send_param=[
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'shop_address1'=>$shop_address[0],
            'shop_address2'=>$shop_address[1],
            'shop_address3'=>$shop_address[2],
            'shop_address4'=>$shop_address[3],
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
            'company_item'=>$shop_item,
        ];

        return view(Config::get('const.title.title49')."/company_account_detail", $send_param);
    }

    ///////企業情報詳細_post
    public function administrator_company_account_detail_post(Request $request,$id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        $shop_item=DB::table('insyokus')->where('delete_flag','0')->where('id',$id)->first();

        $target_path = 'biography_works_files/';


        // ボタン区別
    }




    ////////////////////案件
    //運営者案件ページ (案件情報検索)////////////////////
    public function administrator_all_issue(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');

        //全案件取得
        $issue_item = [];
        $get_issue_item1=DB::table('matters')->where('delete_flag','0')->where('flag','0')->select('id','shop_id','shop_name','matter_name','flag','shop_number_id')->orderBy('updated_at', 'asc')->get();
        $get_issue_item2=DB::table('matters')->where('delete_flag','0')->where('flag', '<>', '0')->select('id','shop_id','shop_name','matter_name','flag','shop_number_id')->get();

        $get_issue_item = [];
        if (!empty($get_issue_item1)) {
            foreach ($get_issue_item1 as $i_item1) {
                array_push($get_issue_item, $i_item1);
                // var_dump($i_item);
            }
        }
        if (!empty($get_issue_item2)) {
            foreach ($get_issue_item2 as $i_item2) {
                array_push($get_issue_item, $i_item2);
                // var_dump($i_item);
            }
        }
        // var_dump($get_issue_item);

        if (session()->has('issue_search_word')){
            $session_issue_search_word= session()->get('issue_search_word');
            //全悟空白
            $session_issue_search_word = trim($session_issue_search_word);
            if (empty($session_issue_search_word)) {
                $issue_item = $get_issue_item;
            }
            if (!empty($session_issue_search_word)) {
                foreach ($get_issue_item as $item) {
                    $judge_num1 = 0;

                    if (preg_match( '{'.$session_issue_search_word.'}', $item->matter_name )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_issue_search_word.'}', $item->shop_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_issue_search_word.'}', $item->shop_name )) {$judge_num1 = 1;}

                    if ($judge_num1 == 1) {
                        array_push($issue_item, $item);
                    }
                }
            }
        } else {
            $issue_item = $get_issue_item;
        }

        //ページない５つ処理
        $page_num = 0;
        $item_10 = [];
        $count_10 = 0;
        foreach ($issue_item as $item_one) {
            //初めのページ
            if (!isset($request->page)) {
                if ($count_10 < 10) {
                array_push($item_10, $item_one);
                }
            }

            //2ページ目以降
            if (isset($request->page)) {
                $page_plus_10_down = ($request->page * 10) - 10;
                $page_plus_10_up = ($request->page * 10) - 1;
                if ($count_10 >= $page_plus_10_down && $count_10 <= $page_plus_10_up) {
                array_push($item_10, $item_one);
                }
            }
            $count_10++;
        }

        //ページネーション
        $pege_10_count = count($issue_item) / 10;
        $pege_10_count = floor ( $pege_10_count + 0.99) ;

        if (isset($request->page)) {
        $prev = $request->page - 1;
        $next = $request->page + 1;
        } 
        if (!isset($request->page) && $pege_10_count !== 1) {
        $prev = 0;
        $next = 2;
        }
        if (!isset($request->page) && $pege_10_count == 1) {
        $prev = 0;
        $next = 0;
        }
        if ($pege_10_count == $request->page) {
        $next = 0;
        } 

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'issue_item'=>$item_10,
            'prev'=>$prev,
            'next'=>$next,
        ];

        return view(Config::get('const.title.title49').".all_issue", $send_param);
    }

    //運営者案件ページ (案件情報検索&削除&許可+案件新規投稿match_mail)
    public function administrator_issue_search(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        if (isset($request->search_word_submit)) {
            //sessionに検索ワード挿入
            session()->put('issue_search_word', $request->search_word);
        }

        $msgs="";
        if (isset($request->submit_d)) {
            $today = date("Y-m-d-H:i:s");
            $param_d=[
                'delete_flag'=>'1',
                'updated_at'=>$today,
            ];
            $param=[
                'delete_flag'=>'1',
            ];
            DB::table('matters')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param_d);
            DB::table('apply_contacts')
            ->where('issue_id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="削除しました";
        }
        //kyoka
        if (isset($request->submit_p)) {
            $today = date("Y-m-d-H:i:s");
            $param=[
                'flag'=>'1',
                'first_match_mail_flag'=>'1',
                'updated_at'=>$today,
            ];

            $issue_item = DB::table('matters')->where('delete_flag','0')->where('id',$request->permission_num)->first();

            ///////////マッチメール
            if ($issue_item->first_match_mail_flag == null) {
                $users_item = DB::table('influs')->where('delete_flag','0')->Where('desired_position1', '<>', NULL)->orWhere('desired_skill1', '<>', NULL)->orWhere('desired_industry1', '<>', NULL)->get();

                $lists = Influ::matching_list_get();
                $todouhuken_list=Config::get('list.todouhuken');
                $issue_todouhuken = "";
                foreach ($todouhuken_list as $key=>$value) {
                    if($key == $issue_item->todouhuken) {
                        $issue_todouhuken = $value;
                    }
                }

                var_dump(count($users_item));
                foreach ($users_item as $u_item) {
                    $match_position = [];
                    $match_skill = [];
                    $match_industry = [];
                    var_dump($u_item->user_id);
                    
                    //都道府県のマッチが前提
                    $user_address = explode("=", $u_item->user_address);
                    $user_address1 = $user_address[0];

                    if ($user_address1 == $issue_todouhuken) {

                        ///positionマッチ
                        for ($i = 1;$i <= 3;$i++) {
                            $issue_match_name = "matching_position".$i;
                            if ($issue_item->$issue_match_name == $u_item->desired_position1) {
                                array_push($match_position,$u_item->desired_position1);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_position2) {
                                array_push($match_position,$u_item->desired_position2);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_position3) {
                                array_push($match_position,$u_item->desired_position3);
                            }
                        }
                        // var_dump($match_position);
                        
                        ///positionマッチ
                        for ($i = 1;$i <= 7;$i++) {
                            $issue_match_name = "matching_skill".$i;
                            if ($issue_item->$issue_match_name == $u_item->desired_skill1) {
                                array_push($match_skill,$u_item->desired_skill1);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_skill2) {
                                array_push($match_skill,$u_item->desired_skill2);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_skill3) {
                                array_push($match_skill,$u_item->desired_skill3);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_skill4) {
                                array_push($match_skill,$u_item->desired_skill4);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_skill5) {
                                array_push($match_skill,$u_item->desired_skill5);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_skill6) {
                                array_push($match_skill,$u_item->desired_skill6);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_skill7) {
                                array_push($match_skill,$u_item->desired_skill7);
                            }
                        }
                        // var_dump($match_skill);
    
                        ///positionマッチ
                        for ($i = 1;$i <= 3;$i++) {
                            $issue_match_name = "matching_industry".$i;
                            if ($issue_item->$issue_match_name == $u_item->desired_industry1) {
                                array_push($match_industry,$u_item->desired_industry1);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_industry2) {
                                array_push($match_industry,$u_item->desired_industry2);
                            } elseif ($issue_item->$issue_match_name == $u_item->desired_industry3) {
                                array_push($match_industry,$u_item->desired_industry3);
                            }
                        }
                        // var_dump($match_industry);
    
                        if (count($match_position) !== 0 || count($match_skill) !== 0 ||count($match_industry) !== 0) {
                            // メール
                            $mail_param_isuue=[
                                'form_name'=>$issue_item->shop_name,
                                'issue_name'=>$issue_item->matter_name,
                                'issue_number'=>$issue_item->id,
                                'shop_number_id'=>$issue_item->shop_number_id,
                                'match_position'=>$match_position,
                                'match_skill'=>$match_skill,
                                'match_industry'=>$match_industry,
                                'lists'=>$lists,
                            ];
                            $email = $u_item->user_mail;

                            Mail::to($email)->send(new IssueMatchMail($mail_param_isuue));
                        }

                    }
                    
                }


            }


            DB::table('matters')
            ->where('id', $request->permission_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="許可しました";

            $mail_param=[
                'form_name'=>$issue_item->shop_name,
                'issue_name'=>$issue_item->matter_name,
            ];
            $email = $issue_item->shop_id;

            // メール
            Mail::to($email)->send(new IssuePermissionMail($mail_param));

            $msgs="案件の掲載許可を出しました。";
        }

        return redirect(Config::get('const.title.title49').'/all_issue')->with('msgs',$msgs);
    }


    ///////案件情報詳細
    public function administrator_issue_detail($id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('shop_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');
        $issue_item=DB::table('matters')->where('delete_flag','0')->where('id',$id)->first();

        if (empty($issue_item)) {
            $msgs="案件が存在しません";
            return redirect(Config::get('const.title.title49').'/all_issue')->with('msgs',$msgs);
        }

        //マッチング情報が一つもなければ不正
        if (empty($issue_item->matching_position1)) {
            $msgs="不正な案件です。";
            return redirect(Config::get('const.title.title49').'/all_issue')->with('msgs',$msgs);
        }
        if (empty($issue_item->matching_skill1)) {
            $msgs="不正な案件です。";
            return redirect(Config::get('const.title.title49').'/all_issue')->with('msgs',$msgs);
        }
        if (empty($issue_item->matching_industry1)) {
            $msgs="不正な案件です。";
            return redirect(Config::get('const.title.title49').'/all_issue')->with('msgs',$msgs);
        }

        //list
        $contract_form_list=Config::get('form_list.contract_form');
        $dress_list=Config::get('form_list.dress');
        $todouhuken_list=Config::get('list.todouhuken');
        $lists = Influ::matching_list_get();
        $m_lists = Insyoku::one_matching_skill_lists_db_get($issue_item);

        $new_messages = Manager::new_messages_alert();

        $send_param=[
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'contract_form_list'=>$contract_form_list,
            'dress_list'=>$dress_list,
            'todouhuken_list'=>$todouhuken_list,
            'matching_position'=>$m_lists[0],
            'matching_skill'=>$m_lists[1],
            'matching_industry'=>$m_lists[2],
            'matching_technology_prosess_sonota'=>$m_lists[3],
            'lists'=>$lists,
            'issue_item'=>$issue_item,
        ];

        return view(Config::get('const.title.title49')."/issue_detail", $send_param);
    }

    ///////案件情報詳細_post
    public function administrator_issue_detail_post(Request $request,$id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        $shop_item=DB::table('matters')->where('delete_flag','0')->where('id',$id)->first();

        $target_path = 'biography_works_files/';
        // ボタン区別
    }




    ////////////////////契約(contacts)
    //運営者契約(contacts)ページ (契約(contacts)情報検索)////////////////////
    public function administrator_all_contacts(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('shop_search_word');
        session()->forget('issue_search_word');
        $session_manager_name = session()->get('manager_name');

        //全契約(contacts)取得
        $contacts_item = [];
        $get_contacts_item=DB::table('contacts')->where('delete_flag','0')->select('id','shop_id','issue_id','shop_name','contacts_id','operation_start_at','shop_number_id','payment_judge','user_judge','contract_expiration_3month','payment_term')->orderBy('contacts_id', 'desc')->get();

        if (session()->has('contacts_search_word')){
            $session_contacts_search_word= session()->get('contacts_search_word');
            //全悟空白
            $session_contacts_search_word = trim($session_contacts_search_word);
            if (empty($session_contacts_search_word)) {
                $contacts_item = $get_contacts_item;
            }
            if (!empty($session_contacts_search_word)) {
                foreach ($get_contacts_item as $item) {
                    $judge_num1 = 0;

                    if (preg_match( '{'.$session_contacts_search_word.'}', $item->contacts_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_contacts_search_word.'}', $item->shop_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_contacts_search_word.'}', $item->shop_name )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_contacts_search_word.'}', $item->issue_id )) {$judge_num1 = 1;}

                    if ($judge_num1 == 1) {
                        array_push($contacts_item, $item);
                    }
                }
            }
        } else {
            $contacts_item = $get_contacts_item;
        }


        //契約select_submit
        if (session()->has('contacts_select_submit')) {
            $contacts_select_submit = session()->get('contacts_select_submit');

            $select_submit_data=[];
            if (!empty($contacts_select_submit)) {
                foreach ($contacts_item as $select_item) {
                    $three_month_Date = new DateTime(date("{$select_item->contract_expiration_3month}"));

                    $todayDate = new DateTime(date("Y-m-d"));
                    $intvl = $three_month_Date->diff($todayDate);

                    if ($contacts_select_submit == "2") {
                        //満了三日以内
                        if ($three_month_Date > $todayDate){
                            //3monthがtodayより未来
                            if ($intvl->days <= 3 && $intvl->days >= 1) {
                                //三日以内当日の前日以内
                                array_push($select_submit_data, $select_item);
                            }
                        }
                    }
                    if ($contacts_select_submit == "3") {
                        //契約満了：未払：未人材確認
                        if ($three_month_Date <= $todayDate){
                            //3monthが今日を含む過去
                            if ($select_item->payment_judge == null && $select_item->user_judge == '0') {
                                //未払い：未人材確認
                                array_push($select_submit_data, $select_item);
                            }
                        }
                    }
                    if ($contacts_select_submit == "4") {
                        //人材非稼働
                        if ($three_month_Date <= $todayDate){
                            //3monthが今日を含む過去
                            if ($select_item->payment_judge == null && $select_item->user_judge == '1') {
                                //人材非稼働
                                array_push($select_submit_data, $select_item);
                            }
                        }
                    }
                    if ($contacts_select_submit == "5") {
                        //人材稼働確認：未払い
                        if ($three_month_Date <= $todayDate){
                            //3monthが今日を含む過去
                            if ($select_item->payment_judge == null && $select_item->user_judge == '2') {
                                //人材稼働確認：未払い
                                array_push($select_submit_data, $select_item);
                            }
                        }
                    }
                    if ($contacts_select_submit == "6") {
                        if ($three_month_Date <= $todayDate){
                            //3monthが今日を含む過去
                            if ($select_item->payment_judge == '1' && $select_item->user_judge == '2') {
                                //支払完了
                                array_push($select_submit_data, $select_item);
                            }
                        }
                    }
                    $contacts_item = $select_submit_data;
                }
            } 
        }

        //ページない５つ処理////////////////////////////////////////////////
        $page_num = 0;
        $item_10 = [];
        $count_10 = 0;
        foreach ($contacts_item as $item_one) {
            //初めのページ
            if (!isset($request->page)) {
                if ($count_10 < 10) {
                array_push($item_10, $item_one);
                }
            }

            //2ページ目以降
            if (isset($request->page)) {
                $page_plus_10_down = ($request->page * 10) - 10;
                $page_plus_10_up = ($request->page * 10) - 1;
                if ($count_10 >= $page_plus_10_down && $count_10 <= $page_plus_10_up) {
                array_push($item_10, $item_one);
                }
            }
            $count_10++;
        }

        //ページネーション
        $pege_10_count = count($contacts_item) / 10;
        $pege_10_count = floor ( $pege_10_count + 0.99) ;

        if (isset($request->page)) {
        $prev = $request->page - 1;
        $next = $request->page + 1;
        } 
        if (!isset($request->page) && $pege_10_count !== 1) {
        $prev = 0;
        $next = 2;
        }
        if (!isset($request->page) && $pege_10_count == 1) {
        $prev = 0;
        $next = 0;
        }
        if ($pege_10_count == $request->page) {
        $next = 0;
        } 

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'contacts_item'=>$item_10,
            'prev'=>$prev,
            'next'=>$next,
        ];

        return view(Config::get('const.title.title49').".all_contacts", $send_param);
    }

    //運営者契約(contacts)ページ (契約(contacts)情報検索&削除)
    public function administrator_contacts_search(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        if (isset($request->search_word_submit)) {
            //sessionに検索ワード挿入
            session()->put('contacts_search_word', $request->search_word);
        }

        if (isset($request->set_session_1)) {
            //sessionに検索ワード挿入
            session()->put('contacts_select_submit', "");
            session()->put('contacts_search_word', "");
        }
        if (isset($request->set_session_2)) {
            //sessionに検索ワード挿入
            session()->put('contacts_select_submit', "2");
        }
        if (isset($request->set_session_3)) {
            //sessionに検索ワード挿入
            session()->put('contacts_select_submit', "3");
        }
        if (isset($request->set_session_4)) {
            //sessionに検索ワード挿入
            session()->put('contacts_select_submit', "4");
        }
        if (isset($request->set_session_5)) {
            //sessionに検索ワード挿入
            session()->put('contacts_select_submit', "5");
        }
        if (isset($request->set_session_6)) {
            //sessionに検索ワード挿入
            session()->put('contacts_select_submit', "6");
        }

        $msgs="";
        if (isset($request->submit_d)) {
            $today = date("Y-m-d-H:i:s");
            $param=[
                'delete_flag'=>'1',
                'updated_at'=>$today,
            ];
            DB::table('contacts')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="削除しました";
        }

        return redirect(Config::get('const.title.title49').'/all_contacts')->with('msgs',$msgs);
    }


    ///////契約(contacts)情報詳細
    public function administrator_contacts_detail($id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('shop_search_word');
        session()->forget('issue_search_word');
        $session_manager_name = session()->get('manager_name');
        $contacts_item=DB::table('contacts')->where('delete_flag','0')->where('id',$id)->first();

        if (empty($contacts_item)) {
            $msgs="契約が存在しません";
            return redirect(Config::get('const.title.title49').'/all_contacts')->with('msgs',$msgs);
        }

        //マッチング情報が一つもなければ不正
        if (empty($contacts_item->contacts_id)) {
            $msgs="不正な契約です。";
            return redirect(Config::get('const.title.title49').'/all_contacts')->with('msgs',$msgs);
        }

        if (empty($contacts_item->contract_users_id)) {
            $msgs="不正な契約です。";
            return redirect(Config::get('const.title.title49').'/all_contacts')->with('msgs',$msgs);
        }


        //エクスプロード削除 配列ではなく単体で、user取得

        $user_info_item=DB::table('influs')->where('delete_flag','0')->where('user_id',$contacts_item->contract_users_id)->first();  
        if (empty($user_info_item)) {
            $msgs="不正な契約です。";
            return redirect(Config::get('const.title.title49').'/all_contacts')->with('msgs',$msgs);
        }

        if(empty($user_info_item)) {
            $msgs="不正な契約です。";
            return redirect(Config::get('const.title.title49').'/all_contacts')->with('msgs',$msgs);
        }

        $new_messages = Manager::new_messages_alert();

        $send_param=[
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'contacts_item'=>$contacts_item,
            'user_item'=>$user_info_item,
        ];

        return view(Config::get('const.title.title49')."/contacts_detail", $send_param);
    }

    ///////契約(contacts)情報詳細_post
    public function administrator_contacts_detail_post(Request $request,$id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        $shop_item=DB::table('contacts')->where('delete_flag','0')->where('id',$id)->first();

        $target_path = 'biography_works_files/';
        // ボタン区別
    }




    ////////////////////契約(payment)
    //運営者契約(payment)ページ (契約(payment)情報検索)////////////////////
    public function administrator_all_payment(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('shop_search_word');
        session()->forget('issue_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');

        //全契約(payment)取得
        $payment_item = [];
        $get_payment_item=DB::table('payment_information')->where('delete_flag','0')->orderBy('contacts_id', 'desc')->get();

        if (session()->has('payment_search_word')){
            $session_payment_search_word= session()->get('payment_search_word');
            //全悟空白
            $session_payment_search_word = trim($session_payment_search_word);
            if (empty($session_payment_search_word)) {
                $payment_item = $get_payment_item;
            }
            if (!empty($session_payment_search_word)) {
                foreach ($get_payment_item as $item) {
                    $judge_num1 = 0;

                    if (preg_match( '{'.$session_payment_search_word.'}', $item->contacts_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_payment_search_word.'}', $item->shop_id )) {$judge_num1 = 1;}
                    elseif (preg_match( '{'.$session_payment_search_word.'}', $item->shop_name )) {$judge_num1 = 1;}

                    if ($judge_num1 == 1) {
                        array_push($payment_item, $item);
                    }
                }
            }
        } else {
            $payment_item = $get_payment_item;
        }


        //契約select_submit
        if (session()->has('payment_select_submit')) {
            $payment_select_submit = session()->get('payment_select_submit');

            $select_submit_data=[];
            if (!empty($payment_select_submit)) {
                foreach ($payment_item as $select_item) {
                    $three_month_Date = new DateTime(date("{$select_item->payment_term}"));

                    $todayDate = new DateTime(date("Y-m-d"));
                    $intvl = $three_month_Date->diff($todayDate);

                    if ($payment_select_submit == "1") {
                        //未払い
                        if ($select_item->payment_judge == null) {
                            array_push($select_submit_data, $select_item);
                        }
                    }
                    if ($payment_select_submit == "2") {
                        if ($select_item->payment_judge == '1') {
                            //支払完了
                            array_push($select_submit_data, $select_item);
                        }
                    }
                    $payment_item = $select_submit_data;
                }
            } 
        }

        //ページない５つ処理////////////////////////////////////////////////
        $page_num = 0;
        $item_10 = [];
        $count_10 = 0;
        foreach ($payment_item as $item_one) {
            //初めのページ
            if (!isset($request->page)) {
                if ($count_10 < 10) {
                array_push($item_10, $item_one);
                }
            }

            //2ページ目以降
            if (isset($request->page)) {
                $page_plus_10_down = ($request->page * 10) - 10;
                $page_plus_10_up = ($request->page * 10) - 1;
                if ($count_10 >= $page_plus_10_down && $count_10 <= $page_plus_10_up) {
                array_push($item_10, $item_one);
                }
            }
            $count_10++;
        }

        //ページネーション
        $pege_10_count = count($payment_item) / 10;
        $pege_10_count = floor ( $pege_10_count + 0.99) ;

        if (isset($request->page)) {
        $prev = $request->page - 1;
        $next = $request->page + 1;
        } 
        if (!isset($request->page) && $pege_10_count !== 1) {
        $prev = 0;
        $next = 2;
        }
        if (!isset($request->page) && $pege_10_count == 1) {
        $prev = 0;
        $next = 0;
        }
        if ($pege_10_count == $request->page) {
        $next = 0;
        } 

        $new_messages = Manager::new_messages_alert();

        $send_param = [
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'payment_item'=>$item_10,
            'prev'=>$prev,
            'next'=>$next,
        ];

        return view(Config::get('const.title.title49').".all_payment", $send_param);
    }

    //運営者契約(payment)ページ (契約(payment)情報検索&削除)
    public function administrator_payment_search(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        if (isset($request->search_word_submit)) {
            //sessionに検索ワード挿入
            session()->put('payment_search_word', $request->search_word);
        }

        if (isset($request->set_session_1)) {
            //sessionに検索ワード挿入
            session()->put('payment_select_submit', "");
            session()->put('payment_search_word', "");
        }
        if (isset($request->set_session_2)) {
            //sessionに検索ワード挿入
            session()->put('payment_select_submit', "1");
        }
        if (isset($request->set_session_3)) {
            //sessionに検索ワード挿入
            session()->put('payment_select_submit', "2");
        }

        $msgs="";
        if (isset($request->submit_d)) {
            $today = date("Y-m-d-H:i:s");
            $param=[
                'delete_flag'=>'1',
                'updated_at'=>$today,
            ];
            DB::table('payment_information')
            ->where('id', $request->delete_num)
            ->where('delete_flag','0')
            ->update($param);
            $msgs="削除しました";
        }

        return redirect(Config::get('const.title.title49').'/all_payment')->with('msgs',$msgs);
    }


    ///////支払情報(payment)情報詳細
    public function administrator_payment_detail($id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        session()->forget('user_search_word');
        session()->forget('shop_search_word');
        session()->forget('issue_search_word');
        session()->forget('contacts_search_word');
        $session_manager_name = session()->get('manager_name');
        $payment_item=DB::table('payment_information')->where('delete_flag','0')->where('id',$id)->first();

        if (empty($payment_item)) {
            $msgs="支払情報が存在しません";
            return redirect(Config::get('const.title.title49').'/all_payment')->with('msgs',$msgs);
        }

        //マッチング情報が一つもなければ不正
        if (empty($payment_item->contacts_id)) {
            $msgs="不正な支払情報です。";
            return redirect(Config::get('const.title.title49').'/all_payment')->with('msgs',$msgs);
        }

        $new_messages = Manager::new_messages_alert();

        $send_param=[
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'payment_item'=>$payment_item,
        ];

        return view(Config::get('const.title.title49')."/payment_detail", $send_param);
    }

    ///////契約(payment)情報詳細_post
    public function administrator_payment_detail_post(Request $request,$id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        $shop_item=DB::table('contacts')->where('delete_flag','0')->where('id',$id)->first();

        $target_path = 'biography_works_files/';
        // ボタン区別
    }

    ///////管理者メッセージ一覧(company)
    public function administrator_messages(){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        $session_manager_name = session()->get('manager_name');

        //room
        $room_data = DB::table('mg_message_room')->where('delete_flag','0')->orderBy('update_at', 'desc')->get();
        //roomのcompanyを配列
        $room_company = [];
        $room_id = [];
        $room_comments = [];
        $room_midoku_comments = [];
        if (isset($room_data)) {
            foreach ($room_data as $room_one) {
                $room_company_one = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$room_one->shop_id)->select("id","shop_id","shop_name","client_image")->first();
                array_push($room_company, $room_company_one);
                array_push($room_id, $room_one->id);
                // /roomのコメント数
                $room_comment = DB::table('mg_message')->where('delete_flag','0')->where('room_id',$room_one->id)->get();
                if (!empty($room_comment)) {
                    array_push($room_comments, $room_comment);
                    //未読の数
                    $room_midoku_comment=[];
                    foreach ($room_comment as $midoku_comment) {
                        if ($midoku_comment->show_flag == 0 && $midoku_comment->destination_mg == 'administrator') {
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
            // var_dump($room_company);
        } else {
            $room_data = [];
        }


        $new_messages = Manager::new_messages_alert();

        $send_param=[
            'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'room_data'=>$room_data,
            'room_company'=>$room_company,
            'room_id'=>$room_id,
            'room_comments'=>$room_comments,
            'room_midoku_comments'=>$room_midoku_comments,
        ];

        return view(Config::get('const.title.title49')."/messages_all", $send_param);
    }

    ///////管理者メッセージroom(company)
    public function administrator_message_room($id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        $session_manager_name = session()->get('manager_name');

        $room_data = DB::table('mg_message_room')->where('delete_flag','0')->where('id',$id)->first();
        if (empty($room_data)) {
            //自分のルームじゃない場合
            return redirect(Config::get('const.title.title49').'/messages');
        }
        $shop_data = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$room_data->shop_id)->select("id","shop_id","shop_name","client_image")->first();

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

        DB::table('mg_message')->where('delete_flag','0')->where('room_id', $id)->where('destination_mg', 'administrator')->update($param);

        $send_param=[
            // 'new_messages'=>$new_messages,
            'manager_name'=>$session_manager_name,
            'room_data'=>$room_data,
            'shop_data'=>$shop_data,
            'room_comments'=>$room_comments,
        ];

        return view(Config::get('const.title.title49')."/message_talk_room", $send_param);
    }

    //メッセージroom_post
    public function administrator_message_post(Request $request,$id){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }
        $session_manager_name = session()->get('manager_name');

        $today = date("Y年m月d日 H:i");
        $day_time = date("H:i");
        $today_time = date("Y-m-d H:i:s");

        if (isset($request->post_message)) {

            $param=[
                'room_id'=>$id,
                'mg_flag'=>'1',
                'comment'=>$request->message_post_textarea,
                'destination_shop_id'=>$request->shop_id,
                'show_flag'=>"0",
                'day_time'=>$day_time,
                'delete_flag'=>'0',
                'created_at'=>$today,
            ];
            $param2=[
                'update_at'=>$today_time,
                'delete_flag'=>'0',
            ];
            DB::table('mg_message_room')->where('delete_flag','0')->where('id',$id)->update($param2);
            DB::table('mg_message')->insert($param);

            $mail_param=[
                'form_name'=>"longopmatch管理者",
                'send_client'=>"1",
            ];
            $email = $request->shop_id;
    
            // メール
            Mail::to($email)->send(new ClientMessageMail($mail_param));
        }

        return redirect(Config::get('const.title.title49').'/message/'.$id);
    }


    //パスワード・メールアドレス変更
    public function admin_account_edit(Request $request){
        if (!session()->has('manager_id')){
            return redirect(Config::get('const.title.title49'));
        }

        $manager_id=session()->get('manager_id');

        if ($request->has('password_submit')){

            $password=$request->password;
            $password2=$request->password2;

            if ($password===$password2){
                //暗号化
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                DB::table('managers')
                ->where('manager_id', $manager_id)
                ->where('delete_flag','0')
                ->update(['manager_pass'=>$password_hash]);

                $msgs="パスワードを変更しました。";
                return redirect(Config::get('const.title.title49').'/admin_account_edit')->with('msgs',$msgs);
            }elseif (strlen($password)<8){
                $msgs="パスワードには8文字以上を設定してください。";
                return redirect(Config::get('const.title.title49').'/admin_account_edit')->with('msgs',$msgs);
            }else{
                $msgs="確認用パスワードが異なります。";
                return redirect(Config::get('const.title.title49').'/admin_account_edit')->with('msgs',$msgs);
            }
        }elseif ($request->has('mail_submit')){
            DB::table('managers')
            ->where('manager_id', $manager_id)
            ->where('delete_flag','0')
            ->update(['manager_pass'=>$request->mail]);

            $msgs="メールアドレスを変更しました。";
            return redirect(Config::get('const.title.title49').'/admin_account_edit')->with('msgs',$msgs);
        }else{
            return redirect(Config::get('const.title.title49'));
        }
    }
}
