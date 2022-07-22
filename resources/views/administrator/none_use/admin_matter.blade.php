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
            <p>{{$item2->shop_name}}</p>
                <table class="table_map">
                    <tr>
                        <th>{{config('const.matter_info.info1')}}</th>
                        <th>{{config('const.matter_info.info6')}}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($item as $value)
                    <tr>
                        <td><a href="../admin_matter_detail/{{$value->matter_id}}">{{$value->matter_id}}</a></td>
                        <td><a href="../admin_{{config('const.title.title48')}}_2_detail/{{$value->influ_id}}">{{$value->influ_name}}</a></td>
                        <td class="table_btn">
                            <form method="POST" action="">
                                @csrf
                                <input type="hidden" name="saiyou" value="T">
                                <input type="hidden" name="matter_id" value="{{$value->matter_id}}">
                                <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                <input type="submit"　name="submit_matter_1" value="採用" class="btn">
                            </form>
                        </td>
                        <td class="table_btn">
                            <form method="POST" action="">
                                @csrf
                                <input type="hidden" name="saiyou" value="F">
                                <input type="hidden" name="matter_id" value="{{$value->matter_id}}">
                                <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                <input type="submit"　name="submit_matter_2" value="不採用" class="btn">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </body>
    @include('administrator.component.footer')
</html>
