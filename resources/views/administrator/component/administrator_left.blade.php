<link rel="stylesheet" href="{{ asset('css/mypage_left.css')}}"> 
<style>
  .menu_div {background: #00CC00;}
  .menu_div.active {background: #00CC00;}
  .shutdown.icon:before {
  border-left: solid 3px #00CC00;
  border-right: solid 3px #00CC00;
}
.chat.icon:before {
  background-color: #00CC00;
}
</style>

<div id="left_shadow" class="left_shadow"></div>
<div id="box_left" class="menu_div">
  
  <div class="menu_bar">
    <div class="menu_title">
      <a href="{{ asset(config('const.title.title49'))}}/main" class="menu_title_a">HOME</a>
    </div>

    <ul class="menu_bar_ul">
      <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <!-- <div class="eye icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title49'))}}/account_all" class="menu_a">管理者ページ</a>
          </div>     
        </div>
      </li>

      
      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <!-- <div class="profile icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title49'))}}/user_account">ユーザー情報</a>
          </div>
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <!-- <div class="chat icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title49'))}}/company_account">クライアント情報</a>
          </div>
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <!-- <div class="clock icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title49'))}}/all_issue">案件情報</a>
          </div>
  
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <!-- <div class="chat icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title49'))}}/all_contacts">人材契約情報</a>
          </div>
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <!-- <div class="chat icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title49'))}}/all_payment">支払情報</a>
          </div>
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <!-- <div class="chat icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title49'))}}/messages">メッセージ一覧</a>
          </div>
        </div>
      </li>

      <!-- <li class="menu_li">
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
            <li class="sub_menu_li"><a class="sub_menu_a">パスワード設定</a></li>
            <li class="sub_menu_li"><a class="sub_menu_a">メルマガ設定</a></li>
          </ul>
        </div>
      </li> -->

      <li class="menu_li menu_last_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <!-- <div class="shutdown icon"></div> -->
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title49'))}}/logout" class="menu_a">ログアウト</a>
          </div>
        </div>

      </li>
    </ul>
  </div>
</div>



