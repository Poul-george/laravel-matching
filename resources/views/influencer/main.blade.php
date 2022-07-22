<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title1')}}</title>
    </head>
    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title1')}}</h3>
        </div>



        <div class="main_form">
            <div class="main_page_link">
                <li><a href="matter"><div class="link_form">{{config('const.title.title24')}}
                <p>案件の閲覧と応募、採用された案件の進行を行えます。</p></div>

                </a></li>
                <li><a href="chat_admin"><div class="link_form">{{config('const.title.title25')}}
                    <p>運営者とのチャットを行えます。</p></div>

                    </a></li>
            </div>
            <div class="main_page_link">

                <li><a href="payment/0"><div class="link_form">{{config('const.title.title40')}}
                <p>お支払通知一覧とその詳細を閲覧できます。</p></div>

                </a></li>
            </div>
        </div>

    </body>
    @include('influencer.component.footer')
</html>
