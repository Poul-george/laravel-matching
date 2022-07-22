<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator; 
use Illuminate\Pagination\Paginator;

use App\Models\Matter;
use App\Models\Influ;
use App\Models\Insyoku;
use App\Mail\IssueApplyMail;
use App\Mail\IssueApplyDefeatedMail;

use Illuminate\Support\Facades\Storage;

//案件関連controller

class IssueController extends Controller
{
     // /////////////////////////////////////////////////////////////////////////////////////////////
    //案件一覧表示
    public function my_all_issues_page(){
      $shop_id=session()->get("shop_id");
      if (!session()->has("shop_id")){
          return redirect(Config::get('const.title.title47'));
      }
      $new_messages = Insyoku::new_messages_alert($shop_id);

      $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
      $data = Insyoku::edit_get_same($item);
      $item2 = DB::table('matters')->where('delete_flag','0')
                  ->where('shop_id',$shop_id)->get();
      //list
      $lists = Insyoku::matching_list_get();
      //db_マッチングlist
      $m_lists = Insyoku::matching_skill_lists_db_get($item2);

      $send_param=[
          'shop_name'=>$data[4],
          'new_messages'=>$new_messages,
          'shop_image'=>$data[5],
          'matching_position'=>$m_lists[0],
          'matching_skill'=>$m_lists[1],
          'matching_industry'=>$m_lists[2],
          'lists'=>$lists,
      ];

      session()->forget('all_input_edit_session');
      return view(Config::get('const.title.title47')."/issues/my_all_issues", $send_param)->with('item2',$item2);
  }

  // /////////////////////////////////////////////////////////////////////////////////////////////
  //案件詳細表示
  public function my_issues_detail_page($id){
      $shop_id=session()->get("shop_id");
      if (!session()->has("shop_id")){
          return redirect(Config::get('const.title.title47'));
      }
      $new_messages = Insyoku::new_messages_alert($shop_id);

      $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
      $data = Insyoku::edit_get_same($item);
      $item2 = DB::table('matters')
                ->where('delete_flag','0')
                ->where('shop_id',$shop_id)
                ->where('id',$id)
                ->first();
      if (empty($item2)) {
          return redirect(Config::get('const.title.title47').'/'.'client_account/my_all_issues');
      }
      //list
      $lists = Insyoku::matching_list_get();
      $contract_form_list=Config::get('form_list.contract_form');
      $dress_list=Config::get('form_list.dress');
      $todouhuken_list=Config::get('list.todouhuken');
      //db_マッチングlist
      $m_lists = Insyoku::one_matching_skill_lists_db_get($item2);

      $send_param=[
          'shop_name'=>$data[4],
          'new_messages'=>$new_messages,
          'shop_image'=>$data[5],
          'contract_form_list'=>$contract_form_list,
          'dress_list'=>$dress_list,
          'todouhuken_list'=>$todouhuken_list,
          'matching_position'=>$m_lists[0],
          'matching_skill'=>$m_lists[1],
          'matching_industry'=>$m_lists[2],
          'matching_technology_prosess_sonota'=>$m_lists[3],
          'lists'=>$lists,
      ];
      session()->forget('all_input_edit_session');

      return view(Config::get('const.title.title47')."/issues/my_issues_detail", $send_param)->with('item2',$item2);
  }
  //案件詳細表示 削除処理
  public function my_issues_detail_delete(Request $request,$id){
      $shop_id=session()->get("shop_id");
      if (!session()->has("shop_id")){
          return redirect(Config::get('const.title.title47'));
      }

      if (isset($request->delete_sub)) {
          if ($request->issue_id == $id) {
            $today = date("Y-m-d-H:i:s");
            $param=[
                'delete_flag'=>'1',
                'updated_at'=>$today,
            ];

            $issue_item = DB::table('matters')
                ->where('delete_flag','0')
                ->where('id',$id)
                ->where('shop_id',$shop_id)
                ->where('flag','0')
                ->orWhere('flag','1')
                ->first();

            if (empty($issue_item)) {
                $msgs="案件が存在しません。";
                return redirect(Config::get('const.title.title47').'/'.'client_account/my_all_issues')->with('msgs',$msgs);
            }

            DB::table('matters')
            ->where('id', $id)
            ->where('shop_id',$shop_id)
            ->where('delete_flag','0')
            ->update($param);
            DB::table('apply_contacts')
            ->where('issue_id', $id)
            ->where('shop_id',$shop_id)
            ->where('delete_flag','0')
            ->update($param);

            $msgs="削除が完了しました。";
          } else {
            $msgs="エラーが発生しました。1";
          }
      } else {
          $msgs="エラーが発生しました。2";
      }


      return redirect(Config::get('const.title.title47').'/'.'client_account/my_all_issues')->with('msgs',$msgs);
  }

  // /////////////////////////////////////////////////////////////////////////////////////////////
  //案件関係
  //案件登録ページ表示
  public function create_issues_page(){
      $shop_id=session()->get("shop_id");
      if (!session()->has("shop_id")){
          return redirect(Config::get('const.title.title47'));
      }
      $new_messages = Insyoku::new_messages_alert($shop_id);

      $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
      //基本情報は全て入力していなかったら
      $item_judge = $item;
      $count = 0; $judge_count = 0;
      foreach ($item_judge as $judge) {
          if ($count <= 20) {
              if (isset($judge)) {
                  $judge_count++;
              }
          }
          $count++;
      }

  if ($judge_count < 21) {
      $msgs="基本情報の入力を完了させてください。";
      return redirect(Config::get('const.title.title47').'/'.'client_account/edit')->with('msgs',$msgs);
  }



      $data = Insyoku::edit_get_same($item);
      //list
      $contract_form_list=Config::get('form_list.contract_form');
      $dress_list=Config::get('form_list.dress');
      $todouhuken_list=Config::get('list.todouhuken');
      $lists = Insyoku::matching_list_get();
      $list_title = Insyoku::matching_list_title_get();
      //session
      if (!session()->has("all_input_session")){
          $session_test = "";
      } else {
          $session_test = session()->get('all_input_session');
      }

      $send_param=[
          'shop_name'=>$data[4],
          'new_messages'=>$new_messages,
          'shop_image'=>$data[5],
          'contract_form_list'=>$contract_form_list,
          'dress_list'=>$dress_list,
          'todouhuken_list'=>$todouhuken_list,
          'lists'=>$lists,
          'list_title'=>$list_title,
          'session_test'=>$session_test,
      ];

      return view(Config::get('const.title.title47')."/issues/create_issues", $send_param)->with('item',$item);
  }

