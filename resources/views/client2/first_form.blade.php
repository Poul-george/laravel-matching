<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{config('const.title.title29')}}</title>
  <link rel="stylesheet" href="{{ secure_asset('css/first_form.css')}}">
  <link rel="stylesheet" href="{{ asset('css/first_form.css')}}">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
    .error{
        text-align: center;
        color: red;
    }
    .input_submit { 
      background: #5D99FF;
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

      <div class="form-item">
        <label for="メールアドレス">メールアドレス</label>
        <input class="input_text" type="email" placeholder="(例)it_tarou@gmail.com" name="email" required>
      </div>
      <div class="form-item">
        <label for="氏名">氏名</label>
          <input class="input_text" type="text" name="name" required="required" placeholder="(例)田中太朗">
      </div>
        


      <div class="msg_center">
        <div><input onclick="setEditEnable('send_btn', this.checked)" class="input_checkbox" name="doui" value="1" type="checkbox" id="doui"><label for="doui" ><a href="#" target="_blank">利用規約</a>に同意</label></div>
      </div>

    <br>

    <div class="space_div" ></div>

    <input class="input_submit" name="send_btn" id="send" type="submit" value="送信" disabled="disabled">

  </form>

  @endif



</body>

<script type="text/javascript">


function setEditEnable(strName, boolEnable){ 
    var elm = document.getElementsByName(strName).item(0);
    elm.disabled = !boolEnable;
  } 
</script>
</html>
