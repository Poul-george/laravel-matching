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
        <title>人材選定</title>
    </head>

    <style>
      .user_select_div {
          margin: 0;
      }

    .checkbox_plural_div {
        margin: 13px;
    }
    @media screen and (max-width: 799px) {
      .checkbox_plural_div {
          width: 28px;
      }
    }
  </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">人材確定申請</h3>
            </div>

           <!-- ///////////////////// -->

           <div class="mypage_edit_div">
                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <!-- <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit2()"> -->
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit_user_num()">

                        @csrf

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">企業名</p>
                                <input required id="" class="input_text max_input_text"  type="text" name="shop_name" value="{{$shop_item->shop_name}}" readonly >
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">メールアドレス</p>
                                <input required id="" class="input_text max_input_text"  type="email" name="shop_mail" value="{{$shop_item->shop_mail}}" readonly >
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">担当者名</p>
                                <input required id="" class="input_text max_input_text"  type="text" name="tantou_name" value="{{$shop_item->tantou_name}}" readonly>
                            </div>

                            <div class="edit_form_div" id="year_month_day_div">
                                <p class="questionnaire_input_p">人材稼動開始日</p>
                                <p class="questionnaire_input_p user_select_alert_p" id="year_month_day"></p>
                                <div class="select_flex">
                                    <div class="cp_ipselect cp_sl01 select_3 ">
                                        <select class="cp_sl06 select_year" name="year" required>
                                          @if (empty($session_data['year']))
                                            <option value="">選択</option>
                                          @else
                                            <option selected value="{{$session_data['year']}}">{{$session_data['year']}}</option>
                                          @endif
                                            @for ($i=$year;$i<=$year+1;$i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="cp_ipselect cp_sl01 select_3 ">
                                        <select class="cp_sl06 select_month" name="month" required>
                                          @if (empty($session_data['month']))
                                            <option value="">選択</option>
                                          @else
                                            <option selected value="{{$session_data['month']}}">{{$session_data['month']}}</option>
                                          @endif
                                            @for ($i=1;$i<=12;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="cp_ipselect cp_sl01 select_3 ">
                                        <select class="cp_sl06 select_day" name="days" required>
                                          @if (empty($session_data['days']))
                                            <option value="">選択</option>
                                          @else
                                            <option selected value="{{$session_data['days']}}">{{$session_data['days']}}</option>
                                          @endif
                                            @for ($i=1;$i<=31;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- div hiddenn -->
                            <div class="user_select_hidden_div">
                                <div class="">
                                @if (!empty($session_data["user_select"]))
                                  @foreach ($session_data['user_select'] as $check)
                                    <div class="user_select_hidden_div_one">
                                        <input class="user_select_input_check_num" value="{{$check}}" type="hidden" id="">
                                    </div>
                                  @endforeach
                                @endif
                                </div>
                            </div>
                            
                            <div class="edit_form_div " id="user_select_check">
                              <p class="questionnaire_input_p">採用人材選択</p>
                              <p class="questionnaire_input_p user_select_alert_p" id="user_select_check_num"></p>
                              <div class="user_select_div">

                                @foreach ($issue_users as $user_item)
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

                                  <div class="user_message_alret_day_hm">
                                      <div class="checkbox_plural_div sukil_check_restriction_none">
                                      <input class="zinbutu_user interview_check check_input" name="user_select[]" value="{{$user_item->id}}" type="checkbox" id="interview_check">
                                      <div class="zinbutu_user_flex_div">
                                          <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label user_select_label_div"></div>
                                          <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                      </div>
                                    </div>
                                  </div>      

                                </div>
                              
                                @endforeach
                              </div>

                            </div>

                            <div class="submit_div" >
                                <input class="input_submit" type="submit" value="確認画面へ">
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