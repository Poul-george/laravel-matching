<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title5')}}</title>
    </head>

    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title5')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="/logout">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>

        <div class="main_form">
            <div class="main_page_link">
                <li><a href="admin_config"><div class="link_form">{{config('const.config_info.info3')}}
                <p>案件に関しての設定項目の編集を行えます。</p></div>

                </a></li>
                <li><a href="admin_config_{{config('const.title.title47')}}"><div class="link_form">{{config('const.config_info.info4')}}
                <p>{{config('const.title.title3')}}向けの設定項目の編集を行えます。</p></div>

                </a></li>
            </div>

        </div>

    </body>
    @include('administrator.component.footer')
</html>
