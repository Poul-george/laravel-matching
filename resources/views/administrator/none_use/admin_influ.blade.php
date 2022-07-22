<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title18')}}</title>
    </head>

    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title18')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>

        <div class="main_form">
            <div class="main_page_link">
                <li><a href="admin_{{config('const.title.title48')}}_1"><div class="link_form">{{config('const.title.title14')}}
                    <p>事前登録済みの(マッチング相手)の閲覧と本登録への可否を行えます。</p>
                </div></a></li>
                <li><a href="admin_{{config('const.title.title48')}}_2"><div class="link_form">{{config('const.title.title16')}}
                    <p>本登録済みの(マッチング相手)の閲覧ができます。</p>
                </div></a></li>
            </div>
        </div>

    </body>
    @include('administrator.component.footer')
</html>
