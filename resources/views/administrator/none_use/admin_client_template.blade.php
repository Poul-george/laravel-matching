<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title42')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title42')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        <div class="main_form">

            <div class="create">
                @if (session('msgs'))
                    <p>{{session('msgs')}}</p><br>
                @endif

                <form method="POST" action="">
                    @csrf

                    @if (!empty($template_list))
                        @foreach ($template_list as $key=>$value)
                            <div class="form_group">
                                <textarea class="form_textarea" name="template[]">{{$value}}</textarea>
                            </div>
                        @endforeach
                    @endif

                    <div id="additional_textarea">

                    </div>

                    <div class="msg_center">
                        <a href="javascript:OnLinkClickAdd();">フォーム追加</a>
                    </div>

                    <div class="create_submit">
                        <input type="submit" value="更新" class="btn">
                    </div>
                </form>
            </div>
        </div>

    </body>

    <script>
        function OnLinkClickAdd(){
            var form_group=document.createElement('div');
            form_group.classList.add('form_group');
            var textarea=document.createElement('textarea');
            textarea.classList.add('form_textarea');
            textarea.name='template[]';

            form_group.appendChild(textarea);

            var parent=document.getElementById('additional_textarea');
            parent.appendChild(form_group);
        }
    </script>
    @include('administrator.component.footer')
</html>
