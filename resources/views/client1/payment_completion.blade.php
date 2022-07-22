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

    <script>
      cancelsubmit_receipt
      function cancelsubmit_receipt() {
        if (confirm('領収書は一度しか発行されません。\n領収書発行後は、ダウンロードをして、保存してください。')) {
        } else {
          return false
        }
      }
    </script>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')
            @if (session('msgs')) 
              <p class="msg_center">{{session('msgs')}}</p> 
            @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">お支払い完了一覧</h3>
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
                      <h4 class="issue_contents_h4">支払日</h4>
                      <div class="issue_contents_right_div">
                        <h3 class="issue_contents_money">{{$item->payment_day}}</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">支払状態</h4>
                      <div class="issue_contents_right_div">
                          <h3 class="issue_contents_money">
                            支払済み
                          </h3>
                      </div>
                    </div>

                  </div>

                  <!-- 領収書 -->

                  @if ($item->receipt_flag == NULL)
                    <div class="issue_edit_btn_box_div" style="padding:0;background: #fff;margin-bottom: 0;">
                      <form action="" method="POST" onsubmit="return cancelsubmit_receipt()">
                        @csrf
                        <input type="submit" name="receipt_submit" value="領収書発行" class="issue_edit_btn_a">
                        <input type="hidden" name="pay_id" value="{{$item->id}}" >
                        <input type="hidden" name="contacts_id" value="{{$item->contacts_id}}" >
                      </form>
                    </div>
                  @else
                    <div class="issue_edit_btn_box_div" style="padding:0;background: #fff;margin-bottom: 0;">
                        <a class="issue_edit_btn_a" style="background:rgb(50,50,50); font-size: 13px;">領収書発行済</a>
                    </div>
                  @endif


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