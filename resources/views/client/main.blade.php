<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title1')}}</title>
    </head>
    <body>
    @include('client.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title1')}}</h3>
        </div>

        <div class="main_form">
        @if (session('flash_message'))
            <p class="msg_center">{{session('flash_message')}}</p>
        @endif
            <div class="main_page_link">
                <li><a href="create_matter"><div class="link_form">{{config('const.title.title28')}}
                <p>新たに案件を作成していただけます。</p></div>

                </a></li>
                <li><a href="matter"><div class="link_form">{{config('const.title.title24')}}
                <p>作成された案件一覧と各案件毎のステータス管理・採用された(マッチング相手)の方とのやりとりを行えます。</p></div>

                </a></li>
            </div>
            <div class="main_page_link">
                <li><a href="client_form_before"><div class="link_form">{{config('const.title.title27')}}
                <p>案件ごとに(マッチング相手)の投稿報告内容や運営者からの診断書が閲覧できます。</p></div>

                </a></li>
                <li><a href="chat_admin"><div class="link_form">{{config('const.title.title25')}}
                <p>運営側とのチャットを行えます。</p></div>

                </a></li>
            </div>
        </div>

    </body>
    @include('client.component.footer')
</html>
