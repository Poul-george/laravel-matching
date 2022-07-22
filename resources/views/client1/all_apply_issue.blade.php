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
        <title>案件一覧</title>
    </head>

    <style>
      @media screen and (max-width: 799px) {
        .issue_edit_btn_a {
          width: 50%;
        }
      }
    </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')
            @if (session('msgs'))
            <p class="error">{{session('msgs')}}</p>
        @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">応募のある案件一覧</h3>
            </div>

           <!-- ///////////////////// -->

           @foreach ($item2 as $item)
            <div class="confirmation_input_div">
              @if ($item->flag == 0)
              <p class="judge_issue_p">申請判断中</p>
              <p class="judge_issue_sub_p">申請判断中のものは、掲載されません</p>
              <div class="confirmation_input_group_div not_view">
              @else
                <div class="confirmation_input_group_div">
              @endif

                <div class="issues_one_div">

                  <div class="issue_img_title_flex">
                    <div class="issue_img_div">
                      @if ($shop_image === null || $shop_image === "")  
                          <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                      @else
                          <img class="issue_img" src="{{asset('client_images/' . $shop_image )}}"/>
                      @endif
                    </div>
                    <div class="issue_title_h3_div">
                      <a class="issue_detail_a" href="{{ asset(config('const.title.title47'))}}/client_account/my_issues_detail/{{$item->id}}">
                        <h3 class="issue_title_h3">{{$item->matter_name}}</h3>
                      </a>
                    </div>
                  </div>

                  <div class="issues_contents_div">

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">単価</h4>
                      <div class="issue_contents_right_div">
                        <?php
                          if (strlen($item->basic_info_select1_1) === 3) {
                            $money1 = insertStr1($item->basic_info_select1_1, ',', 1);
                          } else {
                            $money1 = $item->basic_info_select1_1;
                          }
                          if (strlen($item->basic_info_select1_2) === 3) {
                            $money2 = insertStr1($item->basic_info_select1_2, ',', 1);
                          } else {
                            $money2 = $item->basic_info_select1_2;
                          }
                        ?>
                        <h3 class="issue_contents_money"><span class="money_span">{{$money1}}0,000 ~ {{$money2}}0,000</span>円/月</h3>
                      </div>
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">応募件数</h4>
                      <div class="issue_contents_right_skill">
                        <div class="confirmation_input_a_div issue_contents">
                          <a href="{{ asset(config('const.title.title47'))}}/client_account/issue_apply_user/{{$item->id}}" class="confirmation_input_a">
                            {{$issue_apply_num[$count]}}件
                          </a>
                        </div>
                      </div> 
                    </div>


                  </div>

                  @if ($item->flag == 2)
                    <div class="issue_edit_btn_box_div" style="padding:0;background: #fff;margin-bottom: 0;">
                        <a class="issue_edit_btn_a" style="background: rgb(70, 70, 70);">人材確定済み</a>
                    </div>
                  @else
                    <div class="issue_edit_btn_box_div" style="padding:0;background: #fff;margin-bottom: 0;">
                        <a href="{{ asset(config('const.title.title47'))}}/client_account/contract_form/{{$item->id}}" class="issue_edit_btn_a">人材を確定する</a>
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
    @include('client1.component.footer')
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>