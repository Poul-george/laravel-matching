<?php
  $shop_id=session()->get("shop_id");
  $shop_name=session()->get("shop_name");

?>


@if (session()->has("shop_id") && session()->has("shop_name"))

@else
    <script>window.location = "/client1";</script>
@endif

<link href="{{asset ('css/header2.css') }}" rel="stylesheet">
<style>

        
    </style>

<div class="pageWrapper">
    <div class="login_logo">
        <img src="{{asset('template_img/ITシステム-長期運用案件マッチング.com_透過ロゴ.png')}}" alt="logo" class="site_logo">
    </div>
    <div id="openbtn4" class="openbtn4"><span></span><span></span><span></span></div>
</div>
<script language="javascript" type="text/javascript">

let btn = document.getElementById('openbtn4');
btn.addEventListener('click', function() {
    if (btn.classList.contains('active')) {
        btn.classList.remove('active');
    } else {
        btn.classList.add('active');
    }
  
    console.log(btn);
}, false);

</script>

