<?php 
$room_count=0;
// var_dump($administrator_room_comments);
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

    <body style="background: #fffaff;">
        
        @if (session('msgs'))
            <p class="error">{{session('msgs')}}</p>
        @endif
            
        @include('client1.component.mypage_left')
<div class="main_div" id="main_div">
    @include('client1.component.mypage_header')


    <div class="top_title">
        <!-- <h3 class="title">{{config('const.title.title49')}}</h3> -->
        <h3 class="title">メッセージ一覧</h3>
    </div>

    <div class="message_box_div" style="height:auto">
      @if (empty($administrator_room_id))
        <form method="POST" action="" enctype="multipart/form-data" >
          @csrf
          <input class="managers_message_btn" type="submit" name="submit_msg" value="管理者へメッセージ">
          <input class="" type="hidden" name="shop_number_id" value="{{$item->id}}">
          <input class="" type="hidden" name="shop_id" value="{{$item->shop_id}}">
        </form>
      @endif

      @if (isset($administrator_room_id))
          <?php $administrator_comennt_last = 1;?>
          <?php $administrator_comennt_last2 = 1;?>
          <a class="message_box_one_a" href="{{ asset(config('const.title.title47'))}}/client_account/mg_message/{{$administrator_room_id->id}}">
            <div class="message_box_one_div">

              <div class="user_img_message">
                    <img class="user_img_msg" src="{{asset('template_img/face_green.png')}}">
              </div>
        
              <div class="user_message_title_name">
                <p class="user_message_name">管理者</p>
                  @if (!empty($administrator_room_midoku_comments))
                    @if (count($administrator_room_midoku_comments) == 0)
                      @foreach ($administrator_room_comments as $administrator_comment)
                        @if (count($administrator_room_comments) == $administrator_comennt_last)
                          <p class="user_message_title">{{$administrator_comment->comment}}</p>
                        @endif
                        <?php $administrator_comennt_last++;?>
                      @endforeach
                    @endif

                    @if (count($administrator_room_midoku_comments) !== 0)
                      <p class="user_message_title">新着メッセージがあります。</p>
                    @endif
                  @endif

              </div>
        
              <div class="user_message_alret_day_hm">
                @if (!empty($administrator_room_midoku_comments))
                  @if (count($administrator_room_midoku_comments) == 0)
                    @foreach ($administrator_room_comments as $administrator_comment)
                      @if (count($administrator_room_comments) == $administrator_comennt_last2)
                        <p class="user_message_day_hm">{{$administrator_comment->day_time}}</p>
                      @endif
                      <?php $administrator_comennt_last2++;?>
                    @endforeach
                  @endif

                  @if (count($administrator_room_midoku_comments) !== 0)
                    @foreach ($administrator_room_comments as $administrator_comment)
                      @if (count($administrator_room_comments) == $administrator_comennt_last2)
                        <p class="user_message_day_hm">{{$administrator_comment->day_time}}</p>
                      @endif
                      <?php $administrator_comennt_last2++;?>
                      @endforeach
                      <div class="user_message_alret"><span class="user_message_alret_span">{{count($administrator_room_midoku_comments)}}</span></div>
                  @endif
                @endif
              </div>      
              
            </div>
          </a>
      @endif
    </div>


    <div class="message_box_div">

      @if (isset($room_user))
        @foreach ($room_user as $user)
          <?php $comennt_last = 1;?>
          <?php $comennt_last2 = 1;?>
          <a class="message_box_one_a" href="{{ asset(config('const.title.title47'))}}/client_account/message/{{$room_id[$room_count]}}">
            <div class="message_box_one_div">

              <div class="user_img_message">
                @if ($user->user_image === null || $user->user_image === "")  
                    <img class="user_img_msg" src="{{asset('template_img/face_red.png')}}">
                @else
                    <img class="user_img_msg" src="{{asset('user_images/' . $user->user_image )}}"/>
                @endif
              </div>
        
              <div class="user_message_title_name">
                <p class="user_message_name">{{$user->user_name}}</p>
                  @if (count($room_midoku_comments[$room_count]) == 0)
                    @foreach ($room_comments[$room_count] as $comment)
                      @if (count($room_comments[$room_count]) == $comennt_last)
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
              </div>      
              
            </div>
          </a>
          <?php $room_count++;?>
        @endforeach
      @endif

    </div>


</div>


        

    </body>
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>