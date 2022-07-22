<?php
function insertStr1($text, $insert, $num){
  return substr_replace($text, $insert, $num, 0);
}
$count = 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>支払</title>
    </head>

    <style>
      .issue_contents_money {
        line-height: 30px;
      }
      .stripe-button-el {
        margin: 0 auto;
        background: #CC00FF;
        display: block;
      }
    </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')
            @if (session('msgs')) 
              <p class="msg_center">{{session('msgs')}}</p> 
            @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">未払いお支払</h3>
            </div>

           <!-- ///////////////////// -->

           @foreach ($payment_item as $item)
            <div class="confirmation_input_div">
                <div class="confirmation_input_group_div">

                <div class="issues_one_div">

                  <div class="issues_contents_div">

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">支払ID</h4>
                      <div class="issue_contents_right_div">
                        <h3 class="issue_contents_money">{{$item->contacts_id}}</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">支払金額</h4>
                      <div class="issue_contents_right_div">
                          <h3 class="issue_contents_money">{{number_format($item->payment_money)}}円</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">支払期限</h4>
                      <div class="issue_contents_right_div">
                        <h3 class="issue_contents_money">{{$item->payment_term}}</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">支払状態</h4>
                      <div class="issue_contents_right_div">

                      <?php
                        $payment_item_judge = "";
                        $three_month_Date = new DateTime(date("{$item->payment_term}"));

                        $todayDate = new DateTime(date("Y-m-d"));
                        $intvl = $three_month_Date->diff($todayDate);

                      //未払い
                        $payment_item_out = "";
                        if ($item->payment_judge == null) {
                          $payment_item_judge = "1";
                          //支払期限超過
                          if ($three_month_Date <= $todayDate){
                              $payment_item_out = "out";
                          }
                        }
                        
                        //支払完了
                        if ($item->payment_judge == '1') {
                          $payment_item_judge = "2";
                        }

                      ?>

                          <h3 class="issue_contents_money">
                          @if ($payment_item_judge == '1')
                            未払い
                          @elseif ($payment_item_judge == '2')
                            支払済み
                          @endif

                          </h3>
                      </div>
                    </div>

                  </div>

                    <div class="issue_edit_btn_box_div" style="padding:0;background: #fff;margin-bottom: 0;">
                        <form action="{{ asset('/client1/client_account/payment') }}" method="POST">
                          {{ csrf_field() }}
                          <script 
                            

                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"     
                            data-key="{{ $stripe_pk_key }}"
                            data-amount="{{ $item->payment_money }}"
                            data-name="Stripe決済デモサイト"
                            data-label="支払をする"
                            data-description="これはStripeのデモです。"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-currency="JPY">
                          </script>
                          <input type="hidden" name="payment_contacts_id" value="{{$item->contacts_id}}">
                        </form>
                    </div>


                </div>

              </div>
            </div>
            <?php $count++; ?>
          @endforeach



  <!-- /////// -->


        </div>
    </body>
    <!-- @include('client1.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>