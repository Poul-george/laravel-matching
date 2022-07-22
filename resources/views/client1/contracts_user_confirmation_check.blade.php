<?php
function insertStr1($text, $insert, $num){
  return substr_replace($text, $insert, $num, 0);
}
$count = 0;
$year = date('Y');
$session_data = session()->get('user_select_contract_form_data');
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
        <title>稼働確認</title>
    </head>

    <style>
      .user_select_div {
          margin: 0;
      }

    .checkbox_plural_div {
        margin: 13px;
    }
    .edit_form_radio_li {
      display: block;
      width: 50%;
    }
    @media screen and (max-width: 799px) {
      .checkbox_plural_div {
          width: 28px;
      }
      .edit_form_radio_li {
        display: block;
        width: 100%;
      }
      .edit_form_radio_ul {
        display: block;
      }
    }
  </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">人材稼働確認</h3>
            </div>

           <!-- ///////////////////// -->

           <div class="mypage_edit_div">
                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return user_judge_submit()">

                        @csrf

                            <!-- div hiddenn -->
                            
                            
                            <div class="edit_form_div" id="user_select_check">
                              <p class="questionnaire_input_p">稼働確認人材</p>
                              <p class="questionnaire_input_p user_select_alert_p" id="user_select_check_num"></p>
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

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">人材が3ヶ月稼働できたか</p>
                                <ul class="edit_form_radio_ul">
                                  <li class="edit_form_radio_li">
                                      @if (!empty($session_contacts_user_judge_input["selector1"]))
                                        @if ($session_contacts_user_judge_input["selector1"] == '1')
                                          <input type="radio" id="1-option" name="selector1" value="1" checked>
                                        @else
                                          <input type="radio" id="1-option" name="selector1" value="1">
                                        @endif
                                      @else
                                        <input type="radio" id="1-option"   name="selector1" value="1">
                                      @endif
                                    <label for="1-option">稼働できなかった</label>
                                    <div class="check"></div>
                                  </li>
                                  <li class="edit_form_radio_li">
                                    @if (!empty($session_contacts_user_judge_input["selector1"]))
                                      @if ($session_contacts_user_judge_input["selector1"] == '2')
                                        <input type="radio" id="2-option" name="selector1" value="2" checked>
                                      @else
                                        <input type="radio" id="2-option" name="selector1" value="2">
                                      @endif
                                    @else
                                        <input type="radio" id="2-option" name="selector1" value="2">
                                    @endif
                                      <label for="2-option">稼働できた</label>
                                      <div class="check"><div class="inside"></div></div>
                                  </li>
                                </ul>
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">理由</p>
                                <div class="input_caution_div">
                                  <div class="input_caution_flex_div">
                                      <p class="input_caution_p">人材が3ヶ月稼働できなかった理由、状況を記載ください。<br>稼働できた場合は、未記入で大丈夫です。</p>
                                  </div>
                                </div>
                                @if (!empty($session_contacts_user_judge_input["user_judge_textarea"]))
                                  <textarea id="user_judge_textarea" class="textarea_input" name="user_judge_textarea">{{$session_contacts_user_judge_input["user_judge_textarea"]}}</textarea>
                                @else
                                  <textarea id="user_judge_textarea" class="textarea_input" name="user_judge_textarea"></textarea>

                                @endif
                            </div>

                            <input type="hidden" name="contract_id" value="{{$contracts_item->id}}">
                            <input type="hidden" name="user_id" value="{{$user_item->id}}">


                            <div class="submit_div" >
                                <input class="input_submit" type="submit" name="input_submit" value="確認画面へ">
                            </div>

                        </form>
                    </div>
                </div>
            </div>

  <!-- /////// -->


        </div>
    </body>
    <!-- @include('client1.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>