  //案件登録ページデータ送信
  public function create_issues_page_post(Request $request){
      if (!session()->has('shop_id')){
          return redirect(Config::get('const.title.title47'));
      }

      //送信データをsessionに保持
      $test = $request->all();
      // var_dump($test);
      // echo "///////////////////////////////////////////////////////\n";


      //sessionほじ
      session()->put('all_input_session', $test);

      //確認ページへリダイレクト
      return redirect(Config::get('const.title.title47').'/'.'client_account/create_issues/confirmation');
  }

  //案件確認ページ表示
  public function create_issues_confirmation(){
      if (!session()->has('shop_id')){
          return redirect(Config::get('const.title.title47'));
      }

      //sessionデータを表示 input hiddenに挿入＋表示
      if (!session()->has("all_input_session")){
          return redirect(Config::get('const.title.title47').'/client_account');
      }
      $session_test = session()->get('all_input_session');
      // var_dump($session_test);
      $contract_form_list=Config::get('form_list.contract_form');
      $dress_list=Config::get('form_list.dress');
      $todouhuken_list=Config::get('list.todouhuken');
      $lists = Insyoku::matching_list_get();

      $send_param=[
          
          'contract_form_list'=>$contract_form_list,
          'dress_list'=>$dress_list,
          'todouhuken_list'=>$todouhuken_list,
          'lists'=>$lists,
      ];

      return view(Config::get('const.title.title47')."/issues/create_issues_confirmation", $send_param)->with('session_test',$session_test);
  }

