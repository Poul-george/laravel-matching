<?php
  $manager_id=session()->get("manager_id");
  $manager_name=session()->get("manager_name");
  $url_return=session()->get("url_return");
  $url_num = url()->current();
  $url_rtn = url()->previous();
  $url_now = session()->get("url_now");
  if ($url_num !== $url_now) {
    session()->put('url_now', $url_num);
    session()->put('url_return', $url_rtn);
  }

  // var_dump($url_num);
  // var_dump($url_rtn);
  // var_dump($url_return);
?>


@if (session()->has("manager_id") && session()->has("manager_name"))

@else
    <script>window.location = "/administrator";</script>
@endif
<link rel="stylesheet" href="{{ asset('css/mypage_header.css')}}"> 
<link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css')}}"> 
<style>

</style>
<script type="text/javascript" src="{{ asset('js/perfect-scrollbar.js')}}"></script>
<script>
  var ps = new PerfectScrollbar('.menu_div');
</script>

<!-- <a href="{{$url_rtn}}">戻る</a> -->


<header class="mypage_header">
  <div class="mypage_header_div">
    <div id="mypage_menu" class="mypage_menu">
      <div class="menu icon"></div>
    </div>
    <div class="mypage_search_div">
      <div class="mypage_search">
          <div class="message_icon_p_div_user">
          @if ($new_messages !== 0)
            <p class="message_count_p_user" style="background: #00CC00;">{{$new_messages}}</p>
            @endif
            <a class="message_box_one_a" href="{{ asset(config('const.title.title49'))}}/messages">
              <div class="message icon"></div>
            </a>
          </div>
        <div id="user_icon_div" class="user_icon_div">
              <img class="user_img" src="{{asset('template_img/face_green.png')}}"/>
          <p class="user_name_p">{{$manager_name}}</p>
        </div>
      </div>
    </div>

    <div id="user_operate_div" class="user_operate_div">
      <!-- <div class="user_one_operate_div1">
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
      </div> -->
      <a href="{{ asset(config('const.title.title49'))}}/logout" style="text-decoration: none;color:#000;" >
        <div class="user_one_operate_div4">
          <div class="operate_i"><i class="gg-log-out"></i></div>
          <div class="operate_text"><p style="margin-top: -3px;" class="user_operate_p">ログアウト</p></div>
        </div>
      </a>
    </div>
  </div>
</header>

