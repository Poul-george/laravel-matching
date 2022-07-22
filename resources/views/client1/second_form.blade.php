<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{config('const.title.title31')}}</title>
  <link href="{{ asset('/css/form.css') }}" rel="stylesheet"> 
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

</head>

<style>
    .error{
        text-align: center;
        color: red;
    }
    .input_submit {
      background: #CC00FF;
      color: #fff;
    }
    .second_form_h3 {
      text-align: center;
      padding: 40px 0;
    }

</style>

<body>
  <h3 class="second_form_h3">本登録情報入力</h3>
  @if (session('msgs'))
    <p class="error">{{session('msgs')}}</p>
  @endif
  <div class="mypage_form_center">

    <form class="questionnaire_form h-adr" action="" method="post" enctype="multipart/form-data">
    @csrf

      <div class="edit_form_div flex_input">
        <p class="questionnaire_input_p">事業者名</p>
        <input class="input_text" type="text" placeholder="例) 株式会社〇〇" name="company_name" value="{{ old('company_name') }}" required>
      </div>

      <div class="edit_form_div">
        <p class="questionnaire_input_p">最寄駅</p>
        <input class="input_text" placeholder="例) 東京駅" type="text" name="near_station" required>
      </div>

      <div class="edit_form_div">
          <p class="questionnaire_input_p">拠点：郵便番号</p>
          <span class="p-country-name" style="display:none;">Japan</span>
          <input type="text" class="input_text p-postal-code" size="10" maxlength="8" placeholder="例) 1000001" name="address_number" value="" required>
        </div>

        <div class="edit_form_div">
          <div class="area_div">
            <div class="area_div_p">
              <div class="area_div_one">
                  <p class="questionnaire_input_p flex_2">都道府県</p>
                  <input type="text" class="p-region input_text_automatic" readonly placeholder="自動で入力されます" name="address_tdfk" value="" required/>
              </div>
              <div class="area_div_one area_right">
                  <p class="questionnaire_input_p flex_2">市町村</p>
                  <input type="text" class="p-locality input_text_automatic" readonly placeholder="自動で入力されます" name="address_city" value="" required/>
              </div>
            </div>
          </div>
        </div>
        
        <div class="edit_form_div">
          <p class="questionnaire_input_p">町名・番地</p>
          <input type="text" class="input_text p-street-address" required placeholder="例) 千代田３丁目1-11" name="address_banti" value="" required/>
        </div>

        <div class="edit_form_div">
          <p class="questionnaire_input_p">ビル名・部屋番号</p>
          <input type="text" class="input_text p-extended-address" placeholder="例) 〇〇ビル12階" name="address_building" value=""/>
        </div>

      <div class="edit_form_div flex_input">
        <p class="questionnaire_input_p">担当者名</p>
          <input class="input_text" type="text" placeholder="例) 田中" name="name_1" required>
          <input class="input_text" type="text" placeholder="例) 太朗" name="name_2" required>
      </div>
      <div class="edit_form_div flex_input">
        <p class="questionnaire_input_p">担当者名(ひらがな)</p>
        <input class="input_text" type="text" placeholder="例) タナカ" name="furigana_1" required>
        <input class="input_text" type="text" placeholder="例) タロウ" name="furigana_2" required>
      </div>

      <div class="edit_form_div">
        <p class="questionnaire_input_p">電話番号</p>
        <input class="input_text" type="tel" name="tel01" placeholder="例) 09012341234" required>
      </div>

      <div class="edit_form_div">
        <p class="questionnaire_input_p">emailアドレス</p>
        <input class="input_text" type="email" placeholder="例) taro@example.com" name="email" required>
      </div>

      <div class="edit_form_div">
        <p class="questionnaire_input_p">パスワード</p>
        <input class="input_text" type="password" name="password" placeholder="8桁以上半角英数字" required>
      </div>

      <div class="edit_form_div">
        <p class="questionnaire_input_p">パスワード(再確認)</p>
        <input class="input_text" type="password" name="password_again" placeholder="" required>
      </div>

      <div class="submit_div" >

        <input class="input_submit" type="submit" value="送信">
      </div>


    </form>

  </div>




</body>
<script type="text/javascript">
    
  </script>
</html>
