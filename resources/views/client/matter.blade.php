<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title24')}}</title>
    </head>
    <body>
    @include('client.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title24')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        </div>
        <div class="main_form">
            <div class="table_div">
                @if (session('msg'))
                    <p>{{session('msg')}}</p><br>
                @endif
                <table class="table_map">
                    <tr>
                        <th>{{config('const.matter_info.info1')}}</th>
                        <th>{{config('const.matter_info.info7')}}</th>
                        <th>{{config('const.matter_info.info59')}}</th>
                        <th>{{config('const.matter_info.info26')}}</th>
                        <th>{{config('const.matter_info.info27')}}</th>
                        <th>{{config('const.matter_info.info28')}}</th>
                        <th>{{config('const.matter_info.info19')}}</th>
                        <th></th>
                    </tr>

                    @foreach ($item as $value)
                    @if (empty($value->id))
                        <p class="msg_center">現在、案件はありません。</p>
                    @else
                    <tr>
                        <td><a href="matter_state/{{$value->id}}">{{$value->id}}</a></td>
                        <td><a href="matter_state/{{$value->id}}">{{$value->shop_name}}</a></td>
                        <td><a href="matter_state/{{$value->id}}">{{$value->matter_name}}</a></td>
                        <td>{{$value->gather_before}}</td>
                        <td>{{$value->gather_after}}</td>
                        <td>{{$value->matter_num}}</td>
                        <td>{{$flag_list[$value->flag]}}</td>
                        <td><a href="matter_detail/{{$value->id}}">詳細確認</a></td>
                    </tr>
                    @endif
                    @endforeach

                </table>
            </div>

        </div>

    </body>
    @include('client.component.footer')
</html>
