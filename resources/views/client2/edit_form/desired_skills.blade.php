<?php

$box_index1 = 1;
$box_index2 = 1;
$box_index2_2 = 8;
$box_index3 = 1;
$box_index3_2 = 18;
$list_index = 0;
$list_index2 = 0;
// foreach ($experience_position_check as $check) {
//     var_dump($check);
// }

?>

<!DOCTYPE html>
<html id="html">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <!-- <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>希望スキル編集</title>
    </head>

    <body>
        @include('client2.component.mypage_left')
        
        <div class="main_div desired_skills_blade" id="main_div">
            @include('client2.component.mypage_header')
            @if (session('msgs'))
              <p class="error">{{session('msgs')}}</p>
            @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">希望スキル</h3>
            </div>
            <div class="mypage_edit_div ">

                @include('client2.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit3()">
                        @csrf


                            <div class="thumbnail_div">

                                <div class="user_thumbnail_input_div ">

                                    <!-- ////////////////////////////グループ1 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_1" class="questionnaire_input_p alret_p alret_p_num_1"></p>
                                        <div class="questionnaire_input_p_flex">
                                            <p class="questionnaire_input_p">希望ポジション</p>
                                            <label class="questionnaire_input_label">必須</label>
                                        </div>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">3つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                            <!-- div hiddenn -->
                                            <div class="hidden_div">
                                                <div class="">
                                                    @if (isset($desired_position_check))
                                                        @foreach ($desired_position_check as $check)
                                                        <div class="hidden_div_one">
                                                            <input class="hidden_check_num1" value="{{$check}}" type="hidden" id="">
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- ふえる部分 -->
                                            @for ($l_x = 0; $l_x <= 6; $l_x++)
                                            <div class="edit_checkbox_num_div">


                                                <!-- for変更number -->
                                                @foreach ($skill_lists[0] as $key=>$value) 
                                                    @if ($key == $box_index1)
                                                    <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                    @endif
                                                @endforeach

                                                <div class="checkbox_group_div">

                                                    @foreach ($lists[$l_x] as $key=>$value) 
                                                        <div class="checkbox_plural_div sukil_check_restriction_none">
                                                            <input class="zinbutu_user check_input1" name="skill_posi[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
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


                                    <div class="edit_form_div">
                                        <div class="margin_side_5px_div">
                                            <div class="edit_form2_div_flex">
                                                <p class="questionnaire_input_p">特筆事項</p>
                                                <!-- class -->
                                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/200文字</label>
                                            </div>

                                            <div class="edit_form2_div_input">
                                                <!-- name -->
                                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="position_tokuhitu_text">{{$item->position_tokuhitu_text}}</textarea>
                                            </div>
                                            
                                        </div>
                                    </div>


                                    <!-- ////////////////////////////グループ2 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_2" class="questionnaire_input_p alret_p alret_p_num_2"></p>
                                        <div class="questionnaire_input_p_flex">
                                            <p class="questionnaire_input_p">希望スキル</p>
                                            <label class="questionnaire_input_label">必須</label>
                                        </div>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">7つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                            <!-- div hiddenn -->
                                            <div class="hidden_div">
                                                <div class="">
                                                    @foreach ($desired_skill_check as $check)
                                                    <div class="hidden_div_one">
                                                        <input class="hidden_check_num2" value="{{$check}}" type="hidden" id="">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- ふえる部分 -->
                                            @for ($l_x = 7; $l_x <= 16; $l_x++)
                                            <div class="edit_checkbox_num_div">


                                                <!-- for変更number -->
                                                @foreach ($skill_lists[1] as $key=>$value) 
                                                    @if ($key == $box_index2)
                                                    <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                    @endif
                                                @endforeach

                                                <div class="checkbox_group_div">

                                                    @foreach ($lists[$l_x] as $key=>$value) 
                                                        <div class="checkbox_plural_div sukil_check_restriction_none">
                                                            <input class="zinbutu_user check_input2" name="skill_skl[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                            <div class="zinbutu_user_flex_div">
                                                                <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label2"></div>
                                                                <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                <span class="checkbox_check_span">{{$value}}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>
                                            <?php $list_index++; ?>
                                            <?php $box_index2++; ?>
                                            <?php $box_index2_2++; ?>
                                            @endfor
                                            <!-- ////////////////////// -->
                                        </div>
                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->

                                    <div class="edit_form_div">
                                        <div class="margin_side_5px_div">
                                            <div class="edit_form2_div_flex">
                                                <p class="questionnaire_input_p">特筆事項</p>
                                                <!-- class -->
                                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/200文字</label>
                                            </div>

                                            <div class="edit_form2_div_input">
                                                <!-- name -->
                                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="skill_tokuhitu_text">{{$item->skill_tokuhitu_text}}</textarea>
                                            </div>
                                            
                                        </div>
                                    </div>


                                    <!-- ////////////////////////////グループ3 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_3" class="questionnaire_input_p alret_p alret_p_num_3"></p>
                                        <div class="questionnaire_input_p_flex">
                                            <p class="questionnaire_input_p">希望業界・業種種別</p>
                                            <label class="questionnaire_input_label">必須</label>
                                        </div>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">3つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                            <!-- div hiddenn -->
                                            <div class="hidden_div">
                                                <div class="">
                                                    @foreach ($desired_industry_check as $check)
                                                    <div class="hidden_div_one">
                                                        <input class="hidden_check_num3" value="{{$check}}" type="hidden" id="">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- ふえる部分 -->
                                            @for ($l_x = 17; $l_x <= 19; $l_x++)
                                            <div class="edit_checkbox_num_div">


                                                <!-- for変更number -->
                                                @foreach ($skill_lists[2] as $key=>$value) 
                                                    @if ($key == $box_index3)
                                                    <p class="experienced_companies_p edit_checkbox_plural_p">{{$value}}</p>
                                                    @endif
                                                @endforeach

                                                <div class="checkbox_group_div">

                                                    @foreach ($lists[$l_x] as $key=>$value) 
                                                        <div class="checkbox_plural_div sukil_check_restriction_none">
                                                            <input class="zinbutu_user check_input3" name="skill_industry[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                                            <div class="zinbutu_user_flex_div">
                                                                <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label3"></div>
                                                                <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                                <span class="checkbox_check_span">{{$value}}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>
                                            <?php $box_index3++; ?>
                                            <?php $box_index3_2++; ?>
                                            <?php $list_index2++; ?>
                                            @endfor
                                            <!-- ////////////////////// -->
                                        </div>
                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->

                                    <div class="edit_form_div">
                                        <div class="margin_side_5px_div">
                                            <div class="edit_form2_div_flex">
                                                <p class="questionnaire_input_p">特筆事項</p>
                                                <!-- class -->
                                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/200文字</label>
                                            </div>

                                            <div class="edit_form2_div_input">
                                                <!-- name -->
                                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="industry_tokuhitu_text">{{$item->industry_tokuhitu_text}}</textarea>
                                            </div>
                                            
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- /////////////////////////// -->

                            <div class="edit_form_div">
                                <div class="margin_side_5px_div">
                                    <p class="questionnaire_input_p">希望があるテクノロジー</p>
                                    <p id="alret_p_num_4" class="questionnaire_input_p alret_p alret_p_num_4"></p>
                                    <div class="input_caution_div ">
                                        <div class="input_caution_flex_div ">
                                        <p class="input_caution_p">3つ以内まで選択できます</p>
                                        </div>
                                    </div>

                                    <!-- div hiddenn -->
                                    <div class="hidden_div">
                                        <div class="">
                                            @foreach ($desired_technology_prosess as $check)
                                            <div class="hidden_div_one">
                                                <input class="hidden_check_num4" value="{{$check}}" type="hidden" id="">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
    
                                    @foreach ($lists[20] as $key=>$value) 
                                        <div class="checkbox_plural_div sukil_check_restriction_none">
                                            <input class="zinbutu_user check_input4" name="experience_technology[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                            <div class="zinbutu_user_flex_div">
                                                <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label4"></div>
                                                <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                <span class="checkbox_check_span">{{$value}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="margin_side_5px_div">
                                    <div class="edit_form2_div_flex">
                                        <p class="questionnaire_input_p">特筆事項</p>
                                        <!-- class -->
                                        <label class="input_text_label "><span id="" class="input_count_span">0</span>/200文字</label>
                                    </div>

                                    <div class="edit_form2_div_input">
                                        <!-- name -->
                                        <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="technology_tokuhitu_text">{{$item->technology_tokuhitu_text}}</textarea>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="margin_side_5px_div">
                                    <div class="questionnaire_input_p_flex">
                                        <p class="questionnaire_input_p">希望工程</p>
                                        <label class="questionnaire_input_label">必須</label>
                                    </div>
                                    <p id="alret_p_num_5" class="questionnaire_input_p alret_p alret_p_num_5"></p>
                                    <div class="input_caution_div ">
                                        <div class="input_caution_flex_div ">
                                        <p class="input_caution_p">5つ以内まで選択できます</p>
                                        </div>
                                    </div>

                                    <!-- div hiddenn -->
    
                                    @foreach ($lists[21] as $key=>$value) 
                                        <div class="checkbox_plural_div sukil_check_restriction_none">
                                            <input class="zinbutu_user check_input4" name="experience_process[]" value="{{$key}}" type="checkbox" id="zinbutu_user">
                                            <div class="zinbutu_user_flex_div">
                                                <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label4"></div>
                                                <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                                <span class="checkbox_check_span">{{$value}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="margin_side_5px_div">
                                    <div class="edit_form2_div_flex">
                                        <p class="questionnaire_input_p">特筆事項</p>
                                        <!-- class -->
                                        <label class="input_text_label "><span id="" class="input_count_span">0</span>/200文字</label>
                                    </div>

                                    <div class="edit_form2_div_input">
                                        <!-- name -->
                                        <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="process_tokuhitu_text">{{$item->process_tokuhitu_text}}</textarea>
                                    </div>
                                    
                                </div>
                            </div>

                            

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