  //案件確認ページデータpost
  public function create_issues_confirmation_post(Request $request){
      if (!session()->has('shop_id')){
          return redirect(Config::get('const.title.title47'));
      }
      if (!session()->has("all_input_session")){
          return redirect(Config::get('const.title.title47').'/client_account');
      }
      //戻るボタン
      if (isset($request->return_sub)) {
          return redirect(Config::get('const.title.title47').'/'.'client_account/create_issues');
      }
      
      //送信データを登録&運営側に確認
      if (isset($request->post_sub)) {
          $shop_id=session()->get("shop_id");
          $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
          $session_input = session()->get('all_input_session');
          $today = date("Y-m-d-H:i:s");

          //checkbox値の処理
          $matching_position = $session_input["create_issues_checkbox1"];
          for ($i = 1; $i <= 3 - count($session_input["create_issues_checkbox1"]);$i++) {
              array_push($matching_position, null);
          }
          
          //skill
          $matching_skill = $session_input["create_issues_checkbox2"];
          for ($i = 1; $i <= 7 - count($session_input["create_issues_checkbox2"]);$i++) {
              array_push($matching_skill, null);
          }
          
          //gyou
          $matching_industry = $session_input["create_issues_checkbox3"];
          for ($i = 1; $i <= 3 - count($session_input["create_issues_checkbox3"]);$i++) {
              array_push($matching_industry, null);
          }
          
          //tec.porosess,sonota
          $matching_technology = [];
          $matching_prosess = [];
          $matching_sonota = [];
          if (empty($session_input["create_issues_checkbox4"])) {
              //tech
              for ($i = 1; $i <= 3 ;$i++) {
                  array_push($matching_technology, null);
              }
              //poro
              for ($i = 1; $i <= 5 ;$i++) {
                  array_push($matching_prosess, null);
              }
              //sonota
              for ($i = 1; $i <= 20 ;$i++) {
                  array_push($matching_sonota, null);
              }
          } elseif (isset($session_input["create_issues_checkbox4"])) {
              foreach ($session_input["create_issues_checkbox4"] as $value) {
                  if (intval($value) <= 19) {
                      array_push($matching_technology, $value);
                  } elseif (intval($value) > 19 && intval($value) <= 34) {
                      array_push($matching_prosess, $value);
                  } elseif (intval($value) > 34 && intval($value) <= 85) {
                      array_push($matching_sonota, $value);
                  }
                  //tech
              }
              $matching_technology_count = $matching_technology;
              for ($i = 1; $i <= 3 - count($matching_technology_count);$i++) {
                  array_push($matching_technology, null);
              }
              //poro
              $matching_prosess_count = $matching_prosess;
              for ($i = 1; $i <= 5 - count($matching_prosess_count);$i++) {
                  array_push($matching_prosess, null);
              }
              //sonota
              $matching_sonota_count = $matching_sonota;
              for ($i = 1; $i <= 20 - count($matching_sonota_count);$i++) {
                  array_push($matching_sonota, null);
              }

          }

          $param=[
              'shop_number_id'=>$item->id,
              'shop_id'=>$shop_id,
              'shop_name'=>$item->shop_name,
              'matter_name'=>$session_input["matter_name"],
              'issue_info_textarea1'=>$session_input["create_issues_textarea1"],
              'issue_info_textarea2'=>$session_input["create_issues_textarea2"],
              'issue_info_textarea3'=>$session_input["create_issues_textarea3"],
              'issue_info_textarea4'=>$session_input["create_issues_textarea4"],

              'basic_info_select1_1'=>$session_input["create_issues_select1"],
              'basic_info_select1_2'=>$session_input["create_issues_select2"],
              'basic_info_text1'=>$session_input["create_issues_text1"],
              'basic_info_text2'=>$session_input["create_issues_text2"],
              'basic_info_select2'=>$session_input["create_issues_select3"],
              'basic_info_text3'=>$session_input["create_issues_text3"],

              'recruitment_info_text1'=>$session_input["create_issues_text4"],
              'recruitment_info_text2'=>$session_input["create_issues_text5"],
              'recruitment_info_text3'=>$session_input["create_issues_text6"],
              'recruitment_info_text4'=>$session_input["create_issues_text7"],
              'recruitment_info_textarea1'=>$session_input["create_issues_textarea5"],
              'recruitment_info_text5'=>$session_input["create_issues_text8"],
              'recruitment_info_text6'=>$session_input["create_issues_text9"],

              'company_info_text1'=>$session_input["create_issues_text10"],
              'company_info_select1'=>$session_input["create_issues_select4"],
              'company_info_text2'=>$session_input["create_issues_text11"],
              'company_info_text3'=>$session_input["create_issues_text12"],
              'company_info_text4'=>$session_input["create_issues_text13"],
              'company_info_text5'=>$session_input["create_issues_text14"],
              'company_info_text6'=>$session_input["create_issues_text15"],
              'company_info_text7'=>$session_input["create_issues_text16"],
              'company_info_text8'=>$session_input["create_issues_text17"],

              'matching_position1'=>$matching_position[0],
              'matching_position2'=>$matching_position[1],
              'matching_position3'=>$matching_position[2],
              //
              'matching_skill1'=>$matching_skill[0],
              'matching_skill2'=>$matching_skill[1],
              'matching_skill3'=>$matching_skill[2],
              'matching_skill4'=>$matching_skill[3],
              'matching_skill5'=>$matching_skill[4],
              'matching_skill6'=>$matching_skill[5],
              'matching_skill7'=>$matching_skill[6],
              //
              'matching_industry1'=>$matching_industry[0],
              'matching_industry2'=>$matching_industry[1],
              'matching_industry3'=>$matching_industry[2],
              //
              'matching_technology1'=>$matching_technology[0],
              'matching_technology2'=>$matching_technology[1],
              'matching_technology3'=>$matching_technology[2],

              'matching_prosess1'=>$matching_prosess[0],
              'matching_prosess2'=>$matching_prosess[1],
              'matching_prosess3'=>$matching_prosess[2],
              'matching_prosess4'=>$matching_prosess[3],
              'matching_prosess5'=>$matching_prosess[4],
              
              'matching_sonota1'=>$matching_sonota[0],
              'matching_sonota2'=>$matching_sonota[1],
              'matching_sonota3'=>$matching_sonota[2],
              'matching_sonota4'=>$matching_sonota[3],
              'matching_sonota5'=>$matching_sonota[4],
              'matching_sonota6'=>$matching_sonota[5],
              'matching_sonota7'=>$matching_sonota[6],
              'matching_sonota8'=>$matching_sonota[7],
              'matching_sonota9'=>$matching_sonota[8],
              'matching_sonota10'=>$matching_sonota[9],
              'matching_sonota11'=>$matching_sonota[10],
              'matching_sonota12'=>$matching_sonota[11],
              'matching_sonota13'=>$matching_sonota[12],
              'matching_sonota14'=>$matching_sonota[13],
              'matching_sonota15'=>$matching_sonota[14],
              'matching_sonota16'=>$matching_sonota[15],
              'matching_sonota17'=>$matching_sonota[16],
              'matching_sonota18'=>$matching_sonota[17],
              'matching_sonota19'=>$matching_sonota[18],
              'matching_sonota20'=>$matching_sonota[19],

              'todouhuken'=>$session_input["todouhuken"],
              'client_image'=>$item->client_image,
              'flag'=>"0",
              'delete_flag'=>'0',
              'created_at'=>$today,
          ];
          DB::table('matters')->insert($param);
          
          $msgs="案件投稿申請を受け付けました";
          // session削除
          $request->session()->forget('all_input_session');
          return redirect(Config::get('const.title.title47').'/'.'client_account')->with('msgs',$msgs);

      }
  }

  /////////////////////////////////////////////////////////////////////////////////////////////
  //案件編集ページ表示
  public function edit_issues_page($issue_id){
      $shop_id=session()->get("shop_id");
      if (!session()->has("shop_id")){
          return redirect(Config::get('const.title.title47'));
      }
      $new_messages = Insyoku::new_messages_alert($shop_id);

      $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
      $item2 = DB::table('matters')
                ->where('delete_flag','0')
                  ->where('id',$issue_id)
                  ->where('shop_id',$shop_id)
                  ->first();
          if (empty($item2)) {
              return redirect(Config::get('const.title.title47').'/'.'client_account/my_all_issues');
          }
      $session_test = session()->get('all_input_edit_session');
      $data = Insyoku::edit_get_same($item);
      //list
      $lists = Insyoku::matching_list_get();
      $list_title = Insyoku::matching_list_title_get();
      $contract_form_list=Config::get('form_list.contract_form');
      $dress_list=Config::get('form_list.dress');
      $todouhuken_list=Config::get('list.todouhuken');
      //db_マッチングlist
      $m_lists = Insyoku::one_matching_skill_lists_db_get($item2);

      $send_param=[
          'shop_name'=>$data[4],
          'new_messages'=>$new_messages,
          'shop_image'=>$data[5],
          'contract_form_list'=>$contract_form_list,
          'dress_list'=>$dress_list,
          'todouhuken_list'=>$todouhuken_list,
          'matching_position'=>$m_lists[0],
          'matching_skill'=>$m_lists[1],
          'matching_industry'=>$m_lists[2],
          'matching_technology_prosess_sonota'=>$m_lists[3],
          'lists'=>$lists,
          'session_test'=>$session_test,
          'list_title'=>$list_title,
      ];

      return view(Config::get('const.title.title47')."/issues/edit_issues", $send_param)->with('item2',$item2);
  }

