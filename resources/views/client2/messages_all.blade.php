<?php
$room_count=0;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/message.css') }}" rel="stylesheet">
        <title>メッセージ</title>
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>
        
        @if (session('msgs'))
            <p class="error">{{session('msgs')}}</p>
        @endif
            
        @include('client2.component.mypage_left')
<div class="main_div" id="main_div">
    @include('client2.component.mypage_header')


    <div class="top_title">
        <h3 class="title">メッセージ一覧</h3>
    </div>

    <div class="message_box_div">

    <!-- 相手からのメッセージがあればトークルームを表示 -->
      @if (isset($room_shop))
        @foreach ($room_shop as $shop)
          <?php $comennt_last = 1;?>
          <?php $comennt_last2 = 1;?>
          @if (count($room_comments[$room_count]) !== 0)
            <a class="message_box_one_a" href="{{ asset(config('const.title.title48'))}}/user_account/message/{{$room_id[$room_count]}}">
              <div class="message_box_one_div">
  
                <div class="user_img_message">
                  @if ($shop->client_image === null || $shop->client_image === "")  
                      <img class="user_img_msg" src="{{asset('template_img/face_red.png')}}">
                  @else
                      <img class="user_img_msg" src="{{asset('client_images/' . $shop->client_image )}}"/>
                  @endif
                </div>
          
                <div class="user_message_title_name">
                  <p class="user_message_name">{{$shop->shop_name}}</p>
                  @if (count($room_midoku_comments[$room_count]) == 0)
                    @foreach ($room_comments[$room_count] as $comment)
                      @if (count($room_comments[$room_count]) == $comennt_last)
                        <!-- <p class="user_message_title">新着メッセージがあります。</p> -->
                        <p class="user_message_title">{{$comment->comment}}</p>
                      @endif
                      <?php $comennt_last++;?>
                    @endforeach
                  @endif
                  @if (count($room_midoku_comments[$room_count]) !== 0)
                    <p class="user_message_title">新着メッセージがあります。</p>
                  @endif
                </div>
          
                <div class="user_message_alret_day_hm">
                  @if (count($room_midoku_comments[$room_count]) == 0)
                    @foreach ($room_comments[$room_count] as $comment)
                      @if (count($room_comments[$room_count]) == $comennt_last2)
                        <p class="user_message_day_hm">{{$comment->day_time}}</p>
                      @endif
                      <?php $comennt_last2++;?>
                    @endforeach
                  @endif

                  @if (count($room_midoku_comments[$room_count]) !== 0)
                    @foreach ($room_comments[$room_count] as $comment)
                      @if (count($room_comments[$room_count]) == $comennt_last2)
                        <p class="user_message_day_hm">{{$comment->day_time}}</p>
                      @endif
                      <?php $comennt_last2++;?>
                      @endforeach
                      <div class="user_message_alret"><span class="user_message_alret_span">{{count($room_midoku_comments[$room_count])}}</span></div>
                  @endif
                  <!-- <p class="user_message_day_hm">12/24</p> -->
                </div>      
                
              </div>
            </a>
          @endif
          <?php $room_count++;?>
        @endforeach
      @endif

    </div>

</div>


        

    </body>
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>