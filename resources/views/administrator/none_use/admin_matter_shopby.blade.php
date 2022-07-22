<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title20')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title20')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        <div class="main_form">

            <div class="table_div">
                @if (session('msgs'))
                    <p>{{session('msgs')}}</p><br>
                @endif
                <p>{{config('const.table_info.info1')}}</p>
                <table class="table_map">
                    <tr>
                        <th>{{config('const.matter_info.info1')}}</th>
                        <th>{{config('const.matter_info.info57')}}</th>
                        <th>{{config('const.matter_info.info7')}}</th>
                    </tr>
                    @foreach ($id_list as $key=>$value)
                    <tr>
                        <td><a href="admin_matter/{{$key}}">{{$key}}</a></td>
                        <td><a href="admin_{{config('const.title.title47')}}_2_detail/{{$value}}">{{$value}}</a></td>
                        <td><a href="admin_{{config('const.title.title47')}}_2_detail/{{$value}}">{{$name_list[$key]}}</a></td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </body>
    @include('administrator.component.footer')
</html>