  //案件編集確認ページデータ送信
  public function edit_issues_page_post(Request $request, $issue_id){
      if (!session()->has('shop_id')){
          return redirect(Config::get('const.title.title47'));
      }
      //送信データをsessionに保持
      $post_data = $request->all();
      //sessionほじ
      session()->put('all_input_edit_session', $post_data);

      //確認ページへリダイレクト
      return redirect(Config::get('const.title.title47').'/'.'client_account/edit_issues/confirmation/'.$issue_id);
  }

   //案件編集確認ページ表示
   public function edit_issues_confirmation($issue_id){
      if (!session()->has('shop_id')){
          return redirect(Config::get('const.title.title47'));
      }

      //sessionデータを表示 input hiddenに挿入＋表示
      if (!session()->has("all_input_edit_session")){
          return redirect(Config::get('const.title.title47').'/client_account');
      }
      $session_test = session()->get('all_input_edit_session');
      $contract_form_list=Config::get('form_list.contract_form');
      $dress_list=Config::get('form_list.dress');
      $todouhuken_list=Config::get('list.todouhuken');
      $lists = Insyoku::matching_list_get();

      $send_param=[
          
          'contract_form_list'=>$contract_form_list,
          'dress_list'=>$dress_list,
          'todouhuken_list'=>$todouhuken_list,
          'lists'=>$lists,
      ];

      return view(Config::get('const.title.title47')."/issues/edit_issues_confirmation", $send_param)->with('session_test',$session_test);
  }

  //案件編集確認ページデータpost
  public function edit_issues_confirmation_post(Request $request,$issue_id){
      if (!session()->has('shop_id')){
          return redirect(Config::get('const.title.title47'));
      }
      if (!session()->has("all_input_edit_session")){
          return redirect(Config::get('const.title.title47').'/client_account');
      }
      //戻るボタン
      if (isset($request->return_sub)) {
          return redirect(Config::get('const.title.title47').'/'.'client_account/edit_issues/'.$issue_id);
      }
      
      //送信データを登録&運営側に確認
      if (isset($request->post_sub)) {
          $shop_id=session()->get("shop_id");
          $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
          $session_input = session()->get('all_input_edit_session');
          $today = date("Y-m-d-H:i:s");

          //checkbox値の処理
          $matching_position = $session_input["create_issues_checkbox1"];
          for ($i = 1; $i <= 3 - count($session_input["create_issues_checkbox1"]);$i++) {
              array_push($matching_position, null);
          }
          
          //skill
          $matching_skill = $session_input["create_issues_checkbox2"];
          for ($i = 1; $i <= 7 - count($session_input["create_issues_checkbox2"]);$i++) {
              array_push($matching_skill, null);
          }
          
          //gyou
          $matching_industry = $session_input["create_issues_checkbox3"];
          for ($i = 1; $i <= 3 - count($session_input["create_issues_checkbox3"]);$i++) {
              array_push($matching_industry, null);
          }
          
          //tec.porosess,sonota
          $matching_technology = [];
          $matching_prosess = [];
          $matching_sonota = [];
          if (empty($session_input["create_issues_checkbox4"])) {
              //tech
              for ($i = 1; $i <= 3 ;$i++) {
                  array_push($matching_technology, null);
              }
              //poro
              for ($i = 1; $i <= 5 ;$i++) {
                  array_push($matching_prosess, null);
              }
              //sonota
              for ($i = 1; $i <= 20 ;$i++) {
                  array_push($matching_sonota, null);
              }
          } elseif (isset($session_input["create_issues_checkbox4"])) {
              foreach ($session_input["create_issues_checkbox4"] as $value) {
                  if (intval($value) <= 19) {
                      array_push($matching_technology, $value);
                  } elseif (intval($value) > 19 && intval($value) <= 34) {
                      array_push($matching_prosess, $value);
                  } elseif (intval($value) > 34 && intval($value) <= 85) {
                      array_push($matching_sonota, $value);
                  }
                }
              //tech
              $matching_technology_count = $matching_technology;
              for ($i = 1; $i <= 3 - count($matching_technology_count);$i++) {
                  array_push($matching_technology, null);
              }
              //poro
              $matching_prosess_count = $matching_prosess;
              for ($i = 1; $i <= 5 - count($matching_prosess_count);$i++) {
                  array_push($matching_prosess, null);
              }
              //sonota
              $matching_sonota_count = $matching_sonota;
              for ($i = 1; $i <= 20 - count($matching_sonota_count);$i++) {
                  array_push($matching_sonota, null);
              }

          }

          $param=[
              'shop_number_id'=>$item->id,
              'shop_id'=>$shop_id,
              'shop_name'=>$item->shop_name,
              'matter_name'=>$session_input["matter_name"],
              'issue_info_textarea1'=>$session_input["create_issues_textarea1"],
              'issue_info_textarea2'=>$session_input["create_issues_textarea2"],
              'issue_info_textarea3'=>$session_input["create_issues_textarea3"],
              'issue_info_textarea4'=>$session_input["create_issues_textarea4"],

              'basic_info_select1_1'=>$session_input["create_issues_select1"],
              'basic_info_select1_2'=>$session_input["create_issues_select2"],
              'basic_info_text1'=>$session_input["create_issues_text1"],
              'basic_info_text2'=>$session_input["create_issues_text2"],
              'basic_info_select2'=>$session_input["create_issues_select3"],
              'basic_info_text3'=>$session_input["create_issues_text3"],

              'recruitment_info_text1'=>$session_input["create_issues_text4"],
              'recruitment_info_text2'=>$session_input["create_issues_text5"],
              'recruitment_info_text3'=>$session_input["create_issues_text6"],
              'recruitment_info_text4'=>$session_input["create_issues_text7"],
              'recruitment_info_textarea1'=>$session_input["create_issues_textarea5"],
              'recruitment_info_text5'=>$session_input["create_issues_text8"],
              'recruitment_info_text6'=>$session_input["create_issues_text9"],

              'company_info_text1'=>$session_input["create_issues_text10"],
              'company_info_select1'=>$session_input["create_issues_select4"],
              'company_info_text2'=>$session_input["create_issues_text11"],
              'company_info_text3'=>$session_input["create_issues_text12"],
              'company_info_text4'=>$session_input["create_issues_text13"],
              'company_info_text5'=>$session_input["create_issues_text14"],
              'company_info_text6'=>$session_input["create_issues_text15"],
              'company_info_text7'=>$session_input["create_issues_text16"],
              'company_info_text8'=>$session_input["create_issues_text17"],

              'matching_position1'=>$matching_position[0],
              'matching_position2'=>$matching_position[1],
              'matching_position3'=>$matching_position[2],
              //
              'matching_skill1'=>$matching_skill[0],
              'matching_skill2'=>$matching_skill[1],
              'matching_skill3'=>$matching_skill[2],
              'matching_skill4'=>$matching_skill[3],
              'matching_skill5'=>$matching_skill[4],
              'matching_skill6'=>$matching_skill[5],
              'matching_skill7'=>$matching_skill[6],
              //
              'matching_industry1'=>$matching_industry[0],
              'matching_industry2'=>$matching_industry[1],
              'matching_industry3'=>$matching_industry[2],
              //
              'matching_technology1'=>$matching_technology[0],
              'matching_technology2'=>$matching_technology[1],
              'matching_technology3'=>$matching_technology[2],

              'matching_prosess1'=>$matching_prosess[0],
              'matching_prosess2'=>$matching_prosess[1],
              'matching_prosess3'=>$matching_prosess[2],
              'matching_prosess4'=>$matching_prosess[3],
              'matching_prosess5'=>$matching_prosess[4],
              
              'matching_sonota1'=>$matching_sonota[0],
              'matching_sonota2'=>$matching_sonota[1],
              'matching_sonota3'=>$matching_sonota[2],
              'matching_sonota4'=>$matching_sonota[3],
              'matching_sonota5'=>$matching_sonota[4],
              'matching_sonota6'=>$matching_sonota[5],
              'matching_sonota7'=>$matching_sonota[6],
              'matching_sonota8'=>$matching_sonota[7],
              'matching_sonota9'=>$matching_sonota[8],
              'matching_sonota10'=>$matching_sonota[9],
              'matching_sonota11'=>$matching_sonota[10],
              'matching_sonota12'=>$matching_sonota[11],
              'matching_sonota13'=>$matching_sonota[12],
              'matching_sonota14'=>$matching_sonota[13],
              'matching_sonota15'=>$matching_sonota[14],
              'matching_sonota16'=>$matching_sonota[15],
              'matching_sonota17'=>$matching_sonota[16],
              'matching_sonota18'=>$matching_sonota[17],
              'matching_sonota19'=>$matching_sonota[18],
              'matching_sonota20'=>$matching_sonota[19],

              'todouhuken'=>$session_input["todouhuken"],
              'client_image'=>$item->client_image,
              'flag'=>"0",
              'delete_flag'=>'0',
              'updated_at'=>$today,
          ];
  
          DB::table('matters')
          ->where('delete_flag','0')
          ->where('shop_id', $shop_id)
          ->where('id', $issue_id)
          ->update($param);
          
          $msgs="案件編集申請を受け付けました";
          // session削除
          $request->session()->forget('all_input_edit_session');
          return redirect(Config::get('const.title.title47').'/'.'client_account')->with('msgs',$msgs);
      }
  }


