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
        <style>

        .main_div.active {
            background: rgb(248, 252, 255);
        }
        .btn, .apply_submit, a.btn, button.btn {
          color: #fff;
        }
        </style>

        <title>{{config('const.title.title1')}}</title>
    </head>
    <body>
    @include('client2.component.header')
    @include('client2.component.mypage_left')

        <div class="main_div" id="main_div">
            <p class="search_all_p">
                @if (!empty($search_session['current_situation'])) 
                    @foreach ($todouhuken_list as $key=>$value)
                        @if ($key == $search_session['current_situation'])
                            {{$value}}、
                        @endif
                    @endforeach
                @endif
                @if (!empty($search_session['money1'])) 
                    下限{{$search_session['money1']}}万円、
                @endif
                @if (!empty($search_session['money2'])) 
                    上限{{$search_session['money2']}}万円、
                @endif

                @if (!empty($search_session['create_issues_checkbox1'])) 
                    @for ($i = 0;$i <= 6;$i++)
                        @foreach ($search_session['create_issues_checkbox1'] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                                @if($item == $key)
                                    {{$value}}、
                                @endif
                            @endforeach
                        @endforeach
                    @endfor
                @endif

                @if (!empty($search_session['create_issues_checkbox2'])) 
                    @for ($i = 7;$i <= 16;$i++)
                        @foreach ($search_session['create_issues_checkbox2'] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                                @if($item == $key)
                                    {{$value}}、
                                @endif
                            @endforeach
                        @endforeach
                    @endfor
                @endif

                @if (!empty($search_session['create_issues_checkbox3'])) 
                    @for ($i = 17;$i <= 19;$i++)
                        @foreach ($search_session['create_issues_checkbox3'] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                                @if($item == $key)
                                    {{$value}}、
                                @endif
                            @endforeach
                        @endforeach
                    @endfor
                @endif

                @if (!empty($search_session['create_issues_checkbox4'])) 
                    @for ($i = 20;$i <= 30;$i++)
                        @foreach ($search_session['create_issues_checkbox4'] as $item)
                            @foreach ($lists[$i] as $key=>$value)
                                @if($item == $key)
                                    {{$value}}、
                                @endif
                            @endforeach
                        @endforeach
                    @endfor
                @endif
            </p>
            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">検索結果{{$item_count}}件</h3>
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
                            <div class="issue_title_h3_div">
                                <a class="issue_detail_a" href="{{ asset(config('const.title.title48'))}}/search_detail/{{$item->id}}">
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
            <div class="pagination_div">
                <div class="pagination_ul_div">
                    <ul class="pagination">
                        @if ($prev == 0)
                            <li class="disabled pagination_li" aria-disabled="true">前のページ</li>
                        @else
                            <li class="pagination_li not_disabled"><a rel="prev" href="{{ asset(config('const.title.title48'))}}/search_list?page={{$prev}}" class="btn prev_next_btn">前のページ</a></li>
                        @endif

                        @if ($next !== 0)
                            <li class="pagination_li not_disabled"><a rel="next" href="{{ asset(config('const.title.title48'))}}/search_list?page={{$next}}" class="btn prev_next_btn">次のページ</a></li>
                        @else
                            <li class="disabled pagination_li" aria-disabled="true">次のページ</li>
                        @endif
                    </ul>
                </div>
            </div>

            
        </div>
        
    </body>
    <!-- @include('client2.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/main_page.js')}}"></script>