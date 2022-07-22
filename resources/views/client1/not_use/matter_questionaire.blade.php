<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title30')}}</title>
    </head>
    <body>
    @include('client1.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title30')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="admin_{{config('const.title.title48')}}">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            <div class="syousai_area">

                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if (empty($value))
                            <p>なし</p>
                        @else
                            <p>{{$value}}</p>
                        @endif
                    </div>
                @endforeach

            </div><br>


            <div class="syousai_area">
                <div class="syousai_title">
                    <p>{{config('const.matter_info.info43')}}</p>
                </div>
                <div class="syousai_comment">
                    <div class="last_comment">
                        @if (!empty($service_value_memo))
                            <div>{{$service_value_memo}}</div>
                        @else
                            <div>なし</div>
                        @endif
                    </div>
                </div>
            </div><br>


            <div class="syousai_area">
                <div class="syousai_title">
                    <p>{{config('const.matter_info.info29')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item2 as $key=>$value)
                            @if  ($value==="F" || empty($value))
                            @else
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                        @if (!empty($notice_memo))
                            <li>{{$notice_memo}}</li>
                        @endif
                    </ul>
                </div>
            </div><br>


            <div class="syousai_area">
                <div class="syousai_title">
                    <p>{{config('const.matter_info.info44')}}</p>
                </div>
                <div class="syousai_comment">
                    <div class="last_comment">
                        @if (!empty($notice_other))
                            <div>{{$notice_other}}</div>
                        @else
                            <div>なし</div>
                        @endif
                    </div>
                </div>
            </div><br>

        </div>

    </body>
    @include('client1.component.footer')
</html>
