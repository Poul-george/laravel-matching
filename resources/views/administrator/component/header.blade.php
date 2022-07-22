<?php
  $manager_id=session()->get("manager_id");
  $manager_name=session()->get("manager_name");
?>

@if (session()->has("manager_id") && session()->has("manager_name"))

@else
    <script>window.location = "/administrator";</script>
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
                    <li class="menu_item"><a href="/administrator/main">{{config('const.title.title1')}}</a></li>
                    <li class="menu_item"><a href="/administrator/admin_{{config('const.title.title48')}}">{{config('const.title.title2')}}</a></li>
                    <li class="menu_item"><a href="/administrator/admin_{{config('const.title.title47')}}">{{config('const.title.title3')}}</a></li>
                    <li class="menu_item"><a href="/administrator/matter">{{config('const.title.title4')}}</a></li>
                    <li class="menu_item"><a href="/administrator/admin_config_main">{{config('const.title.title5')}}</a></li>
                    <li class="menu_item"><a href="/administrator/admin_matter_shopby">{{config('const.title.title6')}}</a></li>
                    <li class="menu_item"><a href="/administrator/admin_create">{{config('const.title.title7')}}</a></li>
                    <li class="menu_item"><a href="/administrator/chat">{{config('const.title.title8')}}</a></li>
                    <li class="menu_item"><a href="/administrator/payment">{{config('const.title.title37')}}</a></li>
                    <li class="menu_item"><a href="/administrator/payment_{{config('const.title.title48')}}">{{config('const.title.title41')}}</a></li>
                </ul>
            </div>
        </li>
    </div>
    <div class="header_box_2">
        <li>
            <a href="javascript:OnLinkClick_2();" class="dropdown_btn" id="dropdown_btn_2">
                <img src="{{ asset('template_img/face_green.png')}}" alt="face" class="face_img">
            </a>
            <div class="face_dropdown" id="face_dropdown">
                <ul class="face_list">

                    <div class="profile icon"></div><li class="face_item">{{$manager_name}}様</li>
                    <div class="profile_link"><a href="/administrator/admin_account_edit"><li class="">{{config('const.title.title43')}}</li></div>
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

