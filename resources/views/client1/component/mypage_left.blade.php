<link rel="stylesheet" href="{{ asset('css/mypage_left.css')}}"> 
<link rel="stylesheet" href="{{ asset('css/mypage_left2.css')}}"> 

<div id="left_shadow" class="left_shadow"></div>
<div id="box_left" class="menu_div">
  
  <div class="menu_bar">
    <div class="menu_title">
      <a href="" class="menu_title_a">Cname</a>
    </div>

    <ul class="menu_bar_ul">
      <li class="menu_li">
        <div class="icon_flex_div">
          <div class="icon_div">
            <div class="eye icon"></div>
          </div>
          <div class="menu_bar_content">
            <a href="{{ asset(config('const.title.title47'))}}/client_account" class="menu_a">マイページ</a>
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
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/edit" class="sub_menu_a">基本情報</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/self_introduction/edit"  class="sub_menu_a">特徴・会社紹介</a></li>
          </ul>
        </div>
      </li>
      
      <li class="menu_li">
        <div class="icon_flex_div ">
          <div class="icon_div">
            <div class="chat icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a" href="{{ asset(config('const.title.title47'))}}/client_account/messages">メッセージ一覧</a>
          </div>
          <!-- <div class="purasu_icon">＋</div> -->
        </div>

      </li>

      <li class="menu_li">
        <div class="icon_flex_div sub_menu_have">
          <div class="icon_div">
            <div class="clock icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a">案件状況</a>
          </div>
  
          <div class="purasu_icon">＋</div>
        </div>

        <div class="sub_menu_div">
          <ul class="sub_menu_ul">
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/create_issues"  class="sub_menu_a">案件作成</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/my_all_issues"  class="sub_menu_a">案件履歴一覧</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/apply_issue" class="sub_menu_a">応募状況</a></li>
          </ul>
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div sub_menu_have">
          <div class="icon_div">
            <div class="profile icon"></div>
            <div class="check icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a">契約情報</a>
          </div>
  
          <div class="purasu_icon">＋</div>
        </div>

        <div class="sub_menu_div">
          <ul class="sub_menu_ul">
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/my_contracts_all"  class="sub_menu_a">契約一覧</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/user_confirmation"  class="sub_menu_a">人材稼働確認</a></li>
          </ul>
        </div>
      </li>

      <li class="menu_li">
        <div class="icon_flex_div sub_menu_have">
          <div class="icon_div">
            <div class="card icon"></div>
          </div>
          <div class="menu_bar_content">
            <a class="menu_a">支払情報</a>
          </div>
  
          <div class="purasu_icon">＋</div>
        </div>

        <div class="sub_menu_div">
          <ul class="sub_menu_ul">
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/payment"  class="sub_menu_a">支払いをする</a></li>
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account/payment_completion"  class="sub_menu_a">支払完了情報</a></li>
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
            <li class="sub_menu_li"><a href="{{ asset(config('const.title.title47'))}}/client_account_password" class="sub_menu_a">パスワード設定</a></li>
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
            <a href="{{ asset(config('const.title.title47'))}}/logout" class="menu_a">ログアウト</a>
          </div>
        </div>

      </li>
    </ul>
  </div>
</div>



