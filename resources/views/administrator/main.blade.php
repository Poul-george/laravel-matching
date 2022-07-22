<?php
    // $rrr = null;
    // $sss = "";
    // var_dump(empty($rrr));
    // var_dump(empty($sss));
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>{{config('const.title.title1')}}</title>
    </head>

    <style>
        .mypage_div {display: block;}
        .user_notice_div {
            width: calc(100% - 80px );
            margin: 15px 40px;
        }
        .notice_p_span {
            font-size: 16px;
            color: #00CC00;
        }
        @media screen and (max-width: 799px) {
            .user_notice_div {
                width: calc(100% - 40px);
                margin: 15px 20px;
            }
        }
    </style>

    <body>
        @include('administrator.component.administrator_left')
        <div class="main_div" id="main_div">
            @include('administrator.component.administrator_header')
            <div class="top_title">
                <h3 class="title">HOME</h3>
            </div>

            <div class="mypage_div">  
                
                <div class="user_notice_div">
                    @if ($issue_item_count  !== 0)
                    <section class="notice_section">
                        <h3 class="notice_h3">案件申請</h3>
                        <div class="notice_notice_div_hr"></div>
                        <a href="{{ asset(config('const.title.title49'))}}/all_issue">
                            <p class="notice_p">未対応の案件申請が <span class="notice_p_span">{{$issue_item_count}}</span> 件あります。</p>
                        </a>
                    </section>
                    @endif

                    @if ($contacts_within_three_days_count  !== 0)
                    <section class="notice_section">
                        <h3 class="notice_h3">契約確認</h3>
                        <div class="notice_notice_div_hr"></div>
                        <a href="{{ asset(config('const.title.title49'))}}/all_contacts">
                            <p class="notice_p">契約満了三日以内の契約が <span class="notice_p_span">{{$contacts_within_three_days_count}}</span> 件あります。</p>
                        </a>
                    </section>
                    @endif

                    @if ($contacts_expiration_one_week_count  !== 0)
                    <section class="notice_section">
                        <h3 class="notice_h3">人材稼動確認</h3>
                        <div class="notice_notice_div_hr"></div>
                        <a href="{{ asset(config('const.title.title49'))}}/all_contacts">
                            <p class="notice_p">人材稼動確認を1週間以上行っていない契約が <span class="notice_p_span">{{$contacts_expiration_one_week_count}}</span> 件あります。</p>
                        </a>
                    </section>
                    @endif

                    @if ($payment_term_out  !== 0)
                    <section class="notice_section">
                        <h3 class="notice_h3">未払い契約</h3>
                        <div class="notice_notice_div_hr"></div>
                        <a href="{{ asset(config('const.title.title49'))}}/all_payment">
                            <p class="notice_p">お支払い期限を過ぎている契約が <span class="notice_p_span">{{$payment_term_out}}</span> 件あります。</p>
                        </a>
                    </section>
                    @endif
                </div>
            </div>

        </div>

    </body>
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>