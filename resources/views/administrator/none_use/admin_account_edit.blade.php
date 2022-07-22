<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <title>{{config('const.title.title43')}}</title>
    </head>

    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title43')}}</h3>
        </div>


        <div class="main_form">
            @if (session('msgs'))
                <p class="error">{{session('msgs')}}</p>
            @endif

                <form method="POST" action="">
                    @csrf
                    <div class="create">

                            <div class="form_group">
                                <label>新しいメールアドレス</label>
                                <input type="email" name="mail" required>
                            </div>

                        <div class="chat_submit">
                            <input type="submit" class="chat_btn" name="mail_submit" value="メールアドレス更新">
                        </div>

                    </div><br>
                </form>
                <form method="POST" action="">
                    @csrf
                    <div class="create">

                            <div class="form_group">
                                <label>新しいパスワード（半角英数字8文字以上）</label>
                                <input type="password" name="password" required>
                            </div>
                            <div class="form_group">
                                <label>もう一度入力してください。</label>
                                <input type="password" name="password2" required>
                            </div>

                        <div class="chat_submit">
                            <input type="submit" class="chat_btn" name="password_submit" value="パスワード更新">
                        </div>

                    </div>
                </form>

        </div>

    </body>
    @include('administrator.component.footer')
</html>
