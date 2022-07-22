<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title9')}}</title>
    </head>
    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title9')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="admin_client">戻る</a></li> --}}
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
                    <th>{{config('const.client_info.info1')}}</th>
                    <th>{{config('const.client_info.info8')}}</th>
                    <th>{{config('const.client_info.info9')}}</th>
                    <th></th>
                </tr>
                @foreach ($item as $value)
                <tr>
                    <td><a href="admin_{{config('const.title.title47')}}_1_detail/{{$value->id}}">{{$value->id}}</a></td>
                    <td><a href="admin_{{config('const.title.title47')}}_1_detail/{{$value->id}}">{{$value->shop_name}}</a></td>
                    <td>{{$value->shop_oubo}}</td>
                    @if ($value->shop_flag==='4')
                        <td>検討中</td>
                    @else
                        <td>未選考</td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    </body>
    @include('administrator.component.footer')
</html>