  //人材案件検索結果ページview
  public function search_list_page_view(Request $request) {
    // if (!session()->has('user_id')){
    //     return redirect(Config::get('const.title.title48'));
    // }
    // $user_id=session()->get('user_id');
    // $new_messages = Influ::new_messages_alert($user_id);

    $item2 = DB::table('matters')->where('flag',"1")->paginate(5);
    $item2 = DB::table('matters')->where('delete_flag','0')->where('flag',"1")->get();
    // $item2 = $item2->paginate(5);
    $search_session = session()->get('search_session');
    $todouhuken_list=Config::get('list.todouhuken');

    $search_item_list = $item2;
    //最終的に当てはまったものを格納
    $search_item_todouhuken_list = [];$search_item_money_list1 = [];$search_item_money_list2 = [];$search_item_position_list = [];$search_item_skill_list = [];$search_item_industry_list = [];$search_item_sonota_list = [];


    //ワード検索
    // 全角スペースを半角に変換 search_word
    if (isset($search_session['search_word_submit'])) {

      $spaceConversion = mb_convert_kana($search_session['search_word'], 's');

      if ($spaceConversion === "") {
        $search_item_sonota_list = $search_item_list;
      }

      if ($spaceConversion !== "") {

        foreach ($search_item_list as $item) {
          $judge_num1 = 0;
          if (preg_match( '{'.$spaceConversion.'}', $item->matter_name )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->issue_info_textarea1 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->issue_info_textarea2 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->issue_info_textarea3 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->issue_info_textarea4 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->basic_info_text1 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->basic_info_text2 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->basic_info_text3 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_text1 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_text2 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_text3 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_text4 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_textarea1 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_text5 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->recruitment_info_text6 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text1 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text2 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text3 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text4 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text5 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text6 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text7 )) {$judge_num1 = 1;}
          elseif (preg_match( '{'.$spaceConversion.'}', $item->company_info_text8 )) {$judge_num1 = 1;}
  
          //1だったら
          if ($judge_num1 === 1) {
            array_push($search_item_sonota_list, $item);
          }
        }
        
      }



    }


