<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
  {{-- <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet"> --}}
  <link href="{{ secure_asset('/css/confirm.css') }}" rel="stylesheet">
  <title>{{config('const.title.title28')}}（確認）</title>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  {{-- @include('client.component.header') --}}
  <h3>{{config('const.title.title28')}}（確認）</h3>

  @if (session('msgs'))
    <p class="error">{{session('msgs')}}</p>
  @endif

  <form class="questionnaire_form" action="./create_matter" method="post" enctype="multipart/form-data">
    @csrf

    <p class="confirm_title">{{config('const.title.title3')}}ID</p>
    <p class="confirm_text">{{$param['shop_id']}}</p>
    <input type="hidden" name="shop_id" value="{{$param['shop_id']}}">

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


    <p class="confirm_title">募集期間</p>
    <p class="confirm_text">{{$param['year1']}}-{{$param['month1']}}-{{$param['date1']}} ～ {{$param['year2']}}-{{$param['month2']}}-{{$param['date2']}}</p>
    <input type="hidden" name="year1" value="{{$param['year1']}}">
    <input type="hidden" name="month1" value="{{$param['month1']}}">
    <input type="hidden" name="date1" value="{{$param['date1']}}">
    <input type="hidden" name="year2" value="{{$param['year2']}}">
    <input type="hidden" name="month2" value="{{$param['month2']}}">
    <input type="hidden" name="date2" value="{{$param['date2']}}">

    <p class="confirm_title">ジャンル・カテゴリ</p>
    <ul class="confirm_checkbox">
        @foreach ($checkbox as $key=>$value)
            <li>{{$matter_genre[$value]}}</li>
        @endforeach
    </ul>
    @foreach ($checkbox as $value)
        <input type="hidden" name="checkbox[]" value="{{$value}}">
    @endforeach


    <p class="confirm_title">店舗紹介文</p>
    <p class="confirm_text">{{$param['intro_text']}}</p>
    <input type="hidden" name="intro_text" value="{{$param['intro_text']}}">


    <p class="confirm_title">予約可能日時</p>
    <p class="confirm_text">{{$param['able_datetime']}}</p>
    <input type="hidden" name="able_datetime" value="{{$param['able_datetime']}}">

    <p class="confirm_title">予約可能時間</p>
    <p class="confirm_text">{{$param['able_time']}}</p>
    <input type="hidden" name="able_time" value="{{$param['able_time']}}">

    <p class="confirm_title">予約NG日</p>
    <p class="confirm_text">{{$param['not_able_date']}}</p>
    <input type="hidden" name="not_able_date" value="{{$param['not_able_date']}}">




    <p class="confirm_title">応募条件(フォロワー数)</p>
    <p class="confirm_text">{{$follower[$param['least_follower']]}}</p>
    <input type="hidden" name="selector1" value="{{$param['least_follower']}}">

    <p class="confirm_title">募集人数</p>
    <p class="confirm_text">{{$param['matter_num']}}</p>
    <input type="hidden" name="matter_num" value="{{$param['matter_num']}}">


    <p class="confirm_title">報酬内容</p>
    <p class="confirm_text">{{$param['reward']}}</p>
    <input type="hidden" name="reward" value="{{$param['reward']}}">

    <p class="confirm_title">提供メニュー</p>
    <p class="confirm_text">{{$param['serve_menu']}}</p>
    <input type="hidden" name="menu" value="{{$param['serve_menu']}}">

    <p class="confirm_title">メニュー料金 </p>
    <p class="confirm_text">{{$param['serve_value']}}</p>
    <input type="hidden" name="serve_value" value="{{$param['serve_value']}}">

    <p class="confirm_title">同伴者人数</p>
    <p class="confirm_text">{{$param['companion_num']}}</p>
    <input type="hidden" name="companion_num" value="{{$param['companion_num']}}">


    <p class="confirm_title">投稿SNS</p>
    <ul class="confirm_checkbox">
        @foreach ($checkbox1 as $key=>$value)
            <li>{{$matter_sns[$value]}}</li>
        @endforeach
    </ul>
    @foreach ($checkbox1 as $value)
        <input type="hidden" name="checkbox1[]" value="{{$value}}">
    @endforeach

    <p class="confirm_title">投稿条件</p>
    <ul class="confirm_checkbox">
        @foreach ($checkbox2 as $key=>$value)
            <li>{{$term["term$value"]}}</li>
        @endforeach
    </ul>
    @foreach ($checkbox2 as $value)
        <input type="hidden" name="checkbox2[]" value="{{$value}}">
    @endforeach

    <p class="confirm_title">その他投稿条件</p>
    <ul class="confirm_checkbox">
        @foreach ($post_conditions as $value)
            @if (!empty($value))
                <li>{{$value}}</li>
            @endif
        @endforeach
    </ul>
    @foreach ($post_conditions as $value)
        <input type="hidden" name="post_conditions[]" value="{{$value}}">
    @endforeach


    <p class="confirm_title">指定ハッシュタグ</p>
    <p class="confirm_text">{{$param['hashtag']}}</p>
    <input type="hidden" name="hashtag" value="{{$param['hashtag']}}">

    <p class="confirm_title">タグ付け用アカウント</p>
    <p class="confirm_text">{{$param['tag_account']}}</p>
    <input type="hidden" name="tag_account" value="{{$param['tag_account']}}">

    <p class="confirm_title">位置情報</p>
    <p class="confirm_text">{{$param['location']}}</p>
    <input type="hidden" name="location" value="{{$param['location']}}">


    <p class="confirm_title">Instagramへの投稿期限</p>
    <p class="confirm_text">{{$deadline[$param['post_deadline']]}}</p>
    <input type="hidden" name="selector2" value="{{$param['post_deadline']}}">

    <p class="confirm_title">ストーリーズ用URL</p>
    <p class="confirm_text">{{$param['story_url']}}</p>
    <input type="hidden" name="story_url" value="{{$param['story_url']}}">

    <p class="confirm_title">投稿に関する注意事項</p>
    <ul class="confirm_checkbox">
        @foreach ($checkbox3 as $key=>$value)
            <li>{{$notice["notice$value"]}}</li>
        @endforeach
    </ul>
    @foreach ($checkbox3 as $value)
        <input type="hidden" name="checkbox3[]" value="{{$value}}">
    @endforeach

    <p class="confirm_title">その他投稿に関する注意事項</p>
    <ul class="confirm_checkbox">
        @foreach ($post_conditions2 as $value)
            @if (!empty($value))
                <li>{{$value}}</li>
            @endif
        @endforeach
    </ul>
    @foreach ($post_conditions2 as $value)
        <input type="hidden" name="post_conditions2[]" value="{{$value}}">
    @endforeach

    <p class="confirm_title">イメージ画像</p>
    <div class="img_area">
        @foreach ($filepath_list as $key=>$value)
            @if (!empty($value))
                <div class="img_box">
                    <img src="{{ asset("laravel/public/storage/matter_img/$value") }}" alt="img">
                </div>
                <input type="hidden" name="matter_img[]" value="{{$value}}">
            @endif
        @endforeach
    </div>

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


