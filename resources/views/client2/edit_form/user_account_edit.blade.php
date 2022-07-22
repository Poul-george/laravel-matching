<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>{{config('const.title.title35')}}編集</title>
    </head>

    <style>
        /* .questionnaire_input_p_flex {
            display: flex;
        }
        .questionnaire_input_label {
            color: #5D99FF;
            border: 1px solid #5D99FF;
            padding: 2px 5px;
            font-size: 14px;
            border-radius: 5px;
            margin-left: 10px;
            margin-top: -2px;
        }
        @media screen and (max-width: 999px){
            .questionnaire_input_label {
                font-size: 13px;
            }
        }       
        @media screen and (max-width: 799px) {
            .questionnaire_input_label {
                font-size: 12px;
            }
        } */
    </style>

    <body>
        @include('client2.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client2.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">基本情報</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client2.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data">

                        @csrf

                            <div class="thumbnail_div">
                                <div class="user_thumbnail_div">
                                    @if ($user_image === null || $user_image === "")  
                                        <img class="user_thumbnail_img" src="{{asset('template_img/face_blue.png')}}"/>
                                    @else
                                        <img class="user_thumbnail_img" src="{{asset('user_images/' . $user_image )}}"/>
                                    @endif
                                </div>

                                <div class="user_thumbnail_input_div">
                                    <div class="edit_thumbnail_cautio_div">
                                        <div class="questionnaire_input_p_flex">
                                            <p class="questionnaire_input_p">サムネイル</p>
                                            <label class="questionnaire_input_label">必須</label>
                                        </div>
                                        <div class="thumbnail_caution_div">
                                            <div class="thumbnail_caution_flex_div">
                                                <div class="check_caution icon"></div>
                                                <p class="thumbnail_caution_p">pg / gif / png の10MB以下でお願い致します。</p>
                                            </div>
                                            <div class="thumbnail_caution_flex_div">
                                                <div class="check_caution icon"></div>
                                                <p class="thumbnail_caution_p">自動で正方形にトリミングされます。</p>
                                            </div>
                                            <div class="thumbnail_caution_flex_div">
                                                <div class="check_caution icon"></div>
                                                <p class="thumbnail_caution_p">各種ソーシャルサービスのプロフィール画像と連動することはありません。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="thumbnail_up_div">
                                    <div class="thumbnai_up_file">
                                        <label class="user_thumbnail_input_label">
                                            <input id="user_thumbnail1" class="input_file" type="file" name="user_thumbnail" onchange="selectFile()" accept="image/*"> 
                                            ファイルを選択する
                                        </label>
                                        <span class="file_name_span" id="file_name_span1">選択されていません</span>
                                        <input type="hidden" name="user_now_img" value="{{$item->user_image}}"  required>
                                    </div>
                                    <div class="thumbnai_delete"id="thumbnai_delete1">
                                        <input class="file_delete_check" name="file_delete_check" value="削除" type="checkbox" id="file_delete_check1">
                                        <div id="delete_label_div1" class="delete_label_div"><label id="thumbnai_delete_label1" class="thumbnai_delete_label">削除</label></div>
                                    </div>
                                </div>
                            </div>

                            <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">氏名</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" placeholder="例) 田中" name="name_1" value="{{$name1}}" required>
                                <input class="input_text input_right" type="text" placeholder="例) 太朗" name="name_2" value="{{$name2}}" required>
                            </div>
                            <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">氏名(ひらがな)</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" placeholder="例) タナカ" name="furigana_1" value="{{$name_fri1}}" required>
                                <input class="input_text input_right" type="text" placeholder="例) タロウ" name="furigana_2" value="{{$name_fri2}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">性別</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <ul class="edit_form_radio_ul">
                                    <li class="edit_form_radio_li">
                                    @if ($item->user_seibetu === '男性')
                                        <input type="radio" id="1-option" name="selector1" value="男性" checked required>
                                    @else
                                        <input type="radio" id="1-option" name="selector1" value="男性"  required>
                                    @endif
                                    <label for="1-option">男性</label>
                                    <div class="check"></div>
                                    </li>
                                    <li class="edit_form_radio_li">
                                    @if ($item->user_seibetu === '女性')
                                        <input type="radio" id="2-option" name="selector1" value="女性" checked required>
                                    @else
                                        <input type="radio" id="2-option" name="selector1" value="女性"  required>
                                    @endif
                                    <label for="2-option">女性</label>
                                    <div class="check"><div class="inside"></div></div>
                                    </li>
                                </ul>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">生年月日</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="select_flex">
                                    <div class="cp_ipselect cp_sl01 select_3 not_change">
                                        <select class="cp_sl06" name="" required disabled>
                                        <option value="{{$birth_y}}" selected>{{$birth_y}}</option>
                                        @for ($i=1970;$i<=$year;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                        </select>
                                        <input type="hidden" name="year" value="{{$birth_y}}"  required>
                                    </div>

                                    <div class="cp_ipselect cp_sl01 select_3 not_change">
                                        <select class="cp_sl06" name="" required disabled>
                                        <option value="{{$birth_m}}" selected>{{$birth_m}}</option>
                                        @foreach ($month_list as $key=>$value)
                                                <option value="{{$value}}">{{$key}}</option>
                                        @endforeach
                                        </select>
                                        <input type="hidden" name="month" value="{{$birth_m}}"  required>
                                    </div>

                                    <div class="cp_ipselect cp_sl01 select_3 not_change">
                                        <select class="cp_sl06" name="" required disabled>
                                        <option value="{{$birth_d}}" selected>{{$birth_d}}</option>
                                        @foreach ($date_list as $key=>$value)
                                                <option value="{{$value}}">{{$key}}</option>
                                        @endforeach
                                        </select>
                                        <input type="hidden" name="days" value="{{$birth_d}}"  required>
                                    </div>
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">国籍</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="cp_ipselect cp_sl01 country_select">
                                    <select class="cp_sl05" name="national" required>
                                    @foreach ($national as $key=>$value)
                                        @if ($item->user_national == $key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">最寄駅</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" placeholder="例) 東京駅" type="text" name="near_station" value="{{$item->moyori_eki}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">現住所：郵便番号</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <span class="p-country-name" style="display:none;">Japan</span>
                                <input type="text" class="input_text p-postal-code" size="10" maxlength="8" placeholder="例) 1000001" name="address_number" value="{{$item->address_number}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="area_div">
                                    <div class="area_div_p">
                                        <div class="area_div_one">
                                            <div class="questionnaire_input_p_flex">
                                                <p class="questionnaire_input_p">都道府県</p>
                                                <label class="questionnaire_input_label">必須</label>
                                            </div>
                                            <input type="text" class="p-region input_text_automatic" readonly placeholder="自動で入力されます" name="address_tdfk" value="{{$user_address1}}" required/>
                                        </div>
                                        <div class="area_div_one area_right">
                                            <div class="questionnaire_input_p_flex">
                                                <p class="questionnaire_input_p">市町村</p>
                                                <label class="questionnaire_input_label">必須</label>
                                            </div>
                                            <input type="text" class="p-locality input_text_automatic" readonly placeholder="自動で入力されます" name="address_city" value="{{$user_address2}}" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">町名・番地</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input type="text" class="input_text p-street-address" required placeholder="例) 千代田３丁目1-11" name="address_banti" value="{{$user_address3}}" required/>
                            </div>
                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">ビル名・部屋番号</p>
                                <input type="text" class="input_text p-extended-address" placeholder="例) 〇〇ビル12階" name="address_building" value="{{$user_address4}}"/>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">電話番号</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="tel" name="tel01" placeholder="例) 09012341234" value="{{$item->user_phone}}" required>
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
    @include('client2.component.footer')
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>