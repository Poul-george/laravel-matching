<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
  {{-- <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet"> --}}
  <link href="{{ secure_asset('/css/confirm.css') }}" rel="stylesheet">
  <title>{{config('const.title.title28')}}（確認）</title>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  {{-- @include('client1.component.header') --}}
  <h3>{{config('const.title.title28')}}（確認）</h3>

  @if (session('msgs'))
    <p class="error">{{session('msgs')}}</p>
  @endif

  <form class="questionnaire_form" action="./create_matter" method="post" enctype="multipart/form-data">
    @csrf

    <p class="confirm_title">企業名（店舗名）</p>
    <p class="confirm_text">{{$param['shop_name']}}</p>
    <input type="hidden" name="name" value="{{$param['shop_name']}}">


    <p class="confirm_title">ご担当者名</p>
    <p class="confirm_text">{{$param['shop_tantou']}}</p>
    <input type="hidden" name="tantou" value="{{$param['shop_tantou']}}">


    <p class="confirm_title">ご連絡先(電話番号)</p>
    <p class="confirm_text">{{$param['shop_phone']}}</p>
    <input type="hidden" name="tel01" value="{{$param['shop_phone']}}">


    <p class="confirm_title">郵便番号</p>
    <p class="confirm_text">{{$param['shop_area']}}</p>
    <input type="hidden" name="area" value="{{$param['shop_area']}}">

    <p class="confirm_title">所在地</p>
    <p class="confirm_text">{{$param['shop_address']}}</p>
    <input type="hidden" name="address" value="{{$param['shop_address']}}">

    <p class="confirm_title">URL</p>
    <p class="confirm_text">{{$param['shop_url']}}</p>
    <input type="hidden" name="shop_url" value="{{$param['shop_url']}}">

    <p class="confirm_title">定休日・店休日</p>
    <p class="confirm_text">{{$param['shop_close_date']}}</p>
    <input type="hidden" name="close_date" value="{{$param['shop_close_date']}}">

    <p class="confirm_title">営業時間</p>
    <p class="confirm_text">{{$param['shop_open_time']}}</p>
    <input type="hidden" name="open_time" value="{{$param['shop_open_time']}}">





    <div class="space_div" ></div>

    <input type="hidden" name="hidden" value="client">
    <div class="submit_confirm">
        <input class="input_submit" type="submit" name="submit1" value="再入力">
        <input class="input_submit" type="submit" name="submit2" value="登録">
    </div>

  </form>

</body>

<script type="text/javascript">
  $('#attachment1 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment1').find('.filename').text(file.name);
   });
  $('#attachment2 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment2').find('.filename').text(file.name);
   });
  $('#attachment3 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment3').find('.filename').text(file.name);
   });
  $('#attachment4 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment4').find('.filename').text(file.name);
   });
  $('#attachment5 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment5').find('.filename').text(file.name);
   });

   function Check_checkbox() {
	var checkbox1 = document.getElementById("genre-1");
	var checkbox2 = document.getElementById("box-1");
	var checkbox3 = document.getElementById("term-1");
	var checkbox4 = document.getElementById("notice-1");

    if (checkbox1.classList.contains('check_once')){
        var arr_checkBoxes = document.getElementsByClassName("check_once");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
        } else {
            window.alert("ジャンル・カテゴリの項目を1つ以上選択してください。");
            return false;
        }
    }
    if (checkbox2.classList.contains('check_once1')){

        var arr_checkBoxes = document.getElementsByClassName("check_once1");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
        } else {
            window.alert("投稿SNSの項目を1つ以上選択してください。");
            return false;
        }
    }
    if (checkbox3.classList.contains('check_once2')){
        var arr_checkBoxes = document.getElementsByClassName("check_once2");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
        } else {
            window.alert("投稿条件の項目を1つ以上選択してください。");
            return false;
        }
    }
    if (checkbox4.classList.contains('check_once3')){
        var arr_checkBoxes = document.getElementsByClassName("check_once3");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
            return true;
        } else {
            window.alert("投稿に関する注意事項の項目を1つ以上選択してください。");
            return false;
        }
    }
}
</script>

</html>


