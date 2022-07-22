<?php
$count = 0;
$c_form_count = 1;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>ユーザー情報</title>
    </head>
    <style>

      .main_div {
        margin-top: 0;
        background: #fffaff;
      }
    </style>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">ユーザー情報</h3>
            </div>

           <!-- ///////////////////// -->

           <div class="confirmation_input_div company_info_div">
              <div class="confirmation_input_group_div">
              <p class="questionnaire_input_p issue_company_name_p">{{$item->user_forte}}</p>

                <div class="issues_one_div company_one_div">

                  <div class="issue_img_title_flex company_img_title_div">
                    <div class="issue_img_div">
                      @if ($item->user_image === null || $item->user_image === "")  
                          <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                      @else
                          <img class="issue_img" src="{{asset('user_images/' . $item->user_image )}}"/>
                      @endif
                    </div>
                    <div class="issue_title_h3_div">
                        <h3 class="issue_title_h3">{{$item->user_name}}</h3>
                    </div>
                  </div>

                </div>

              </div>
            </div>


            <!-- //////////////////////////////////////////////////////////基本情報 -->

            <div class="confirmation_input_div" style="margin-top:0">
              <div class="company_info_detail_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">基本情報</h3></div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">氏名（カタカナ）</h4>
                    <p class="company_info_detail_p">{{$item->user_furigana}}</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">性別</h4>
                    <p class="company_info_detail_p">{{$item->user_seibetu}}</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">生年月日</h4>
                    <p class="company_info_detail_p">{{$birth_y}}年{{$birth_m}}月{{$birth_d}}日</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">国籍</h4>
                    @foreach ($national as $key=>$value)
                        @if ($item->user_national == $key)
                            <p class="company_info_detail_p">{{$value}}</p>
                        @endif
                    @endforeach
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">都道府県</h4>
                    <p class="company_info_detail_p">{{$user_address1}}</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">最寄駅</h4>
                    <p class="company_info_detail_p">{{$item->moyori_eki}}</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">電話番号</h4>
                    <p class="company_info_detail_p">{{$item->user_phone}}</p>
                  </div>

              </div>
            </div>

            <!-- /////// -->

            <!-- //////////////////////////////////////////////////////////ユーザー情報 -->

            <div class="confirmation_input_div" >
              <div class="company_info_detail_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">自己紹介</h3></div>

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">職種</h4>
                    @foreach ($jobs as $key=>$value)
                        @if ($item->it_job === $key)
                        <p class="company_info_detail_p">{{$value}}</p>
                        @endif
                    @endforeach
                  </div>

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">業界経験</h4>
                    <p class="company_info_detail_p">{{$item->Industry_experience}}年前後</p>
                  </div>
                  
                  <!-- 必須 -->
                  <div class="company_info_detail_one_textarea">
                    <h4 class="company_info_detail_title_h4">自己紹介</h4>
                    <p class="company_info_detail_text">{!! nl2br(e($item->self_introduction_text)) !!}</p>
                  </div>
                  
                  <!-- 必須 -->
                  <div class="company_info_detail_one_textarea">
                    <h4 class="company_info_detail_title_h4">希望の業務内容</h4>
                    <p class="company_info_detail_text">{!! nl2br(e($item->description_text)) !!}</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">最終学歴</h4>
                    @foreach ($last_education as $key=>$value)
                        @if ($item->last_education == $key)
                            <p class="company_info_detail_p">{{$value}}</p>
                        @endif
                    @endforeach
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">卒業学校名</h4>
                      <p class="company_info_detail_p">{{$item->user_univ_name}}</p>
                  </div>
                  
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">英語力(語学レベル)</h4>
                    @foreach ($language_level as $key=>$value)
                      @if ($item->language_level == $key)
                      <p class="company_info_detail_p">{{$value}}</p>
                      @endif
                    @endforeach
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">TOEIC</h4>
                      <p class="company_info_detail_p">{{$item->toeic}}点</p>
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">その他言語1</h4>
                    @foreach ($language as $key=>$value)
                      @if ($item->language1 == $key)
                      <p class="company_info_detail_p">{{$value}}</p>
                      @endif
                    @endforeach
                  </div>

                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">その他言語2</h4>
                    @foreach ($language as $key=>$value)
                      @if ($item->language2 == $key)
                      <p class="company_info_detail_p">{{$value}}</p>
                      @endif
                    @endforeach
                  </div>

                  <!-- 必須 -->
                  @if (!empty($experience_industry_check))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">経験業界</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 17;$i <= 19;$i++)
                        @foreach ($experience_industry_check as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  @if (!empty($experience_technology_prosess))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">経験テクノロジー</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 20;$i <= 20;$i++)
                        @foreach ($experience_technology_prosess as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  <!-- 必須 -->
                  @if (!empty($experience_technology_prosess))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">経験工程</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 21;$i <= 21;$i++)
                        @foreach ($experience_technology_prosess as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  <!-- 必須 -->
                  @if (!empty($experience_position_check))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">経験ポジション</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 0;$i <= 6;$i++)
                        @foreach ($experience_position_check as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif


                  <!-- 必須 -->
                  @if (!empty($experience_skill_check))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">経験スキル</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 7;$i <= 16;$i++)
                        @foreach ($experience_skill_check as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">職務経歴書<br>スキルシート</h4>
                    <form method="POST" class="company_info_detail_p" action="" enctype="multipart/form-data" style="display:block;margin:0 auto;">
                    @csrf
                      <button class="biography_works_file_download" id="biography_works_file_download1" name="file_download_btn_1" value="down_btn_1" style="display:block;margin:0 auto;">ダウンロード</button>
                    </form>
                  </div>

                  @if (isset($item->biography_works_file_2))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">ポートフォリオ</h4>
                    <form method="POST" class="company_info_detail_p" action="" enctype="multipart/form-data" style="display:block;margin:0 auto;">
                    @csrf
                      <button class="biography_works_file_download" id="biography_works_file_download1" name="file_download_btn_2" value="down_btn_2" style="display:block;margin:0 auto;">ダウンロード</button>
                    </form>
                  </div>
                  @endif

              </div>
            </div>

            <!-- /////// -->

            <!-- //////////////////////////////////////////////////////////ユーザー希望情報 -->

            <div class="confirmation_input_div" >
              <div class="company_info_detail_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">希望情報</h3></div>

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">希望金額</h4>
                      <p class="company_info_detail_p">{{$item->desired_money1}}万円 〜 {{$item->desired_money2}}万円</p>
                  </div>

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">現在の状況</h4>
                    @foreach ($current_status_list as $key=>$value)
                        @if ($item->current_situation == $key)
                            <p class="company_info_detail_p">{{$value}}</p>
                        @endif
                    @endforeach
                  </div>

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">稼動開始日</h4>
                      <p class="company_info_detail_p">{{$kadou_kaisibi_y}}年{{$kadou_kaisibi_m}}月{{$kadou_kaisibi_d}}日</p>
                  </div>
                  
                  <!-- 必須 -->
                  <div class="company_info_detail_one_textarea">
                    <h4 class="company_info_detail_title_h4">希望契約形態</h4>
                    <p class="company_info_detail_text">
                      @foreach ($desired_contract_form as $c_form)
                        @foreach ($contract_form_list as $key=>$value)
                          @if ($c_form == $key)
                              第{{$c_form_count}}希望： {{$value}}<br>
                          @endif
                        @endforeach
                        <?php $c_form_count++; ?>
                      @endforeach
                    </p>
                  </div>

                  <!-- 必須 -->
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">面談・商談方法</h4>
                    <p class="company_info_detail_p">
                      @foreach ($interview_place as $place)
                        @foreach ($interview_list as $key=>$value)
                            @if ($place == $key)
                                {{$value}} /
                            @endif
                        @endforeach
                      @endforeach
                    </p>
                  </div>

                  <!-- 必須 -->
                  @if (!empty($desired_industry_check))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">希望業界</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 17;$i <= 19;$i++)
                        @foreach ($desired_industry_check as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  @if (!empty($desired_technology_prosess))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">希望テクノロジー</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 20;$i <= 20;$i++)
                        @foreach ($desired_technology_prosess as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  <!-- 必須 -->
                  @if (!empty($desired_technology_prosess))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">希望工程</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 21;$i <= 21;$i++)
                        @foreach ($desired_technology_prosess as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

                  <!-- 必須 -->
                  @if (!empty($desired_position_check))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">希望ポジション</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 0;$i <= 6;$i++)
                        @foreach ($desired_position_check as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif


                  <!-- 必須 -->
                  @if (!empty($desired_skill_check))
                  <div class="company_info_detail_one_flex">
                    <h4 class="company_info_detail_title_h4">希望スキル</h4>
                    <p class="company_info_detail_p" style="line-height:2">
                      @for ($i = 7;$i <= 16;$i++)
                        @foreach ($desired_skill_check as $check)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($check == $key)
                            {{$value}} /
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    </p>
                  </div>
                  @endif

              </div>
            </div>

            <!-- /////// -->


        </div>
    </body>
    @include('client1.component.footer')
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>