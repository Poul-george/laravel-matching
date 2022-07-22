<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{config('const.title.title34')}}</title>
  {{-- <link rel="stylesheet" href="{{ asset('css/form.css')}}"> --}}
  <link rel="stylesheet" href="{{ secure_asset('css/form.css')}}">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  <h3>{{config('const.title.title34')}}</h3>
  <form class="questionnaire_form" action="" method="post">
    @csrf
    <p class="questionnaire_input_p">美味しかったメニュー</p>
    <input class="input_text" type="text" placeholder="テキスト" name="menu1" required>
    <p class="questionnaire_input_p">美味しくなかったメニュー</p>
    <input class="input_text" type="text" placeholder="テキスト" name="menu2">

    <p class="questionnaire_input_p">接客評価 10段階評価</p>
    <div class="hyouka_radio_div">
      <p class="hyouka_p">とても悪い</p>
        <ul class="radio_ul">
          <li class="radio_li">
            <input type="radio" id="1-option" name="selector1" value="1" required>
            <label for="1-option">1</label>
            <div class="check"></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="2-option" name="selector1" value="2">
            <label for="2-option">2</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="3-option" name="selector1" value="3">
            <label for="3-option">3</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="4-option" name="selector1" value="4">
            <label for="4-option">4</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="5-option" name="selector1" value="5">
            <label for="5-option">5</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="6-option" name="selector1" value="6">
            <label for="6-option">6</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="7-option" name="selector1" value="7">
            <label for="7-option">7</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="8-option" name="selector1" value="8">
            <label for="8-option">8</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="9-option" name="selector1" value="9">
            <label for="9-option">9</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="10-option" name="selector1" value="10">
            <label class="two_sum" for="10-option">10</label>
            <div class="check"><div class="inside"></div></div>
          </li>
        </ul>
        <p class="hyouka_p">とても良い</p>
      </div>

      <p class="questionnaire_input_p">接客評価について悪いor良いと思った点をお書きください。</p>
      <textarea class="input_textarea" placeholder="テキストエリア" name="service_value_memo" required></textarea>

      <p class="questionnaire_input_p">価格への満足度 5段階評価</p>
      <div class="hyouka_radio_div">
      <p class="hyouka_p">満足度が低い</p>
        <ul class="radio_ul">
          <li class="radio_li">
            <input type="radio" id="11-option" name="selector2" value="1" required>
            <label for="11-option">1</label>
            <div class="check"></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="12-option" name="selector2" value="2">
            <label for="12-option">2</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="13-option" name="selector2" value="3">
            <label for="13-option">3</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="14-option" name="selector2" value="4">
            <label for="14-option">4</label>
            <div class="check"><div class="inside"></div></div>
          </li>
          <li class="radio_li">
            <input type="radio" id="15-option" name="selector2" value="5">
            <label for="15-option">5</label>
            <div class="check"><div class="inside"></div></div>
          </li>
        </ul>
        <p class="hyouka_p">満足度が高い</p>
      </div>

      <p class="questionnaire_input_p">気になる事はありましたか？</p>
      <div class="checkbox_div" style="padding-bottom: 5px;">
      <?php $i=1; ?>
        @foreach ($item as $key=>$value)
            @if (!empty($value))
                <div><input class="input_checkbox" type="checkbox" id="box-{{$i}}" name="notice[]" value="{{$value}}"><label for="box-{{$i}}">{{$value}}</label></div>
                <?php $i+=1; ?>
            @endif
        @endforeach

      </div>

      <p class="questionnaire_input_p">その他、気になる事はありましたか？</p>
      <input class="input_text" type="text" placeholder="テキスト" name="notice_memo">

      <p class="questionnaire_input_p">その他、お伝えしたい事があれば、ご記入ください。</p>
      <textarea class="input_textarea" placeholder="記入欄" name="notice_other"></textarea>




    <div class="space_div" ></div>
    <input type="hidden" name="hidden_id" value="{{$id}}">
    <input class="input_submit" type="submit" value="送信">

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
</script>

</html>


