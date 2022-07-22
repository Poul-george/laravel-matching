<?php
function insertStr1($text, $insert, $num){
    return substr_replace($text, $insert, $num, 0);
  }
  // //ab|Text|cdef
  // echo insertStr1('abcdef', '|Text|', 2);
  $count = 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <!-- <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}">  -->
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <link href="{{ asset('/css/message.css') }}" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="{{ asset('js/chartjs-plugin-labels.js')}}"></script>
        <style>

      .main_div {
        margin: 0;
      }
      .main_div.active {
        background: rgb(248, 252, 255);
      }
      .detail_a_url {
        width: 75%;
      }
      @media screen and (max-width: 799px) {
        .user_select_div {
          margin: 20px 10px 20px;
        }
      }
    </style>

        <title>契約詳細</title>
    </head>
    <body>
      @include('administrator.component.administrator_left')
      <div class="main_div" id="main_div">
        @include('administrator.component.administrator_header')
        @if (session('msgs')) 
          <p class="msg_center">{{session('msgs')}}</p> 
        @endif

        <div class="top_title">
            <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
            <h3 class="title">契約情報</h3>
        </div>


        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">契約情報</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約ID</h4>
                  <p class="company_info_detail_p">{{$contacts_item->contacts_id}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約案件</h4>
                <p class="company_info_detail_p"><a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/issue_detail/{{$contacts_item->issue_id}}">案件詳細</a></p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約会社</h4>
                <p class="company_info_detail_p">
                  <a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/company_account_detail/{{$contacts_item->shop_number_id}}">
                    {{$contacts_item->shop_name}}
                  </a>
                </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約会社ID</h4>
                <p class="company_info_detail_p">
                  <a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/company_account_detail/{{$contacts_item->shop_number_id}}">
                    {{$contacts_item->shop_id}}
                  </a>
                </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">担当者名</h4>
                  <p class="company_info_detail_p">{{$contacts_item->shop_tantou_name}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約日時</h4>
                  <p class="company_info_detail_p">{{$contacts_item->created_at}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">人材稼動開始日</h4>
                  <p class="company_info_detail_p">{{$contacts_item->operation_start_at}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約満了日</h4>
                  <p class="company_info_detail_p">{{$contacts_item->contract_expiration_3month}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約状態</h4>
                  <p class="company_info_detail_p">

                    <?php
                      $contacts_item_judge = "";
                      $three_month_Date = new DateTime(date("{$contacts_item->contract_expiration_3month}"));

                      $todayDate = new DateTime(date("Y-m-d"));
                      $intvl = $three_month_Date->diff($todayDate);

                      //契約満了
                      if ($three_month_Date <= $todayDate){
                        //3monthが今日を含む過去
                        if ($contacts_item->payment_judge == null && $contacts_item->user_judge == '0') {
                            //未払い：未人材確認
                            $contacts_item_judge = "1";
                        }
                      }

                      //人材非稼働
                      if ($three_month_Date <= $todayDate){
                        //3monthが今日を含む過去
                        if ($contacts_item->payment_judge == null && $contacts_item->user_judge == '1') {
                            //未払い：未人材確認
                            $contacts_item_judge = "2";
                        }
                      }
                      
                      //未払い
                      if ($three_month_Date <= $todayDate){
                        //3monthが今日を含む過去
                        if ($contacts_item->payment_judge == null && $contacts_item->user_judge == '2') {
                            //未払い：未人材確認
                            $contacts_item_judge = "3";
                        }
                      }
                      
                      //支払完了
                      if ($three_month_Date <= $todayDate){
                        //3monthが今日を含む過去
                        if ($contacts_item->payment_judge == '1' && $contacts_item->user_judge == '2') {
                            //未払い：未人材確認
                            $contacts_item_judge = "4";
                        }
                      }

                      //支払完了
                      if ($three_month_Date > $todayDate){
                        //契約期間外
                        $contacts_item_judge = "5";
                      }
                    ?>

                    @if ($contacts_item_judge == '1')
                      契約満了
                    @elseif ($contacts_item_judge == '2')
                      人材確定済み(非稼働)
                    @elseif ($contacts_item_judge == '3')
                      人材確定済み(未払い)
                    @elseif ($contacts_item_judge == '4')
                      人材確定済み(支払済み)
                    @elseif ($contacts_item_judge == '5')
                      契約期間外
                    @else
                      契約期間中
                    @endif

                  </p>
              </div>

              @if (!empty($contacts_item->reason_textarea)) 
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">非稼働理由</h4>
                    <p class="company_info_detail_p">{{$contacts_item->reason_textarea}}</p>
                </div>
              @endif

          </div>
        </div>

        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">人材情報</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">人材人数</h4>
                  <p class="company_info_detail_p">{{$contacts_item->contract_users_number}}名</p>
              </div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">人材情報</h4>
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
                      <a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/user_account_detail/{{$user_item->id}}">
                        <p class="user_message_name">{{$user_item->user_name}}</p>
                      </a>
                    </div>   

                  </div>

                </div>

              </div>

          </div>
        </div>


      </div>
        
    </body>
    <!-- @include('client2.component.footer') -->



</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>