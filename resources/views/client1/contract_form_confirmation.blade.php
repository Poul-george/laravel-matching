<?php
// var_dump($session_data);
// $session_data = session()->get('user_select_contract_form_data');
// $contract_expiration_3month = date("{$session_data['year']}-{$session_data['month']}-{$session_data['days']}",strtotime('+3 month'));
// echo date("Y-m-d",strtotime($contract_expiration_3month . "+3 month"));
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <link href="{{ asset('/css/message.css') }}" rel="stylesheet">
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>案件作成</title>
    </head>

    <style>
      .main_div {
          margin: 0;
      }
      .confirmation_input_p {
          border-bottom: none;
      }
      html {
        height: auto;
      }
  </style>

    <body>
        
        <div class="main_div" id="main_div">

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">確認画面</h3>
            </div>


            <!-- ///////////////////// -->

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">会社情報</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">会社名</h4>
                  <p class="confirmation_input_p">{{$session_data["shop_name"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">メールアドレス</h4>
                  <p class="confirmation_input_p">{{$session_data["shop_mail"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">担当者名</h4>
                  <p class="confirmation_input_p">{{$session_data["tantou_name"]}}</p>
                </div>

              </div>
            </div>

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">採用人材情報</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">採用人数</h4>
                  <p class="confirmation_input_p">{{count($session_data["user_select"])}}人</p>
                </div>
                <div class="confirmation_input_group_one_flex ">
                  <h4 class="confirmation_input_title_h4">採用人材稼動日</h4>
                  <p class="confirmation_input_p">{{$session_data["year"]}}年{{$session_data["month"]}}月{{$session_data["days"]}}日</p>
                </div>

                <div class="company_info_detail_one_textarea">
                  <h4 class="company_info_detail_title_h4">採用人材</h4>
                  <div class="user_select_div">
                    @foreach ($item_users as $user_item)
                    <div class="user_select_one_div">

                      <div class="user_img_message">
                        @if ($user_item->user_image === null || $user_item->user_image === "")  
                            <img class="user_img_msg" src="{{asset('template_img/face_blue.png')}}"/>
                          @else
                            <img class="user_img_msg" src="{{asset('user_images/' . $user_item->user_image )}}"/>
                        @endif
                      </div>

                      <div class="user_select_title_name">
                        <p class="user_message_title">{{$user_item->user_forte}}</p>
                        <p class="user_message_name">{{$user_item->user_name}}</p>
                      </div>   

                    </div>
                    @endforeach
                  </div>
                </div>

              </div>
            </div>
            
            <!-- ///////////////////// -->


            <form method="POST" class="questionnaire_form h-adr confirmation_submit_form" action="" enctype="multipart/form-data" >

              @csrf
              <div class="confirmation_btn_div">
                <div class="submit_div submit_flex" >
                  <input class="input_submit return_submit" name="return_sub" type="submit" value="戻る">
                </div>
      
                <div class="submit_div submit_flex" >
                  <input class="input_submit" type="submit" name="post_sub" value="人材確定">
                </div>
              </div>

            </form>

        </div>
    </body>
    <!-- @include('client1.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>