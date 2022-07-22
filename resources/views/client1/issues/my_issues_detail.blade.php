<?php
function insertStr1($text, $insert, $num){
  return substr_replace($text, $insert, $num, 0);
}
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
        <title>案件詳細</title>
    </head>

    <body>
        @include('client1.component.mypage_left')
        
        <div class="main_div" id="main_div">
            @include('client1.component.mypage_header')

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">案件詳細</h3>
            </div>

           <!-- ///////////////////// -->

           <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">

                <div class="issues_one_div">

                  <div class="issue_img_title_flex">
                    <div class="issue_img_div">
                      @if ($shop_image === null || $shop_image === "")  
                          <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                      @else
                          <img class="issue_img" src="{{asset('client_images/' . $shop_image )}}"/>
                      @endif
                    </div>
                    <div class="issue_title_h3_div">
                        <h3 class="issue_title_h3">{{$item2->matter_name}}</h3>
                    </div>
                  </div>

                </div>

              </div>
            </div>

           <!-- ///////////////////// -->

           <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">業務内容</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">作業内容</h4>
                  <p class="confirmation_input_p">{{$item2->issue_info_textarea1}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">必須スキル</h4>
                  <p class="confirmation_input_p">{{$item2->issue_info_textarea2}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">尚可スキル</h4>
                  <p class="confirmation_input_p">{{$item2->issue_info_textarea3}}</p>
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">開発環境</h4>
                  <p class="confirmation_input_p bottom">{{$item2->issue_info_textarea4}}</p>  
                </div>

              </div>
            </div>

            <!-- /////// -->

            <!-- ///////////////////// -->

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">基本情報</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">単価</h4>
                  <?php
                    if (strlen($item2->basic_info_select1_1) === 3) {
                      $money1 = insertStr1($item2->basic_info_select1_1, ',', 1);
                    } else {
                      $money1 = $item2->basic_info_select1_1;
                    }
                    if (strlen($item2->basic_info_select1_2) === 3) {
                      $money2 = insertStr1($item2->basic_info_select1_2, ',', 1);
                    } else {
                      $money2 = $item2->basic_info_select1_2;
                    }
                  ?>
                  <p class="confirmation_input_p money_p">{{$money1}}0,000 〜 {{$money2}}0,000 円/月</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">精算幅</h4>
                  <p class="confirmation_input_p">{{$item2->basic_info_text1}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">勤務地</h4>
                  <p class="confirmation_input_p">{{$item2->basic_info_text2}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">都道府県</h4>
                  <p class="confirmation_input_p">
                    @foreach ($todouhuken_list as $key=>$value)
                      @if($key == $item2->todouhuken)
                        {{$value}}
                      @endif
                    @endforeach
                  </p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">契約形態</h4>
                  @foreach ($contract_form_list as $key=>$value)
                    @if($key == $item2->basic_info_select2)
                    <p class="confirmation_input_p">{{$value}}</p>
                    @endif
                  @endforeach
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">商流</h4>
                  <p class="confirmation_input_p bottom">{{$item2->basic_info_text3}}</p>  
                </div>

              </div>
            </div>

            <!-- /////// -->

            <!-- ///////////////////// -->

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">募集条件</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">契約期間</h4>
                  <p class="confirmation_input_p">{{$item2->recruitment_info_text1}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">勤務時間</h4>
                  <p class="confirmation_input_p">{{$item2->recruitment_info_text2}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">平均<br>稼動時間</h4>
                  <p class="confirmation_input_p">{{$item2->recruitment_info_text3}}</p>
                </div>
                
                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">募集人数</h4>
                  <p class="confirmation_input_p">{{$item2->recruitment_info_text4}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">募集背景</h4>
                  <p class="confirmation_input_p">{{$item2->recruitment_info_textarea1}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">面談回数</h4>
                  <p class="confirmation_input_p">{{$item2->recruitment_info_text5}}</p>
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">備考</h4>
                  <p class="confirmation_input_p bottom">{{$item2->recruitment_info_text6}}</p>  
                </div>

              </div>
            </div>

            <!-- /////// -->

            <!-- ///////////////////// -->

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">現場情報</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">勤務先企業</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text1}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">服装</h4>
                  <p class="confirmation_input_p">
                    @foreach ($dress_list as $key=>$value)
                      @if($key == $item2->company_info_select1)
                        {{$value}}
                      @endif
                    @endforeach
                  </p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">平均年齢</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text2}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">プロジェクト人数</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text3}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">所在地</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text4}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">設立</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text5}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">代表者</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text6}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">従業員数</h4>
                  <p class="confirmation_input_p">{{$item2->company_info_text7}}</p>
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">資本金</h4>
                  <p class="confirmation_input_p bottom">{{$item2->company_info_text8}}</p>  
                </div>

              </div>
            </div>

            <!-- /////// -->

            <!-- ///////////////////// -->

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">マッチング設定</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">ポジション</h4>
                  <div class="confirmation_input_p display_flex">
                    @if (!empty($matching_position))
                      @for ($i = 0;$i <= 6;$i++)
                        @foreach ($matching_position as $item)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($item == $key)
                              <div class="confirmation_input_a_div">
                                <a class="confirmation_input_a">{{$value}}</a>
                              </div>
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    @endif
                  </div>  
                </div>
                
                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">スキル</h4>
                  <div class="confirmation_input_p display_flex">
                  @if (!empty($matching_skill))
                    @for ($i = 7;$i <= 16;$i++)
                      @foreach ($matching_skill as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                           <div class="confirmation_input_a_div">
                              <a class="confirmation_input_a">{{$value}}</a>
                            </div>
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </div>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">業界・業種</h4>
                  <div class="confirmation_input_p display_flex">
                  @if (!empty($matching_industry))
                    @for ($i = 17;$i <= 19;$i++)
                      @foreach ($matching_industry as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                           <div class="confirmation_input_a_div">
                              <a class="confirmation_input_a">{{$value}}</a>
                            </div>
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </div>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">テクノロジー</h4>
                  <div class="confirmation_input_p display_flex">
                  @if (!empty($matching_technology_prosess_sonota))
                    @for ($i = 20;$i <= 20;$i++)
                      @foreach ($matching_technology_prosess_sonota as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                           <div class="confirmation_input_a_div">
                              <a class="confirmation_input_a">{{$value}}</a>
                            </div>
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </div>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">担当工程</h4>
                  <div class="confirmation_input_p display_flex">
                  @if (!empty($matching_technology_prosess_sonota))
                    @for ($i = 21;$i <= 21;$i++)
                      @foreach ($matching_technology_prosess_sonota as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                           <div class="confirmation_input_a_div">
                              <a class="confirmation_input_a">{{$value}}</a>
                            </div>
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </div>
                </div>


                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">特徴・その他</h4>
                  <div class="confirmation_input_p bottom display_flex">
                  @if (!empty($matching_technology_prosess_sonota))
                    @for ($i = 22;$i <= 30;$i++)
                      @foreach ($matching_technology_prosess_sonota as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                            <div class="confirmation_input_a_div">
                              <a class="confirmation_input_a">{{$value}}</a>
                            </div>
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </div>
                </div>

              </div>
            </div>

            <!-- /////// -->
           

          <!-- /////// -->
          <!-- //応募　編集ボタンa -->
          @if ($item2->flag !== "2")
          <form method="POST" class="questionnaire_form h-adr confirmation_submit_form" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit_delete()">

            @csrf
            <div class="issue_edit_btn_box_div">
              <div class="confirmation_btn_div">
                <div class="submit_div submit_flex" >
                  <input class="input_submit return_submit" name="delete_sub" type="submit" value="削除">
                  <input  name="issue_id" type="hidden" value="{{$item2->id}}">
                </div>
      
                <div class="submit_div submit_flex" >
                  <a href="{{ asset(config('const.title.title47'))}}/client_account/edit_issues/{{$item2->id}}" class="input_submit" style="text-decoration:none;display:block;text-align:center;">編集する</a>
                </div>
              </div>
            </div>

          </form>
          @else
          <div class="issue_edit_btn_box_div">
              <a class="issue_edit_btn_a" style="background-color: rgb(238, 238, 238); color:rgb(50,50,50)">人材確定済み</a>
          </div>

          @endif


        </div>
    </body>
    @include('client1.component.footer')
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>