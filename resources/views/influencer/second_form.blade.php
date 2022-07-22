<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{config('const.title.title31')}}</title>
  {{-- <link rel="stylesheet" href="{{ asset('css/form.css')}}"> --}}
  <link rel="stylesheet" href="{{ secure_asset('css/form.css')}}">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
    .center_container{
        text-align: center;
    }
    .yazirusi{
        font-size: 30px;
    }
</style>
<body>
@if ($item['user_flag']==="1")

  <h3>{{config('const.title.title31')}}</h3>
  <form class="questionnaire_form" action="" method="post" enctype="multipart/form-data">
    @csrf
    <input class="input_text" type="text" placeholder="氏名" name="name" value="{{$item['user_name']}}" required>
    <input class="input_text" type="text" placeholder="氏名(フリガナ)" name="furigana" value="{{$item['user_furigana']}}" required>
    <input class="input_text" type="email" placeholder="メールアドレス" name="email" value="{{$item['user_mail']}}" required>

    <p class="questionnaire_input_p">生年月日</p>
    <div class="cp_ipselect_div">
      <div class="cp_ipselect">
        <select class="cp_sl06" name="year" required>
          <option value="" hidden disabled selected></option>
          @for ($i=1970;$i<=$year;$i++)
            @if ($user_year===strval($i))
                <option value="{{$i}}" selected>{{$i}}</option>
            @else
                <option value="{{$i}}">{{$i}}</option>
            @endif
          @endfor
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect mounth">
        <select class="cp_sl06" name="month" required>
          <option value="" hidden disabled selected></option>
          @foreach ($month_list as $key=>$value)
            @if ($user_month===$value)
                <option value="{{$value}}" selected>{{$key}}</option>
            @else
                <option value="{{$value}}">{{$key}}</option>
            @endif
          @endforeach
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect day">
        <select class="cp_sl06" name="days" required>
          <option value="" hidden disabled selected></option>
          @foreach ($date_list as $key=>$value)
            @if ($user_date===$value)
                <option value="{{$value}}" selected>{{$key}}</option>
            @else
                <option value="{{$value}}">{{$key}}</option>
            @endif
          @endforeach
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>
    </div>

    <input class="input_text" placeholder="郵便番号 (例 100-0000 or 1000000)" type="text" name="area" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" required>
    <input class="input_text" placeholder="所在地" type="text" name="address" size="60" required>
    <input class="input_text" type="tel" name="tel01" placeholder="電話番号" required>

    <p class="questionnaire_input_p">性別</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="1-option" name="selector1" value="男性" required>
          <label for="1-option">男性</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="2-option" name="selector1" value="女性"">
          <label for="2-option">女性</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

     <p class="questionnaire_input_p">子供の有無</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="3-option" name="selector2" value="T" required>
          <label for="3-option">あり</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="4-option" name="selector2" value="F">
          <label for="4-option">無し</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">ペット(犬・猫)の有無</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="5-option" name="selector3" value="T" required>
          <label for="5-option">あり</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="6-option" name="selector3" value="F">
          <label for="6-option">無し</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">Instagramについて</p>

    <p class="questionnaire_input_p">InstagramアカウントURL</p>
    <input class="input_text" type="text" placeholder="" name="instagram_url" value="{{$item['user_instagram_url']}}" required>
    {{-- <p class="questionnaire_input_p">Instagramフォロワー数</p>
    <input class="input_text" type="text" placeholder="(例) 10000" name="instagram_follower" required> --}}
    <p class="questionnaire_input_p">インスタグラムのフォロワー数</p>
    <input class="input_text" type="number" placeholder="" name="instagram_num" value="{{$item['user_follower_num']}}" required>
    <p class="questionnaire_input_p">食べログURL（任意）</p>
    <input class="input_text" type="text" placeholder="" name="taberogu" value="{{$item['user_taberogu']}}">
    <p class="questionnaire_input_p">Google Map URL（任意）</p>
    <input class="input_text" type="text" placeholder="" name="google" value="{{$item['user_google']}}">
    {{-- <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="i5-option" name="selector_i" value="A" required>
          <label for="i5-option">～4,999</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="i6-option" name="selector_i" value="B">
          <label for="i6-option">～9,999</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="i7-option" name="selector_i" value="C">
          <label for="i7-option">～14,999</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="i8-option" name="selector_i" value="D">
          <label for="i8-option">15,000～</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div> --}}

    {{-- <p class="questionnaire_input_p">Google MAP</p> --}}
    {{-- <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="7-option" name="selector4" value="T" required>
          <label for="7-option">はい</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="8-option" name="selector4" value="F">
          <label for="8-option">いいえ</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">食べログ</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="9-option" name="selector5" value="T" required>
          <label for="9-option">はい</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="10-option" name="selector5" value="F">
          <label for="10-option">いいえ</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div> --}}

    <p class="questionnaire_input_p">その他SNSのアカウント ※任意１</p>
     <input class="input_text" type="text" placeholder="SNS名の入力 (例) Twitter" name="sns_name1">
     {{-- <input class="input_text" type="text" placeholder="アカウント名の入力" name="sns_account_1" > --}}

    <p class="questionnaire_input_p">その他SNSのアカウント ※任意2</p>
     <input class="input_text" type="text" placeholder="SNS名の入力 (例) Twitter" name="sns_name2" >
     {{-- <input class="input_text" type="text" placeholder="アカウント名の入力" name="sns_account_2" > --}}

    <p class="questionnaire_input_p">その他SNSのアカウント ※任意2</p>
     <input class="input_text" type="text" placeholder="SNS名の入力 (例) Twitter" name="sns_name3" >
     {{-- <input class="input_text" type="text" placeholder="アカウント名の入力" name="sns_account_3" > --}}

     <p class="questionnaire_input_p">あなたの得意なジャンルを選択してください。(複数回答可)</p>
     <div class="checkbox_div">
        @for ($i=1;$i<=23;$i++)
            <div><input class="input_checkbox" name="checkbox1[]" value="{{$i}}" type="checkbox" id="box-{{$i}}"><label for="box-{{$i}}">{{config("list.user_genre.user_genre$i")}}</label></div>
        @endfor
     </div><br>

     <p class="questionnaire_input_p">主な活動エリア(複数回答可)</p>
     <div class="checkbox_div">
        @for ($i=1;$i<=47;$i++)
            <div><input type="checkbox" class="input_checkbox" name="checkbox2[]" value="{{$i}}" id="todouhuken-{{$i}}"><label for="todouhuken-{{$i}}">{{config("list.todouhuken.todouhuken$i")}}</label></div>
        @endfor
     </div>

     <div class="attachment">
        <p class="questionnaire_input_p">アイコン画像</p>
        <div id="attachment4" class="file_up_div">
            <label><input type="file" name="icon_img" value="icon_img" class="fileinput" accept=".png, .jpg, .jpeg" required>ファイルを添付する</label>
            <span class="filename">選択されていません</span>
        </div>
    </div><br>


    <p class="questionnaire_input_p">インサイト画像提出(変更時のみ)</p>
      <div class="attachment">

        <p class="questionnaire_input_p">≪画像１枚目≫期間は過去30日間、トップの場所は【市区町村】が分かるように</p>
        <p class="questionnaire_input_p">現在の登録画像</p>
        <img class="sample_png" src="{{ asset("laravel/public/storage/insite/$user_insite_img1") }}">
      <div id="attachment1" class="file_up_div">
        <label><input type="file" name="upfile[]" value="upfile[]" class="fileinput" accept=".png, .jpg, .jpeg">ファイルを添付する</label>
        <span class="filename">選択されていません</span>
      </div>

    <p class="questionnaire_input_p">≪画像2枚目≫期間は過去30日間、年齢層は【すべて】が分かるように</p>
      <p class="questionnaire_input_p">現在の登録画像</p>
      <img class="sample_png" src="{{ asset("laravel/public/storage/insite/$user_insite_img2") }}">
      <div id="attachment2" class="file_up_div">
        <label><input type="file" name="upfile[]" value="upfile[]" class="fileinput" accept=".png, .jpg, .jpeg">ファイルを添付する</label>
        <span class="filename">選択されていません</span>
      </div>
    <p class="questionnaire_input_p">≪画像3枚目≫期間は過去30日間、性別は【男女比】が分かるように</p>
      <p class="questionnaire_input_p">現在の登録画像</p>
      <img class="sample_png" src="{{ asset("laravel/public/storage/insite/$user_insite_img3") }}">
      <div id="attachment3" class="file_up_div">
        <label><input type="file" name="upfile[]" value="upfile[]" class="fileinput" accept=".png, .jpg, .jpeg">ファイルを添付する</label>
        <span class="filename">選択されていません</span>
      </div>
    </div>

    <p class="questionnaire_input_p">事務所への所属</p>
    <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="11-option" name="selector6" value="T" required>
          <label for="11-option">あり</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="12-option" name="selector6" value="F">
          <label for="12-option">なし</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

    <p class="questionnaire_input_p">口座番号</p>
    <p class="questionnaire_input_p">銀行名</p>
     <input class="input_text" type="text" placeholder="" name="bank" required>

     <p class="questionnaire_input_p">口座種別</p>
     <div class="radio_div">
      <ul>
        <li>
          <input type="radio" id="bank-1" name="selector_bank" value="普通" required>
          <label for="bank-1">普通</label>
          <div class="check"></div>
        </li>
        <li>
          <input type="radio" id="bank-2" name="selector_bank" value="当座">
          <label for="bank-2">当座</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="bank-3" name="selector_bank" value="貯蓄">
          <label for="bank-3">貯蓄</label>
          <div class="check"><div class="inside"></div></div>
        </li>
      </ul>
    </div>

     <p class="questionnaire_input_p">口座番号（半角数字のみ）</p>
     <input class="input_text" type="text" placeholder="" name="bank_number" oninput="value = value.replace(/[０-９]/g,s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');" required>

     <p class="questionnaire_input_p">口座名義</p>
     <small>※登録氏名と口座名義が一致する口座情報を登録してください。</small>
     <input class="input_text" type="text" placeholder="" name="cash_name" required>



    <div class="space_div" ></div>

    <input class="input_submit" type="submit" value="登録">

  </form>
@else
  <div class="center_container">
    <p class="msg_center">本登録が完了しました！</p><br><br>
    <p class="yazirusi">⇓</p><br>
    <p class="msg_center"><a href="./main">{{config('const.title.title45')}}　メインページへ</a></p>
  </div>
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
  $('#attachment4 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment4').find('.filename').text(file.name);
   });
</script>

</html>
