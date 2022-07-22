<?php
  $user_id=session()->get("user_id");
  $user_name=session()->get("user_name");
  $url_num = url()->current();
?>

<link rel="stylesheet" href="{{ asset('css/mypage_left.css')}}"> 

<div id="left_shadow" class="left_shadow"></div>
<div id="box_left" class="menu_div">
  
  <div class="menu_bar">
    <div class="menu_title">
      <a href="{{ asset(config('const.title.title48'))}}/main" class="menu_title_a">longmatch</a>
    </div>

    <ul class="menu_bar_ul">
      @if (empty($user_id))

      <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title48'))}}" class="menu_a">ログイン</a>
          </div>     
        </div>

      </li>

      <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title48'))}}/first_form" class="menu_a">新規登録</a>
          </div>     
        </div>

      </li>

      @else
      <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <div class="eye icon"></div>
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title48'))}}/user_account" class="menu_a">マイページ</a>
          </div>     
        </div>

      </li>

      <li class="menu_li">
        <div class="icon_flex_div sub_menu_have">
          <div class="icon_div">
            <div class="profile icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a">プロフィール編集</a>
          </div>
  
          <div class="purasu_icon">＋</div>
        </div>

        <div class="sub_menu_div">
          <ul class="sub_menu_ul">
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/edit" class="sub_menu_a">基本情報</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/self_introduction/edit" class="sub_menu_a">自己紹介</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/biography_works/edit" class="sub_menu_a">経歴・作新</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/experienced_companies/edit" class="sub_menu_a">経験企業</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/experienced_skill/edit" class="sub_menu_a">経験スキル</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/desired_conditions/edit" class="sub_menu_a">希望条件</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/desired_skills/edit" class="sub_menu_a">希望スキル等</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/user_conditions/edit" class="sub_menu_a">こだわり条件</a></li>
          </ul>
        </div>
      </li>
      
      <!-- <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <div class="profile icon"></div>
            <div class="check icon"></div>
          </div>
          <div class="menu_bar_content">
            <a href="" class="menu_a">スカウト一覧</a>
          </div>     
        </div>

      </li> -->
      
      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <div class="chat icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title48'))}}/user_account/messages">メッセージ一覧</a>
          </div>
        </div>
      </li>
      <li class="menu_li">
        <div class="icon_flex_div sub_menu_have">
          <div class="icon_div">
            <div class="clock icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a">応募状況</a>
          </div>
  
          <div class="purasu_icon">＋</div>
        </div>

        <div class="sub_menu_div">
          <ul class="sub_menu_ul">
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/user_apply" class="sub_menu_a">応募履歴一覧</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account/user_apply_defeated" class="sub_menu_a">落選した応募</a></li>
          </ul>
        </div>
      </li>
      <li class="menu_li">
        <div class="icon_flex_div sub_menu_have">
          <div class="icon_div">
            <div class="browser icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a">設定</a>
          </div>
  
          <div class="purasu_icon">＋</div>
        </div>

        <div class="sub_menu_div">
          <ul class="sub_menu_ul">
            <li class="sub_menu_li"><a class="sub_menu_a">メッセージ設定</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title48'))}}/user_account_password" class="sub_menu_a">パスワード設定</a></li>
            <li class="sub_menu_li"><a class="sub_menu_a">メルマガ設定</a></li>
          </ul>
        </div>
      </li>
      <li class="menu_li menu_last_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <div class="shutdown icon"></div>
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title48'))}}/logout" class="menu_a">ログアウト</a>
          </div>
        </div>

      </li>

      @endif
    </ul>
  </div>
</div>



