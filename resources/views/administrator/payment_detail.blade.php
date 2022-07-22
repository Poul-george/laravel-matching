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

        <title>支払情報詳細</title>
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
            <h3 class="title">支払情報</h3>
        </div>


        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">支払情報</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">支払&契約ID</h4>
                  <p class="company_info_detail_p">{{$payment_item->contacts_id}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約詳細</h4>
                <p class="company_info_detail_p"><a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/contacts_detail/{{$payment_item->contacts_number_id}}">契約詳細ページ</a></p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約会社</h4>
                <p class="company_info_detail_p">
                  <a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/company_account_detail/{{$payment_item->shop_number_id}}">
                    {{$payment_item->shop_name}}
                  </a>
                </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約会社ID</h4>
                <p class="company_info_detail_p">
                  <a class="detail_a_url" href="{{ asset(config('const.title.title49'))}}/company_account_detail/{{$payment_item->shop_number_id}}">
                    {{$payment_item->shop_id}}
                  </a>
                </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">支払金額</h4>
                  <p class="company_info_detail_p">{{$payment_item->payment_money}}円</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">支払期限</h4>
                  <p class="company_info_detail_p">{{$payment_item->payment_term}}</p>
              </div>


              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">支払状態</h4>
                  <p class="company_info_detail_p">

                    <?php
                      $payment_item_judge = "";
                      $three_month_Date = new DateTime(date("{$payment_item->payment_term}"));

                      $todayDate = new DateTime(date("Y-m-d"));
                      $intvl = $three_month_Date->diff($todayDate);

                     //未払い
                      $payment_item_out = "";
                      if ($payment_item->payment_judge == null) {
                        $payment_item_judge = "1";
                        //支払期限超過
                        if ($three_month_Date <= $todayDate){
                            $payment_item_out = "out";
                        }
                      }
                      
                      //支払完了
                      if ($payment_item->payment_judge == '1') {
                        $payment_item_judge = "2";
                      }

                    ?>

                    @if ($payment_item_judge == '1')
                      未払い
                    @elseif ($payment_item_judge == '2')
                      支払済み
                    @endif

                  </p>
              </div>

          </div>
        </div>


      </div>
        
    </body>
    <!-- @include('client2.component.footer') -->



</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>