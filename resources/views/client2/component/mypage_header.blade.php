<?php
  $user_id=session()->get("user_id");
  $user_name=session()->get("user_name");
  $url_num = url()->current();
?>


@if (session()->has("user_id") && session()->has("user_name"))

@else
    <script>window.location = "/client2";</script>
@endif
<link rel="stylesheet" href="{{ asset('css/mypage_header.css')}}"> 
<link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css')}}"> 
<script type="text/javascript" src="{{ asset('js/perfect-scrollbar.js')}}"></script>
<script>
  var ps = new PerfectScrollbar('.menu_div');
</script>


<header class="mypage_header">
  <div class="mypage_header_div">
    <div id="mypage_menu" class="mypage_menu">
      <div class="menu icon"></div>
    </div>
    <div class="mypage_search_div">
      <div class="mypage_search">
         <div class="search_icon_p_div">
            <a class="message_box_one_a" href="{{ asset(config('const.title.title48'))}}/main#search">
              <div class="search icon"></div>
            </a>
          </div>
          <div class="message_icon_p_div_user">
            @if ($new_messages !== 0)
            <p class="message_count_p_user">{{$new_messages}}</p>
            @endif
            
            <a class="message_box_one_a" href="{{ asset(config('const.title.title48'))}}/user_account/messages">
              <div class="message icon"></div>
            </a>
          </div>
        <div id="user_icon_div" class="user_icon_div">
          @if ($user_image === null || $user_image === "")  
              <img class="user_img" src="{{asset('template_img/face_blue.png')}}"/>
          @else
              <img class="user_img" src="{{asset('user_images/' . $user_image )}}"/>
          @endif
          <p class="user_name_p">{{$name1}} {{$name2}}</p>
        </div>
      </div>
    </div>

    <div id="user_operate_div" class="user_operate_div">
      <div class="user_one_operate_div1">
        <div class="operate_i"><i class="gg-globe-alt"></i></div>
        <div class="operate_text"><p class="user_operate_p">設定</p></div>
      </div>
      <div class="user_one_operate_div2">
        <div class="operate_i"><i class="gg-list"></i></div>
        <div class="operate_text"><p class="user_operate_p">よくあるご質問</p></div>
      </div>
      <div class="user_one_operate_div3">
        <div class="operate_i"><i class="gg-info"></i></div>
        <div class="operate_text"><p class="user_operate_p">ヘルプ</p></div>
      </div>
      <a href="{{ asset(config('const.title.title48'))}}/logout" style="text-decoration: none;color:#000;" >
        <div class="user_one_operate_div4">
            <div class="operate_i"><i class="gg-log-out"></i></div>
            <div class="operate_text"><p style="margin-top: -3px;" class="user_operate_p">ログアウト</p></div>
        </div>
      </a>
    </div>
  </div>
</header>

