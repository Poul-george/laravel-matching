<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <!-- <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>経歴・作品編集</title>
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
                <h3 class="title">経歴・作品</h3>
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
                              <div class="questionnaire_input_p_flex">
                                  <p class="questionnaire_input_p">希望の職務経歴書・スキルシート業務内容</p>
                                  <label class="questionnaire_input_label">必須</label>
                              </div>
                              <div class="thumbnail_caution_div">
                                <div class="thumbnail_caution_flex_div">
                                  <div class="check_caution icon"></div>
                                  <p class="thumbnail_caution_p">開発職・制作職・企画職・営業職の方は必須です。</p>
                                </div>
                                <div class="thumbnail_caution_flex_div">
                                  <div class="check_caution icon"></div>
                                  <p class="thumbnail_caution_p">希望しない企業から過剰な連絡が来る可能性があるため、個人情報・連絡先等は削除してからアップロードをしてください。</p>
                                </div>
                                <div class="thumbnail_caution_flex_div">
                                  <div class="check_caution icon"></div>
                                  <p class="thumbnail_caution_p">当サービス以外での連絡手段に関するトラブルには、当社が関与・仲裁に入ることは出来ません。ご注意ください。</p>
                                </div>
                              </div>
                            </div>

                            <div class="thumbnail_up_div biography_works_file_up_div">
                              <div class="thumbnai_up_file">
                                <label class="user_thumbnail_input_label">
                                  <input id="user_thumbnail1" class="input_file" type="file" name="biography_works_file[]" onchange="selectFile()" > 
                                  ファイルを選択する
                                </label>
                                <span class="file_name_span" id="file_name_span1">選択されていません</span>
                                <input id="user_now_file1" type="hidden" name="user_now_file1" value="{{$item->biography_works_file_1}}"  required>
                              </div>
                              <div class="thumbnai_delete"id="thumbnai_delete1">
                                <input class="file_delete_check" name="biography_works_file_delete1" value="削除" type="checkbox" id="file_delete_check1">
                                <div id="delete_label_div1" class="delete_label_div"><label id="thumbnai_delete_label1" class="thumbnai_delete_label">削除</label></div>
                              </div>
                            </div>

                            <div class="biography_works_file_info_div">
                              <div class="file_info_div">
                                <p class="file_info_p">ファイル名：<span id="file_info_name1" class="file_info_span">{{$item->biography_works_file_1}}</span></p>
                                <p class="file_info_p">更　新　日：<span class="file_info_span">{{$item->biography_works_file_1_day}}</span></p>
                              </div>
                              <div class="file_download_div">
                              <button class="biography_works_file_download" id="biography_works_file_download1" name="file_download_btn_1" value="down_btn_1">ダウンロード</button>
                              </div>
                            </div>
                            
                            <div class="edit_form_div margin_none_cautio_div">
                              <p class="questionnaire_input_p">ポートフォリオ</p>
                              <div class="input_caution_div">
                                <div class="input_caution_flex_div">
                                  <p class="input_caution_p">制作職（クリエイティブ）の方は基本的に必須です。</p>
                                </div>
                              </div>
                            </div>

                            <div class="thumbnail_up_div biography_works_file_up_div">
                              <div class="thumbnai_up_file">
                                <label class="user_thumbnail_input_label">
                                  <input id="user_thumbnail2" class="input_file" type="file" name="biography_works_file[]" onchange="selectFile()" > 
                                  ファイルを選択する
                                </label>
                                <span class="file_name_span" id="file_name_span2">選択されていません</span>
                                <input id="user_now_file2" type="hidden" name="user_now_file2" value="{{$item->biography_works_file_2}}"  required>
                              </div>
                              <div class="thumbnai_delete"id="thumbnai_delete2">
                                <input class="file_delete_check" name="biography_works_file_delete2" value="削除" type="checkbox" id="file_delete_check2">
                                <div id="delete_label_div2" class="delete_label_div"><label id="thumbnai_delete_label2" class="thumbnai_delete_label">削除</label></div>
                              </div>
                            </div>

                            <div class="biography_works_file_info_div">
                              <div class="file_info_div">
                                <p class="file_info_p">ファイル名：<span id="file_info_name2" class="file_info_span">{{$item->biography_works_file_2}}</span></p>
                                <p class="file_info_p">更　新　日：<span class="file_info_span">{{$item->biography_works_file_2_day}}</span></p>
                              </div>
                              <div class="file_download_div">
                              <button class="biography_works_file_download" id="biography_works_file_download2" name="file_download_btn_2" value="down_btn_2">ダウンロード</button>
                              </div>
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