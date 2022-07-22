<?php

$index1 = 0;
$index2 = 0;
$today_y = date("Y");



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
        <title>希望条件編集</title>
    </head>

    <body>
        @include('client2.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client2.component.mypage_header')
            @if (session('msgs'))
              <p class="error">{{session('msgs')}}</p>
            @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">希望条件</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client2.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit()">
                        @csrf


                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">希望条件の優先順位</p>
                                <ul class="edit_form_ul">
                                    @for ($i = 1; $i <= 4;$i++)
                                    <li class="select_label_flex edit_form_flex_li desired_flex_li">
                                        <label class="input_text_label input_text_label_flex desired_flex_label">第<span class="in_number">{{$i}}</span>希望</label>
                                        <div class="cp_ipselect cp_sl01 country_select desired_flex_select">
                                            <select class="cp_sl05" name="priority{{$i}}" >

                                                @if ($priority[$index1] === "") 
                                                    <option value="" selected>選択してください</option>
                                                @endif

                                                @foreach ($priority_form_list as $key=>$value)
                                                    @if ($priority[$index1] == $key && $priority[$index1] !== "")
                                                        <option selected value="{{$priority[$index1]}}" >{{$value}}</option>
                                                    @endif
                                                    <option value="{{$key}}" >{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                    <?php $index1++; ?>
                                    @endfor

                                </ul>
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p alret_p"></p>
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">希望金額（／月）</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="width_1000_flex_div">

                                    <div class="input_caution_div width_1000_flex_one_div">
                                        <div class="input_caution_flex_div">
                                            <p class="input_caution_p">最低希望金額は必須。（差額は5万円以内）</p>
                                        </div>
                                    </div>
                    
                                    <div class="select_flex">
                                        <div class="cp_ipselect cp_sl01 select_3 ">
                                            <select class="cp_sl06 money_width1" name="money1" >
                                                @if ($desired_money[0] === null) 
                                                    <option value="" selected>選択</option>
                                                @endif
                                                @for ($i = 10; $i <= 200;$i+=5)
                                                    @if ($desired_money[0] !== null) 
                                                        <option selected value="{{$desired_money[0]}}" >{{$desired_money[0]}}</option>
                                                    @endif
                                                    <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    
                                        <label class="input_text_label input_text_label_flex in_text_label">から</label>
                                    
                                        <div class="cp_ipselect cp_sl01 select_3 ">
                                            <select class="cp_sl06 money_width2" name="money2" >
                                                @if ($desired_money[1] === null) 
                                                    <option value="" selected>選択</option>
                                                @endif
                                                @for ($i = 10; $i <= 200;$i+=5)
                                                    @if ($desired_money[1] !== null) 
                                                        <option selected value="{{$desired_money[1]}}" >{{$desired_money[1]}}</option>
                                                    @endif
                                                    <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>

                                    </div>

                                </div>

                                <div class="edit_form2_div_hr"></div>
                            
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">現在の状況</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="cp_ipselect cp_sl01 desired_fulsize_select">
                                    <select class="cp_sl05" name="current_situation" >
                                        @if ($item->current_situation === null) 
                                            <option value="" selected>選択してください</option>
                                        @endif

                                        @foreach ($current_status_list as $key=>$value)
                                            @if ($item->current_situation == $key)
                                                <option value="{{$item->current_situation}}" >{{$value}}</option>
                                            @endif
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="edit_form2_div_hr"></div>
                            </div>


                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">稼働開始可能日</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>

                                <div class="input_caution_div ">
                                    <div class="input_caution_flex_div ">
                                        <p class="input_caution_p">本日以降〜1年未満の日付で設定してください。</p>
                                    </div>
                                </div>

                                <div class="select_flex">
                                    <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                    <!-- name -->
                                        <select class="cp_sl06" name="year" >
                                            @if ($kadou_kaisibi_y === null || $kadou_kaisibi_y === "") 
                                                <option value="" selected>選択</option>
                                            @endif
                                            @for ($i = $today_y; $i <= $today_y+1;$i++)
                                                @if ($kadou_kaisibi_y == $i) 
                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                @endif
                                                <option value="{{$i}}" >{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <label class="input_text_label input_text_label_flex ex_companies_label">年</label>
                    
                                    <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                    <!-- name -->
                                        <select class="cp_sl06" name="month" >
                                            @if ($kadou_kaisibi_m === null || $kadou_kaisibi_m === "") 
                                                <option value="" selected>選択</option>
                                            @endif
                                            @for ($i = 1; $i <= 12;$i++)
                                                @if ($kadou_kaisibi_m == $i) 
                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                @endif
                                                <option value="{{$i}}" >{{$i}}</option>
                                            @endfor

                                        </select>
                                    </div>
                                    <label class="input_text_label input_text_label_flex ex_companies_label">月</label>
                    
                                    <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                    <!-- name -->
                                        <select class="cp_sl06" name="day" >
                                            @if ($kadou_kaisibi_d === null || $kadou_kaisibi_d === "") 
                                                <option value="" selected>選択</option>
                                            @endif
                                            @for ($i = 1; $i <= 31;$i++)
                                                @if ($kadou_kaisibi_d == $i) 
                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                @endif
                                                <option value="{{$i}}" >{{$i}}</option>
                                            @endfor

                                        </select>
                                    </div>
                                    <label class="input_text_label input_text_label_flex ex_companies_label">日</label>
                                </div>
                                
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">希望契約形態</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <ul class="edit_form_ul">
                                    @for ($i = 1; $i <= 5;$i++)
                                    <li class="select_label_flex edit_form_flex_li desired_flex_li">
                                        <label class="input_text_label input_text_label_flex desired_flex_label">第<span class="in_number">{{$i}}</span>希望</label>
                                        <div class="cp_ipselect cp_sl01 country_select desired_flex_select">
                                            <select class="cp_sl05" name="desired_contract_form{{$i}}" >
                                                @if ($desired_contract_form[$index2] === "") 
                                                    <option value="" selected>選択してください</option>
                                                @endif

                                                @foreach ($contract_form_list as $key=>$value)
                                                    @if ($desired_contract_form[$index2] == $key && $desired_contract_form[$index2] !== "")
                                                        <option selected value="{{$desired_contract_form[$index2]}}" >{{$value}}</option>
                                                    @endif
                                                    <option value="{{$key}}" >{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                    <?php $index2++; ?>
                                    @endfor
                                </ul>
                                
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">面接・商談方法</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="input_caution_div ">
                                    <div class="input_caution_flex_div ">
                                    <p class="input_caution_p">可能な面接・商談方法を選択してください。</p>
                                    </div>
                                </div>

                                <!-- div hiddenn -->
                                <div class="hidden_div">
                                    <div class="">
                                        @if ($interview_place !== null || $interview_place !== "") 
                                            @foreach ($interview_place as $check)
                                            <div class="hidden_div_one">
                                                <input class="hidden_check_num1" value="{{$check}}" type="hidden" id="">
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                @foreach ($interview_list as $key=>$value)
                                <div class="checkbox_plural_div sukil_check_restriction_none">
                                    <input class="zinbutu_user interview_check check_input1" name="interview_check[]" value="{{$key}}" type="checkbox" id="interview_check">
                                    <div class="zinbutu_user_flex_div">
                                        <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label1"></div>
                                        <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                        <span class="checkbox_check_span">{{$value}}</span>
                                    </div>
                                </div>

                               
                                @endforeach
                                
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">勤務・作業場所</p>
                                <input class="input_text" placeholder="例) 23区希望" type="text" name="job_place" value="{{$item->job_place}}" >

                                <!-- div hiddenn -->
                                <div class="hidden_div">
                                    <div class="">
                                        @if ($item->job_home_check !== null || $item->job_home_check !== "") 
                                            <div class="hidden_div_one">
                                                <input class="hidden_check_num2" value="{{$item->job_home_check}}" type="hidden" id="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="checkbox_plural_div sukil_check_restriction_none job_place_div">
                                    <input class="zinbutu_user interview_check check_input2" name="job_place_check" value="1" type="checkbox" id="interview_check">
                                    <div class="zinbutu_user_flex_div">
                                        <div id="zinbutu_user_label_div" class="zinbutu_user_label_div check_label2"></div>
                                        <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                        <span class="checkbox_check_span">在宅勤務のみ</span>
                                    </div>
                                </div>
                                
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">通勤時間</p>
                                <div class="cp_ipselect cp_sl01 country_select">
                                    <select class="cp_sl05" name="commuting_work_minute" >
                                        @if ($item->commuting_work_minute === null || $item->commuting_work_minute === "") 
                                            <option value="" selected>選択してください</option>
                                        @endif
                                        @for ($i = 30; $i <= 120;$i+=30)
                                            @if ($item->commuting_work_minute == $i)
                                                <option selected value="{{$i}}">{{$i}}分以内</option>
                                            @endif
                                            <option value="{{$i}}">{{$i}}分以内</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">稼働時間／月</p>
                                <div class="cp_ipselect cp_sl01 country_select">
                                    <select class="cp_sl05" name="uptime_month" >
                                    @if ($item->uptime_month === null || $item->uptime_month === "") 
                                        <option value="" selected>選択してください</option>
                                    @endif
                                    @for ($i = 160; $i <= 200;$i+=10)
                                        @if ($item->uptime_month == $i)
                                            <option selected value="{{$i}}">{{$i}}時間以内</option>
                                        @endif
                                        <option value="{{$i}}">{{$i}}時間以内</option>
                                    @endfor
                                    @if ($item->uptime_month === "200")
                                        <option selected value="200" >200時間以上可能</option>
                                        @else
                                        <option value="200" >200時間以上可能</option>
                                    @endif
                                    </select>
                                </div>
                                
                                <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                                <div class="edit_form2_div_flex">
                                    <p class="questionnaire_input_p">案件へのこだわり待遇に関する条件その他の希望条件</p>
                                    <!-- class -->
                                    <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                                </div>
                                <div class="edit_form2_div_input">
                                    <!-- name -->
                                    <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="desired_textarea">{{$item->desired_textarea}}</textarea>
                                </div>
                            
                            </div>
                            <!-- ///////////////////////////////////////////// -->

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