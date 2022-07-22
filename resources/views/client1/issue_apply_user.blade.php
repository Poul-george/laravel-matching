<?php
function insertStr1($text, $insert, $num){
  return substr_replace($text, $insert, $num, 0);
}
$count = 0;
$num_count = 1;
$shop_id=session()->get('shop_id');
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
        <title>案件応募</title>
    </head>
    <style>

      .confirmation_btn_div {
        margin: 40px 40px 20px;
      }
      .submit_flex {
          width: calc(100% - 5%);
      }
      .user_defeated_message_form {
        width: 100%;
      }
      @media screen and (max-width: 799px) {
        .confirmation_btn_div{
          margin: 40px 0 20px;
        }
      }
      @media screen and (min-width: 1000px){
        .confirmation_btn_div {
          width: calc(100% - 200px);
          margin: 40px 100px 20px;
        }
      }

    </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">応募者一覧</h3>
            </div>

           <!-- ///////////////////// -->

           @foreach ($item2 as $item)
            <div class="confirmation_input_div">
                <div class="confirmation_input_group_div">
                  
                  <div class="issues_one_div">
                  <p class="questionnaire_input_p" style="padding: 0 10px 10px">{{$item->user_forte}}</p>

                  <div class="issue_img_title_flex">
                    <div class="issue_img_div">
                      @if ($item->user_image === null || $item->user_image === "")  
                          <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                      @else
                          <img class="issue_img" src="{{asset('user_images/' . $item->user_image )}}"/>
                      @endif
                    </div>
                    <div class="issue_title_h3_div" style="width:100%;">
                      <a class="issue_detail_a" href="{{ asset(config('const.title.title47'))}}/client_account/user_detail/{{$item->id}}">
                        <h3 class="issue_title_h3">{{$item->user_name}}</h3>
                      </a>
                    </div>
                    @if ($apply_contacts_flag[$count] == 1)
                      <style>
                            .rate_num{{$num_count}}:before{
                              color: #ffb81c;
                            }
                      </style>
                    @endif
                    <div class="rate rate_num{{$num_count}}"></div>
                    <div id="rate_info_div{{$num_count}}" class="rate_info_div">
                      <div class="rate_info_div_text">
                        <p class="rate_info_p">このユーザーをお気に入りに設定することで、一覧表示で上位に表示されます。<br><br> 人材選定では、お気に入りに選択されているユーザーのみが表示されます。</p>
                      </div>
                    </div>
                  </div>

                  <div class="issues_contents_div">
                    <!-- ////////// -->
                 
                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">職種</h4>
                      <div class="issue_contents_right_skill">
                        @for ($i = 0;$i <= 6;$i++)
                          @foreach ($experience_positions[$count] as $skill_item)
                            @foreach ($lists[$i] as $key=>$value)
                              @if($skill_item == $key)
                                <div class="confirmation_input_a_div issue_contents">
                                  <a class="confirmation_input_a">
                                    {{$value}}
                                  </a>
                                </div>
                              @endif
                            @endforeach
                          @endforeach
                        @endfor
                      </div> 
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">スキル</h4>
                      <div class="issue_contents_right_skill">
                        @for ($i = 7;$i <= 16;$i++)
                          @foreach ($experience_skills[$count] as $skill_item)
                            @foreach ($lists[$i] as $key=>$value)
                              @if($skill_item == $key)
                                <div class="confirmation_input_a_div issue_contents">
                                  <a class="confirmation_input_a">
                                    {{$value}}
                                  </a>
                                </div>
                              @endif
                            @endforeach
                          @endforeach
                        @endfor
                      </div> 
                    </div>

                    <div class="issue_contents_flex">
                      <h4 class="issue_contents_h4">業界</h4>
                      <div class="issue_contents_right_skill">
                        @for ($i = 17;$i <= 19;$i++)
                          @foreach ($experience_industrys[$count] as $skill_item)
                            @foreach ($lists[$i] as $key=>$value)
                              @if($skill_item == $key)
                                <div class="confirmation_input_a_div issue_contents">
                                  <a class="confirmation_input_a">
                                    {{$value}}
                                  </a>
                                </div>
                              @endif
                            @endforeach
                          @endforeach
                        @endfor
                      </div> 
                    </div>

                    <!-- ////// -->
                  </div>

                  <div class="confirmation_btn_div">
                      <form method="POST" class="user_defeated_message_form" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit_defeated()">
                    
                        @csrf
                          <input type="hidden" name="user_id" value="{{$item->user_id}}">
                          <input type="hidden" name="apply_id" value="{{$apply_contacts_id[$count]}}">
                          <input type="hidden" name="shop_id" value="{{$shop_id}}">
                    
                          <div class="submit_div submit_flex" >
                            <input class="input_submit return_submit" name="defeated_user" type="submit" value="応募を見送る">
                          </div>
                    
                      </form>
                    
                      <form method="POST" class="user_defeated_message_form" action="" enctype="multipart/form-data" >
                    
                        @csrf
                          <input type="hidden" name="user_id" value="{{$item->user_id}}">
                          <input type="hidden" name="apply_id" value="{{$apply_contacts_id[$count]}}">
                          <input type="hidden" name="shop_id" value="{{$shop_id}}">
                    
                          <div class="submit_div submit_flex" >
                            <input class="input_submit" type="submit" name="message_room" value="メッセージ">
                          </div>
                    
                      </form>
                  </div>

                </div>

              </div>
            </div>

            <!-- //////form -->
            <form action="" method="post" class="issue_apply_user_form{{$num_count}}">
            @csrf
              <input type="hidden" name="user_id" value="{{$item->user_id}}">
              <input type="hidden" name="apply_id" value="{{$apply_contacts_id[$count]}}">
              <input type="hidden" name="shop_id" value="{{$shop_id}}">
              <input type="hidden" name="user_check" value="check">
              <input style="display:none" type="submit" name="none_sub"  class="apply_submit">
            </form>

            <?php $count++; ?>
            <?php $num_count++; ?>
          @endforeach

  <!-- /////// -->


        </div>
    </body>
    @include('client1.component.footer')
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>