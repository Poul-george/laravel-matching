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
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <title>応募一覧</title>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <style>

      .main_div {
        margin-top: 0;
      }
      .main_div.active {
        background: rgb(248, 252, 255);
      }
      body {
        background: rgb(248, 252, 255);
      }
    </style>

    <body>
        
        @if (session('msgs'))
            <p class="error">{{session('msgs')}}</p>
        @endif
            
        @include('client2.component.mypage_left')
<div class="main_div" id="main_div">
    @include('client2.component.mypage_header')


    <div class="top_title">
        <!-- <h3 class="title">{{config('const.title.title49')}}</h3> -->
        <h3 class="title">応募一覧</h3>
    </div>

    <!-- ///////////////////// -->

    @foreach ($item2 as $item)
            <div class="confirmation_input_div">
                <div class="confirmation_input_group_div">

                <div class="issues_one_div">

                  <div class="issue_img_title_flex">
                    <div class="issue_img_div">
                      @if ($item->client_image === null || $item->client_image === "")  
                          <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                      @else
                          <img class="issue_img" src="{{asset('client_images/' . $item->client_image )}}"/>
                      @endif
                    </div>
                    <div class="issue_title_h3_div" >
                      <a class="issue_detail_a" href="{{ asset(config('const.title.title48'))}}/user_account/apply_issues_detail/{{$item->id}}">
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
                      <h4 class="issue_contents_h4">職種</h4>
                      <div class="issue_contents_right_skill">
                        @for ($i = 0;$i <= 6;$i++)
                          @foreach ($matching_position[$count] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                              @if($item == $key)
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
                          @foreach ($matching_skill[$count] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                              @if($item == $key)
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
                          @foreach ($matching_industry[$count] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                              @if($item == $key)
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



                  </div>

                </div>

              </div>
            </div>
            <?php $count++; ?>
          @endforeach

  <!-- /////// -->
        

</div>


        

    </body>
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>