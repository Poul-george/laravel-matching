<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title22')}}</title>
    </head>
    <body>
    @include('client.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title22')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="matter">戻る</a></li> --}}
        </div>
        <div class="main_form">
            <div class="table_div">
                @if (session('msg'))
                    <p class="msg_center">{{session('msg')}}</p><br>
                    <p>{{config('const.table.info1')}}
                @endif
                <table class="table_map">
                    <tr>
                        <th>{{config('const.matter_info.info18')}}</th>
                        <th>{{config('const.matter_info.info19')}}</th>
                        <th>{{config('const.matter_info.info39')}}</th>
                        <th>{{config('const.matter_info.info40')}}</th>
                        <th>{{config('const.matter_info.info41')}}</th>
                    </tr>

                    @foreach ($item as $value)
                    @if (empty($value->id))
                        <p>現在、採用済みの(マッチング相手)はいません。</p>
                    @else
                    <tr>
                        <td><a href="../matter_state_detail/{{$value->id}}">{{$value->influ_name}}</a></td>
                        <td>{{$flag_list[$value->flag]}}</td>
                        <td>{{$value->date_result}}</td>
                        <td>{{$value->time_result}}</td>
                        <td>{{$value->member_result}}</td>
                    </tr>
                    @endif
                    @endforeach

                </table>
            </div><br>

            @if ($matter_flag==="4")
                @if (empty($end_date))
                    <div class="create">
                        <p>{{config('const.matter_info.info45')}}</p>
                        <form method="POST" action="">
                            @csrf
                            <div class="select_submit">
                                <select class="select_2separate" name="selector1" required>
                                    <option value="">案件完了後、選択してください。</option>
                                    <option value="1">{{config('const.matter_info.info45')}}</option>
                                </select>
                                <input type="hidden" name="hidden_id" value="{{$id}}">
                                <input type="submit" class="btn" name="confirm" value="案件完了">
                            </div>
                        </form>
                    </div><br>
                @else
                    <div class="syousai_area">
                        <p class="msg_center">この案件は、{{$end_date}}に完了しました。</p>
                    </div>
                @endif
            @endif

        </div>

    </body>
    @include('client.component.footer')
</html>
