<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client2Controller;
use App\Http\Controllers\Client1Controller;
use App\Http\Controllers\MatterController;
use App\Http\Controllers\MatterstateController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Config;



use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// test
Route::get('/mail', function () {
    $mail_text = "メールテストで使いたい文章";
    Mail::to('pogbakami@icloud.com')->send(new MailTest($mail_text));
});





// Route::get('/laravel/public', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('index');
});

Route::post(Config::get('const.title.title49'), [ManagerController::class, 'login']);
Route::get(Config::get('const.title.title49'), function () {
    return view(Config::get('const.title.title49').'.index');
});
Route::post(Config::get('const.title.title49'), [ManagerController::class, 'login']);

Route::get(Config::get('const.title.title49').'/admin_create', function () {
    return view(Config::get('const.title.title49').'.admin_create');
});

// Route::get(Config::get('const.title.title49').'/main', function () {
//     return view(Config::get('const.title.title49').'.main');
// });
//logout
Route::get(Config::get('const.title.title49').'/logout', [ManagerController::class, 'administrator_logout']);
//運営者
Route::get(Config::get('const.title.title49').'/main', [ManagerController::class, 'administrator_main']);
//管理者ページ
Route::get(Config::get('const.title.title49').'/account_all', [ManagerController::class, 'administrator_account']);
//管理者削除
Route::post(Config::get('const.title.title49').'/account_all', [ManagerController::class, 'administrator_account_delete']);
//管理者作成
Route::get(Config::get('const.title.title49').'/account_create', [ManagerController::class, 'administrator_account_create']);
//管理者作成post
Route::post(Config::get('const.title.title49').'/account_create', [ManagerController::class, 'administrator_account_create_post']);

//ユーザー管理//////////////
Route::get(Config::get('const.title.title49').'/user_account', [ManagerController::class, 'administrator_user_account']);
//検索
Route::post(Config::get('const.title.title49').'/user_account', [ManagerController::class, 'administrator_user_account_search']);
//ユーザー詳細
Route::get(Config::get('const.title.title49').'/user_account_detail/{id}', [ManagerController::class, 'administrator_user_account_detail']);
Route::post(Config::get('const.title.title49').'/user_account_detail/{id}', [ManagerController::class, 'administrator_user_account_detail_post']);

///企業管理//////////////
Route::get(Config::get('const.title.title49').'/company_account', [ManagerController::class, 'administrator_company_account']);
//検索
Route::post(Config::get('const.title.title49').'/company_account', [ManagerController::class, 'administrator_company_account_search']);
///企業詳細
Route::get(Config::get('const.title.title49').'/company_account_detail/{id}', [ManagerController::class, 'administrator_company_account_detail']);
Route::post(Config::get('const.title.title49').'/company_account_detail/{id}', [ManagerController::class, 'administrator_company_account_detail_post']);

///案件管理//////////////
Route::get(Config::get('const.title.title49').'/all_issue', [ManagerController::class, 'administrator_all_issue']);
//検索
Route::post(Config::get('const.title.title49').'/all_issue', [ManagerController::class, 'administrator_issue_search']);
///案件詳細
Route::get(Config::get('const.title.title49').'/issue_detail/{id}', [ManagerController::class, 'administrator_issue_detail']);
Route::post(Config::get('const.title.title49').'/issue_detail/{id}', [ManagerController::class, 'administrator_issue_detail_post']);

///contacts管理//////////////
Route::get(Config::get('const.title.title49').'/all_contacts', [ManagerController::class, 'administrator_all_contacts']);
//検索
Route::post(Config::get('const.title.title49').'/all_contacts', [ManagerController::class, 'administrator_contacts_search']);
//contacts編集ページ
Route::get(Config::get('const.title.title49').'/edit_contacts', [ManagerController::class, 'administrator_edit_contacts']);
//contacts編集post
Route::post(Config::get('const.title.title49').'/edit_contacts', [ManagerController::class, 'administrator_contacts_edit']);
///contacts詳細
Route::get(Config::get('const.title.title49').'/contacts_detail/{id}', [ManagerController::class, 'administrator_contacts_detail']);
Route::post(Config::get('const.title.title49').'/contacts_detail/{id}', [ManagerController::class, 'administrator_contacts_detail_post']);

