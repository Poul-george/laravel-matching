<?php 
$room_count=0;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/form_client1.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/message.css') }}" rel="stylesheet">
        <title>メッセージ</title>
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body >
            
<div class="main_div" id="main_div">


  <div class="message_box_div message_post_page_div">
    <div class="message_box_div_flex">
      
          <div class="message_opponent_div_flex">
            <a class="message_box_one_a" href="{{ asset(config('const.title.title47'))}}/client_account/messages" style="color:#fff;">
              <div class="return_icon_div"><i class="gg-chevron-left"></i></div>
            </a>
            <p class="message_opponent_name">{{$user_data->user_name}}様</p>
          </div>
      
          <div class="message_text_div" id="message_text_div">
            
            <!-- //ループ -->
            @foreach ($room_comments as $comment)

              <!-- //自分 -->
              @if ($comment->shop_id == $shop_id)
                <div class="me_message_img_day_hm_div_flex">
                  @if ($comment->show_flag == 1)
                    <p class="show_message">既読</p>
                  @endif
                  <div class="message_text my_message">
                    <span class="message_ymd_span">{{$comment->created_at}}</span>
                    <p>{!! nl2br(e($comment->comment)) !!}</p>
                  </div>
                    @if ($shop_image === null || $shop_image === "")  
                        <img class="message_img_msg"src="{{asset('template_img/face_red.png')}}">
                    @else
                        <img class="message_img_msg" src="{{asset('client_images/' . $shop_image )}}"/>
                    @endif
                </div>
              @endif

              <!-- 相手 -->
              @if ($comment->user_id == $user_data->user_id)
                <div class="opponent_message_img_day_hm_div_flex">
                    @if ($user_data->user_image === null || $user_data->user_image === "")  
                        <img class="message_img_msg"src="{{asset('template_img/face_blue.png')}}">
                    @else
                        <img class="message_img_msg" src="{{asset('user_images/' . $user_data->user_image )}}"/>
                    @endif
                  <div class="message_text opponent_message">
                    <span class="message_ymd_span">{{$comment->created_at}}</span>
                    <p>{!! nl2br(e($comment->comment)) !!}</p>
                  </div>
                </div>
              @endif

            @endforeach

          </div>

          <div class="message_post_div">
            <form method="POST" action="" enctype="multipart/form-data"class="message_post_form" action="" onsubmit="return cancelsubmit_message_post()">
            @csrf
              <div class="message_post_div_flex">
                <input type="hidden" name="user_id" value="{{$user_data->user_id}}">
                <textarea name="message_post_textarea" class="message_post_textarea" column="1"></textarea>
                <input type="submit" class="message_post_sub" name="post_message" value="送信">
              </div>
            </form>
          </div>
      

    </div>
  </div>
  

</div>


        

    </body>
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>