    //条件選択検索
    if (isset($search_session['submit'])) {

      //地域を含むか
      if (isset($search_session['current_situation'])) {
        foreach ($search_item_list as $item) {
            if ($item->todouhuken == $search_session['current_situation']) {
              array_push($search_item_todouhuken_list, $item);
            }
        }
      } else {
        $search_item_todouhuken_list = $search_item_list;
      }

      //選択単価範囲に含まれるもの
      if (isset($search_session['money1'])) {
        foreach ($search_item_todouhuken_list as $item) {
          //最低金額より多いか
            if ( $item->basic_info_select1_1 >= $search_session['money1'] || $item->basic_info_select1_2 >= $search_session['money1'] ) {
              array_push($search_item_money_list1, $item);
            }
        }
      } else {
        $search_item_money_list1 = $search_item_todouhuken_list;
      }

      //選択単価範囲に含まれるもの
      if (isset($search_session['money2'])) {
        foreach ($search_item_money_list1 as $item) {
          //最低金額より多いか
            if ( $item->basic_info_select1_2 <= $search_session['money2']) {
              array_push($search_item_money_list2, $item);
            }
        }
      } else {
        $search_item_money_list2 = $search_item_money_list1;
      }
      
      // ポジションを含むか/////////////////////////////////////////////////////////////////////
      if (!empty($search_session['create_issues_checkbox1'])) {
        //123の内どれかが含まれていたら１、そうでない場合は２
        foreach ($search_item_money_list2 as $item) {
            $judge_num1 = 0;
            foreach ($search_session['create_issues_checkbox1'] as $check) {
                if ($item->matching_position1 == $check) {$judge_num1 = 1;} 
                elseif ($item->matching_position2 == $check) {$judge_num1 = 1;} 
                elseif ($item->matching_position3 == $check) {$judge_num1 = 1;}
              }
            //1だったら
            if ($judge_num1 === 1) {
              array_push($search_item_position_list, $item);
            }
        }
      } else {
        $search_item_position_list = $search_item_money_list2;
      }
      /////////////////////////////////////////////////////////////////////

      // スキルを含むか/////////////////////////////////////////////////////////////////////
      if (!empty($search_session['create_issues_checkbox2'])) {
        //123の内どれかが含まれていたら１、そうでない場合は２
        foreach ($search_item_position_list as $item) {
            $judge_num2 = 0;
            foreach ($search_session['create_issues_checkbox2'] as $check) {
                if ($item->matching_skill1 == $check) {$judge_num2 = 1;} 
                elseif ($item->matching_skill2 == $check) {$judge_num2 = 1;} 
                elseif ($item->matching_skill3 == $check) {$judge_num2 = 1;} 
                elseif ($item->matching_skill4 == $check) {$judge_num2 = 1;} 
                elseif ($item->matching_skill5 == $check) {$judge_num2 = 1;} 
                elseif ($item->matching_skill6 == $check) {$judge_num2 = 1;} 
                elseif ($item->matching_skill7 == $check) {$judge_num2 = 1;}
            }
            //1だったら
            if ($judge_num2 === 1) {
              array_push($search_item_skill_list, $item);
            }
        }
      } else {
        $search_item_skill_list = $search_item_position_list;
      }
      /////////////////////////////////////////////////////////////////////

      // 業界を含むか/////////////////////////////////////////////////////////////////////
      if (!empty($search_session['create_issues_checkbox3'])) {
        //123の内どれかが含まれていたら１、そうでない場合は２
        foreach ($search_item_skill_list as $item) {
            $judge_num3 = 0;
            foreach ($search_session['create_issues_checkbox3'] as $check) {
                if ($item->matching_industry1 == $check) {$judge_num3 = 1;} 
                elseif ($item->matching_industry2 == $check) {$judge_num3 = 1;} 
                elseif ($item->matching_industry3 == $check) {$judge_num3 = 1;} 
            }
            //1だったら
            if ($judge_num3 === 1) {
              array_push($search_item_industry_list, $item);
            }
        }
      } else {
        $search_item_industry_list = $search_item_skill_list;
      }
      /////////////////////////////////////////////////////////////////////

      // その他を含むか/////////////////////////////////////////////////////////////////////
      if (!empty($search_session['create_issues_checkbox4'])) {
          //123の内どれかが含まれていたら１、そうでない場合は２
          foreach ($search_item_industry_list as $item) {
              $judge_num4 = 0;
              foreach ($search_session['create_issues_checkbox4'] as $check) {
                  //tech
                  if (intval($check) <= 19) {
                      if ($item->matching_technology1 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_technology2 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_technology3 == $check) {$judge_num4 = 1;} 
                  } 
                  //porsess
                  elseif (intval($check) > 19 && intval($check) <= 34) {
                      if ($item->matching_prosess1 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_prosess2 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_prosess3 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_prosess4 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_prosess5 == $check) {$judge_num4 = 1;} 
                  } 
                  //sonota
                  elseif (intval($check) > 34 && intval($check) <= 85) {
                      if ($item->matching_sonota1 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota2 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota3 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota4 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota5 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota6 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota7 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota8 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota9 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota10 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota11 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota12 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota13 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota14 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota15 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota16 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota17 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota18 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota19 == $check) {$judge_num4 = 1;} 
                      elseif ($item->matching_sonota20 == $check) {$judge_num4 = 1;} 
                    }
                }
                //1だったら
                if ($judge_num4 === 1) {
                  array_push($search_item_sonota_list, $item);
                }
            }
        } else {
          $search_item_sonota_list = $search_item_industry_list;
        }
        /////////////////////////////////////////////////////////////////////

    }


