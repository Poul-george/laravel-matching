<?php
// var_dump($session_test);

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

    <body>
        
        <div class="main_div" id="main_div">

            <div class="top_title">
                <!-- <h3 class="title">{{config('const.title.title35')}}</h3> -->
                <h3 class="title">確認画面</h3>
            </div>


            <!-- ///////////////////// -->

            <div class="confirmation_input_div">
              <div class="confirmation_input_group_div">
                <div class="input_title_h3_div confirmation_input_title_h3_div"><h3 class="input_title_h3">業務内容</h3></div>

                <div class="confirmation_input_group_one_flex top">
                  <h4 class="confirmation_input_title_h4">作業内容</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_textarea1"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">必須スキル</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_textarea2"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">尚可スキル</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_textarea3"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">開発環境</h4>
                  <p class="confirmation_input_p bottom">{{$session_test["create_issues_textarea4"]}}</p>  
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
                  <p class="confirmation_input_p money_p">{{$session_test["create_issues_select1"]}}0,000 〜 {{$session_test["create_issues_select2"]}}0,000 円/月</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">精算幅</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text1"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">勤務地</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text2"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">都道府県</h4>
                  @foreach ($todouhuken_list as $key=>$value)
                    @if($key == $session_test["todouhuken"])
                    <p class="confirmation_input_p">{{$value}}</p>
                    @endif
                  @endforeach
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">契約形態</h4>
                  @foreach ($contract_form_list as $key=>$value)
                    @if($key == $session_test["create_issues_select3"])
                    <p class="confirmation_input_p">{{$value}}</p>
                    @endif
                  @endforeach
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">商流</h4>
                  <p class="confirmation_input_p bottom">{{$session_test["create_issues_text3"]}}</p>  
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
                  <p class="confirmation_input_p">{{$session_test["create_issues_text4"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">勤務時間</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text5"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">平均<br>稼動時間</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text6"]}}</p>
                </div>
                
                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">募集人数</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text7"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">募集背景</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_textarea5"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">面談回数</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text8"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">備考</h4>
                  <p class="confirmation_input_p bottom">{{$session_test["create_issues_text9"]}}</p>  
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
                  <p class="confirmation_input_p">{{$session_test["create_issues_text10"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">服装</h4>
                  <p class="confirmation_input_p">
                    @foreach ($dress_list as $key=>$value)
                      @if($key == $session_test["create_issues_select4"])
                        {{$value}}
                      @endif
                    @endforeach
                  </p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">平均年齢</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text11"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">プロジェクト人数</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text12"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">所在地</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text13"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">設立</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text14"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">代表者</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text15"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex">
                  <h4 class="confirmation_input_title_h4">従業員数</h4>
                  <p class="confirmation_input_p">{{$session_test["create_issues_text16"]}}</p>
                </div>

                <div class="confirmation_input_group_one_flex bottom">
                  <h4 class="confirmation_input_title_h4">資本金</h4>
                  <p class="confirmation_input_p bottom">{{$session_test["create_issues_text17"]}}</p>  
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
                    @if (!empty($session_test["create_issues_checkbox1"]))
                      @for ($i = 0;$i <= 6;$i++)
                        @foreach ($session_test["create_issues_checkbox1"] as $item)
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
                  @if (!empty($session_test["create_issues_checkbox2"]))
                    @for ($i = 7;$i <= 16;$i++)
                      @foreach ($session_test["create_issues_checkbox2"] as $item)
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
                  @if (!empty($session_test["create_issues_checkbox3"]))
                    @for ($i = 17;$i <= 19;$i++)
                      @foreach ($session_test["create_issues_checkbox3"] as $item)
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
                  @if (!empty($session_test["create_issues_checkbox4"]))
                    @for ($i = 20;$i <= 20;$i++)
                      @foreach ($session_test["create_issues_checkbox4"] as $item)
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
                  @if (!empty($session_test["create_issues_checkbox4"]))
                    @for ($i = 21;$i <= 21;$i++)
                      @foreach ($session_test["create_issues_checkbox4"] as $item)
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
                  @if (!empty($session_test["create_issues_checkbox4"]))
                    @for ($i = 22;$i <= 30;$i++)
                      @foreach ($session_test["create_issues_checkbox4"] as $item)
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

            <!-- <form method="POST" class="questionnaire_form h-adr" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit2()"> -->
            <form method="POST" class="questionnaire_form h-adr confirmation_submit_form" action="" enctype="multipart/form-data" >

            @csrf
            <div class="confirmation_btn_div">
              <div class="submit_div submit_flex" >
                <input class="input_submit return_submit" name="return_sub" type="submit" value="戻る">
              </div>
    
              <div class="submit_div submit_flex" >
                <input class="input_submit" type="submit" name="post_sub" value="登録申請">
              </div>
            </div>

            </form>
        </div>
    </body>
    <!-- @include('client1.component.footer') -->
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>