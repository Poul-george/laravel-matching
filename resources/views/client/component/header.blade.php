<?php
  $shop_id=session()->get("shop_id");
  $shop_name=session()->get("shop_name");


  $filename="laravel/public/storage/shop_img/shop_img-$shop_id";
  if (file_exists("$filename.png")){
      $filename="$filename.png";
  }
  elseif (file_exists("$filename.jpeg")){
      $filename="$filename.jpeg";
  }
  elseif (file_exists("$filename.jpg")){
      $filename="$filename.jpg";
  }else{
      $filename="template_img/face_blue.png";
  }
?>


@if (session()->has("shop_id") && session()->has("shop_name"))

@else
    <script>window.location = "/client";</script>
@endif
<nav class="nav_bar">

    <div class="header_box_1">
        <li>
            <div class="header_left">
                <a href="javascript:OnLinkClick();" class="dropdown_btn" id="dropdown_btn">
                    <div id="humberger">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </a><br>
                <a href="javascript:void(0);" onclick="history.back();" class="prevpage">前のページに戻る</a>
            </div>

            <div class="menu_dropdown" id="menu_dropdown">
                {{-- <div class="menubar_center">
                    <p>{{config('const.title.title0')}}</p>
                </div> --}}
                <ul class="menu_list">
                    <li class="menu_item"><a href="/client/main">{{config('const.title.title1')}}</a></li>
                    <li class="menu_item"><a href="/client/create_matter">{{config('const.title.title28')}}</a></li>
                    <li class="menu_item"><a href="/client/matter">{{config('const.title.title24')}}</a></li>
                    <li class="menu_item"><a href="/client/client_form_before">{{config('const.title.title27')}}</a></li>
                    <li class="menu_item"><a href="/client/chat_admin">{{config('const.title.title25')}}</a></li>
                </ul>
            </div>
        </li>
    </div>
    <div class="header_box_2">
        <li>
            <a href="javascript:OnLinkClick_2();" class="dropdown_btn" id="dropdown_btn_2">
                <img src="{{ asset($filename)}}" alt="face" class="face_img">
            </a>
            <div class="face_dropdown" id="face_dropdown">
                <ul class="face_list">

                    <div class="profile icon"></div><li class="face_item">{{$shop_name}}様</li>
                    <div class="profile_link"><a href="/client/client_account"><li class="">プロフィール情報・編集</li></div>
                    <div class="logout_icon"></div><li class="face_item"><a href="/logout">{{config('const.title.title33')}}</a></li>
                </ul>
            </div>
        </li>
    </div>

</nav>
<script language="javascript" type="text/javascript">


    function OnLinkClick(){
        const face = document.getElementById('menu_dropdown');
        face.classList.toggle('is-open');
        face.classList.toggle('menu_dropdown');
    }
    function OnLinkClick_2(){
        const face = document.getElementById('face_dropdown');
        face.classList.toggle('is-open_2');
        face.classList.toggle('face_dropdown');
    }

</script>

