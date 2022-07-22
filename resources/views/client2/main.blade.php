<?php
  $box_index1 = 1;$box_index2 = 1;$box_index3 = 1;$box_index4 = 1;$box_index5 = 1;$box_index6 = 1;
  $box_index2_2 = 8;$box_index3_2 = 18;$box_index4_2 = 19;$box_index5_2 = 20;$box_index6_2 = 21;
  $list_index = 0;$list_index2 = 0;$list_index3 = 0;$list_index4 = 0;$list_index5 = 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <!-- <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}">  -->
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 

        <title>{{config('const.title.title1')}}</title>
    </head>

    <style>

        .top_title_img_p {
            position: absolute;
            z-index: 2;
            margin: 100px calc( (100% - 613px) / 2 );
            font-size: 28px;
            color: #fff;
            font-weight: 600;
            text-shadow: 1px 2px 3px #808080;
        }
        .top_title_img_div {
            background: #000;
            height: 400px;
        }
        .top_title_img {
            opacity: 0.7;
        }
        @media screen and (max-width: 799px) {
            .top_title_img_div {
                height: 250px;
            }
            .top_title_img_p {
                margin: 50px calc( (100% - 525.5px) / 2 );
                font-size: 24px;
            }
        }
        @media screen and (max-width: 599px) {
            .top_title_img_div {
                height: 250px;
            }
            .top_title_img_p {
                margin: 50px calc( (100% - 481.6px) / 2 );
                font-size: 22px;
                right: 0px;
                left: 0px;
                margin-right: 0px;
                margin-left: 0px;
                width: auto;
                text-align: center;
            }
            .top_title_img_p span {
                display: block;
            }
        }
    </style>



    <body>
    @include('client2.component.header')
    @include('client2.component.mypage_left')

        <div class="main_div" id="main_div">
            <div class="top_title_img_div">
                <p class="top_title_img_p">ITシステム運用に特化した<span>求人・案件検索サイト</span></p>
                <img class="top_title_img" src="{{asset('template_img/トップページメイン画像.jpg')}}"/>
            </div>

            <!-- //form -->

            <div class="mypage_edit_div">
                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" >
                        @csrf

                            <!-- //////////////////////////////////////////////////////////////// -->
                            <div class="edit_form_div search_from_div">
                            <a name="search"></a>
                            <p class="judge_issue_sub_p">フリーワード検索</p>
                                <div class="word_search_div">
                                    <input id="" class="input_text max_input_text"  type="text" name="search_word" value="" >
                                    <input class="search_word_submit" name="search_word_submit" type="submit" value="検索">
                                </div>
                            </div>

                            <div class="input_title_h3_div" style="padding-left:10px;"><h3 class="input_title_h3">条件を選択して探す</h3></div>

                            <div class="edit_form_div search_from_div">
                                <div class="cp_ipselect cp_sl01 desired_fulsize_select">
                                    <select class="cp_sl05" name="current_situation" >
                                        <option value="" selected>地域を選択</option>
                                        @foreach ($todouhuken_list as $key=>$value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="edit_form_div search_from_div">
                                <div class="width_1000_flex_div">
                                    <div class="select_flex">
                                        <div class="cp_ipselect cp_sl01 select_3 ">
                                            <select class="cp_sl06 money_width1" name="money1" >
                                                    <option value="" selected>単価（下限）なし</option>
                                                @for ($i = 10; $i <= 200;$i+=5)
                                                    <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    
                                        <label class="input_text_label input_text_label_flex in_text_label">〜</label>
                                    
                                        <div class="cp_ipselect cp_sl01 select_3 " style="margin-right: 0px;">
                                            <select class="cp_sl06 money_width2" name="money2" >
                                                <option value="" selected>単価（上限）なし</option>
                                                @for ($i = 10; $i <= 200;$i+=5)
                                                    <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                              <div class="thumbnail_div">

                                <div class="user_thumbnail_input_div ">

                                    <div class='multipletab'>
                                        <div class='tab-buttons'>
                                            <span id='content1'>ポジション</span>
                                            <span id='content2'>スキル</span>
                                            <span id='content3'>業界・サービス</span>
                                            <span id='content4'>その他</span>
                                        </div>
                                    </div>

                                    <div class='tab-content'>
                                        <!-- ////////////////////////////グループ1 -->
                                        <div class="edit_form_div experienced_companies_form_div check_content_div" id='content1'>
                                            <div class="edit_checkbox_plural_div">

                                                <!-- ふえる部分 -->
                                                @for ($l_x = 0; $l_x <= 6; $l_x++)
                                                <div class="edit_checkbox_num_div">

                                                    <!-- for変更number -->
                                                    @foreach ($list_title[0] as $key=>$value) 
                                                        @if ($key == $box_index1)
                                                        <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                        @endif
                                                    @endforeach

                                                    <div class="checkbox_group_div">

                                                        @foreach ($lists[$l_x] as $key=>$value) 
                                                            <div class="checkbox_plural_div sukil_check_restriction_none">
                                                                <input class="zinbutu_user check_input1" name="create_issues_checkbox1[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                                <div class="zinbutu_user_flex_div">
                                                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label1"></div>
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

                                        <!-- ////////////////////////////グループ2 -->
                                        <div class="edit_form_div experienced_companies_form_div check_content_div" id='content2'>
                                            <div class="edit_checkbox_plural_div">

                                                <!-- ふえる部分 -->
                                                @for ($l_x = 7; $l_x <= 16; $l_x++)
                                                <div class="edit_checkbox_num_div">

                                                    <!-- for変更number -->
                                                    @foreach ($list_title[1] as $key=>$value) 
                                                        @if ($key == $box_index2)
                                                        <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                        @endif
                                                    @endforeach

                                                    <div class="checkbox_group_div">

                                                        @foreach ($lists[$l_x] as $key=>$value) 
                                                            <div class="checkbox_plural_div sukil_check_restriction_none">
                                                                <input class="zinbutu_user check_input2" name="create_issues_checkbox2[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                                <div class="zinbutu_user_flex_div">
                                                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label2"></div>
                                                                    <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                    <span class="checkbox_check_span">{{$value}}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>
                                                <?php $list_index++; ?><?php $box_index2++; ?><?php $box_index2_2++; ?>
                                                @endfor
                                                <!-- ////////////////////// -->
                                            </div>
                                        </div>
                                        <!-- /////////////////////////////////////////////////////// -->

                                        <!-- ////////////////////////////グループ3 -->
                                        <div class="edit_form_div experienced_companies_form_div check_content_div" id='content3'>
                                            <div class="edit_checkbox_plural_div">

                                                <!-- ふえる部分 -->
                                                @for ($l_x = 17; $l_x <= 19; $l_x++)
                                                <div class="edit_checkbox_num_div">

                                                    <!-- for変更number -->
                                                    @foreach ($list_title[2] as $key=>$value) 
                                                        @if ($key == $box_index3)
                                                        <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                        @endif
                                                    @endforeach

                                                    <div class="checkbox_group_div">

                                                        @foreach ($lists[$l_x] as $key=>$value) 
                                                            <div class="checkbox_plural_div sukil_check_restriction_none">
                                                                <input class="zinbutu_user check_input3" name="create_issues_checkbox3[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                                <div class="zinbutu_user_flex_div">
                                                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label3"></div>
                                                                    <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                    <span class="checkbox_check_span">{{$value}}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>
                                                <?php $box_index3++; ?><?php $box_index3_2++; ?><?php $list_index2++; ?>
                                                @endfor
                                                <!-- ////////////////////// -->
                                            </div>
                                        </div>
                                        <!-- /////////////////////////////////////////////////////// -->

                                        <!-- ////////////////////////////グループ4 -->
                                        <div class="edit_form_div experienced_companies_form_div check_content_div" id='content4'>

                                            <div class="edit_checkbox_plural_div">
                                                <!-- ふえる部分 -->
                                                @for ($l_x = 20; $l_x <= 20; $l_x++)
                                                <div class="edit_checkbox_num_div">

                                                    <!-- for変更number -->
                                                        <p class="experienced_companies_p edit_checkbox_plural_p">テクノロジー</p>

                                                    <div class="checkbox_group_div">

                                                        @foreach ($lists[$l_x] as $key=>$value) 
                                                            <div class="checkbox_plural_div sukil_check_restriction_none">
                                                                <input class="zinbutu_user check_input4" name="create_issues_checkbox4[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                                <div class="zinbutu_user_flex_div">
                                                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label4"></div>
                                                                    <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                    <span class="checkbox_check_span">{{$value}}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>
                                                <?php $box_index4++; ?><?php $box_index4_2++; ?><?php $list_index3++; ?>
                                                @endfor
                                                <!-- ////////////////////// -->

                                                <!-- ふえる部分 -->
                                                @for ($l_x = 21; $l_x <= 21; $l_x++)
                                                    <div class="edit_checkbox_num_div">

                                                        <!-- for変更number -->
                                                            <p class="experienced_companies_p edit_checkbox_plural_p">担当工程</p>

                                                        <div class="checkbox_group_div">

                                                            @foreach ($lists[$l_x] as $key=>$value) 
                                                                <div class="checkbox_plural_div sukil_check_restriction_none">
                                                                    <input class="zinbutu_user check_input4" name="create_issues_checkbox4[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                                    <div class="zinbutu_user_flex_div">
                                                                        <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label4"></div>
                                                                        <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                        <span class="checkbox_check_span">{{$value}}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </div>
                                                <?php $box_index5++; ?><?php $box_index5_2++; ?><?php $list_index4++; ?>
                                                @endfor
                                                <!-- ////////////////////// -->

                                                <!-- ふえる部分 -->
                                                @for ($l_x = 22; $l_x <= 30; $l_x++)
                                                <div class="edit_checkbox_num_div">

                                                    <!-- for変更number -->
                                                    @foreach ($list_title[4] as $key=>$value) 
                                                        @if ($key == $box_index6)
                                                        <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                        @endif
                                                    @endforeach

                                                    <div class="checkbox_group_div">

                                                        @foreach ($lists[$l_x] as $key=>$value) 
                                                            <div class="checkbox_plural_div sukil_check_restriction_none">
                                                                <input class="zinbutu_user check_input4" name="create_issues_checkbox4[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                                <div class="zinbutu_user_flex_div">
                                                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label4"></div>
                                                                    <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                    <span class="checkbox_check_span">{{$value}}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>
                                                <?php $box_index6++; ?><?php $box_index6_2++; ?><?php $list_index5++; ?>
                                                @endfor
                                                <!-- ////////////////////// -->

                                            </div>
                                            <!-- /////////////////////////////////////////////////////// -->
                                        </div>

                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->
                                </div>
                            </div>

                            <div class="submit_div" >
                                <input class="input_submit" name="submit" type="submit" value="案件を探す">
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
        
    </body>
    @include('client2.component.footer')
</html>
<script type="text/javascript" src="{{ asset('js/main_page.js')}}"></script>