<?php

$box_index1 = 1;
$box_index2 = 1;
$box_index2_2 = 8;
$box_index3 = 1;
$box_index3_2 = 18;
$list_index = 0;
$list_index2 = 0;

// phpinfo();
// ini_set('memory_limit', '5000M');
// echo ini_get('memory_limit');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <title>マイページ</title>
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>
        
        @if (session('msgs'))
            <p class="error">{{session('msgs')}}</p>
        @endif
            
        @include('client2.component.mypage_left')
<div class="main_div" id="main_div">
    @include('client2.component.mypage_header')


    <div class="top_title">
        <!-- <h3 class="title">{{config('const.title.title49')}}</h3> -->
        <h3 class="title">マイページ</h3>
    </div>

    <div class="mypage_div">  
        <div class="user_info_div">
            <div class="user_info_icon_div">
            @if ($user_image === null || $user_image === "")  
                    <img class="user_info_icon_img" src="{{asset('template_img/face_blue.png')}}"/>
                @else
                    <img class="user_info_icon_img" src="{{asset('user_images/' . $user_image )}}"/>
                @endif
            </div>
            <div class="user_info_name_div">
                <p class="user_info_name_p">{{$name1}} {{$name2}}</p>
            </div>
            <!-- <div class="user_profile_how_div">
                <p class="user_info_p">プロフィール入力率</p>
                <div class="profile_how_width">
                <div class="how_wudth"><span class="how_width_span">60%</span></div>
                </div>
            </div> -->
            <div class="user_profile_sukil_div">
                <p class="user_info_p">経験スキル</p>
                <div class="profile_sukil_div">
                <!-- ////////////////////////////////////// -->
                <!-- ふえる部分 -->
                @for ($l_x = 7; $l_x <= 16; $l_x++)
                    @foreach ($skill_lists[$l_x] as $key=>$value) 
                        @if ($list_index !== 10)
                            @foreach ($experience_skill_check as $check)
                                @if ($check == $key) 
                                <div class="sukil_a_div"><a href="" class="sukil_a">{{$value}}</a></div>
                                @endif
                            
                            @endforeach
                        @elseif ($list_index === 10)
                        @endif
                    @endforeach
                    <?php $list_index++; ?>
                    <?php $box_index2_2++; ?>
                @endfor
                </div>
            </div>
        </div>
        
        <div class="user_notice_div">
            <section class="notice_section">
            <h3 class="notice_h3">お知らせ情報</h3>
            <div class="notice_notice_div_hr"></div>
            <p class="notice_p">マイページのリニューアルをしました。</p>
            </section>

            <!-- <section class="notice_section">
            <h3 class="notice_h3">プロフィール入力 20%</h3>
            <div class="notice_notice_div_hr"></div>
            <p class="notice_p">プロフィールの入力を充実させることでスカウトの受信率が高くなります。まずは、職務経歴書・スキルシートをアップロードし、充実させましょう。また、以前にアップロードしたままの方は、最新の情報を更新し、再アップロードされることをお勧めします。</p>
            </section> -->

            <!-- <section class="notice_section">
            <h3 class="notice_h3">新着・未対応スカウト</h3>
            <div class="notice_notice_div_hr"></div>
            <p class="notice_p">佐々木様へ届いたスカウトは、『スカウト一覧』から確認することができます。今までのご経験やスキルを拝見し、マッチした案件を提案しております。スカウト内容詳細をご確認の上、応募または辞退を行ってください。1ヶ月放置すると辞退の自動処理が行われます。</p>
            </section> -->
        </div>
    </div>

</div>


        

    </body>
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>