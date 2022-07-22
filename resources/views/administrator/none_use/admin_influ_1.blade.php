<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title14')}}</title>
    </head>

    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title14')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="admin_influ">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
        @if (session('msg'))
            <p class="msg_center">{{session('msg')}}</p>
        @endif
            <div class="table_div">
                <p>{{config('const.table_info.info1')}}</p>
                <table class="table_map">
                    <tr>
                        <th>{{config('const.influ_info.info4')}}</th>
                        <th>{{config('const.influ_info.info5')}}</th>
                        <th>{{config('const.influ_info.info6')}}</th>
                    </tr>
                    @foreach ($item as $value)
                    <tr>
                        <td><a href="admin_{{config('const.title.title48')}}_1_detail/{{$value->id}}">{{$value->id}}</a></td>
                        <td><a href="admin_{{config('const.title.title48')}}_1_detail/{{$value->id}}">{{$value->user_name}}</a></td>
                        <td>{{$value->user_oubo}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </body>
    @include('administrator.component.footer')
</html>
