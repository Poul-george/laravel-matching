<?php
function insertStr1($text, $insert, $num){
    return substr_replace($text, $insert, $num, 0);
  }
  // //ab|Text|cdef
  // echo insertStr1('abcdef', '|Text|', 2);
  $count = 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}"> 
        <!-- <link rel="stylesheet" href="{{ asset('css/form_client1.css')}}">  -->
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="{{ asset('js/chartjs-plugin-labels.js')}}"></script>
        <style>

      .main_div {
        margin: 0;
      }
      .main_div.active {
        background: rgb(248, 252, 255);
      }
    </style>

        <title>案件詳細</title>
    </head>
    <body>
      @include('administrator.component.administrator_left')
      <div class="main_div" id="main_div">
        @include('administrator.component.administrator_header')
        @if (session('msgs')) 
          <p class="msg_center">{{session('msgs')}}</p> 
        @endif

        <div class="confirmation_input_div company_info_div">

          <div class="confirmation_input_group_div">
          <p class="questionnaire_input_p issue_company_name_p">{{$issue_item->matter_name}}案件・求人【{{$issue_item->shop_name}}】</p>

            <div class="issues_one_div company_one_div">

              <div class="issue_img_title_flex company_img_title_div">
                <div class="issue_img_div">
                    @if ($issue_item->client_image === null || $issue_item->client_image === "")  
                        <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                    @else
                        <img class="issue_img" src="{{asset('client_images/' . $issue_item->client_image )}}"/>
                    @endif
                </div>
                <div class="issue_title_h3_div ">
                  <p class="questionnaire_input_p">{{$issue_item->shop_name}}</p>
                  <h3 class="issue_title_h3">{{$issue_item->matter_name}}</h3>
                </div>  
              </div>  
            </div>  
          </div>  
        </div>  

        <div class="confirmation_input_div" style="margin-top:0">
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">業務内容</h3></div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">作業内容</h4>
                <p class="company_info_detail_text">{{$issue_item->issue_info_textarea1}}</p>
              </div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">必須スキル</h4>
                <p class="company_info_detail_text">{{$issue_item->issue_info_textarea2}}</p>
              </div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">尚可スキル</h4>
                <p class="company_info_detail_text">{{$issue_item->issue_info_textarea3}}</p>
              </div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">尚可スキル</h4>
                <p class="company_info_detail_text">{{$issue_item->issue_info_textarea4}}</p>
              </div>

          </div>
        </div>

        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">基本情報</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">単価</h4>
                <?php
                    if (strlen($issue_item->basic_info_select1_1) === 3) {
                      $money1 = insertStr1($issue_item->basic_info_select1_1, ',', 1);
                    } else {
                      $money1 = $issue_item->basic_info_select1_1;
                    }
                    if (strlen($issue_item->basic_info_select1_2) === 3) {
                      $money2 = insertStr1($issue_item->basic_info_select1_2, ',', 1);
                    } else {
                      $money2 = $issue_item->basic_info_select1_2;
                    }
                  ?>
                  <p class="company_info_detail_p">{{$money1}}0,000 〜 {{$money2}}0,000 円/月</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">精算幅</h4>
                  <p class="company_info_detail_p">{{$issue_item->basic_info_text1}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">勤務地</h4>
                  <p class="company_info_detail_p">{{$issue_item->basic_info_text2}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">都道府県</h4>
                  <p class="company_info_detail_p">
                    @foreach ($todouhuken_list as $key=>$value)
                      @if($key == $issue_item->todouhuken)
                        {{$value}}
                      @endif
                    @endforeach
                  </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約形態</h4>
                  <p class="company_info_detail_p">
                    @foreach ($contract_form_list as $key=>$value)
                      @if($key == $issue_item->basic_info_select2)
                      {{$value}}
                      @endif
                    @endforeach
                  </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">商流</h4>
                  <p class="company_info_detail_p">{{$issue_item->basic_info_text3}}</p>
              </div>

          </div>
        </div>


         <!-- ////////////// -->
         <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">募集条件</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">契約期間</h4>
                  <p class="company_info_detail_p">{{$issue_item->recruitment_info_text1}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">勤務時間</h4>
                  <p class="company_info_detail_p">{{$issue_item->recruitment_info_text2}}</p>
                </div>
                
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">平均<br>稼動時間</h4>
                  <p class="company_info_detail_p">{{$issue_item->recruitment_info_text3}}</p>
                </div>
                
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">募集人数</h4>
                  <p class="company_info_detail_p">{{$issue_item->recruitment_info_text4}}</p>
              </div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">募集背景</h4>
                <p class="company_info_detail_text">{{$issue_item->recruitment_info_textarea1}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">面談回数</h4>
                  <p class="company_info_detail_p">{{$issue_item->recruitment_info_text5}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">備考</h4>
                  <p class="company_info_detail_p">{{$issue_item->recruitment_info_text6}}</p>
              </div>

          </div>
        </div>


        <!-- ////////////// -->
        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">現場情報</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">勤務先企業</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text1}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">服装</h4>
                  <p class="company_info_detail_p">
                    @foreach ($dress_list as $key=>$value)
                      @if($key == $issue_item->company_info_select1)
                        {{$value}}
                      @endif
                    @endforeach
                  </p>
                </div>
                
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">平均<br>稼動時間</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text2}}</p>
                </div>
                
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">プロジェクト人数</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text3}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">所在地</h4>
                <p class="company_info_detail_p">{{$issue_item->company_info_text4}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">設立</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text5}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">代表者</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text6}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">従業員数</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text7}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">資本金</h4>
                  <p class="company_info_detail_p">{{$issue_item->company_info_text8}}</p>
              </div>

          </div>
        </div>


        <!-- ////////////// -->
        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">マッチング情報</h3></div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">ポジション</h4>
                  <p class="company_info_detail_p">
                  @if (!empty($matching_position))
                      @for ($i = 0;$i <= 6;$i++)
                        @foreach ($matching_position as $item)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($item == $key)
                              {{$value}}/
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    @endif
                  </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">スキル</h4>
                  <p class="company_info_detail_p">
                  @if (!empty($matching_skill))
                    @for ($i = 7;$i <= 16;$i++)
                      @foreach ($matching_skill as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                            {{$value}}/
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </p>
                </div>
                
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">業界・業種</h4>
                  <p class="company_info_detail_p">
                    @if (!empty($matching_industry))
                      @for ($i = 17;$i <= 19;$i++)
                        @foreach ($matching_industry as $item)
                          @foreach ($lists[$i] as $key=>$value)
                            @if($item == $key)
                              {{$value}}/
                            @endif
                          @endforeach
                        @endforeach
                      @endfor
                    @endif
                  </p>
                </div>
                
                <div class="company_info_detail_one_flex">
                  <h4 class="company_info_detail_title_h4">テクノロジー</h4>
                  <p class="company_info_detail_p">
                  @if (!empty($matching_technology_prosess_sonota))
                    @for ($i = 20;$i <= 20;$i++)
                      @foreach ($matching_technology_prosess_sonota as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                            {{$value}}/
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">担当工程</h4>
                <p class="company_info_detail_p">
                  @if (!empty($matching_technology_prosess_sonota))
                    @for ($i = 21;$i <= 21;$i++)
                      @foreach ($matching_technology_prosess_sonota as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                            {{$value}}/
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                </p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">特徴・その他</h4>
                  <p class="company_info_detail_p">
                  @if (!empty($matching_technology_prosess_sonota))
                    @for ($i = 22;$i <= 30;$i++)
                      @foreach ($matching_technology_prosess_sonota as $item)
                        @foreach ($lists[$i] as $key=>$value)
                          @if($item == $key)
                            {{$value}}/
                          @endif
                        @endforeach
                      @endforeach
                    @endfor
                  @endif
                  </p>
              </div>

          </div>
        </div>

       


      </div>
        
    </body>
    <!-- @include('client2.component.footer') -->



</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>