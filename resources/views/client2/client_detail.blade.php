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

      .main_div.active {
        background: rgb(248, 252, 255);
      }
    </style>

        <title>企業情報</title>
    </head>
    <body>
    @include('client2.component.header')
    @include('client2.component.mypage_left')

      <div class="main_div" id="main_div">

        <div class="confirmation_input_div company_info_div">

          <div class="confirmation_input_group_div">
            <p class="questionnaire_input_p">{{$company_item->shop_name}}の企業情報</p>

            <div class="issues_one_div company_one_div">

              <div class="issue_img_title_flex company_img_title_div">
                <div class="issue_img_div">
                    @if ($company_item->client_image === null || $company_item->client_image === "")  
                        <img class="issue_img" src="{{asset('template_img/face_red.png')}}"/>
                    @else
                        <img class="issue_img" src="{{asset('client_images/' . $company_item->client_image )}}"/>
                    @endif
                </div>
                <div class="issue_title_h3_div ">
                  <a class="issue_detail_a" href="{{ asset(config('const.title.title48'))}}/client_detail/{{$company_item->id}}">
                    <h3 class="issue_title_h3">{{$company_item->shop_name}}</h3>
                  </a>
                </div>  
              </div>  
            </div>  
          </div>  
        </div>  

        <div class="confirmation_input_div" style="margin-top:0">
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">概要</h3></div>

              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">事業内容</h4>
                <p class="company_info_detail_text">{{$company_item->business_bescription}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">設立</h4>
                <p class="company_info_detail_p">{{$birth_y}}年{{$birth_m}}月{{$birth_d}}日</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">住所</h4>
                <p class="company_info_detail_p">{{$shop_address1}} {{$shop_address2}} {{$shop_address3}} {{$shop_address4}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">資本金</h4>
                <p class="company_info_detail_p">{{$company_item->capital}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">売上</h4>
                <p class="company_info_detail_p">{{$company_item->sales}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">代表取締役</h4>
                <p class="company_info_detail_p">{{$company_item->ceo_name}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">従業員数</h4>
                <p class="company_info_detail_p">{{$company_item->number_employees}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">総稼働者数</h4>
                <p class="company_info_detail_p">{{$company_item->total_number_employees}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">免許・許認可</h4>
                <p class="company_info_detail_p">{{$company_item->license_text}}</p>
              </div>

              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">主要取引先</h4>
                <p class="company_info_detail_p">{{$company_item->majo_business_partners}}</p>
              </div>

          </div>
        </div>


        <div class="confirmation_input_div" >
          <div class="company_info_detail_div">
            <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">特徴</h3></div>

            @if ($company_item->company_introduction !== null)
              <div class="company_info_detail_one_textarea">
                <h4 class="company_info_detail_title_h4">会社紹介</h4>
                <p class="company_info_detail_text">{{$company_item->company_introduction}}</p>
              </div>
            @endif

            @if ($rate_1 !== 0)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">業界</h4>
                <div class="canvas_div_flex">
                  <div style="width: 150px;" class="canvas_div">
                    <canvas id="chart1" width="150" height="150"></canvas>
                  </div>

                  <div class="canvas_title_div">
                    @for ($i = 0;$i <= count($relation_industry1)-1; $i++)
                      @foreach ($industry_list as $key=>$value)
                        @if ($relation_industry1[$i] == $key)
                          <div class="canvas_color_title_flex">
                            <div class="camvas_color color{{$i+1}}"></div>
                            <p class="canvas_title">{{$value}}</p>
                          </div>
                        @endif
                      @endforeach
                    @endfor
                    @if ($rate_1 !== 101)
                      <div class="canvas_color_title_flex">
                        <div class="camvas_color color5"></div>
                        <p class="canvas_title">その他</p>
                      </div>
                    @endif
                  </div>

                </div>
              </div>
            @endif
            
              @if ($rate_3 !== 0)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">業種</h4>
                <div class="canvas_div_flex">
                  <div style="width: 150px;" class="canvas_div">
                    <canvas id="chart2" width="150" height="150"></canvas>
                  </div>

                  <div class="canvas_title_div">
                    @for ($i = 0;$i <= count($relation_industry2)-1; $i++)
                      @foreach ($industry_kind_list as $key=>$value)
                        @if ($relation_industry2[$i] == $key)
                          <div class="canvas_color_title_flex">
                            <div class="camvas_color color{{$i+1}}"></div>
                            <p class="canvas_title">{{$value}}</p>
                          </div>
                        @endif
                      @endforeach
                    @endfor
                    @if ($rate_2 !== 101)
                      <div class="canvas_color_title_flex">
                        <div class="camvas_color color5"></div>
                        <p class="canvas_title">その他</p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            @endif
            
            @if ($rate_3 !== 0)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">資格</h4>
                <div class="canvas_div_flex">
                  <div style="width: 150px;" class="canvas_div">
                    <canvas id="chart3" width="150" height="150"></canvas>
                  </div>

                  <div class="canvas_title_div">
                    @for ($i = 0;$i <= count($company_qualification)-1; $i++)
                      @foreach ($qualifications_held_list as $key=>$value)
                        @if ($company_qualification[$i] == $key)
                          <div class="canvas_color_title_flex">
                            <div class="camvas_color color{{$i+1}}"></div>
                            <p class="canvas_title">{{$value}}</p>
                          </div>
                        @endif
                      @endforeach
                    @endfor
                    @if ($rate_3 !== 100)
                      <div class="canvas_color_title_flex">
                        <div class="camvas_color color5"></div>
                        <p class="canvas_title">その他</p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            @endif

            @if ($company_item->pr_comment !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">PRコメント</h4>
                <p class="company_info_detail_p">{{$company_item->pr_comment}}</p>
              </div>
            @endif

            @if ($company_item->company_type !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">会社種類</h4>
                <p class="company_info_detail_p">{{$company_item->company_type}}</p>
              </div>
            @endif

            @if ($company_item->interview_format !== "")
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">面談形式</h4>
                <p class="company_info_detail_p">
                  @foreach ($interview_list as $key=>$value)
                    @foreach ($interview_format as $check)
                      @if ($key == $check)
                        {{$value}}、
                      @endif
                    @endforeach
                  @endforeach
                </p>
              </div>
            @endif

            @if ($company_item->member_text !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">メンバー</h4>
                <p class="company_info_detail_p">{{$company_item->member_text}}</p>
              </div>
            @endif

            @if ($company_item->characteristics_of_holding !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">保有案件の特徴</h4>
                <p class="company_info_detail_p">{{$company_item->characteristics_of_holding}}</p>
              </div>
            @endif

            @if ($company_item->business_partner_trends !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">取引先の傾向</h4>
                <p class="company_info_detail_p">{{$company_item->business_partner_trends}}</p>
              </div>
            @endif

            @if ($company_item->payment_site_info !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">支払サイト</h4>
                <p class="company_info_detail_p">{{$company_item->payment_site_info}}</p>
              </div>
            @endif

            @if ($company_item->trends_in_human_resources !== null)
              <div class="company_info_detail_one_flex">
                <h4 class="company_info_detail_title_h4">所属人材の傾向</h4>
                <p class="company_info_detail_p">{{$company_item->trends_in_human_resources}}</p>
              </div>
            @endif


          </div>
        </div>


      </div>
        
    </body>
    <!-- @include('client2.component.footer') -->

     <!-- div hiddenn -->
     <div class="hidden_div">
        <div class="">
          @if ($relation_industry_rate_1 !== null || $relation_industry_rate_1 !== "") 
                @foreach ($relation_industry_rate_1 as $check)
                  <div class="hidden_div_one">
                      <input class="hidden_lata_num1" value="{{$check}}" type="hidden" id="">
                  </div>
                @endforeach
            @endif
        </div>
    </div>
     <!-- div hiddenn -->
     <div class="hidden_div">
        <div class="">
          @if ($relation_industry_rate_2 !== null || $relation_industry_rate_2 !== "") 
                @foreach ($relation_industry_rate_2 as $check)
                  <div class="hidden_div_one">
                      <input class="hidden_lata_num2" value="{{$check}}" type="hidden" id="">
                  </div>
                @endforeach
            @endif
        </div>
    </div>
     <!-- div hiddenn -->
     <div class="hidden_div">
        <div class="">
          @if ($company_qualification_rate_1 !== null || $company_qualification_rate_1 !== "") 
                @foreach ($company_qualification_rate_1 as $check)
                  <div class="hidden_div_one">
                      <input class="hidden_lata_num3" value="{{$check}}" type="hidden" id="">
                  </div>
                @endforeach
            @endif
        </div>
    </div>

</html>
<script type="text/javascript" src="{{ asset('js/main_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/chart_graph.js')}}"></script>