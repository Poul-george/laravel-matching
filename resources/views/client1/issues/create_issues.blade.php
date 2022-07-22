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
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>案件作成</title>
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
                <h3 class="title">案件作成</h3>
            </div>
            <div class="mypage_edit_div">
                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <!-- <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit2()"> -->
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit3()">

                        @csrf

                        @if (session()->has('all_input_session'))
                          @include('client1.issues.create_issues_session')
                        @endif

                        @if (!session()->has('all_input_session'))

                          <!-- <div class="edit_form_div_matter_name"> -->
                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">案件タイトル</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input required id="" class="input_text max_input_text"  type="text" name="matter_name" value="" placeholder="例) 新規アプリ開発、iOSエンジニア募集">
                            </div>
                          <!-- </div> -->

                          <div class="input_title_h3_div"><h3 class="input_title_h3">業務内容</h3></div>
                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">作業内容</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea required id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="create_issues_textarea1"></textarea>
                              </div>
                            </div>

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">必須スキル</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea required id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="create_issues_textarea2"></textarea>
                              </div>
                            </div>

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">尚可スキル</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="create_issues_textarea3"></textarea>
                              </div>
                            </div>

                            <div class="edit_form_div">
                              <div class="edit_form2_div_flex">
                                <p class="questionnaire_input_p">開発環境</p>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                              </div>
                              <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="create_issues_textarea4"></textarea>
                              </div>
                            </div>

                            <!-- //////////////////////////////////////////////////////////////// -->
                            <div class="input_title_h3_div"><h3 class="input_title_h3">基本情報</h3></div>
                            <div class="edit_form_div">
                                <p class="questionnaire_input_p alret_p"></p>
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">単価（／月）</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="width_1000_flex_div">
                    
                                    <div class="select_flex">
                                        <div class="cp_ipselect cp_sl01 select_3 ">
                                            <select required class="cp_sl06 money_width1" name="create_issues_select1" >
                                                    <option value="" selected>選択</option>
                                                @for ($i = 10; $i <= 200;$i+=5)
                                                  <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    
                                        <label class="input_text_label input_text_label_flex in_text_label">から</label>
                                    
                                        <div class="cp_ipselect cp_sl01 select_3 ">
                                            <select required class="cp_sl06 money_width2" name="create_issues_select2" >
                                                <option value="" selected>選択</option>
                                                @for ($i = 10; $i <= 200;$i+=5)
                                                  <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                  </div>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">精算幅</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 160H~200H" name="create_issues_text1" value="" required>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">勤務地</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) JR山手線　五反田駅 / 品川区西五反田" name="create_issues_text2" value="" required>
                              </div>

                              <div class="edit_form_div">
                                  <div class="edit_form2_div_flex">
                                    <div class="questionnaire_input_p_flex">
                                      <p class="questionnaire_input_p">都道府県</p>
                                      <label class="questionnaire_input_label">必須</label>
                                    </div>
                                  </div>
                                  <div class="edit_form2_div_input">
                                      <div class="cp_ipselect cp_sl01 country_select ex_companies_half_slct">
                                          <!-- name -->
                                          <select required class="cp_sl05" name="todouhuken" >
                                                    <option value="" selected>選択</option>
                                                @foreach ($todouhuken_list as $key=>$value)
                                                  <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>

                              <div class="edit_form_div">
                                  <div class="edit_form2_div_flex">
                                    <div class="questionnaire_input_p_flex">
                                      <p class="questionnaire_input_p">契約形態</p>
                                      <label class="questionnaire_input_label">必須</label>
                                    </div>
                                  </div>
                                  <div class="edit_form2_div_input">
                                      <div class="cp_ipselect cp_sl01 country_select ex_companies_half_slct">
                                          <!-- name -->
                                          <select required class="cp_sl05" name="create_issues_select3" >
                                                    <option value="" selected>選択</option>
                                                @foreach ($contract_form_list as $key=>$value)
                                                  <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">商流</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 自社案件・請負案件" name="create_issues_text3" value="" required>
                              </div>

                              <!-- //////////////////////////////////////////////////////////////// -->
                              <div class="input_title_h3_div"><h3 class="input_title_h3">募集情報</h3></div>
                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">契約期間</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 即日～3ヶ月更新" name="create_issues_text4" value="" required>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">勤務時間</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 10:00 ～ 19:00　残業月10～20時間程度" name="create_issues_text5" value="" required>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">平均稼動時間</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 180時間/月" name="create_issues_text6" value="" required>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">募集人数</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 1人" name="create_issues_text7" value="" required>
                              </div>

                              <div class="edit_form_div">
                                <div class="edit_form2_div_flex">
                                  <p class="questionnaire_input_p">募集背景</p>
                                  <!-- class -->
                                  <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                                </div>
                                <div class="edit_form2_div_input">
                                  <!-- name -->
                                  <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="create_issues_textarea5"></textarea>
                                </div>
                              </div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">面談回数</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) ２回" name="create_issues_text8" value="" required>
                              </div>

                              <div class="edit_form_div">
                                  <p class="questionnaire_input_p">備考</p>
                                  <input id="" class="input_text max_input_text"  type="text" name="create_issues_text9" value="" placeholder="例) 正社員・契約社員採用の場合は選考回数は複数回となります。">
                              </div>


                              <!-- //////////////////////////////////////////////////////////////// -->
                              <div class="input_title_h3_div"><h3 class="input_title_h3">現場情報</h3></div>

                              <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">勤務先企業</p>
                                  <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 株式会社〇〇" name="create_issues_text10" value="" required>
                              </div>

                              <div class="edit_form_div">
                                  <div class="edit_form2_div_flex">
                                      <p class="questionnaire_input_p">服装</p>
                                  </div>
                                  <div class="edit_form2_div_input">
                                      <div class="cp_ipselect cp_sl01 country_select ex_companies_half_slct">
                                          <!-- name -->
                                          <select class="cp_sl05" name="create_issues_select4" >
                                                    <option value="" selected>選択</option>
                                                @foreach ($dress_list as $key=>$value)
                                                  <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">平均年齢</p>
                                    <input class="input_text" type="text" placeholder="例) 20代後半" name="create_issues_text11" value="" >
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">プロジェクト人数</p>
                                    <input class="input_text" type="text" placeholder="例) 十数名" name="create_issues_text12" value="" >
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">所在地</p>
                                    <input class="input_text" type="text" placeholder="例) 東京都東京都品川区〇〇" name="create_issues_text13" value="" >
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">設立年</p>
                                    <input class="input_text" type="text" placeholder="例) 2010年10月10日" name="create_issues_text14" value="" >
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">代表者</p>
                                    <input class="input_text" type="text" placeholder="例) 大阪　太朗" name="create_issues_text15" value="" >
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">従業員数</p>
                                    <input class="input_text" type="text" placeholder="例) 20名" name="create_issues_text16" value="" >
                              </div>

                              <div class="edit_form_div flex_input">
                                <p class="questionnaire_input_p">資本金</p>
                                    <input class="input_text" type="text" placeholder="例) 2000万円" name="create_issues_text17" value="" >
                              </div>

                              


                              <!-- //////////////////////////////////////////////////////////////// -->
                              <div class="input_title_h3_div"><h3 class="input_title_h3">マッチング設定</h3></div>

                              <div class="thumbnail_div">

                                <div class="user_thumbnail_input_div ">

                                    <!-- ////////////////////////////グループ1 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                      <p id="alret_p_num_1" class="questionnaire_input_p alret_p alret_p_num_1"></p>
                                        <div class="questionnaire_input_p_flex">
                                          <p class="questionnaire_input_p">ポジション</p>
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
                                                
                                              </div>
                                          </div>
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
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_2" class="questionnaire_input_p alret_p alret_p_num_2"></p>
                                      <div class="questionnaire_input_p_flex">
                                        <p class="questionnaire_input_p">スキル</p>
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
                                                
                                              </div>
                                          </div>
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
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_3" class="questionnaire_input_p alret_p alret_p_num_3"></p>
                                      <div class="questionnaire_input_p_flex">
                                        <p class="questionnaire_input_p">業界・業種種別</p>
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
                                                
                                              </div>
                                          </div>
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
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_4" class="questionnaire_input_p alret_p alret_p_num_4"></p>
                                        <p class="questionnaire_input_p">テクノロジー</p>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">3つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                          <!-- div hiddenn -->
                                          <div class="hidden_div">
                                              <div class="">

                                              </div>
                                          </div>
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
                                        </div>
                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->

                                    <!-- ////////////////////////////グループ4-2 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_5" class="questionnaire_input_p alret_p alret_p_num_5"></p>
                                        <p class="questionnaire_input_p">担当工程</p>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">5つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                            <!-- ふえる部分 -->
                                            @for ($l_x = 21; $l_x <= 21; $l_x++)
                                            <div class="edit_checkbox_num_div">

                                                <!-- div hiddenn -->
                                                <div class="hidden_div">
                                                    <div class="">
                                                      
                                                    </div>
                                                </div>

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
                                        </div>
                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->

                                    <!-- ////////////////////////////グループ4-3 -->
                                    <div class="edit_form_div experienced_companies_form_div">
                                    <p id="alret_p_num_6" class="questionnaire_input_p alret_p alret_p_num_6"></p>
                                        <p class="questionnaire_input_p">その他</p>
                                        <div class="input_caution_div ">
                                          <div class="input_caution_flex_div ">
                                            <p class="input_caution_p">20つ以内まで選択できます</p>
                                          </div>
                                        </div>
                                        <div class="edit_checkbox_plural_div">

                                            <!-- ふえる部分 -->
                                            @for ($l_x = 22; $l_x <= 30; $l_x++)
                                            <div class="edit_checkbox_num_div">

                                                <!-- div hiddenn -->
                                                <div class="hidden_div">
                                                    <div class="">
                                                        
                                                    </div>
                                                </div>

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
                                    </div>
                                    <!-- /////////////////////////////////////////////////////// -->
                                </div>
                            </div>
                          @endif

                            <div class="submit_div" >
                                <input class="input_submit" type="submit" value="確認画面へ">
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
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>