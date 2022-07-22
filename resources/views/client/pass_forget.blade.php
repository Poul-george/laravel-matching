<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <link href="{{asset ('css/client.css') }}" rel="stylesheet">
        <link href="{{asset ('css/login.css') }}" rel="stylesheet"> --}}
        <link href="{{secure_asset ('css/client.css') }}" rel="stylesheet">
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
                <input type="text" name="client_name" required="required" placeholder="店舗名">
                </div>
                <div class="form-item">
                <label for="password"></label>
                <input type="text" name="client_address" required="required" placeholder="店舗住所">
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
                <a href="/client">ログインページへ</a>
            </div>

        </div>
    </body>
</html>
