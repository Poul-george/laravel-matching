<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title27')}}</title>
    </head>
    <body>
    @include('client.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title27')}}</h3>
        </div>

        <div class="main_form">

            <div class="table_div">
                <p>{{config('const.matter_info.info9')}}</p>
                <table class="table_map table_map_2">

                    <tr>
                        <th></th>
                    @for ($i=0;$i<count($item);$i++)
                            <th>{{$item[$i]['influ_name']}}様</th>
                            @endfor
                    </tr>

                    @foreach ($param as $key=>$value)
                        <tr>
                        @for ($i=0;$i<count($item);$i++)
                            @if ($i===0)
                                <td>{{$param[$key]}}</td>
                                @if (empty($item[$i][$key]))
                                    <td>なし</td>
                                @else
                                    <td>{{$item[$i][$key]}}</td>
                                @endif
                            @else
                                @if (empty($item[$i][$key]))
                                    <td>なし</td>
                                @else
                                    <td>{{$item[$i][$key]}}</td>
                                @endif
                            @endif
                        @endfor
                        </tr>
                    @endforeach
                </table>
            </div><br>

            @for ($i=0;$i<count($item);$i++)
            <div class="syousai_area">
                <h4 class="sub_title">{{$item[$i]['influ_name']}}様</h4><br>
                <p class="msg_center">{{config('const.matter_info.info10')}}</p><hr>
                <div class="img_area">
                    @foreach ($param2 as $key=>$value)
                        @if (!empty($item[$i][$key]))
                            <?php $path=$item[$i][$key]; ?>
                            <div class="img_box">
                                <img src="{{ asset("storage/matterstate/$path") }}" alt="insite">
                            </div>
                        @endif
                    @endforeach
                </div><br>
            {{-- </div><br> --}}

            {{-- <div class="syousai_area"> --}}
            <p class="msg_center">{{config('const.matter_info.info20')}}</p><hr>

                @foreach ($param4 as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$value}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if (empty($item[$i][$key]))
                            <p>なし</p>
                        @else
                            <p>{{$item[$i][$key]}}</p>
                        @endif
                    </div><br>
                @endforeach


                <div class="syousai_title">
                    <p>{{config('const.matter_info.info43')}}</p>
                </div>
                <div class="syousai_comment">
                    <div class="last_comment">
                        @if (!empty($iten[$i]['service_value_memo']))
                            <p>{{$iten[$i]['service_value_memo']}}</p>
                        @else
                            <p>なし</p>
                        @endif
                    </div>
                </div><br>

                <div class="syousai_title">
                    <p>{{config('const.matter_info.info29')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @for ($j=1;$j<=20;$j++)
                            @if  (!empty($item[$i]["notice$j"] && $item[$i]["notice$j"]!=="F"))
                                <li>{{$item[$i]["notice$j"]}}</li>
                            @endif
                        @endfor
                        @if (!empty($item[$i]['notice_memo']))
                            <li>{{$item[$i]['notice_memo']}}</li>
                        @endif
                    </ul>
                </div><br>

                <div class="syousai_title">
                    <p>{{config('const.matter_info.info44')}}</p>
                </div>
                <div class="syousai_comment">
                    <div class="last_comment">
                        @if (!empty($item[$i]['notice_other']))
                            <p>{{$item[$i]['notice_other']}}</p>
                        @else
                            <p>なし</p>
                        @endif
                    </div>
                </div>
            </div><br>
            @endfor

            @if ($survey==="T")
                <div class="syousai_area">
                    <p>{{config('const.matter_info.info21')}}</p>
                    @foreach ($item3 as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param3[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if ($value==="F" || empty($value))
                                <p>記入なし</p>
                            @else
                                <div class="last_comment">
                                    <p>{{$value}}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div><br>
            @else
                <p class="msg_center">運営による診断書作成までお待ちください。</p>
            @endif
        </div>
    </body>
    @include('client.component.footer')
</html>
