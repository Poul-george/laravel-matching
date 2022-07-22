<?php
function insertStr1($text, $insert, $num){
  return substr_replace($text, $insert, $num, 0);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>案件応募一覧</title>
        <script type="text/javascript" src="{{ asset('js/jquery.inview.min.js')}}"></script>
    </head>
    <style>

      .main_div {
        margin-top:60px;
      }
      .main_div.active {
        background: rgb(248, 252, 255);
      }
    </style>

    <body>
    @include('client2.component.header')
    @include('client2.component.mypage_left')
        
        <div class="main_div" id="main_div">

        @if (session('msgs'))
              <p class="error">{{session('msgs')}}</p>
            @endif

            <div class="return_page_div">
              <a class="return_a" href="{{ asset(config('const.title.title48'))}}/user_account/user_apply">応募一覧に戻る</a>
            </div>


            @include('client2.component.user_issue_detail')


        </div>
    </body>
    @include('client1.component.footer')
</html>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/main_page.js')}}"></script>