<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  {{-- <link href="{{ asset('/css/style_hp.css') }}" rel="stylesheet"> --}}
  <link href="{{ secure_asset('/css/style_hp.css') }}" rel="stylesheet">
  <title>お問い合わせ</title>
  <link rel="stylesheet" href="index.css">

</head>
<style>
    .error{
        text-align: center;
        color: red;
    }
</style>

<body>
  <h3>お問い合わせ</h3>
  @if (isset($msg))
    <div class="question_form_after">
        <p class="">
            お問い合わせをいただきましてありがとうございます。<br>
            5営業日以内に担当者よりご連絡させていただきます。<br><br>
            ☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆<br><br>
            お問い合わせ先<br>
            XXXXXX株式会社　(サイトタイトル)事業部<br>
            <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
        </p>
    </div>

  @else

  <form class="questionnaire_form" action="" method="POST">
    @if (session('msgs'))
        <p class="error">{{session('msgs')}}</p>
    @endif
      <p class="msg_center">お申込みやご要望などの各種お問い合わせは、以下のフォームよりご連絡ください。<br>
        5営業日以内に担当者よりご連絡させていただきます。
    </p><br>
    @csrf
    <input class="input_text" type="text" placeholder="企業名(店舗名)" name="name" required>
    <input class="input_text" type="text" placeholder="ご担当者名" name="client_name" required>
    <input class="input_text" type="tel" name="tel01" placeholder="ご連絡先(電話番号)" required>
    <input class="input_text" type="email" placeholder="Email" name="email" required>
    <input class="input_text" type="text" placeholder="店舗所在地" name="address" required>
    <input class="input_text" type="text" placeholder="最寄り駅" name="station" required>

    <div class="one_question">
      <p class="questionnaire_input_p">店舗客単価</p>
      <div class="radio_div">
        <ul>
          <li>
            <input type="radio" id="1-option" name="selector1" value="A" required>
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
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">男女比</p>
      <div class="radio_div">
        <ul>
          <li>
            <input type="radio" id="9-option" name="selector2" value="A" required>
            <label for="9-option">男性が多い</label>
            <div class="check"></div>
          </li>
          <li>
            <input type="radio" id="10-option" name="selector2" value="B">
            <label for="10-option">女性が多い</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li>
            <input type="radio" id="11-option" name="selector2" value="C">
            <label for="11-option">同じくらい</label>
            <div class="check"><div class="inside"></div></div>
          </li>
        </ul>
      </div>
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">お客様の年齢層(複数回答可)</p>
      <div class="checkbox_div">
        <div><input class="input_checkbox" name="checkbox1[]" value="1" type="checkbox" id="box-9"><label for="box-9">10代</label></div>
        <div><input class="input_checkbox" name="checkbox1[]" value="2" type="checkbox" id="box-10"><label for="box-10">20代</label></div>
        <div><input class="input_checkbox" name="checkbox1[]" value="3" type="checkbox" id="box-11"><label for="box-11">30代</label></div>
        <div><input class="input_checkbox" name="checkbox1[]" value="4" type="checkbox" id="box-12"><label for="box-12">40代</label></div>
        <div><input class="input_checkbox" name="checkbox1[]" value="5" type="checkbox" id="box-13"><label for="box-13">50代以上</label></div>
        <div><input class="input_checkbox" name="checkbox1[]" value="6" type="checkbox" id="box-14"><label for="box-14">その他</label></div>
      </div>
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">用途(複数回答可)</p>
      <div class="checkbox_div">
        <div><input class="input_checkbox" name="checkbox2[]" value="1" type="checkbox" id="box-15"><label for="box-15">友人・知人と</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="2" type="checkbox" id="box-16"><label for="box-16">同窓会や会社の人と</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="3" type="checkbox" id="box-17"><label for="box-17">デート</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="4" type="checkbox" id="box-18"><label for="box-18">接待</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="5" type="checkbox" id="box-19"><label for="box-19">大人数の宴会</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="6" type="checkbox" id="box-20"><label for="box-20">家族・子供と</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="7" type="checkbox" id="box-21"><label for="box-21">お一人様</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="8" type="checkbox" id="box-22"><label for="box-22">女子会</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="9" type="checkbox" id="box-23"><label for="box-23">合コン</label></div>
        <div><input class="input_checkbox" name="checkbox2[]" value="10" type="checkbox" id="box-24"><label for="box-24">その他</label></div>
      </div>
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">今回のPRのご利用目的(複数回答可)</p>
      <div class="checkbox_div">
        <div><input class="input_checkbox" name="checkbox3[]" value="1" type="checkbox" id="box-25"><label for="box-25">集客UP</label></div>
        <div><input class="input_checkbox" name="checkbox3[]" value="2" type="checkbox" id="box-26"><label for="box-26">知名度UP</label></div>
        <div><input class="input_checkbox" name="checkbox3[]" value="3" type="checkbox" id="box-27"><label for="box-27">良い口コミを増やしたい</label></div>
        <div><input class="input_checkbox" name="checkbox3[]" value="4" type="checkbox" id="box-28"><label for="box-28">打ち出したい商品・メニューがある</label></div>
        <div><input class="input_checkbox" name="checkbox3[]" value="5" type="checkbox" id="box-29"><label for="box-29">客単価UP</label></div>
        <div><input class="input_checkbox" name="checkbox3[]" value="6" type="checkbox" id="box-30"><label for="box-30">新店舗オープンを華やかに拡散したい</label></div>
        <div><input class="input_checkbox" name="checkbox3[]" value="7" type="checkbox" id="box-31"><label for="box-31">その他</label></div>
      </div>
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">今までに利用した集客方法(複数回答可)</p>
      <div class="checkbox_div">
        <div><input class="input_checkbox" name="checkbox4[]" value="1" type="checkbox" id="box-32"><label for="box-32">チラシ配布</label></div>
        <div><input class="input_checkbox" name="checkbox4[]" value="2" type="checkbox" id="box-33"><label for="box-33">雑誌広告</label></div>
        <div><input class="input_checkbox" name="checkbox4[]" value="3" type="checkbox" id="box-34"><label for="box-34">SNS投稿(Facebook・instagram・アフィリエイト等)</label></div>
        <div><input class="input_checkbox" name="checkbox4[]" value="4" type="checkbox" id="box-35"><label for="box-35">他社の{{config('const.title.title2')}}PR</label></div>
        <div><input class="input_checkbox" name="checkbox4[]" value="5" type="checkbox" id="box-36"><label for="box-36">利用したことがない</label></div>
        <div><input class="input_checkbox" name="checkbox4[]" value="6" type="checkbox" id="box-37"><label for="box-37">その他</label></div>
      </div>
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">予約サイトの利用状況(複数回答可)</p>
      <div class="checkbox_div">
        <div><input class="input_checkbox" name="checkbox5[]" value="1" type="checkbox" id="box-38"><label for="box-38">食べログ</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="2" type="checkbox" id="box-39"><label for="box-39">ぐるなび</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="3" type="checkbox" id="box-40"><label for="box-40">ホットペッパー</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="4" type="checkbox" id="box-41"><label for="box-41">一休</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="5" type="checkbox" id="box-42"><label for="box-42">ヒトサラ</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="6" type="checkbox" id="box-43"><label for="box-43">Facebook</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="7" type="checkbox" id="box-44"><label for="box-44">お一人様</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="8" type="checkbox" id="box-45"><label for="box-45">自社HP</label></div>
        <div><input class="input_checkbox" name="checkbox5[]" value="9" type="checkbox" id="box-46"><label for="box-46">その他</label></div>
      </div>
    </div>


    <input class="input_text" type="text" placeholder="自社HPがある場合はこちらにURLをお願いいたします。" name="client_url">
    <p class="questionnaire_input_p">ご質問がございましたらご記入をお願いいたします。</p>
    <textarea class="input_textarea" placeholder="" name="long_text"></textarea>

    <br>
        <div class="msg_center">
          <div><input class="input_checkbox" name="doui" value="1" type="checkbox" id="doui"><label for="doui" onclick="Accept()"><a href="#" target="_blank">利用規約</a>に同意</label></div>
        </div>
    <br>


    <div class="space_div" ></div>

    <input class="input_submit" id="send" type="submit" value="送信" disabled>

  </form>
  @endif
  <script type="text/javascript">
        var Accept = function () {
            const button=document.getElementById("send")
            if(document.getElementById("doui").checked){
                button.disabled=true;
            }else{
                button.disabled=false;
            }
        }
  </script>
</body>
</html>
