<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{config('const.title.title29')}}</title>
  <link rel="stylesheet" href="{{ secure_asset('css/style_hp.css')}}">
  {{-- <link rel="stylesheet" href="{{ asset('css/style_hp.css')}}"> --}}
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
    .error{
        text-align: center;
        color: red;
    }
</style>
<body>
  <h3>{{config('const.title.title29')}}</h3>
  @if (isset($msg))
    <div class="question_form_after">
        <p>{{$msg}}</p>
        <p>{{$msg2}}</p>
    </div>
  @else

  <?php $date_list=config('list.date_list'); ?>
  <?php $month_list=config('list.month_list'); ?>

  <form enctype="multipart/form-data" class="questionnaire_form" action="" method="post">
    @if (session('msgs'))
        <p class="error">{{session('msgs')}}</p>
    @endif
    @csrf
    <input class="input_text" type="text" placeholder="氏名" name="name" required>
    <input class="input_text" type="text" placeholder="氏名（フリガナ）" name="furigana" required>
    <input class="input_text" type="text" placeholder="InstagramアカウントURL" name="instagram_url" required>
    <input class="input_text" type="email" placeholder="メールアドレス" name="email" required>
    <input class="input_text" type="number" placeholder="フォロワー数" name="follower" required>
    <input class="input_text" type="text" placeholder="食べログURL（任意）" name="taberogu">
    <input class="input_text" type="text" placeholder="Google Map URL（任意）" name="google">

    <p class="questionnaire_input_p">生年月日</p>
    <div class="cp_ipselect_div">
      <div class="cp_ipselect">
        <select class="cp_sl06" name="year" required>
          <option value="" hidden disabled selected></option>
          <?php $year=date('Y'); ?>
          @for ($i=1970;$i<=$year;$i++)
            <option value="{{$i}}">{{$i}}</option>
          @endfor
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect mounth">
        <select class="cp_sl06" name="month" required>
          <option value="" hidden disabled selected></option>
          @foreach ($month_list as $key=>$value)
            <option value="{{$value}}">{{$key}}</option>
          @endforeach
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect day">
        <select class="cp_sl06" name="days" required>
          <option value="" hidden disabled selected></option>
          @foreach ($date_list as $key=>$value)
            <option value="{{$value}}">{{$key}}</option>
          @endforeach
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>
    </div>

    {{-- <div class="one_question">
      <p class="questionnaire_input_p">食べログ </p>
      <div class="radio_div">
        <ul>
          <li>
            <input type="radio" id="1-option" name="selector1" value="T" required>
            <label for="1-option">はい</label>
            <div class="check"></div>
          </li>
          <li>
            <input type="radio" id="2-option" name="selector1" value="F">
            <label for="2-option">いいえ</label>
            <div class="check"><div class="inside"></div></div>
          </li>
        </ul>
      </div>
    </div>

    <div class="one_question">
      <p class="questionnaire_input_p">Google MAP </p>
      <div class="radio_div">
        <ul>
          <li>
            <input type="radio" id="3-option" name="selector2" value="T" required>
            <label for="3-option">はい</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li>
            <input type="radio" id="4-option" name="selector2" value="F">
            <label for="4-option">いいえ</label>
            <div class="check"><div class="inside"></div></div>
          </li>
        </ul>
      </div>
    </div> --}}

    <p class="questionnaire_input_p">YouTubeやTikTok、その他ブログやSNSアカウントをお持ちの方はご入力ください。</p>
    <input class="input_text" type="text" placeholder="" name="other">

    <p class="questionnaire_input_p">インサイト画像提出(スクリーンショットを3枚登録)</p>
      <div class="attachment">
        <p class="questionnaire_input_p">≪画像１枚目≫期間は過去30日間、トップの場所は【市区町村】が分かるように</p>
        <p class="questionnaire_input_p">サンプル画像</p>
        <img class="sample_png" src="{{ asset('/sample/sample1.png')}}">
      <div id="attachment1" class="file_up_div">
        <label><input type="file" name="upfile[]" value="upfile[]" class="fileinput" accept=".png, .jpg, .jpeg" required>ファイルを添付する</label>
        <span class="filename">選択されていません</span>
      </div>

    <p class="questionnaire_input_p">≪画像2枚目≫期間は過去30日間、年齢層は【すべて】が分かるように</p>
      <p class="questionnaire_input_p">サンプル画像</p>
      <img class="sample_png" src="{{ asset('/sample/sample2.png')}}">
      <div id="attachment2" class="file_up_div">
        <label><input type="file" name="upfile[]" value="upfile[]" class="fileinput" accept=".png, .jpg, .jpeg" required>ファイルを添付する</label>
        <span class="filename">選択されていません</span>
      </div>
    <p class="questionnaire_input_p">≪画像3枚目≫期間は過去30日間、性別は【男女比】が分かるように</p>
      <p class="questionnaire_input_p">サンプル画像</p>
      <img class="sample_png" src="{{ asset('/sample/sample3.png')}}">
      <div id="attachment3" class="file_up_div">
        <label><input type="file" name="upfile[]" value="upfile[]" class="fileinput" accept=".png, .jpg, .jpeg" required>ファイルを添付する</label>
        <span class="filename">選択されていません</span>
      </div>
    </div>

    <p class="questionnaire_input_p">応募コメント ※任意</p>
    <textarea class="input_textarea" placeholder="コメント" name="message"></textarea>

    <br>
        <div class="msg_center">
          <div><input class="input_checkbox" name="doui" value="1" type="checkbox" id="doui"><label for="doui" onclick="Accept()"><a href="#" target="_blank">利用規約</a>に同意</label></div>
        </div>
    <br>

    <div class="space_div" ></div>

    <input class="input_submit" id="send" type="submit" value="送信" disabled>

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

   var Accept = function () {
        const button=document.getElementById("send")
        if(document.getElementById("doui").checked){
            button.disabled=true;
        }else{
            button.disabled=false;
        }
    }
</script>
</html>
