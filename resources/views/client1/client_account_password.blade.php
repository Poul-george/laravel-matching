<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- <link rel="stylesheet" href="{{ asset('css/main.css')}}">  -->
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>{{config('const.title.title36')}}</title>
    </head>

    <body>
      @include('client1.component.mypage_left')
      
      
      <div class="main_div" id="main_div">
          @include('client1.component.mypage_header')
            @if (session('msgs'))
                <p class="error">{{session('msgs')}}</p>
            @endif
            <div class="top_title">
                <h3 class="title">{{config('const.title.title36')}}</h3>
            </div>

            <div class="mypage_edit_div">

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">

                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" 
                        >
                            @csrf
                                <div class="edit_form_div">
                                    <p class="questionnaire_input_p">新しいパスワード（半角英数字8文字以上）</p>
                                    <input class="input_text max_input_text" type="password" name="password" required>
                                </div>

                                <div class="edit_form_div">
                                    <p class="questionnaire_input_p">もう一度入力してください。</p>
                                    <input class="input_text max_input_text" type="password" name="password_confirmation" required>
                                </div>

                                <div class="submit_div" >
                                    <input class="input_submit" name="input_submit" type="submit" value="更新する" style="color:#fff;">
                                </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </body>
    <!-- @include('client2.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>