    //ページない５つ処理
    $item_5 = [];
    $count_5 = 0;
    foreach ($search_item_sonota_list as $item_one) {
      //初めのページ
      if (!isset($request->page)) {
        if ($count_5 < 5) {
          array_push($item_5, $item_one);
        }
      }

      //2ページ目以降
      if (isset($request->page)) {
        $page_plus_5_down = ($request->page * 5) - 5;
        $page_plus_5_up = ($request->page * 5) - 1;
        if ($count_5 >= $page_plus_5_down && $count_5 <= $page_plus_5_up) {
          array_push($item_5, $item_one);
        }
      }
      $count_5++;
    }


    //ページネーション
    $pege_5_count = count($search_item_sonota_list) / 5;
    $pege_5_count = floor ( $pege_5_count + 0.99) ;

    if (isset($request->page)) {
      $prev = $request->page - 1;
      $next = $request->page + 1;
    } 
    if (!isset($request->page) && $pege_5_count !== 1) {
      $prev = 0;
      $next = 2;
    }
    if (!isset($request->page) && $pege_5_count == 1) {
      $prev = 0;
      $next = 0;
    }
    if ($pege_5_count == $request->page) {
      $next = 0;
    } 

    //list
    $lists = Influ::matching_list_get();
    $m_lists = Insyoku::matching_skill_lists_db_get($item_5);


    $send_param=[
        'lists'=>$lists,
        'prev'=>$prev,
        'next'=>$next,
        'matching_position'=>$m_lists[0],
        'matching_skill'=>$m_lists[1],
        'matching_industry'=>$m_lists[2],
        'item_count'=>count($search_item_sonota_list),
        'search_session'=>$search_session,
        'todouhuken_list'=>$todouhuken_list,

    ];

