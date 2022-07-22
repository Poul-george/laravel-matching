<?php
// var_dump($session_test);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <link href="{{ asset('/css/message.css') }}" rel="stylesheet">
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>人材稼働確認</title>
    </head>

    <style>
      .company_info_detail_title_h4 {
        padding: 20px 0 0 20px;
      }
      .input_caution_div {
        margin-top: 40px;
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
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">確認情報</h3></div>

                <div class="confirmation_input_group_one_flex ">
                  <h4 class="confirmation_input_title_h4">人材稼働結果</h4>
                  @if ($session_contacts_user_judge_input["selector1"] == "1")
                  <p class="confirmation_input_p">3ヶ月稼働できなかった。</p>
                  @endif
                  @if ($session_contacts_user_judge_input["selector1"] == "2")
                  <p class="confirmation_input_p">3ヶ月稼働できた。</p>
                  @endif
                </div>

                <div class="company_info_detail_one_textarea">
                  <h4 class="company_info_detail_title_h4">採用人材</h4>
                  <div class="user_select_div">
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
                  </div>
                </div>

                <div class="company_info_detail_one_textarea">
                  <h4 class="company_info_detail_title_h4">理由</h4>
                  <p class="confirmation_input_p bottom">{{$session_contacts_user_judge_input["user_judge_textarea"]}}</p>  
                </div>

                <div class="input_caution_div">
                  <div class="input_caution_flex_div">
                    <p class="input_caution_p">
                      稼働確認登録を終えると、稼働できた時は、稼働確認登録後、１週間以内に、人材契約仲介手数料のお支払いがあります。
                    </p>
                  </div>
                </div>

              </div>
            </div>


            <!-- /////// -->

            <!-- <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit2()"> -->
            <form method="POST" class="questionnaire_form h-adr confirmation_submit_form" action="" enctype="multipart/form-data" >

            @csrf
              <div class="confirmation_btn_div">
                <div class="submit_div submit_flex" >
                  <input class="input_submit return_submit" name="return_sub" type="submit" value="戻る">
                </div>
      
                <div class="submit_div submit_flex" >
                  <input class="input_submit" type="submit" name="post_sub" value="稼働確認登録">
                </div>
              </div>

            </form>
        </div>
    </body>
    <!-- @include('client1.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>