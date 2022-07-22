<?php

  $index1 = 0;
  $index2 = 0;
  $index3 = 0;
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
        <title>特徴・会社紹介編集</title>
    </head>
    <style>
        .questionnaire_input_label {
            color: #CC00FF;
            border: 1px solid #CC00FF;
        }
    </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">特徴・会社紹介</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client1.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit2()">

                        @csrf

                            <!-- //////////////// -->
                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">会社紹介</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="company_introduction">{{$item->company_introduction}}</textarea>
                              </div>
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <!-- ///////////////////////////////////////////////////////////////////////////// -->
                            <div class="edit_form_div">
                            <p class="questionnaire_input_p alret_p alret_p_num_1"></p>
                              <p class="questionnaire_input_p">関係業界</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p caution_p_padding_bottom">・関係業界とその割合を選択してください</p>
                                  <p class="input_caution_p caution_p_padding_bottom">・割合の総合計が100％以内に収まるように選択してください</p>
                                  <p class="input_caution_p">・関係業界の5個目以降は、その他として自動的にカウントします。</p>
                                </div>
                              </div>
                              <ul class="edit_form_ul">
                                @for ($x = 1;$x <= 4; $x++)
                                <li class="select_label_flex edit_form_flex_li desired_flex_li">
                                  <div class="select_label_set_div_40">
                                    <label class="input_text_label input_text_label_flex desired_flex_label">割合</label>
                                    <div class="cp_ipselect cp_sl01 country_select select_label_set">
                                      <select class="cp_sl05 total1_{{$x}}" name="relation_industry_rate_1_{{$x}}">
                                        @if ($relation_industry_rate[$index1] === "" || $relation_industry_rate[$index1] === null) 
                                          <option value="" selected>選択</option>
                                        @endif
                                        @for ($i = 5;$i <= 100; $i+=5)
                                          @if ($relation_industry_rate[$index1] == $i)
                                              <option selected value="{{$i}}" >{{$i}}%</option>
                                          @else
                                            <option value="{{$i}}">{{$i}}%</option>
                                          @endif
                                        @endfor
                                      </select>
                                    </div>
                                  </div>

                                  <div class="select_label_set_div_55">
                                    <label class="input_text_label input_text_label_flex desired_flex_label">業界</label>
                                    <div class="cp_ipselect cp_sl01 country_select select_label_set">
                                      <select class="cp_sl05 hanbetu1_{{$x}}" name="relation_industry1_{{$x}}">
                                        @if ($relation_industry[$index1] === "") 
                                          <option value="" selected>選択してください</option>
                                        @endif

                                        @foreach ($industry_list as $key=>$value)
                                            @if ($relation_industry[$index1] == $key && $relation_industry[$index1] !== "")
                                                <option selected value="{{$relation_industry[$index1]}}" >{{$value}}</option>
                                                @breack
                                            @else
                                              <option value="{{$key}}" >{{$value}}</option>
                                            @endif
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </li>

                                <?php $index1++; ?>
                                @endfor
                              </ul>
                              <div class="edit_form2_div_hr"></div>
                            </div>
                            <!-- ///////////////////////////////////////////////////////////////////////////// -->

                            <!-- ///////////////////////////////////////////////////////////////////////////// -->
                            <div class="edit_form_div">
                            <p class="questionnaire_input_p alret_p alret_p_num_2"></p>
                              <p class="questionnaire_input_p">関係業種</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p caution_p_padding_bottom">・関係業種とその割合を選択してください</p>
                                  <p class="input_caution_p caution_p_padding_bottom">・割合の総合計が100％以内に収まるように選択してください</p>
                                  <p class="input_caution_p">・関係業種の5個目以降は、その他として自動的にカウントします。</p>
                                </div>
                              </div>
                              <ul class="edit_form_ul">
                                @for ($x = 1;$x <= 4; $x++)
                                <li class="select_label_flex edit_form_flex_li desired_flex_li">
                                  <div class="select_label_set_div_40">
                                    <label class="input_text_label input_text_label_flex desired_flex_label">割合</label>
                                    <div class="cp_ipselect cp_sl01 country_select select_label_set">
                                      <select class="cp_sl05 total2_{{$x}}"  name="relation_industry_rate_2_{{$x}}">
                                        @if ($relation_industry_rate_2[$index2] === "") 
                                          <option value="" selected>選択</option>
                                        @endif
                                        @for ($i = 5;$i <= 100; $i+=5)
                                          @if ($relation_industry_rate_2[$index2] == $i)
                                              <option selected value="{{$i}}" >{{$i}}%</option>
                                          @else
                                            <option value="{{$i}}">{{$i}}%</option>
                                          @endif
                                        @endfor
                                      </select>
                                    </div>
                                  </div>

                                  <div class="select_label_set_div_55">
                                    <label class="input_text_label input_text_label_flex desired_flex_label">業種</label>
                                    <div class="cp_ipselect cp_sl01 country_select select_label_set">
                                      <select class="cp_sl05 hanbetu2_{{$x}}" name="relation_industry2_{{$x}}">
                                        @if ($relation_industry2[$index2] === "") 
                                          <option value="" selected>選択してください</option>
                                        @endif

                                        @foreach ($industry_kind_list as $key=>$value)
                                            @if ($relation_industry2[$index2] == $key && $relation_industry2[$index2] !== "")
                                                <option selected value="{{$relation_industry2[$index2]}}" >{{$value}}</option>
                                                @breack
                                            @else
                                              <option value="{{$key}}" >{{$value}}</option>
                                            @endif
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </li>
                                <?php $index2++; ?>
                                @endfor
                              </ul>
                              <div class="edit_form2_div_hr"></div>
                            </div>
                            <!-- ///////////////////////////////////////////////////////////////////////////// -->

                            <!-- ///////////////////////////////////////////////////////////////////////////// -->
                            <div class="edit_form_div">
                            <p class="questionnaire_input_p alret_p alret_p_num_3"></p>
                              <p class="questionnaire_input_p">資格</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p caution_p_padding_bottom">・資格とその割合を選択してください</p>
                                  <p class="input_caution_p caution_p_padding_bottom">・割合の総合計が100％以内に収まるように選択してください</p>
                                  <p class="input_caution_p">・資格の5個目以降は、その他として自動的にカウントします。</p>
                                </div>
                              </div>
                              <ul class="edit_form_ul">
                                @for ($x = 1;$x <= 4; $x++)
                                <li class="select_label_flex edit_form_flex_li desired_flex_li">
                                  <div class="select_label_set_div_40">
                                    <label class="input_text_label input_text_label_flex desired_flex_label">割合</label>
                                    <div class="cp_ipselect cp_sl01 country_select select_label_set">
                                      <select class="cp_sl05 total3_{{$x}}" name="company_qualification_rate_{{$x}}">
                                        @if ($company_qualification_rate[$index3] === "") 
                                          <option value="" selected>選択</option>
                                        @endif
                                        @for ($i = 5;$i <= 100; $i+=5)
                                          @if ($company_qualification_rate[$index3] == $i)
                                              <option selected value="{{$i}}" >{{$i}}%</option>
                                          @else
                                            <option value="{{$i}}">{{$i}}%</option>
                                          @endif
                                        @endfor
                                      </select>
                                    </div>
                                  </div>

                                  <div class="select_label_set_div_55">
                                    <label class="input_text_label input_text_label_flex desired_flex_label">資格</label>
                                    <div class="cp_ipselect cp_sl01 country_select select_label_set">
                                      <select class="cp_sl05 hanbetu3_{{$x}}" name="company_qualification{{$x}}">
                                        @if ($company_qualification[$index3] === "") 
                                          <option value="" selected>選択してください</option>
                                        @endif

                                        @foreach ($qualifications_held_list as $key=>$value)
                                            @if ($company_qualification[$index3] == $key && $company_qualification[$index3] !== "")
                                                <option selected value="{{$company_qualification[$index3]}}" >{{$value}}</option>
                                                @breack
                                            @else
                                              <option value="{{$key}}" >{{$value}}</option>
                                            @endif
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </li>
                                <?php $index3++; ?>
                                @endfor
                              </ul>
                              <div class="edit_form2_div_hr"></div>
                            </div>
                            <!-- ///////////////////////////////////////////////////////////////////////////// -->

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">PRコメント</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>

                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p">自社のPRコメントをご記入ください</p>
                                </div>
                              </div>

                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="pr_comment">{{$item->pr_comment}}</textarea>
                              </div>
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                              <p class="questionnaire_input_p">会社種類</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p">例) 独立系、インターネット系</p>
                                </div>
                              </div>
                              <input class="input_text ex_companies_input_text input_group1" type="text" placeholder="" name="company_type" value="{{$item->company_type}}">
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                              <p class="questionnaire_input_p">面接・商談方法</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p">可能な面接・商談方法を選択してください。</p>
                                </div>
                              </div>

                              <!-- div hiddenn -->
                              <div class="hidden_div">
                                    <div class="">
                                      @if ($interview_format !== null || $interview_format !== "") 
                                            @foreach ($interview_format as $check)
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
                              <p class="questionnaire_input_p">メンバー</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p">所属メンバーについて　例) 所属が10名程度</p>
                                </div>
                              </div>
                              <input class="input_text ex_companies_input_text input_group1" type="text" placeholder="" name="member_text" value="{{$item->member_text}}">
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">保有案件の特徴</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>

                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="characteristics_of_holding">{{$item->characteristics_of_holding}}</textarea>
                              </div>
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">取引先の傾向</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="business_partner_trends">{{$item->business_partner_trends}}</textarea>
                              </div>
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                              <p class="questionnaire_input_p">支払サイト</p>
                              <div class="input_caution_div ">
                                <div class="input_caution_flex_div ">
                                  <p class="input_caution_p">例) 30日サイトが多い</p>
                                </div>
                              </div>
                              <input class="input_text ex_companies_input_text input_group1" type="text" placeholder="" name="payment_site_info" value="{{$item->payment_site_info}}">
                              <div class="edit_form2_div_hr"></div>
                            </div>

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">所属人材の傾向</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="trends_in_human_resources">{{$item->trends_in_human_resources}}</textarea>
                              </div>
                              <div class="edit_form2_div_hr"></div>
                            </div>


                            <div class="submit_div" >
                                <input class="input_submit" type="submit" value="変更">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </body>
    @include('client1.component.footer')
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>