    return view(Config::get('const.title.title48')."/matter_list", $send_param)->with('item2',$item_5);
  }

  //人材案件検索結果詳細ページview
  public function search_list_page_detail_view($id) {
    if (session()->has('user_id')){
        $user_id=session()->get('user_id');
    }
    // $new_messages = Influ::new_messages_alert($user_id);

    $item2 = DB::table('matters')->where('delete_flag','0')->where('id',$id)->first();
    if (empty($item2)) {
      return redirect(Config::get('const.title.title48').'/'.'search_list');
    }

    if (!session()->has('user_id')){
        $apply_check = 0;
    } else {
        $item3 = DB::table('apply_contacts')->where('delete_flag','0')->where('issue_id',$id)->where('user_id',$user_id)->first();
        //すでに応募していたら
        if (!empty($item3)) {
            $apply_check = 1;
        } else {
            $apply_check = 0;
        }
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

    $send_param=[
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

    response()->json(['name' => '山田太郎', 'gender' => '男','mail' => 'yamada@test.com']);

    return view(Config::get('const.title.title48')."/matter_detail", $send_param)->with(["item2"=>$item2,'company_item'=>$company_item]);
  }

  //////////////////////////////////////////////////////////////////////////////////////////
    //応募処理
    public function apply_issue_user(Request $request,$id){
        if (!session()->has('user_id')){
            return redirect(Config::get('const.title.title48'));
        }
        $user_id=session()->get('user_id');
        $item = DB::table('matters')->where('delete_flag','0')->where('id',$id)->first();
        $item2 = DB::table('apply_contacts')->where('delete_flag','0')->where('issue_id',$id)->where('user_id',$user_id)->first();
        $today = date("Y-m-d-H:i:s");

        //すでに応募していたら
        if (!empty($item2)) {
            $msgs="すでに応募されています。";
            return redirect(Config::get('const.title.title48').'/'.'search_detail/'.$id)->with('msgs',$msgs);
        }

        $param=[
            'issue_id'=>$request->issue_id,
            'shop_id'=>$item->shop_id,
            'user_id'=>$user_id,
            'apply_flag'=>"0",
            'delete_flag'=>'0',
            'created_at'=>$today,
        ];

        DB::table('apply_contacts')->insert($param);

        $user_item = DB::table('influs')->where('delete_flag','0')->where('user_id',$user_id)->first();

        $mail_param=[
            'form_name'=>$user_item->user_name,
        ];
        $email = $item->shop_id;

        // メール
        Mail::to($email)->send(new IssueApplyMail($mail_param));

        $msgs="応募が完了しました";
        return redirect(Config::get('const.title.title48').'/'.'search_detail/'.$id)->with('msgs',$msgs);
    }




    ////応募のある案件一覧 (クライアント)
    public function apply_issue_all_get() {
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        session()->forget('user_select_contract_form_data');
        $shop_id=session()->get('shop_id');
        $new_messages = Insyoku::new_messages_alert($shop_id);

        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();
        $data = Insyoku::edit_get_same($item);
        $item2 = DB::table('matters')->where('delete_flag','0')->where('shop_id',$shop_id)->get();
        $apply_contacts = DB::table('apply_contacts')->where('delete_flag','0')->where('shop_id',$shop_id)->where('apply_flag','!=','2')->get();

        //応募がある案件と応募数の配列
        $issue_item = [];
        $issue_apply_num = [];
        foreach ($item2 as $issue) {
            $apply_there = 0;
            $apply_count = 0;
            foreach ($apply_contacts as $apply) {
                if ($issue->id == $apply->issue_id) {
                    $apply_there = 1;
                    $apply_count++;
                }
            }

            //応募の数
            if ($apply_count !== 0) {
                array_push($issue_apply_num, $apply_count);
            }

            //応募があれば
            if ($apply_there === 1) {
                array_push($issue_item, $issue);
            }
        }

        $send_param=[
            'new_messages'=>$new_messages,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'issue_apply_num'=>$issue_apply_num,
        ];

        return view(Config::get('const.title.title47')."/all_apply_issue", $send_param)->with('item2',$issue_item);
    }

    ////応募ユーザー一覧 (クライアント)
    public function issue_apply_user($id) {
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $new_messages = Insyoku::new_messages_alert($shop_id);

        $item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

        $data = Insyoku::edit_get_same($item);

        $item2 = DB::table('matters')->where('delete_flag','0')->where('id',$id)->where('flag',"1")->where('shop_id',$shop_id)->first();

        $apply_contacts_1 = DB::table('apply_contacts')->where('delete_flag','0')->where('issue_id',$id)->where('apply_flag','1')->get();

        $apply_contacts_0 = DB::table('apply_contacts')->where('delete_flag','0')->where('issue_id',$id)->where('apply_flag','0')->get();

        $apply_contacts = [];
        if (!empty($apply_contacts_1)) {
            foreach ($apply_contacts_1 as $apply_1) {
                array_push($apply_contacts, $apply_1);
            }
        }
        if (!empty($apply_contacts_0)) {
            foreach ($apply_contacts_0 as $apply_0) {
                array_push($apply_contacts, $apply_0);
            }
        }

        //list
        $job_list=Config::get('form_list.jobs');
        $lists = Influ::matching_list_get();

        $user_item = [];
        $apply_contacts_id = [];
        $apply_contacts_flag = [];
        foreach ($apply_contacts as $apply) {
            $item_user_one=DB::table('influs')->where('delete_flag','0')->where('user_id',$apply->user_id)->first();
            array_push($user_item, $item_user_one);
            array_push($apply_contacts_id, $apply->id);
            array_push($apply_contacts_flag, $apply->apply_flag);
        }
        if (empty($user_item)){
            return redirect(Config::get('const.title.title47').'/client_account/apply_issue');
        }
        $user_experience_skills = Insyoku::apply_user_experience_skill_get($user_item);

        $send_param=[
            'new_messages'=>$new_messages,
            'lists'=>$lists,
            'shop_name'=>$data[4],
            'shop_image'=>$data[5],
            'apply_contacts_id'=>$apply_contacts_id,
            'apply_contacts_flag'=>$apply_contacts_flag,
            'job_list'=>$job_list,
            'experience_positions'=>$user_experience_skills[0],
            'experience_skills'=>$user_experience_skills[1],
            'experience_industrys'=>$user_experience_skills[2],
        ];

        return view(Config::get('const.title.title47')."/issue_apply_user", $send_param)->with('item2',$user_item);
    }

    // //応募者合否、お気に入り、選定
    public function issue_apply_user_judge_select(Request $request,$id) {
        if (!session()->has('shop_id')){
            return redirect(Config::get('const.title.title47'));
        }
        $shop_id=session()->get('shop_id');
        $today = date("Y-m-d-H:i:s");
        
        //お気に入りボタン
        if (isset($request->user_check)) {
            $appply_contents = DB::table('apply_contacts')
                                ->where('delete_flag','0')
                                ->where('id',$request->apply_id)
                                ->where('shop_id',$request->shop_id)
                                ->where('user_id',$request->user_id)
                                ->first();
            if ($appply_contents->apply_flag == '0') {
                $flag_num = '1';
            } else {
                $flag_num = '0';
            }

            $param=[
                'apply_flag'=>$flag_num,
                'delete_flag'=>'0',
                'updated_at'=>$today,
            ];

            if ($shop_id == $request->shop_id) {
                DB::table('apply_contacts')
                ->where('id',$request->apply_id)
                ->where('delete_flag','0')
                ->where('shop_id',$request->shop_id)
                ->where('user_id',$request->user_id)
                ->update($param);
            }
        }

        //応募見送りボタン
        if (isset($request->defeated_user)) {
            $appply_contents = DB::table('apply_contacts')
                                ->where('delete_flag','0')
                                ->where('id',$request->apply_id)
                                ->where('shop_id',$request->shop_id)
                                ->where('user_id',$request->user_id)
                                ->first();
                $flag_num = '2';

            $param=[
                'delete_flag'=>'0',
                'apply_flag'=>$flag_num,
                'updated_at'=>$today,
            ];

            if ($shop_id == $request->shop_id) {
                DB::table('apply_contacts')
                ->where('id',$request->apply_id)
                ->where('delete_flag','0')
                ->where('shop_id',$request->shop_id)
                ->where('user_id',$request->user_id)
                ->update($param);

                $user_item = DB::table('influs')->where('delete_flag','0')->where('user_id',$request->user_id)->first();
                $shop_item = DB::table('insyokus')->where('delete_flag','0')->where('shop_id',$shop_id)->first();

                $mail_param=[
                    'form_name'=>$shop_item->shop_name,
                ];
                $email = $request->user_id;

                // メール
                Mail::to($email)->send(new IssueApplyDefeatedMail($mail_param));

                $msgs="応募を見送りましたました";
                return redirect(Config::get('const.title.title47').'/'.'client_account/issue_apply_user/'.$id)->with('msgs',$msgs);
            }
        }

        //メッセージルーム作成 メッセーじ移動
        if (isset($request->message_room)) {
            //ルームは作成済みか
            $message_room = DB::table('message_room')
                                ->where('shop_id',$request->shop_id)
                                ->where('delete_flag','0')
                                ->where('user_id',$request->user_id)
                                ->first();

            //ルームがなかったら
            if (empty($message_room)) {
                $param=[
                    'shop_id'=>$request->shop_id,
                    'user_id'=>$request->user_id,
                    'delete_flag'=>'0',
                    'created_at'=>$today,
                ];

                DB::table('message_room')->insert($param);
            }
            
            $meg_room_id = DB::table('message_room')
                            ->where('shop_id',$request->shop_id)
                            ->where('delete_flag','0')
                            ->where('user_id',$request->user_id)
                            ->first();
            if (empty($meg_room_id)) {
                return redirect(Config::get('const.title.title47').'/'.'client_account/messages/');
            } else {
                return redirect(Config::get('const.title.title47').'/'.'client_account/message/'.$meg_room_id->id);
            }
        }

        return redirect(Config::get('const.title.title47').'/'.'client_account/issue_apply_user/'.$id);
    }

}