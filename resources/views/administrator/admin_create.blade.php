<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link href="{{ asset('/css/administrator.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>管理者作成</title>
    </head>

    <style>
      .input_submit {
        background: #00CC00;
        color: #fff;
      }
      .main_div {
        user-select: auto;
      }
    </style>

    <body>
        @include('administrator.component.administrator_left')
        <div class="main_div" id="main_div">
          @include('administrator.component.administrator_header')
          @if (session('msgs')) <p class="msg_center">{{session('msgs')}}</p> @endif
          <div class="top_title">
            <h3 class="title">管理者作成</h3>
          </div>


          <div class="mypage_edit_div">

            <div class="mypage_form_div">
              <div id="mypage_form_center" class="mypage_form_center">

                @if (isset($account))
                  <p class="p_center">アカウントID：{{$account}}</p>
                  <p class="p_center">パスワード：{{$password}}</p>
                  <br>
                  <small class="p_center">上記情報はメモしておいてください。</small>
                @else

                  <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" 
                  >
                  @csrf

                    <div class="edit_form_div">
                      <p class="questionnaire_input_p">名前</p>
                      <input class="input_text max_input_text" type="text" name="account_name" placeholder="例) test_admin"  required>
                    </div>

                    <div class="edit_form_div">
                      <p class="questionnaire_input_p">メールアドレス</p>
                      <input class="input_text max_input_text" type="email" name="email_ad" placeholder="例) admin@exsample.com"  required>
                    </div>

                    <div class="edit_form_div">
                      <p class="questionnaire_input_p">電話番号</p>
                      <input class="input_text max_input_text" type="tel" name="tel01" placeholder="例) 09012341234"  required>
                    </div>

                    <div class="submit_div" >
                      <input class="input_submit" name="input_submit" type="submit" value="作成する">
                    </div>

                  </form>     
                @endif    
              </div>
            </div>
          </div>


        </div>

    </body>
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>