///payment_管理//////////////
Route::get(Config::get('const.title.title49').'/all_payment', [ManagerController::class, 'administrator_all_payment']);
//検索
Route::post(Config::get('const.title.title49').'/all_payment', [ManagerController::class, 'administrator_payment_search']);
//payment編集ページ
Route::get(Config::get('const.title.title49').'/edit_payment', [ManagerController::class, 'administrator_edit_payment']);
//payment編集post
Route::post(Config::get('const.title.title49').'/edit_payment', [ManagerController::class, 'administrator_payment_edit']);
///payment詳細
Route::get(Config::get('const.title.title49').'/payment_detail/{id}', [ManagerController::class, 'administrator_payment_detail']);
Route::post(Config::get('const.title.title49').'/payment_detail/{id}', [ManagerController::class, 'administrator_payment_detail_post']);

///運営者チャット
Route::get(Config::get('const.title.title49').'/messages', [ManagerController::class, 'administrator_messages']);
Route::get(Config::get('const.title.title49').'/message/{id}', [ManagerController::class, 'administrator_message_room']);
Route::post(Config::get('const.title.title49').'/message/{id}', [ManagerController::class, 'administrator_message_post']);







//運営者店舗クライアント
Route::get(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47'), function () {
    return view(Config::get('const.title.title49').'.admin_influ');
});

