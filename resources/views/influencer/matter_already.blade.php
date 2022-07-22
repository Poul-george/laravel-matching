<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title32')}}</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title32')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msg'))
                <p class="msg_center">{{session('msg')}}</p><br>
            @endif
            <div class="yoyaku_all">
                <div class="yoyaku_box">
                    <div class="yoyaku_title">マクドナルドは多賀谷店</div>
                    <div class="yoyaku_msg">ご登録いただきありがとうございます。今後ともよろしくお願いいたします。</div>
                    <div class="yoyaku_div">来店日時：2021-08-21 18:00</div>
                    <div class="yoyaku_div">予約名・人数：田中太郎&nbsp;&nbsp;3名</div>
                </div>

            </div><br>
        </div>

    </body>
    @include('influencer.component.footer')
</html>
