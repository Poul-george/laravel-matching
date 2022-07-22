<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="{{ asset('/css/first_form.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('/css/first_form.css') }}" rel="stylesheet">
  <title>{{config('const.title.title29')}}</title>
  <link rel="stylesheet" href="index.css">

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

  <form class="questionnaire_form" action="" method="POST">
    @if (session('msgs'))
        <p class="error">{{session('msgs')}}</p>
    @endif
      
    @csrf
    <div class="form-item">
        <label for="メールアドレス">メールアドレス</label>
        <input class="input_text" type="email" placeholder="(例)it_tarou@gmail.com" name="email" required>
      </div>
      <div class="form-item">
        <label for="氏名">企業名または、個人事業主名</label>
          <input class="input_text" type="text" name="name" required="required" placeholder="(例)株式会社〇〇">
      </div>
        


      <div class="msg_center">
        <div><input onclick="setEditEnable('send_btn', this.checked)" class="input_checkbox" name="doui" value="1" type="checkbox" id="doui"><label for="doui" ><a href="#" target="_blank">利用規約</a>に同意</label></div>
      </div>

    <br>

    <div class="space_div" ></div>

    <input class="input_submit" name="send_btn" id="send" type="submit" value="送信" disabled="disabled">

  </form>
  @endif
  <script type="text/javascript">
        function setEditEnable(strName, boolEnable){ 
    var elm = document.getElementsByName(strName).item(0);
    elm.disabled = !boolEnable;
  } 
  </script>
</body>
</html>
