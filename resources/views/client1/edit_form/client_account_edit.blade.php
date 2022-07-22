<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>{{config('const.title.title35')}}編集</title>
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

            @if (session('msgs'))
              <p class="error">{{session('msgs')}}</p>
            @endif

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">基本情報</h3>
            </div>
            <div class="mypage_edit_div">

                @include('client1.component.mypage_edit_url')

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data">

                        @csrf

                            <div class="thumbnail_div">
                                <div class="user_thumbnail_div">
                                  @if ($shop_image === null || $shop_image === "")  
                                      <img class="user_thumbnail_img" src="{{asset('template_img/face_red.png')}}"/>
                                  @else
                                      <img class="user_thumbnail_img" src="{{asset('client_images/' . $shop_image )}}"/>
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
                                        <input type="hidden" name="user_now_img" value="{{$shop_image}}"  required>
                                    </div>
                                    <div class="thumbnai_delete"id="thumbnai_delete1">
                                        <input class="file_delete_check" name="file_delete_check" value="削除" type="checkbox" id="file_delete_check1">
                                        <div id="delete_label_div1" class="delete_label_div"><label id="thumbnai_delete_label1" class="thumbnai_delete_label">削除</label></div>
                                    </div>
                                </div>
                            </div>


                            <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">会社名</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                    <input class="input_text" type="text" placeholder="例) 株式会社LCC" name="company_name" value="{{$item->shop_name}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">最寄駅</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" placeholder="例) 東京駅" type="text" name="near_station" value="{{$item->shop_station}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">拠点：郵便番号</p>
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
                                        <input type="text" class="p-region input_text_automatic" readonly placeholder="自動で入力されます" name="address_tdfk" value="{{$shop_address1}}" required/>
                                    </div>
                                    <div class="area_div_one area_right">
                                        <div class="questionnaire_input_p_flex">
                                            <p class="questionnaire_input_p">市町村</p>
                                            <label class="questionnaire_input_label">必須</label>
                                        </div>
                                        <input type="text" class="p-locality input_text_automatic" readonly placeholder="自動で入力されます" name="address_city" value="{{$shop_address2}}" required/>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">町名・番地</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input type="text" class="input_text p-street-address" required placeholder="例) 千代田３丁目1-11" name="address_banti" value="{{$shop_address3}}" required/>
                            </div>

                            <div class="edit_form_div">
                                <p class="questionnaire_input_p">ビル名・部屋番号</p>
                                <input type="text" class="input_text p-extended-address" placeholder="例) 〇〇ビル12階" name="address_building" value="{{$shop_address4}}"/>
                            </div>

                            <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">担当者名</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" placeholder="例) 田中" name="name_1" value="{{$name1}}" required>
                                <input class="input_text" type="text" placeholder="例) 太朗" name="name_2" value="{{$name2}}" required>
                            </div>
                            <div class="edit_form_div flex_input">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">担当者名(ひらがな)</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" placeholder="例) タナカ" name="furigana_1" value="{{$name_fri1}}" required>
                                <input class="input_text" type="text" placeholder="例) タロウ" name="furigana_2" value="{{$name_fri2}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">電話番号</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="tel" name="tel01" placeholder="例) 09012341234" value="{{$item->shop_phone}}" required>
                            </div>

                            <!-- //////////////// -->
                            <div class="edit_form_div">
                                <div class="edit_form2_div_flex">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">事業内容</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                                </div>
                                <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="business_bescription">{{$item->business_bescription}}</textarea>
                                </div>
                                
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">設立年月日</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="select_flex">
                                <div class="cp_ipselect cp_sl01 select_3 ">
                                    <select class="cp_sl06" name="year" required>
                                        <option value="{{$birth_y}}" selected>{{$birth_y}}</option>
                                        @for ($i=1970;$i<=$year;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="cp_ipselect cp_sl01 select_3 ">
                                    <select class="cp_sl06" name="month" required>
                                        <option value="{{$birth_m}}" selected>{{$birth_m}}</option>
                                         @for ($i=1;$i<=12;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="cp_ipselect cp_sl01 select_3 ">
                                    <select class="cp_sl06" name="days" required>
                                        <option value="{{$birth_d}}" selected>{{$birth_d}}</option>
                                         @for ($i=1;$i<=31;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">資本金</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" name="capital" placeholder="例) 2000万円" value="{{$item->capital}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">売上</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" name="sales" placeholder="例) 1億円" value="{{$item->sales}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">代表取締役名</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <input class="input_text" type="text" name="ceo_name" placeholder="例) 大阪 太朗" value="{{$item->ceo_name}}" required>
                            </div>

                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">従業員数</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="input_label_flex">
                                    <input class="input_text width_80_input" type="text" name="number_employees" placeholder="例) 100" value="{{$item->number_employees}}" required>
                                    <label class="input_text_label input_text_label_flex">人</label>
                                </div>
                            </div>
                                
                            <div class="edit_form_div">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">総稼動員数</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <div class="input_label_flex">
                                    <input class="input_text width_80_input" type="text" name="total_number_employees" placeholder="例) 100" value="{{$item->total_number_employees}}" required>
                                    <label class="input_text_label input_text_label_flex">人</label>
                                </div>
                            </div>

                            <div class="edit_form_div">
                                <div class="edit_form2_div_flex">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">免許・許認可</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                                </div>
                                <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="license_text">{{$item->license_text}}</textarea>
                                </div>
                                
                            </div>

                            <div class="edit_form_div">
                                <div class="edit_form2_div_flex">
                                <div class="questionnaire_input_p_flex">
                                    <p class="questionnaire_input_p">主要取引先</p>
                                    <label class="questionnaire_input_label">必須</label>
                                </div>
                                <!-- class -->
                                <label class="input_text_label "><span id="" class="input_count_span">0</span>/1000文字</label>
                                </div>
                                <div class="edit_form2_div_input">
                                <!-- name -->
                                <textarea id="" class="textarea_input ex_companies_textarea ex_companies_input_text  tokuhitu_textarea" name="majo_business_partners">{{$item->majo_business_partners}}</textarea>
                                </div>
                                
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