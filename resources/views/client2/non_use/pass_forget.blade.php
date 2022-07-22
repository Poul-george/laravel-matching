<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <link href="{{asset ('css/client.css') }}" rel="stylesheet">
        <link href="{{asset ('css/login.css') }}" rel="stylesheet"> --}}
        <link href="{{secure_asset ('css/influ.css') }}" rel="stylesheet">
        <link href="{{secure_asset ('css/login.css') }}" rel="stylesheet">
        <title>パスワード再発行</title>
    </head>
    <body>


        <div class="form-wrapper">
            <h1>パスワード再発行</h1>
            <form method="POST" action="">
                @csrf
                <div class="form-item">
                <label for="email"></label>
                <input type="text" name="id" required="required" placeholder="ID">
                </div>
                <div class="form-item">
                <label for="password"></label>
                <input type="text" name="user_name" required="required" placeholder="お名前">
                </div>
                <div class="form-item">
                <label for="password"></label>
                <input type="text" name="user_instagram_url" required="required" placeholder="インスタグラムURL">
                </div>
                <div class="button-panel">
                <input type="submit" class="button" title="再発行" value="再発行">
                </div>

            </form>
            <br>
                @if (session('msg'))
                    <p class="msg_center">{{session('msg')}}</p>
                @endif
            <br>
            <div class="form-footer">
                <a href="/{{config('const.title.title48')}}">ログインページへ</a>
            </div>

        </div>
    </body>
</html>
