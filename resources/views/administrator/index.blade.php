<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
        <!-- <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/login.css') }}" rel="stylesheet"> -->
        <title>運営者ログイン画面</title>
    </head>
    <body>

        <div class="form-wrapper">
            <h1>管理者ログイン画面</h1>
            <form method="POST" action="">
            @csrf
                <div class="form-item">
                <label for="email"></label>
                <input type="text" name="id" required="required" placeholder="ID">
                </div>
                <div class="form-item">
                <label for="password"></label>
                <input type="password" name="password" required="required" placeholder="パスワード">
                </div>
                <div class="button-panel">
                <input type="submit" class="button" title="Sign In" value="Sign In">
                </div>
            </form><br>
            @if (isset($error))
                    <p>{{$error}}</p>
                @endif
            <div class="form-footer">
                {{-- <p><a href="#">Create an account</a></p>
                <p><a href="#">Forgot password?</a></p> --}}
            </div>
        </div>
    </body>
</html>

<!-- 00bb00 -->