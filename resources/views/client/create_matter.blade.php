<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
  {{-- <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet"> --}}
  <link href="{{ secure_asset('/css/form.css') }}" rel="stylesheet">
  <title>{{config('const.title.title28')}}</title>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  {{-- @include('client.component.header') --}}
  <h3>{{config('const.title.title28')}}</h3>

  @if (session('msgs'))
    <p class="error">{{session('msgs')}}</p>
  @endif

  <form class="questionnaire_form" action="./create_matter_confirm" method="post" enctype="multipart/form-data">
    @csrf

    @if ($item_config->client_name==="T")
        <p class="questionnaire_input_p">企業名（店舗名）<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="name" value="{{$param['shop_name']}}" required>
    @else
        <p class="questionnaire_input_p">企業名（店舗名）</p>
        <input class="input_text" type="text" name="name" value="{{$param['shop_name']}}">
    @endif

    @if ($item_config->client_tantou==="T")
        <p class="questionnaire_input_p">ご担当者名<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="tantou" value="{{$param['shop_tantou']}}" required>
    @else
        <p class="questionnaire_input_p">ご担当者名</p>
        <input class="input_text" type="text" name="tantou" value="{{$param['shop_tantou']}}">
    @endif

    @if ($item_config->client_mail==="T")
        <p class="questionnaire_input_p">ご連絡先(電話番号)<small class="hissu">※必須</small></p>
        <input class="input_text" type="tel" name="tel01" value="{{$param['shop_phone']}}" required>
    @else
        <p class="questionnaire_input_p">ご連絡先(電話番号)</p>
        <input class="input_text" type="tel" name="tel01" value="{{$param['shop_phone']}}">
    @endif

    @if ($item_config->client_area==="T")
        <p class="questionnaire_input_p">郵便番号 (例 100-0000 or 1000000)<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="area" value="{{$param['shop_area']}}" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" required>
    @else
        <p class="questionnaire_input_p">郵便番号 (例 100-0000 or 1000000)</p>
        <input class="input_text" type="text" name="area" value="{{$param['shop_area']}}" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');">
    @endif

    @if ($item_config->client_address==="T")
        <p class="questionnaire_input_p">所在地<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="address" value="{{$param['shop_address']}}" size="60" required>
    @else
        <p class="questionnaire_input_p">所在地</p>
        <input class="input_text" type="text" name="address" value="{{$param['shop_address']}}" size="60">
    @endif

    @if ($item_config->client_url==="T")
        <p class="questionnaire_input_p">URL<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="shop_url" value="{{$param['shop_url']}}" required>
    @else
        <p class="questionnaire_input_p">URL</p>
        <input class="input_text" type="text" name="shop_url" value="{{$param['shop_url']}}">
    @endif

    @if ($item_config->close_date==="T")
        <p class="questionnaire_input_p">定休日・店休日<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="close_date" value="{{$param['shop_close_date']}}" required>
    @else
        <p class="questionnaire_input_p">定休日・店休日</p>
        <input class="input_text" type="text" name="close_date" value="{{$param['shop_close_date']}}">
    @endif

    @if ($item_config->open_time==="T")
        <p class="questionnaire_input_p">営業時間<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="open_time" value="{{$param['shop_open_time']}}" required>
    @else
        <p class="questionnaire_input_p">営業時間</p>
        <input class="input_text" type="text" name="open_time" value="{{$param['shop_open_time']}}">
    @endif






    <div class="space_div" ></div>

    <input type="hidden" name="hidden" value="client">
    <input class="input_submit" type="submit" onClick="Check_checkbox()" value="登録">

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


