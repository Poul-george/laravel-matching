<?php

$box_index1 = 1;

?>

<!DOCTYPE html>
<html id="html">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <!-- <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script> -->
        <!-- <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>こだわり条件編集</title>
    </head>

    <body>
        @include('client2.component.mypage_left')
        
        <div class="main_div user_conditions_blade" id="main_div">
            @include('client2.component.mypage_header')
            @if (session('msgs'))
              <p class="error">{{session('msgs')}}</p>
            @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">こだわり条件</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client2.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit4()">
                        @csrf


                            <div class="thumbnail_div">

                                <div class="user_thumbnail_input_div ">

                                    <!-- ////////////////////////////グループ1 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_6" class="questionnaire_input_p alret_p alret_p_num_6"></p>
                                        <p class="questionnaire_input_p">特徴</p>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">20つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                            <!-- div hiddenn -->
                                            <div class="hidden_div">
                                                <div class="">
                                                    @if (isset($user_conditions_check_lists))
                                                        @foreach ($user_conditions_check_lists as $check)
                                                        <div class="hidden_div_one">
                                                            <input class="hidden_check_num5" value="{{$check}}" type="hidden" id="">
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- ふえる部分 -->
                                            @for ($l_x = 0; $l_x <= 8; $l_x++)
                                            <div class="edit_checkbox_num_div">


                                                <!-- for変更number -->
                                                @foreach ($user_conditions_title as $key=>$value) 
                                                    @if ($key == $box_index1)
                                                    <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                    @endif
                                                @endforeach

                                                <div class="checkbox_group_div">

                                                    @foreach ($user_conditions_list[$l_x] as $key=>$value) 
                                                        <div class="checkbox_plural_div sukil_check_restriction_none">
                                                            <input class="zinbutu_user check_input5" name="user_conditions[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                            <div class="zinbutu_user_flex_div">
                                                                <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label5"></div>
                                                                <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                <span class="checkbox_check_span">{{$value}}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    

                                                </div>

                                            </div>
                                            <?php $box_index1++; ?>
                                            @endfor
                                            <!-- ////////////////////// -->
                                        </div>
                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->

                                </div>
                            </div>

                            <!-- /////////////////////////// -->


                            <div class="submit_div" >
                                <input class="input_submit" name="input_submit" type="submit" value="変更する">
                            </div>

                        </form>         
                    </div>
                </div>
            </div>
        </div>

    </body>     
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>