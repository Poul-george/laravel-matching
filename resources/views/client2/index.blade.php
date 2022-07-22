<?php
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset ('css/influ.css') }}" rel="stylesheet">
        <link href="{{asset ('css/login.css') }}" rel="stylesheet"> 
        <title>{{config('const.title.title2')}}</title>
    </head>
    <style>
        .button-panel .button {
            background: #5D99FF;
        }
    </style>
    <body>
        

        <div class="form-wrapper">
            <h1>{{config('const.title.title2')}}</h1>
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

            </form>
            <br>
                @if (isset($error))
                    <p>{{$error}}</p>
                @endif
            <br>
            <div class="form-footer">
                <a href="{{ asset(config('const.title.title48'))}}/pass_forget">パスワードを忘れた方はこちら</a>
                <a href="{{ asset(config('const.title.title48'))}}/first_form">新規登録はこちらから</a>
            </div>
        </div>
    </body>
</html>
