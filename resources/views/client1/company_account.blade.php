<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/form_client1.css') }}" rel="stylesheet">
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
            
        @include('client1.component.mypage_left')
<div class="main_div" id="main_div">
    @include('client1.component.mypage_header')


    <div class="top_title">
        <!-- <h3 class="title">{{config('const.title.title49')}}</h3> -->
        <h3 class="title">マイページ</h3>
    </div>

    <div class="mypage_div">  
        <div class="user_info_div">
            <div class="user_info_icon_div">
            @if ($shop_image === null || $shop_image === "")  
                    <img class="user_info_icon_img" src="{{asset('template_img/face_red.png')}}"/>
                @else
                    <img class="user_info_icon_img" src="{{asset('client_images/' . $shop_image )}}"/>
                @endif
            </div>
            <div class="user_info_name_div">
                <p class="user_info_name_p">{{$shop_name}}</p>
            </div>
            <div class="user_profile_how_div">
                <p class="user_info_p">プロフィール入力率</p>
                <div class="profile_how_width">
                <div class="how_wudth"><span class="how_width_span">60%</span></div>
                </div>
            </div>
            
        </div>
        
        <div class="user_notice_div">
            @if ($contacts_within_three_days_count  !== 0)
            <section class="notice_section">
                <h3 class="notice_h3">契約情報お知らせ</h3>
                <div class="notice_notice_div_hr"></div>
                <a href="{{ asset(config('const.title.title47'))}}/client_account/my_contracts_all" >
                    <p class="notice_p">契約満了三日以内の契約が <span class="notice_p_span">{{$contacts_within_three_days_count}}</span> 件あります。</p>
                </a>
            </section>
            @endif

            @if ($contacts_expiration_one_week_count  !== 0)
            <section class="notice_section">
                <h3 class="notice_h3">人材稼動確認のお知らせ</h3>
                <div class="notice_notice_div_hr"></div>
                <a href="{{ asset(config('const.title.title47'))}}/client_account/user_confirmation" >
                    <p class="notice_p">人材稼動確認を1週間以上行っていない契約が <span class="notice_p_span">{{$contacts_expiration_one_week_count}}</span> 件あります。</p>
                </a>
            </section>
            @endif

            @if ($payment_term_out !== 0)
            <section class="notice_section">
                <h3 class="notice_h3">支払い情報のお知らせ</h3>
                <div class="notice_notice_div_hr"></div>
                <a href="{{ asset(config('const.title.title47'))}}/client_account/my_contracts_all" >
                    <p class="notice_p">お支払い期限を過ぎている契約が <span class="notice_p_span">{{$payment_term_out}}</span> 件あります。</p>
                </a>
            </section>
            @endif

            <section class="notice_section">
            <h3 class="notice_h3">プロフィール入力 20%</h3>
            <div class="notice_notice_div_hr"></div>
            <p class="notice_p">プロフィールの入力を充実させることでユーザーが案件に対して応募しやすくなります。</p>
            </section>

            <!-- <section class="notice_section">
            <h3 class="notice_h3">案件登録をしよう</h3>
            <div class="notice_notice_div_hr"></div>
            <p class="notice_p">様へ届いたスカウトは、『スカウト一覧』から確認することができます。今までのご経験やスキルを拝見し、マッチした案件を提案しております。スカウト内容詳細をご確認の上、応募または辞退を行ってください。1ヶ月放置すると辞退の自動処理が行われます。</p>
            </section> -->
        </div>
    </div>

</div>


        

    </body>
</html>

<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/company_page.js')}}"></script>