Route::get(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_1', [Client1Controller::class, 'index1']);
Route::get(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_2', [Client1Controller::class, 'index2']);
Route::get(Config::get('const.title.title49').'/'.Config::get('const.title.title47').'_csv/{shop_status_s}/{shop_address_s}', [Client1Controller::class, 'client1_csv']);
Route::post(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_2', [Client1Controller::class, 'mail_to_selected_client1']);
Route::get(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_1_detail/{id}', [Client1Controller::class, 'index1_detail']);
Route::get(Config::get('const.title.title49')."/admin_".Config::get('const.title.title47')."_2_detail/{shop_id}", [Client1Controller::class, 'index2_detail']);

//メルテンプレート
Route::get(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_template', [Client1Controller::class, 'admin_client1_template']);
Route::post(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_template', [Client1Controller::class, 'admin_client1_template_edit']);

Route::post(Config::get('const.title.title49').'/admin_'.Config::get('const.title.title47').'_1_detail/{id}', [Client1Controller::class, 'judge']);
Route::post(Config::get('const.title.title49')."/admin_".Config::get('const.title.title47')."_2_detail/{shop_id}", [Client1Controller::class, 'index2_post']);

//案件作成
Route::get(Config::get('const.title.title49').'/create_matter', [MatterController::class, 'matter_format']);
Route::post(Config::get('const.title.title49').'/create_matter_confirm', [MatterController::class, 'create_matter']);
Route::get(Config::get('const.title.title49').'/create_matter_confirm', function () {
    return view(Config::get('const.title.title49').'.create_matter_confirm');
});
Route::post(Config::get('const.title.title49').'/create_matter', [MatterController::class, 'create_matter_confirm']);

//運営者店舗クライアント終わり

//運営者チャット
Route::get(Config::get('const.title.title49').'/chat', [ContactController::class, 'index']);
Route::get(Config::get('const.title.title49').'/chat_detail/{id}', [ContactController::class, 'index_detail']);
Route::post(Config::get('const.title.title49').'/chat_detail/{id}', [ContactController::class, 'admin_post']);

Route::get(Config::get('const.title.title47'), function () {
    return view(Config::get('const.title.title47').'.index');
});

//請求情報
Route::get(Config::get('const.title.title49').'/payment', [MatterstateController::class, 'admin_payment']);
Route::get(Config::get('const.title.title49').'/payment_'.Config::get('const.title.title48'), [MatterstateController::class, 'admin_payment_client2']);
Route::get(Config::get('const.title.title49').'/payment_csv/{id}/{dates}', [MatterstateController::class, 'admin_payment_csv']);

//運営者設定
Route::get(Config::get('const.title.title49').'/admin_config_main', function () {
    return view('administrator.admin_config_main');
});
Route::get(Config::get('const.title.title49').'/admin_config', [ConfigController::class, 'admin_index']);
Route::post(Config::get('const.title.title49').'/admin_config', [ConfigController::class, 'admin_config']);
Route::get(Config::get('const.title.title49').'/admin_config_'.Config::get('const.title.title47'), [ConfigController::class, 'client1_form_get']);
Route::post(Config::get('const.title.title49').'/admin_config_'.Config::get('const.title.title47'), [ConfigController::class, 'client1_form_post']);

//アカウント情報編集
Route::get(Config::get('const.title.title49').'/admin_account_edit', function () {
    return view('administrator.admin_account_edit');
});
Route::post(Config::get('const.title.title49').'/admin_account_edit', [ManagerController::class, 'admin_account_edit']);






//インフルエンサーページ//////////////////////////////////////

Route::get(Config::get('const.title.title48').'/logout', function () {
    
});




Route::get(Config::get('const.title.title48').'/logout', [Client2Controller::class, 'client2_logout']);




Route::get(Config::get('const.title.title48'), function () {
    return view(Config::get('const.title.title48').'.index');
});
Route::post(Config::get('const.title.title48'), [Client2Controller::class, 'login']);

Route::get(Config::get('const.title.title48').'/pass_forget', function () {
    return view(Config::get('const.title.title48').'.pass_forget');
});
Route::post(Config::get('const.title.title48').'/pass_forget', [Client2Controller::class, 'pass_reput']);

//事前登録　//仮会員登録（メール）
Route::get(Config::get('const.title.title48').'/first_form', function () {
    return view(Config::get('const.title.title48').'.first_form');
});
Route::post(Config::get('const.title.title48').'/first_form', [Client2Controller::class, 'before_form']);



//本登録
Route::get(Config::get('const.title.title48').'/second_form', [Client2Controller::class, 'after_form_pre']);
Route::post(Config::get('const.title.title48').'/second_form', [Client2Controller::class, 'after_form']);

//マイページ
Route::get(Config::get('const.title.title48').'/user_account', [Client2Controller::class, 'mypage_get']);

//マイページ基本情報編集
Route::get(Config::get('const.title.title48').'/user_account/edit', [Client2Controller::class, 'account_get']);
Route::post(Config::get('const.title.title48').'/user_account/edit', [Client2Controller::class, 'account_edit']);
// マイページ自己紹介
Route::get(Config::get('const.title.title48').'/user_account/self_introduction/edit', [Client2Controller::class, 'self_introduction_get']);
Route::post(Config::get('const.title.title48').'/user_account/self_introduction/edit', [Client2Controller::class, 'self_introduction_edit']);
// マイページ経歴・作品
Route::get(Config::get('const.title.title48').'/user_account/biography_works/edit', [Client2Controller::class, 'biography_works_get']);
Route::post(Config::get('const.title.title48').'/user_account/biography_works/edit', [Client2Controller::class, 'biography_works_edit']);
// マイページ経験企業
Route::get(Config::get('const.title.title48').'/user_account/experienced_companies/edit', [Client2Controller::class, 'experienced_companies_get']);
Route::post(Config::get('const.title.title48').'/user_account/experienced_companies/edit', [Client2Controller::class, 'experienced_companies_edit']);
// マイページ経験企業
Route::get(Config::get('const.title.title48').'/user_account/experienced_companies/edit', [Client2Controller::class, 'experienced_companies_get']);
Route::post(Config::get('const.title.title48').'/user_account/experienced_companies/edit', [Client2Controller::class, 'experienced_companies_edit']);
// マイページ経験skill
Route::get(Config::get('const.title.title48').'/user_account/experienced_skill/edit', [Client2Controller::class, 'experienced_skill_get']);
Route::post(Config::get('const.title.title48').'/user_account/experienced_skill/edit', [Client2Controller::class, 'experienced_skill_edit']);
// マイページ希望条件
Route::get(Config::get('const.title.title48').'/user_account/desired_conditions/edit', [Client2Controller::class, 'desired_conditions_get']);
Route::post(Config::get('const.title.title48').'/user_account/desired_conditions/edit', [Client2Controller::class, 'desired_conditions_edit']);
// マイページ希望スキル
Route::get(Config::get('const.title.title48').'/user_account/desired_skills/edit', [Client2Controller::class, 'desired_skills_get']);
Route::post(Config::get('const.title.title48').'/user_account/desired_skills/edit', [Client2Controller::class, 'desired_skills_edit']);
// マイページこだわり条件
Route::get(Config::get('const.title.title48').'/user_account/user_conditions/edit', [Client2Controller::class, 'user_conditions_get']);
Route::post(Config::get('const.title.title48').'/user_account/user_conditions/edit', [Client2Controller::class, 'user_conditions_edit']);

//メイン
Route::get(Config::get('const.title.title48').'/main', [Client2Controller::class, 'main_page_view']);
Route::post(Config::get('const.title.title48').'/main', [Client2Controller::class, 'main_page_search']);

//検索結果
Route::get(Config::get('const.title.title48').'/search_list', [IssueController::class, 'search_list_page_view']);
//検索結果詳細
Route::get(Config::get('const.title.title48').'/search_detail/{id}', [IssueController::class, 'search_list_page_detail_view']);

////////////////////////////////////////////////////////////////////
//ユーザー応募
Route::post(Config::get('const.title.title48').'/search_detail/{id}', [IssueController::class, 'apply_issue_user']);

//ユーザー応募一覧取得
Route::get(Config::get('const.title.title48').'/user_account/user_apply', [Client2Controller::class, 'user_apply_all']);
//ユーザー応募見送り一覧取得
Route::get(Config::get('const.title.title48').'/user_account/user_apply_defeated', [Client2Controller::class, 'user_apply_defeated_all']);
//ユーザー応募案件詳細
Route::get(Config::get('const.title.title48').'/user_account/apply_issues_detail/{id}', [Client2Controller::class, 'user_apply_detail']);

//ユーザークライアント詳細
Route::get(Config::get('const.title.title48').'/client_detail/{id}', [Client2Controller::class, 'client_detail_detail']);

//メッセージ機能 
//メッセージ一覧表示
Route::get(Config::get('const.title.title48').'/'.'user_account/messages', [Client2Controller::class, 'message_user_all']);
//メッセージルーム
Route::get(Config::get('const.title.title48').'/'.'user_account/message/{id}', [Client2Controller::class, 'message_talk_room']);
Route::post(Config::get('const.title.title48').'/'.'user_account/message/{id}', [Client2Controller::class, 'message_talk_room_post']);






//パスワード変更
Route::get(Config::get('const.title.title48').'/user_account_password', function () {
    return view(Config::get('const.title.title48').'.user_account_password');
});
Route::post(Config::get('const.title.title48').'/user_account_password', [Client2Controller::class, 'client2_pass_edit']);



//クライアントページ//////////////////////////////////////////
Route::get(Config::get('const.title.title47'), function () {
    return view(Config::get('const.title.title47').'.index');
});
Route::post(Config::get('const.title.title47'), [Client1Controller::class, 'login']);

//パスワード再発行
Route::get(Config::get('const.title.title47').'/pass_forget', function () {
    return view(Config::get('const.title.title47').'.pass_forget');
});
Route::post(Config::get('const.title.title47').'/pass_forget', [Client1Controller::class, 'pass_reput']);

// Route::get(Config::get('const.title.title47').'/main', function () {
    
// });

//事前登録
Route::get(Config::get('const.title.title47').'/first_form', function () {
    return view(Config::get('const.title.title47').'.first_form');
});
Route::post(Config::get('const.title.title47').'/first_form', [Client1Controller::class, 'before_form']);

//本登録
Route::get(Config::get('const.title.title47').'/second_form', [Client1Controller::class, 'after_form_pre']);

Route::post(Config::get('const.title.title47').'/second_form', [Client1Controller::class, 'after_form']);

//アカウント閲覧
Route::get(Config::get('const.title.title47').'/'.'client_account', [Client1Controller::class, 'mypage_get']);

//基本情報
Route::get(Config::get('const.title.title47').'/'.'client_account/edit', [Client1Controller::class, 'account_get']);
Route::post(Config::get('const.title.title47').'/'.'client_account/edit', [Client1Controller::class, 'account_edit']);

//企業情報情報
Route::get(Config::get('const.title.title47').'/'.'client_account/self_introduction/edit', [Client1Controller::class, 'account_get_2']);
Route::post(Config::get('const.title.title47').'/'.'client_account/self_introduction/edit', [Client1Controller::class, 'account_edit_2']);


//案件一覧
Route::get(Config::get('const.title.title47').'/'.'client_account/my_all_issues', [IssueController::class, 'my_all_issues_page']);

//案件詳細
Route::get(Config::get('const.title.title47').'/'.'client_account/my_issues_detail/{id}', [IssueController::class, 'my_issues_detail_page']);
Route::post(Config::get('const.title.title47').'/'.'client_account/my_issues_detail/{id}', [IssueController::class, 'my_issues_detail_delete']);



//案件作成
Route::get(Config::get('const.title.title47').'/'.'client_account/create_issues', [IssueController::class, 'create_issues_page']);
//確認ページへ
Route::post(Config::get('const.title.title47').'/'.'client_account/create_issues', [IssueController::class, 'create_issues_page_post']);
//確認ページ
Route::get(Config::get('const.title.title47').'/'.'client_account/create_issues/confirmation', [IssueController::class, 'create_issues_confirmation']);
//登録
Route::post(Config::get('const.title.title47').'/'.'client_account/create_issues/confirmation', [IssueController::class, 'create_issues_confirmation_post']);

//案件編集
Route::get(Config::get('const.title.title47').'/'.'client_account/edit_issues/{id}', [IssueController::class, 'edit_issues_page']);
//確認ページへ
Route::post(Config::get('const.title.title47').'/'.'client_account/edit_issues/{id}', [IssueController::class, 'edit_issues_page_post']);
//確認ページ
Route::get(Config::get('const.title.title47').'/'.'client_account/edit_issues/confirmation/{id}', [IssueController::class, 'edit_issues_confirmation']);
//登録
Route::post(Config::get('const.title.title47').'/'.'client_account/edit_issues/confirmation/{id}', [IssueController::class, 'edit_issues_confirmation_post']);


//案件応募一覧
Route::get(Config::get('const.title.title47').'/'.'client_account/apply_issue', [IssueController::class, 'apply_issue_all_get']);
//案件応募 応募者一覧
Route::get(Config::get('const.title.title47').'/'.'client_account/issue_apply_user/{id}', [IssueController::class, 'issue_apply_user']);

//応募者合否、お気に入り、選定
Route::post(Config::get('const.title.title47').'/'.'client_account/issue_apply_user/{id}', [IssueController::class, 'issue_apply_user_judge_select']);


//応募者詳細ページ
Route::get(Config::get('const.title.title47').'/'.'client_account/user_detail/{id}', [Client1Controller::class, 'apply_user_detail']);
Route::post(Config::get('const.title.title47').'/'.'client_account/user_detail/{id}', [Client1Controller::class, 'apply_user_detail_post']);


//メッセージ機能 
//メッセージ一覧表示
Route::get(Config::get('const.title.title47').'/'.'client_account/messages', [Client1Controller::class, 'message_user_all']);
Route::post(Config::get('const.title.title47').'/'.'client_account/messages', [Client1Controller::class, 'administrator_message_room_create']);
//メッセージルーム
Route::get(Config::get('const.title.title47').'/'.'client_account/message/{id}', [Client1Controller::class, 'message_talk_room']);
Route::post(Config::get('const.title.title47').'/'.'client_account/message/{id}', [Client1Controller::class, 'message_talk_room_post']);
//メッセージルーム管理者
Route::get(Config::get('const.title.title47').'/'.'client_account/mg_message/{id}', [Client1Controller::class, 'mg_message_talk_room']);
Route::post(Config::get('const.title.title47').'/'.'client_account/mg_message/{id}', [Client1Controller::class, 'mg_message_talk_room_post']);

//人材選定 契約締結
Route::get(Config::get('const.title.title47').'/'.'client_account/contract_form/{id}', [Client1Controller::class, 'contract_form_view']);
//sessionに保持 確認ペジーへ
Route::post(Config::get('const.title.title47').'/'.'client_account/contract_form/{id}', [Client1Controller::class, 'contract_form_session']);
//確認ページ
Route::get(Config::get('const.title.title47').'/'.'client_account/contract_form_confirmation/{id}', [Client1Controller::class, 'contract_form_confirmation_view']);
//契約DB保存
Route::post(Config::get('const.title.title47').'/'.'client_account/contract_form_confirmation/{id}', [Client1Controller::class, 'contract_form_post']);

//契約情報
//契約一覧取得
Route::get(Config::get('const.title.title47').'/'.'client_account/my_contracts_all', [Client1Controller::class, 'all_contracts_get']);
//人材稼働確認一覧
Route::get(Config::get('const.title.title47').'/'.'client_account/user_confirmation', [Client1Controller::class, 'contracts_user_confirmation']);

//人材稼働確認answer(get)
Route::get(Config::get('const.title.title47').'/'.'client_account/user_confirmation_check/{id}', [Client1Controller::class, 'contracts_user_confirmation_check']);
//人材稼働確認　確認画面&session
Route::post(Config::get('const.title.title47').'/'.'client_account/user_confirmation_check/{id}', [Client1Controller::class, 'contracts_user_confirmation_check_post']);
//人材稼働確認がめん
Route::get(Config::get('const.title.title47').'/'.'client_account/contracts_user_judge_confirmation_view/', [Client1Controller::class, 'contracts_user_judge_confirmation_view']);
//人材稼働確認登録
Route::post(Config::get('const.title.title47').'/'.'client_account/contracts_user_judge_confirmation_view/', [Client1Controller::class, 'contracts_user_judge_confirmation_view_post']);

//支払関係
Route::get(Config::get('const.title.title47').'/'.'client_account/payment', [Client1Controller::class, 'contracts_payment']);
//支払処理
Route::post(Config::get('const.title.title47').'/'.'client_account/payment', [Client1Controller::class, 'charge_payment']);
//支払完了一覧
Route::get(Config::get('const.title.title47').'/'.'client_account/payment_completion', [Client1Controller::class, 'contracts_payment_completion']);
//領収書発行
Route::post(Config::get('const.title.title47').'/'.'client_account/payment_completion', [Client1Controller::class, 'payment_completion_receipt']);

Route::get(Config::get('const.title.title47').'/'.'client_account/test_pdf', [Client1Controller::class, 'test_pdf']);


//パスワード変更
Route::get(Config::get('const.title.title47').'/client_account_password', [Client1Controller::class, 'client_account_password']);
Route::post(Config::get('const.title.title47').'/client_account_password', [Client1Controller::class, 'client_account_password_post']);

//ログアウト
Route::get(Config::get('const.title.title47').'/logout', [Client1Controller::class, 'client1_logout']);

//案件
Route::get(Config::get('const.title.title47').'/matter', [MatterController::class, 'client1_index']);
Route::get(Config::get('const.title.title47').'/matter_detail/{id}', [MatterController::class, 'client1_index_detail']);

Route::get(Config::get('const.title.title47').'/matter_state/{id}', [MatterstateController::class, 'index']);
Route::post(Config::get('const.title.title47').'/matter_state/{id}', [MatterstateController::class, 'client1_finish']);


//案件作成
Route::get(Config::get('const.title.title47').'/create_matter', [MatterController::class, 'matter_format']);
Route::post(Config::get('const.title.title47').'/create_matter_confirm', [MatterController::class, 'create_matter']);
Route::get(Config::get('const.title.title47').'/create_matter_confirm', function () {
    return view(Config::get('const.title.title47').'.create_matter_confirm');
});
Route::post(Config::get('const.title.title47').'/create_matter', [MatterController::class, 'create_matter_confirm']);

//案件進行
Route::get(Config::get('const.title.title47').'/matter_state_detail/{id}', [MatterstateController::class, 'client1_matterstate']);
Route::post(Config::get('const.title.title47').'/matter_state_detail/{id}', [MatterstateController::class,'client1_post']);

//アンケート結果確認
Route::get(Config::get('const.title.title47').'/matter_questionaire/{id}', [MatterstateController::class, 'question_result']);

//報告フォーマット
Route::get(Config::get('const.title.title47').'/'.Config::get('const.title.title47').'_form_before', [MatterController::class, 'client1_index2']);
Route::get(Config::get('const.title.title47').'/'.Config::get('const.title.title47').'_form/{id}', [MatterstateController::class, 'client1_format']);

//運営者へのチャット

Route::get(Config::get('const.title.title47').'/chat_admin', [ContactController::class, 'index_admin']);
Route::post(Config::get('const.title.title47').'/chat_admin', [ContactController::class, 'to_admin']);

//ログアウト
Route::get('/logout', function () {
    return view('logout');
});

//プライ倍―ポリシー
Route::get('content/privacy_policy', function () {
    return view('content.privacy_policy');
});
//規約
Route::get('content/service_terms', function () {
    return view('content.service_terms');
});
