<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title19')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title19')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_influ_2">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif
            <div class="syousai_area">
                <div class="right_top_link">
                    <a href="../admin_matter_edit/{{$id}}">{{config('const.title.title39')}}はこちら</a><br>
                </div>
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
                        @if ($key==="least_follower")
                            <p>{{$follower[$value]}}</p>
                        @elseif ($key==="post_sns")
                            <p>{{$sns[$value]}}</p>
                        @elseif ($key==="shop_url")
                            <p><a href="{{$value}}">{{$value}}</a></p>
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
                    <p>{{config('const.matter_info.info56')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($genre as $key=>$value)
                            @if  ($value==="T")
                                <li>{{$matter_genre[$key]}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="syousai_area">

                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info2')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($sns as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$sns_list[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
            </div>
            {{-- <div class="syousai_area">

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
            </div> --}}
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

            <div class="syousai_area">
                <p class="msg_center">{{config('const.matter_info.info58')}}</p>
                <div class="img_area">
                    @foreach ($file_list as $key=>$value)
                        @if (!empty($value))
                            <div class="img_box">
                                <img src="{{ asset("laravel/public/storage/matter_img/$value") }}" alt="insite">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </body>
    @include('administrator.component.footer')
</html>
