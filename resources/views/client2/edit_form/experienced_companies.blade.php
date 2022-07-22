<?php 
$item2_count = count($item2);
// phpinfo();
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
        <title>経験企業編集</title>
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
                <h3 class="title">経験企業</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client2.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data">
                        @csrf

                        <div class="thumbnail_div">

                            <div class="user_thumbnail_input_div ">
                                <div class="edit_thumbnail_cautio_div biography_works_cautio_div">
                                    <p class="questionnaire_input_p">Web職務経歴書の作成</p>
                                    <div class="thumbnail_caution_div">
                                    <div class="thumbnail_caution_flex_div">
                                        <div class="check_caution icon"></div>
                                        <p class="thumbnail_caution_p">入力した情報は、職務経歴書として自動生成する事ができます。自動生成した職務経歴書は「経歴・作品」からダウンロードして確認できます。</p>
                                    </div>
                                    <div class="thumbnail_caution_flex_div">
                                        <div class="check_caution icon"></div>
                                        <p class="thumbnail_caution_p">すでに「経歴・作品」に、アップロードされている職務経歴書がある場合、経験企業の入力内容から職務経歴書を作成されますと上書きされますのでご注意ください。</p>
                                    </div>
                                    <div class="thumbnail_caution_flex_div">
                                        <div class="check_caution icon"></div>
                                        <p class="thumbnail_caution_p">以下の【追加する】ボタンより、経歴を追加して下さい。</p>
                                    </div>
                                    </div>
                                </div>

                                <div class="edit_form_div">
                                    <button class="add_btn_div" id="add_btn_div" name="add_btn_div" value="add_box">追加する</button>
                                    <input class="box_form_count" name="box_form_count" value="" type="hidden" id="box_form_count">
                                </div>

                                <!-- ////////////////////////////ふえる部分 -->
                                @for ($i = 1; $i <= $box_count ; $i++)
                                    <?php $index=1;  ?>
                                    <?php $index2=1;  ?>
                                    <?php $index3=1;  ?>
                                    <?php $index4=1;  ?>
                                    <?php $index5=1;  ?>
                                    <?php $index6=1;  ?>
                                    <?php $index7=1;  ?>
                                    <?php $index8=1;  ?>
                                    <?php $index9=1;  ?>
                                    <?php $index9_2=1;  ?>
                                    <?php $index_id=1;  ?>
                                    <div class="edit_form_div experienced_companies_form_div">
                                        <div class="experienced_companies_top_div">
                                            <div class="experienced_companies_num_div">
                                                <!-- for変更number -->
                                                @if ($item2_count >= $i)
                                                    <p class="experienced_companies_p">【{{$i}}社目】</p>
                                                @else
                                                    <p class="experienced_companies_p">【新規】</p>
                                                @endif
                                            </div>
                                            <div class="delete_experienced_div">
                                                <!-- 1の部分は、ループで振り分け -->
                                                <!-- delete部分はidの数字変更 -->
                                                <div class="thumbnai_delete ex_companies_delete"id="ex_companies_delete{{$i}}">
                                                    <input class="file_delete_check" name="ex_companies_check_delete{{$i}}" value="削除" type="checkbox" id="ex_companies_check{{$i}}">
                                                    <div id="ex_companies_dlabel_div{{$i}}" class="delete_label_div">
                                                        <label id="ex_companies_dlabel{{$i}}" class="thumbnai_delete_label">削除</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="experienced_companies_form_display dispalu_none_{{$i}} active">
                                            <div class="edit_form2_div">
                                                <div class="edit_form2_div_flex">
                                                    <p class="questionnaire_input_p">社名</p>
                                                <!-- class -->
                                                    <label class="input_text_label "><span id="" class="input_count_span{{$i}}">0</span>/100文字</label>
                                                </div>
                                                <div class="edit_form2_div_input">
                                                    <!-- name -->
                                                    @if ($item2_count >= $i)
                                                        @foreach ($item2 as $ex_item)
                                                            @if ($index == $i)
                                                                <input class="input_text ex_companies_input_text input_group{{$i}}" type="text" placeholder="" name="company_name{{$i}}" value="{{$ex_item->company_name}}">
                                                            @endif
                                                            <?php $index+=1;  ?>
                                                        @endforeach
                                                    @else
                                                        <input class="input_text ex_companies_input_text input_group{{$i}}" type="text" placeholder="" name="company_name{{$i}}" value="">
                                                    @endif
                                                </div>
                                                <div class="edit_form2_div_hr"></div>
                                            </div>
                                        
                                            <div class="edit_form2_div">
                                                <div class="edit_form2_div_flex">
                                                    <p class="questionnaire_input_p">勤務期間</p>
                                                </div>
                                                <div class="edit_form2_div_input">
                                                    <div class="select_flex">
                                                        <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                                        <!-- name -->
                                                            <select class="cp_sl06" name="year{{$i}}_1" >
                                                            @if ($item2_count >= $i)
                                                                @foreach ($item2 as $ex_item)
                                                                    @if ($index2 == $i)
                                                                        <option value="{{$ex_item->year1}}">{{$ex_item->year1}}</option>
                                                                    @endif
                                                                    <?php $index2+=1;  ?>
                                                                @endforeach
                                                            @else
                                                                <option value="">選択</option>
                                                            @endif
                                                            <!--  -->
                                                            @for ($s=1970;$s<=$year;$s++)
                                                                <option value="{{$s}}">{{$s}}</option>
                                                            @endfor
                                                            </select>
                                                        </div>
                                                        <label class="input_text_label input_text_label_flex ex_companies_label">年</label>
                                        
                                                        <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                                        <!-- name -->
                                                            <select class="cp_sl06" name="month{{$i}}_1" >
                                                            @if ($item2_count >= $i)
                                                                @foreach ($item2 as $ex_item)
                                                                    @if ($index3 == $i)
                                                                        <option value="{{$ex_item->month1}}">{{$ex_item->month1}}</option>
                                                                    @endif
                                                                    <?php $index3+=1;  ?>
                                                                @endforeach
                                                            @else
                                                                <option value="">選択</option>
                                                            @endif
                                                            @foreach ($month_list as $key=>$value)
                                                                <option value="{{$value}}">{{$key}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        <label class="input_text_label input_text_label_flex ex_companies_label">月〜</label>
                                                    </div>

                                                    <div class="select_flex ex_companies_slct">
                                                        <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                                        <!-- name -->
                                                            <select class="cp_sl06" name="year{{$i}}_2" >
                                                            @if ($item2_count >= $i)
                                                                @foreach ($item2 as $ex_item)
                                                                    @if ($index4 == $i)
                                                                        <option value="{{$ex_item->year2}}">{{$ex_item->year2}}</option>
                                                                    @endif
                                                                    <?php $index4+=1;  ?>
                                                                @endforeach
                                                            @else
                                                                <option value="">選択</option>
                                                            @endif
                                                            @for ($s=1970;$s<=$year;$s++)
                                                                <option value="{{$s}}">{{$s}}</option>
                                                            @endfor
                                                            </select>
                                                        </div>
                                                        <label class="input_text_label input_text_label_flex ex_companies_label">年</label>
                                        
                                                        <div class="cp_ipselect cp_sl01 select_3 ex_companies">
                                                        <!-- name -->
                                                            <select class="cp_sl06" name="month{{$i}}_2" >
                                                            @if ($item2_count >= $i)
                                                                @foreach ($item2 as $ex_item)
                                                                    @if ($index5 == $i)
                                                                        <option value="{{$ex_item->month2}}">{{$ex_item->month2}}</option>
                                                                    @endif
                                                                    <?php $index5+=1;  ?>
                                                                @endforeach
                                                            @else
                                                                <option value="">選択</option>
                                                            @endif
                                                            @foreach ($month_list as $key=>$value)
                                                                <option value="{{$value}}" >{{$key}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        <label class="input_text_label input_text_label_flex ex_companies_label">月</label>
                                                    </div>
                                                </div>

                                                <div class="thumbnai_delete ex_companies_delete"id="ex_companies_checked_div{{$i}}">
                                                @if ($item2_count >= $i)
                                                    @foreach ($item2 as $ex_item)
                                                        @if ($index9 == $i && $ex_item->ex_companies_check == 1)
                                                            <input class="file_delete_check" name="ex_companies_check{{$i}}" value="1" type="checkbox" id="ex_companies_checked{{$i}}" checked>
                                                            <div id="ex_companies_chlabel_div{{$i}}" class="delete_label_div active">
                                                                <label id="ex_companies_chlabel{{$i}}" class="thumbnai_delete_label">現在も働いている</label>
                                                            </div>
                                                        @elseif ($index9 == $i && $ex_item->ex_companies_check !== 1)
                                                            <input class="file_delete_check" name="ex_companies_check{{$i}}" value="1" type="checkbox" id="ex_companies_checked{{$i}}" >
                                                            <div id="ex_companies_chlabel_div{{$i}}" class="delete_label_div">
                                                                <label id="ex_companies_chlabel{{$i}}" class="thumbnai_delete_label">現在も働いている</label>
                                                            </div>
                                                        @endif
                                                    <?php $index9+=1;  ?>
                                                    @endforeach
                                                @else
                                                    <input class="file_delete_check" name="ex_companies_check{{$i}}" value="1" type="checkbox" id="ex_companies_checked{{$i}}" >
                                                    <div id="ex_companies_chlabel_div{{$i}}" class="delete_label_div ">
                                                        <label id="ex_companies_chlabel{{$i}}" class="thumbnai_delete_label">現在も働いている</label>
                                                    </div>
                                                @endif
                                                </div>
                                                <div class="edit_form2_div_hr"></div>
                                            </div>
                                            
                                            <div class="edit_form2_div">
                                                <div class="edit_form2_div_flex">
                                                    <p class="questionnaire_input_p">契約形態</p>
                                                </div>
                                                <div class="edit_form2_div_input">
                                                    <div class="cp_ipselect cp_sl01 country_select ex_companies_half_slct">
                                                        <!-- name -->
                                                        <select class="cp_sl05" name="contract_form{{$i}}" >
                                                        @if ($item2_count >= $i)
                                                            @foreach ($item2 as $ex_item)
                                                                @if ($index6 == $i)
                                                                    @foreach ($contract_form_list as $key=>$value)
                                                                        @if ($key == $ex_item->contract_form)
                                                                        <option value="{{$key}}"selected>{{$value}}</option>
                                                                        @else
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                <?php $index6+=1;  ?>
                                                            @endforeach
                                                        @else
                                                            <option value="">選択</option>
                                                            @foreach ($contract_form_list as $key=>$value)
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                        @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="edit_form2_div_hr"></div>
                                            </div>
                                            
                                            <div class="edit_form2_div">
                                                <div class="edit_form2_div_flex">
                                                    <p class="questionnaire_input_p">職務内容</p>
                                                    <!-- class -->
                                                    <label class="input_text_label "><span id="" class="input_count_span{{$i}}">0</span>/200文字</label>
                                                </div>
                                                <div class="edit_form2_div_input">
                                                    <!-- name -->
                                                    @if ($item2_count >= $i)
                                                        @foreach ($item2 as $ex_item)
                                                            @if ($index7 == $i)
                                                                <input class="input_text ex_companies_input_text input_group{{$i}}" type="text" placeholder="" name="job_description{{$i}}" value="{{$ex_item->job_description}}">
                                                            @endif
                                                        <?php $index7+=1;  ?>
                                                        @endforeach
                                                    @else
                                                        <input class="input_text ex_companies_input_text input_group{{$i}}" type="text" placeholder="" name="job_description{{$i}}" value="">
                                                    @endif
                                                </div>
                                                <div class="edit_form2_div_hr"></div>
                                            </div>
                                            
                                            <div class="edit_form2_div">
                                                <div class="edit_form2_div_flex">
                                                    <p class="questionnaire_input_p">業務内容</p>
                                                    <!-- class -->
                                                    <label class="input_text_label "><span id="" class="input_count_span{{$i}}">0</span>/1000文字</label>
                                                </div>

                                                <!-- class -->
                                                <div class="edit_form2_reibunn_div box_number{{$i}}">
                                                    <div id="" class="ex_companies_reibunn_div ex_companies_reibunn_div{{$i}}">
                                                        ITエンジニア
                                                    </div>
                                                    <div id="" class="ex_companies_reibunn_div ex_companies_reibunn_div{{$i}} margin_center">
                                                        Webクリエーター
                                                    </div>
                                                    <div id="" class="ex_companies_reibunn_div ex_companies_reibunn_div{{$i}}">
                                                        イラストレーター
                                                    </div>
                                                </div>

                                                <div class="edit_form2_div_input">
                                                <!-- name -->
                                                    @if ($item2_count >= $i)
                                                        @foreach ($item2 as $ex_item)
                                                            @if ($index8 == $i)
                                                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text input_group{{$i}} textarea_number{{$i}}" name="business_description{{$i}}">{{$ex_item->business_description}}</textarea>
                                                            @endif
                                                        <?php $index8+=1;  ?>
                                                        @endforeach
                                                    @else
                                                        <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text input_group{{$i}} textarea_number{{$i}}" name="business_description{{$i}}"></textarea>
                                                    @endif
                                                </div>
                                                <div class="edit_form2_div_hr"></div>
                                            </div>


                                            @if ($item2_count >= $i)
                                                @foreach ($item2 as $ex_item)
                                                    @if ($index_id == $i)
                                                        <input class="input_hidden" type="hidden" name="ex_companies_box_id{{$i}}" value="{{$ex_item->id}}">
                                                    @endif
                                                    <?php $index_id+=1;  ?>
                                                @endforeach
                                            @else
                                            <input class="input_hidden" type="hidden" name="ex_companies_box_id{{$i}}" value="0">
                                            @endif


                                        </div>
                                    </div>
                                @endfor
                                <!-- /////////////////////////////////////////////////////// -->
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
  
  
        <div class="reibun_alert_shadow_div" id="reibun_alert_shadow_div"></div>
        
        <div class="reibun_alert_div" id="reibun_alert_div">
    
            <div class="reibun_alert_div1 reibun_div_onec" id="reibun_alert_div">
                <div class="reibun_judge_p_div">
                    <p class="reibun_judge_p">以下の例文を挿入しますか？</p>
                </div>
                <div class="reibun_main_p_div">
                    <p class="reibun_main_p">【環境】<br>
                    言語：Java,Ruby,PHP,VB.NET,C#.NET,VB6,Javascript,Python,Perl,Scala,C/C++,COBOL<br>
                    OS：Linux,Windows,iOS,Android,フィーチャーフォン,汎用機,AWS,Azure,GAE<br>
                    DB：Oracle,MySQL,PostgreSQL,SQL,Server,MongoDB,SQLite<br>
                    <br>
                    【業務内容】<br>
                    役職／役割：PMO,PM,PL,SE,PG,テスター,SESコーディネーター,DBA<br>
                    担当工程：要件・調査,基本設計,詳細設計,コーディング,単体テスト,結合テスト,運用テスト<br>
                    チーム体制：3～4名<br>
                    内容：●●●●●●●●●●●●</p>
                </div>
                <div class="reibun_button_div">
                    <div class="reibun_button_kara"></div>
                    <div id="reibun_button_cancel" class="reibun_button_cancel">キャンセル</div>
                    <div id="reibun_button_yes" class="reibun_button_yes1">挿入する</div>
                </div>
            </div>
    
            <div class=" reibun_alert_div2 reibun_div_onec" id="reibun_alert_div">
                <div class="reibun_judge_p_div">
                    <p class="reibun_judge_p">以下の例文を挿入しますか？</p>
                </div>
                <div class="reibun_main_p_div">
                    <p class="reibun_main_p">【環境】<br>
                    ツール：Photoshop,Illustrator,Flash,Dreamweaver<br>
                    言語：HTML4/5,CSS2/3,javascript,ActionScript<br>
                    <br>
                    【業務内容】<br>
                    役職／役割：UX・企画,IA・サイト設計,進行管理,UIデザイン,Webデザイン,広告デザイン,コーディング,フロント開発<br>
                    チーム体制：3～4名<br>
                    内容：●●●●●●●●●●●●</p>
                </div>
                <div class="reibun_button_div">
                    <div class="reibun_button_kara"></div>
                    <div id="reibun_button_cancel" class="reibun_button_cancel">キャンセル</div>
                    <div id="reibun_button_yes" class="reibun_button_yes1">挿入する</div>
                </div>
            </div>
        
            <div class=" reibun_alert_div3 reibun_div_onec" id="reibun_alert_div">
                <div class="reibun_judge_p_div">
                    <p class="reibun_judge_p">以下の例文を挿入しますか？</p>
                </div>
                <div class="reibun_main_p_div">
                    <p class="reibun_main_p">【環境】<br>
                    ツール：Photoshop,Fireworks,Illustrator,Flash,QuarkXPress,InDesign,AfterEffects,SAI,Painter<br>
                    テイスト：萌え･美少女系,乙女系,モンスター系,かわいい(ほのぼの)系,アメコミ系,和風･戦国系,ロボット･SF系,厚塗り,アニメ塗り<br>
                    <br>
                    【業務内容】<br>
                    役職／役割：ラフ,キャラクターデザイン,線画,着彩(塗り),背景,マップ,パーツ(アイテム等),レタッチ,ドット絵<br>
                    チーム体制：3～4名<br>
                    内容：●●●●●●●●●●●●</p>
                </div>
                <div class="reibun_button_div">
                    <div class="reibun_button_kara"></div>
                    <div id="reibun_button_cancel" class="reibun_button_cancel">キャンセル</div>
                    <div id="reibun_button_yes" class="reibun_button_yes1">挿入する</div>
                </div>
            </div>
        </div>
    </body>     
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>