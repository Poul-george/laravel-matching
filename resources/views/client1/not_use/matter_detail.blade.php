<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title19')}}</title>
    </head>
    <body>
    @include('client1.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title19')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_{{config('const.title.title48')}}_2">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            <div class="syousai_area2">
                <div class="syousai_area_div2">
                    <div class="syousai_title2">
                        <p class="syousai_title_p2">{{config('const.matter_info.info1')}}</p>
                    </div>
                    <div class="syousai_comment2">
                        <p class="syousai_comment_p2">{{$id}}</p>
                    </div>
                </div>

                @foreach ($item as $key=>$value)
                    <div class="syousai_area_div2">
                        <div class="syousai_title2">
                            <p class="syousai_title_p2">{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment2">
                            @if ($key==="least_follower")
                                <p class="syousai_comment_p2">{{$follower[$value]}}</p>
                            @elseif ($key==="post_deadline")
                                <p class="syousai_comment_p2">{{$deadline[$value]}}</p>
                            @else
                                <p class="syousai_comment_p2">{{$value}}</p>
                            @endif
                        </div>
                    </div>
                @endforeach


            </div>
            <div class="syousai_area2">
                <div class="syousai_area_div2">
                    <div class="syousai_title2">
                        <p class="syousai_title_p2">{{config('const.matter_info.info2')}}</p>
                    </div>
                    <div class="syousai_comment2">
                        <ul class="t_f2">
                            @foreach ($sns as $key=>$value)
                                @if  ($value==="T")
                                    <li class="t_f_li2">{{$sns_list[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="syousai_area2">
                <div class="syousai_area_div2">
                    <div class="syousai_title2">
                        <p>{{config('const.matter_info.info3')}}</p>
                    </div>
                    <div class="syousai_comment2">
                        <ul class="t_f2">
                            @foreach ($item_2 as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$param_2[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div> --}}
            <div class="syousai_area2">
                <div class="syousai_area_div2">
                    <div class="syousai_title2">
                        <p class="syousai_title_p2">{{config('const.matter_info.info4')}}</p>
                    </div>
                    <div class="syousai_comment2">
                        <ul class="t_f2">
                            @foreach ($term as $key=>$value)
                                @if ($value==="T")
                                    <li class="t_f_li2">{{$term_content[$key]}}</li>
                                @elseif ($value!=="" && $value!=="T" && $value!=="F")
                                    <li class="t_f_li2">{{$value}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="syousai_area2">
                <div class="syousai_area_div2">
                    <div class="syousai_title2">
                        <p class="syousai_title_p2">{{config('const.matter_info.info5')}}</p>
                    </div>
                    <div class="syousai_comment2">
                        <ul class="t_f2">
                            @foreach ($notice as $key=>$value)
                                @if ($value==="T")
                                    <li class="t_f_li2">{{$notice_content[$key]}}</li>
                                @elseif ($value!=="" && $value!=="T" && $value!=="F")
                                    <li class="t_f_li2">{{$value}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>


            </div><br>

        </div>

    </body>
    @include('client1.component.footer')
</html>
