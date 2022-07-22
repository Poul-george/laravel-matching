<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <!-- <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>自己紹介編集</title>
    </head>

    <body>
        @include('client2.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client2.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">自己紹介</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client2.component.mypage_edit_url')

                
                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data">

                        @csrf
                        <div class="edit_form_div">
                            <div class="questionnaire_input_p_flex">
                                <p class="questionnaire_input_p">職種</p>
                                <label class="questionnaire_input_label">必須</label>
                            </div>
                            <div class="cp_ipselect cp_sl01 country_select">
                                <select class="cp_sl05" name="it_job" >
                                    @if ($item->it_job == null || $item->it_job === "")
                                        <option value="" selected>選択してください</option>
                                        @foreach ($jobs as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    @else
                                        @foreach ($jobs as $key=>$value)
                                            @if ($item->it_job === $key)
                                                <option value="{{$key}}" selected>{{$value}}</option>
                                            @else
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>      
                        
                        <div class="edit_form_div">
                            <div class="questionnaire_input_p_flex">
                                <p class="questionnaire_input_p">業界経験</p>
                                <label class="questionnaire_input_label">必須</label>
                            </div>
                            <div class="input_caution_div">
                            <div class="input_caution_flex_div">
                                <p class="input_caution_p">1年未満の場合は「0」を設定してください。</p>
                            </div>
                            </div>
                            @if ($item->Industry_experience === null || $item->Industry_experience === "")
                                <input class="input_text text_80px_input"  type="text" name="Industry_experience" value="" >
                            @else
                                <input class="input_text text_80px_input"  type="text" name="Industry_experience" value="{{$item->Industry_experience}}" >
                                
                            @endif
                            <label class="input_text_label">年前後</label>
                        </div>

                        <div class="edit_form_div">
                            <div class="questionnaire_input_p_flex">
                                <p class="questionnaire_input_p">キャッチコピー</p>
                                <label class="questionnaire_input_label">必須</label>
                            </div>
                            <div class="input_caution_div">
                            <div class="input_caution_flex_div">
                                <p class="input_caution_p">あなたの強みを一行で伝えましょう。</p>
                            </div>
                            </div>
                            <div class="reibun_flex_div">
                            <div class="reibun_div1" id="reibun_div1">
                                例文を挿入
                            </div>
                            <div class="reibun_label_div" id="reibun_label_div">
                                <label class="input_text_label input_text_label_count"><span id="input_count_span1" class="input_count_span">0</span>/100文字</label>
                            </div>
                            </div>
                            @if ($item->user_forte === null || $item->user_forte === "")
                                <input id="reibun_div1_input" class="input_text max_input_text"  type="text" name="user_forte" value="" >
                            @else
                                <input id="reibun_div1_input" class="input_text max_input_text"  type="text" name="user_forte" value="{{$item->user_forte}}" >

                                
                            @endif
                        </div>

                        <div class="edit_form_div">
                            <div class="questionnaire_input_p_flex">
                                <p class="questionnaire_input_p">自己紹介文</p>
                                <label class="questionnaire_input_label">必須</label>
                            </div>
                            <div class="input_caution_div">
                            <div class="input_caution_flex_div">
                                <p class="input_caution_p">今までのご経験やこれからのキャリアのビジョンなどを簡潔に記載ください。</p>
                            </div>
                            </div>
                            <div class="reibun_flex_div">
                            <div class="reibun_div1" id="reibun_div2">
                                例文を挿入
                            </div>
                            <div class="reibun_label_div" id="reibun_label_div">
                                <label class="input_text_label input_text_label_count"><span id="input_count_span2" class="input_count_span">0</span>/2000文字</label>
                            </div>
                            </div>
                            @if ($item->self_introduction_text === null || $item->self_introduction_text === "")
                                <textarea id="reibun_div2_input" class="textarea_input" name="self_introduction_text"></textarea>
                            @else
                                <textarea id="reibun_div2_input" class="textarea_input" name="self_introduction_text">{{$item->self_introduction_text}}</textarea>
                            @endif
                        </div>
                        
                        <div class="edit_form_div">
                            <div class="questionnaire_input_p_flex">
                                <p class="questionnaire_input_p">希望の業務内容</p>
                                <label class="questionnaire_input_label">必須</label>
                            </div>
                            <div class="input_caution_div">
                            <div class="input_caution_flex_div">
                                <p class="input_caution_p">自分にあった仕事を受けるために希望の業界／業務内容を記入しましょう</p>
                            </div>
                            </div>
                            <div class="reibun_flex_div">
                            <div class="reibun_div1" id="reibun_div3">
                                例文を挿入
                            </div>
                            <div class="reibun_label_div" id="reibun_label_div">
                                <label class="input_text_label input_text_label_count"><span id="input_count_span3" class="input_count_span">0</span>/2000文字</label>
                            </div>
                            </div>
                            @if ($item->description_text === null || $item->description_text === "")
                                <textarea  id="reibun_div3_input" class="textarea_input" name="description_text"></textarea>
                            @else
                                <textarea  id="reibun_div3_input" class="textarea_input" name="description_text">{{$item->description_text}}</textarea>
                            @endif
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">現在の給与・単価</p>
                            <div class="input_caution_div">
                            <div class="input_caution_flex_div">
                                <p class="input_caution_p">離職中の場合は、前職在籍時の金額をご入力ください。</p>
                            </div>
                            </div>
                            <div class="select_label_flex">
                            <div class="cp_ipselect cp_sl01 country_select">
                                <select class="cp_sl05" name="allowance" >
                                    @if ($item->allowance === null || $item->allowance === "")
                                        <option value="" selected>選択してください</option>
                                        @for ($i=10;$i <=200;$i+= 5)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @else
                                    <option value="{{$item->allowance}}">{{$item->allowance}}</option>
                                        @for ($i=10;$i<=200;$i+= 5)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                            <label class="input_text_label input_text_label_flex">万円/月</label>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">最終学歴</p>
                            <div class="cp_ipselect cp_sl01 country_select">
                            <select class="cp_sl05" name="last_education" >
                                @if ($item->last_education === null || $item->last_education === "")
                                    <option value="" selected>選択してください</option>
                                    @foreach ($last_education as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                @else
                                    @foreach ($last_education as $key=>$value)
                                        @if ($item->last_education === $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">卒業学校名</p>
                            <input id="" class="input_text max_input_text"  type="text" name="user_univ_name" value="{{$item->user_univ_name}}" >
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">卒業年月</p>
                            <div class="select_flex">
                            <div class="cp_ipselect cp_sl01 select_3 ">
                                <select class="cp_sl06" name="year" >
                                    @if ($univ_last_year === null || $univ_last_year === "")
                                        <option value="" selected>選択</option>
                                        @for ($i=1950;$i <=2022;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @else
                                    <option value="{{$univ_last_year}}">{{$univ_last_year}}</option>
                                        @for ($i=1950;$i <=2022;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>

                            <div class="cp_ipselect cp_sl01 select_3 ">
                                <select class="cp_sl06" name="month" >
                                    @if ($univ_last_month === null || $univ_last_month === "")
                                        <option value="" selected>選択</option>
                                        @for ($i=1;$i<=31;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @else
                                    <option value="{{$univ_last_month}}">{{$univ_last_month}}</option>
                                        @for ($i=1;$i<=31;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">英語力(語学レベル)</p>
                            <div class="cp_ipselect cp_sl01 country_select">
                            <select class="cp_sl05" name="language_level" >
                                @if ($item->language_level === null || $item->language_level === "")
                                    <option value="" selected>選択してください</option>
                                        @foreach ($language_level as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                @else
                                    @foreach ($language_level as $key=>$value)
                                        @if ($item->language_level === $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">TOEIC</p>
                            <div class="select_label_flex">
                            <div class="cp_ipselect cp_sl01 country_select">
                                <select class="cp_sl05" name="toeic" >
                                    @if ($item->toeic === null || $item->toeic === "")
                                        <option value="" selected>選択してください</option>
                                        @for ($i=10;$i <=990;$i+= 5)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @else
                                        <option value="{{$item->toeic}}">{{$item->toeic}}</option>
                                        @for ($i=10;$i<=990;$i+= 5)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                            <label class="input_text_label input_text_label_flex">点</label>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">その他言語1</p>
                            <div class="select_flex">
                            <div class="cp_ipselect cp_sl01 select_2 ">
                                <select class="cp_sl06" name="language1" >
                                @if ($item->language1 === null || $item->language1 === "")
                                    <option value="" selected>選択してください</option>
                                    @foreach ($language as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                @else
                                    @foreach ($language as $key=>$value)
                                        @if ($item->language1 == $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                @endif
                                </select>
                            </div>

                            <div class="cp_ipselect cp_sl01 select_2 ">
                                <select class="cp_sl06" name="language_level1" >
                                @if ($item->language_level1 === null || $item->language_level1 === "")
                                    <option value="" selected>選択してください</option>
                                        @foreach ($language_level as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                @else
                                    @foreach ($language_level as $key=>$value)
                                        @if ($item->language_level1 === $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                @endif
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">その他言語2</p>
                            <div class="select_flex">
                            <div class="cp_ipselect cp_sl01 select_2 ">
                                <select class="cp_sl06" name="language2" >
                                @if ($item->language2 === null || $item->language2 === "")
                                    <option value="" selected>選択してください</option>
                                    @foreach ($language as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                @else
                                    @foreach ($language as $key=>$value)
                                        @if ($item->language2 == $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                @endif
                                </select>
                            </div>

                            <div class="cp_ipselect cp_sl01 select_2 ">
                                <select class="cp_sl06" name="language_level2" >
                                    @if ($item->language_level2 === null || $item->language_level2 === "")
                                        <option value="" selected>選択してください</option>
                                            @foreach ($language_level as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                    @else
                                        @foreach ($language_level as $key=>$value)
                                            @if ($item->language_level2 === $key)
                                                <option value="{{$key}}" selected>{{$value}}</option>
                                            @else
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="edit_form_div">
                            <p class="questionnaire_input_p">人物タイプ（3個まで）</p>

                            @foreach ($zinbutu_user as $key=>$value)
                            <div class="zinbutu_user_div">
                                @if ($zinbutu_user1 == $key)
                                    <input class="zinbutu_user" name="zinbutu_user[]" value="{{$key}}" type="checkbox" id="zinbutu_user{{$key}}" checked>
                                @elseif ($zinbutu_user2 == $key)
                                    <input class="zinbutu_user" name="zinbutu_user[]" value="{{$key}}" type="checkbox" id="zinbutu_user{{$key}}" checked> 
                                @elseif ($zinbutu_user3 == $key)
                                    <input class="zinbutu_user" name="zinbutu_user[]" value="{{$key}}" type="checkbox" id="zinbutu_user{{$key}}" checked>
                                @else
                                    <input class="zinbutu_user" name="zinbutu_user[]" value="{{$key}}" type="checkbox" id="zinbutu_user{{$key}}">
                                @endif
                                <div class="zinbutu_user_flex_div">
                                @if ($zinbutu_user1 == $key)
                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div active">
                                @elseif ($zinbutu_user2 == $key)
                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div active"> 
                                @elseif ($zinbutu_user3 == $key)
                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div active">
                                @else
                                    <div id="zinbutu_user_label_div" class="zinbutu_user_label_div">
                                @endif
                                    </div>
                                    <label id="zinbutu_user_label" class="zinbutu_user_label checkbox_check_label"></label>
                                    <span class="checkbox_check_span">{{$value}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>   


                        <div class="submit_div" >
                            <input class="input_submit" type="submit" value="変更する">
                        </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>



        <div class="reibun_alert_shadow_div" id="reibun_alert_shadow_div"></div>

        <div class="reibun_alert_div" id="reibun_alert_div">

            <div class="reibun_alert_div1" id="reibun_alert_div1">
            <div class="reibun_judge_p_div">
                <p class="reibun_judge_p">以下の例文を挿入しますか？</p>
            </div>
            <div class="reibun_main_p_div">
                <p class="reibun_main_p">PHP上級エンジニア／ECサイト・ソーシャルアプリの開発経験が豊富</p>
            </div>
            <div class="reibun_button_div">
                <div class="reibun_button_kara"></div>
                <div id="reibun_button_cancel1" class="reibun_button_cancel">キャンセル</div>
                <div id="reibun_button_yes1" class="reibun_button_yes1">挿入する</div>
            </div>
            </div>

            <div class=" reibun_alert_div2" id="reibun_alert_div2">
            <div class="reibun_judge_p_div">
                <p class="reibun_judge_p">以下の例文を挿入しますか？</p>
            </div>
            <div class="reibun_main_p_div">
                <p class="reibun_main_p">・PHP、Java、HTML5によるプロジェクト経験6件<br>
                ・システムエンジニアとしての実務経験8年<br>
                ・金融システム開発におけるコンサルティングが得意<br>
                ・大手Web制作会社でWebデザイナー4年間の就業経験<br>
                ・プログラマー、ディレクター、Webデザイナー計7名のマネジメント経験<br>
                ・自分のキャリアを発揮したプロジェクトマネージャーになりたい<br>
                ・大規模案件を成功に導くプロジェクトマネージャーを目指します</p>
            </div>
            <div class="reibun_button_div">
                <div class="reibun_button_kara"></div>
                <div id="reibun_button_cancel2" class="reibun_button_cancel">キャンセル</div>
                <div id="reibun_button_yes2" class="reibun_button_yes1">挿入する</div>
            </div>
            </div>

            <div class=" reibun_alert_div3" id="reibun_alert_div3">
            <div class="reibun_judge_p_div">
                <p class="reibun_judge_p">以下の例文を挿入しますか？</p>
            </div>
            <div class="reibun_main_p_div">
                <p class="reibun_main_p">１．最新技術を利用しており経験を積むことができる現場<br>
                ２．大規模トラフィックに対応するような業務（ソーシャルゲーム以外）<br>
                ３．PHP or RubyのMVC環境による開発業務<br>
                ４．デザイナーとして参画し、ディレクターも経験できる現場<br>
                ５．企画立案から関われる事業／またはエンジニアのマネジメント</p>
            </div>
            <div class="reibun_button_div">
                <div class="reibun_button_kara"></div>
                <div id="reibun_button_cancel3" class="reibun_button_cancel">キャンセル</div>
                <div id="reibun_button_yes3" class="reibun_button_yes1">挿入する</div>
            </div>
            </div>
        </div>

    </body>
   
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>