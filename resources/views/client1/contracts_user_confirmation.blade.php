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
        <title>稼働確認</title>
    </head>

    <style>
      .issue_contents_money {
        line-height: 30px;
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
                <h3 class="title">人材稼働確認</h3>
            </div>

           <!-- ///////////////////// -->

           @foreach ($contracts_item as $item)
            <div class="confirmation_input_div">
                <div class="confirmation_input_group_div">

                <div class="issues_one_div">

                  <div class="issues_contents_div">

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">契約ID</h4>
                      <div class="issue_contents_right_div">
                        <h3 class="issue_contents_money">{{$item->contacts_id}}</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">契約案件</h4>
                      <div class="issue_contents_right_div">
                        <a class="issue_contents_url" href="{{ asset(config('const.title.title47'))}}/client_account/my_issues_detail/{{$item->issue_id}}">
                          <h3 class="issue_contents_money">契約案件詳細</h3>
                        </a>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">契約満了日</h4>
                      <div class="issue_contents_right_div">
                        <h3 class="issue_contents_money">{{$item->contract_expiration_3month}}</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">契約状態</h4>
                      <div class="issue_contents_right_div">
                        <h3 class="issue_contents_money">契約満了</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">採用人材</h4>
                      <div class="issue_contents_right_div">
                        <a class="issue_contents_url" href="{{ asset(config('const.title.title47'))}}/client_account/user_detail/{{$item->user_number_id}}">
                          <h3 class="issue_contents_money">{{$item->contract_users_name}}</h3>
                        </a>
                      </div>
                    </div>

                  </div>

                  <div class="issue_edit_btn_box_div" style="padding:0;background: #fff;margin-bottom: 0;">
                      <a href="{{ asset(config('const.title.title47'))}}/client_account/user_confirmation_check/{{$item->id}}" class="issue_edit_btn_a">人材稼働確認</a>
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