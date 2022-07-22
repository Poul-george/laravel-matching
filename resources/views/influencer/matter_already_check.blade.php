<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title19')}}</title>
    </head>
    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title19')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_influ_2">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">{{config('const.matter_info.info1')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$id}}</p>
                </div>

                    @foreach ($item as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if ($key==="least_folloer")
                                <p>{{$follower[$value]}}</p>
                            @elseif ($key==="post_sns")
                                <p>{{$sns[$value]}}</p>
                            @elseif ($key==="post_deadline")
                                <p>{{$deadline[$value]}}</p>
                            @else
                                <p>{{$value}}</p>
                            @endif
                        </div>
                    @endforeach
            </div>
            <div class="syousai_area">

                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info3')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($item_2 as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$param_2[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
            </div>
            <div class="syousai_area">
                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info4')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($term as $key=>$value)
                                @if ($value==="T")
                                    <li>{{$term_content[$key]}}</li>
                                @elseif ($value!=="" && $value!=="T" && $value!=="F")
                                    <li>{{$value}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
            </div>
            <div class="syousai_area">
                <div class="syousai_title">
                    <p>{{config('const.matter_info.info5')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($notice as $key=>$value)
                            @if ($value==="T")
                                <li>{{$notice_content[$key]}}</li>
                            @elseif ($value!=="" && $value!=="T" && $value!=="F")
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

    </body>
    @include('influencer.component.footer')
</html>
