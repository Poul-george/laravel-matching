<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{config('const.title.title31')}}</title>
  {{-- <link href="{{ asset('/css/form.css') }}" rel="stylesheet"> --}}
  <link href="{{ secure_asset('/css/form.css') }}" rel="stylesheet">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
  <h3>{{config('const.title.title31')}}</h3>
  @if (session('msg'))
    <p class="msg_center">{{session('msg')}}</p>
  @else
  @if (session('error'))
    <p class="error">{{session('error')}}</p>
  @endif
  <form class="questionnaire_form" action="" method="post" enctype="multipart/form-data">
  @csrf

    @if ($item_config->client_name==="T")
        <input class="input_text" type="text" placeholder="企業名(店舗名)　※必須" name="name" value="{{$item->shop_name}}" required>
    @else
        <input class="input_text" type="text" placeholder="企業名(店舗名)" name="name" value="{{$item->shop_name}}">
    @endif

    @if ($item_config->client_tantou==="T")
        <input class="input_text" type="text" placeholder="ご担当者名　※必須" name="client_name" value="{{$item->shop_tantou}}" required>
    @else
        <input class="input_text" type="text" placeholder="ご担当者名" name="client_name" value="{{$item->shop_tantou}}">
    @endif

    @if ($item_config->client_phone==="T")
        <input class="input_text" type="tel" name="tel01" placeholder="ご連絡先(電話番号) ※必須" value="{{$item->shop_phone}}" required>
    @else
        <input class="input_text" type="tel" name="tel01" placeholder="ご連絡先(電話番号)" value="{{$item->shop_phone}}">
    @endif

    @if ($item_config->client_mail==="T")
        <input class="input_text" type="email" placeholder="Email　※必須" name="email" value="{{$item->shop_mail}}" required>
    @else
        <input class="input_text" type="email" placeholder="Email" name="email" value="{{$item->shop_mail}}">
    @endif

    @if ($item_config->client_area==="T")
        <input class="input_text" placeholder="郵便番号 (例 100-0000 or 1000000)　※必須" type="text" name="zip" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" required>
    @else
        <input class="input_text" placeholder="郵便番号 (例 100-0000 or 1000000)" type="text" name="zip" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');">
    @endif

    @if ($item_config->client_address==="T")
        <input class="input_text" placeholder="所在地　※必須" type="text" name="address" size="60" required>
    @else
        <input class="input_text" placeholder="所在地" type="text" name="address" size="60">
    @endif

    @if ($item_config->client_station==="T")
        <input class="input_text" type="text" placeholder="店舗最寄り駅 (例 JR大阪駅)　※必須" name="train_station" required>
    @else
        <input class="input_text" type="text" placeholder="店舗最寄り駅 (例 JR大阪駅)" name="train_station">
    @endif

    @if ($item_config->open_time==="T")
        <input class="input_text" type="text" placeholder="営業時間　※必須" name="open_time" required>
    @else
        <input class="input_text" type="text" placeholder="営業時間" name="open_time">
    @endif

    @if ($item_config->open_time==="T")
        <input class="input_text" type="text" placeholder="定休日　※必須" name="close_date" required>
    @else
        <input class="input_text" type="text" placeholder="定休日" name="close_date">
    @endif

    <p class="questionnaire_input_p">個室の有無</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="1-radioT" name="radio1" value="T" required>
          <label for="1-radioT">あり</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="1-radioF" name="radio1" value="F">
          <label for="1-radioF">なし</label>
          <div class="check"></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">お子様同伴</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="2-radioT" name="radio2" value="T" required>
          <label for="2-radioT">可</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="2-radioF" name="radio2" value="F">
          <label for="2-radioF">不可</label>
          <div class="check"></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">ペット同伴</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="3-radioT" name="radio3" value="T" required>
          <label for="3-radioT">可</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="3-radioF" name="radio3" value="F">
          <label for="3-radioF">不可</label>
          <div class="check"></div>
        </li>
      </ul>
    </div><br>


    <div class="attachment">
        @if ($item_config->client_img==="T")
            <p class="questionnaire_input_p">イメージ画像<small class="hissu">※必須</small></p>
            <div id="attachment1" class="file_up_div">
                <label><input type="file" name="shop_img" value="shop_img" class="fileinput" accept=".png, .jpg, .jpeg" required>ファイルを添付する</label>
                <span class="filename">選択されていません</span>
            </div>
        @else
            <p class="questionnaire_input_p">イメージ画像</p>
            <div id="attachment1" class="file_up_div">
                <label><input type="file" name="shop_img" value="shop_img" class="fileinput" accept=".png, .jpg, .jpeg">ファイルを添付する</label>
                <span class="filename">選択されていません</span>
            </div>
        @endif
    </div><br>

    <p class="questionnaire_input_p">新規オープン予定の店舗については下記を記入ください</p>
    <p class="questionnaire_input_p">ジャンル・カテゴリ</p>
    <div class="checkbox_div">
      <div><input class="input_checkbox" name="checkbox1[]" value="1" type="checkbox" id="box-1"><label for="box-1">和食</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="2" type="checkbox" id="box-2"><label for="box-2">イタリアン</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="3" type="checkbox" id="box-3"><label for="box-3">フレンチ</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="4" type="checkbox" id="box-4"><label for="box-4">中華</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="5" type="checkbox" id="box-5"><label for="box-5">韓国料理</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="6" type="checkbox" id="box-6"><label for="box-6">エスニック</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="7" type="checkbox" id="box-7"><label for="box-7">焼肉</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="8" type="checkbox" id="box-8"><label for="box-8">ラーメン</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="9" type="checkbox" id="box-9"><label for="box-9">カフェ・スイーツ</label></div>
      <div><input class="input_checkbox" name="checkbox1[]" value="10" type="checkbox" id="box-10"><label for="box-10">その他</label></div>
    </div>

    <p class="questionnaire_input_p">店舗客単価</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="1-option" name="selector1" value="A">
          <label for="1-option">〜3000円</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="2-option" name="selector1" value="B">
          <label for="2-option">3000〜5000円</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="3-option" name="selector1" value="C">
          <label for="3-option">5000〜7000円</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="4-option" name="selector1" value="D">
          <label for="4-option">7000〜10000円</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="5-option" name="selector1" value="E">
          <label for="5-option">10000〜15000円</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="6-option" name="selector1" value="F">
          <label for="6-option">15000〜20000円</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="7-option" name="selector1" value="G">
          <label for="7-option">20000〜30000円</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="8-option" name="selector1" value="H">
          <label for="8-option">30000円〜</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">ターゲットの年齢層(複数回答可)</p>
    <div class="checkbox_div">
      <div><input class="input_checkbox" name="checkbox2[]" value="1" type="checkbox" id="box-19"><label for="box-19">10代</label></div>
      <div><input class="input_checkbox" name="checkbox2[]" value="2" type="checkbox" id="box-20"><label for="box-20">20代</label></div>
      <div><input class="input_checkbox" name="checkbox2[]" value="3" type="checkbox" id="box-21"><label for="box-21">30代</label></div>
      <div><input class="input_checkbox" name="checkbox2[]" value="4" type="checkbox" id="box-22"><label for="box-22">40代</label></div>
      <div><input class="input_checkbox" name="checkbox2[]" value="5" type="checkbox" id="box-23"><label for="box-23">50代以上</label></div>
      <div><input class="input_checkbox" name="checkbox2[]" value="6" type="checkbox" id="box-25"><label for="box-25">その他</label></div>
    </div>

    <p class="questionnaire_input_p">ターゲットの性別(複数回答可)</p>
    <div class="checkbox_div">
      <div><input class="input_checkbox" name="checkbox3[]" value="1" type="checkbox" id="box-26"><label for="box-26">男性</label></div>
      <div><input class="input_checkbox" name="checkbox3[]" value="2" type="checkbox" id="box-27"><label for="box-27">女性</label></div>
      <div><input class="input_checkbox" name="checkbox3[]" value="3" type="checkbox" id="box-28"><label for="box-28">特になし</label></div>
    </div>



    <p class="questionnaire_input_p">店舗or企業のコンセプト</p>
    <textarea class="input_textarea" placeholder="コンセプト" name="message"></textarea>

    <div class="space_div" ></div>

    <input class="input_submit" type="submit" value="送信">

  </form>
  @endif



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
  </script>
</html>
