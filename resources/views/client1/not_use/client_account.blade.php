<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title35')}}</title>
    </head>
    <body>
    @include('client1.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title35')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_{{config('const.title.title47')}}_1">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif
            <div class="syousai_area">
                <div class="right_top_link">
                    <a href="./{{config('const.title.title47')}}_account_edit">{{config('const.influ_info.info10')}}</a><br>
                    <a href="./{{config('const.title.title47')}}_account_password">パスワードの{{config('const.influ_info.info10')}}</a>
                </div>
                <div class="syousai_title">
                    <p class="">{{config('const.client_info.info1')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$shop_id}}</p>
                </div>
                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if ($key==="shop_tanka")
                            <p>{{$tanka[$value]}}</p>
                        @elseif ($key==="shop_url")
                            <p><a href="{{$value}}">{{$value}}</a></p>
                        @elseif ($key==="shop_gender")
                            <p>{{$gender[$value]}}</p>
                        @elseif ($key==="shop_single_space")
                            <p>{{$arinashi[$value]}}</p>
                        @elseif ($key==="shop_child" || $key==="shop_pet")
                            <p>{{$able[$value]}}</p>
                        @else
                            <p>{{$value}}</p>
                        @endif
                    </div>
                @endforeach

                <div class="syousai_title">
                    <p>{{config('const.client_info.info2')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item_2 as $key=>$value)
                            @if  ($value==="T")
                                <li>{{$param_2[$key]}}</li>
                            @elseif ($key==="other")
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="syousai_title">
                    <p>{{config('const.client_info.info3')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item_3 as $key=>$value)
                            @if  ($value==="T")
                                <li>{{$param_3[$key]}}</li>
                            @elseif ($key==="other")
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="syousai_title">
                    <p>{{config('const.client_info.info4')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item_4 as $key=>$value)
                            @if  ($value==="T")
                                <li>{{$param_4[$key]}}</li>
                            @elseif ($key==="other")
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="syousai_title">
                    <p>{{config('const.client_info.info5')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item_5 as $key=>$value)
                            @if  ($value==="T")
                                <li>{{$param_5[$key]}}</li>
                            @elseif ($key==="other")
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="syousai_title">
                    <p>{{config('const.client_info.info6')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item_6 as $key=>$value)
                            @if  ($value==="T")
                                <li>{{$param_6[$key]}}</li>
                            @elseif ($key==="other")
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

            </div><br>

            @if ($shop_new==="T")
                <div class="syousai_area">
                    <p>新規オープン</p>
                    <div class="syousai_title">
                        <p class="">{{config('const.client_info.info12')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($item_new as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$param_new[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="syousai_title">
                        <p class="">{{config('const.client_info.info13')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <p>{{$tanka[$shop_new_tanka]}}</p>
                    </div>

                    <div class="syousai_title">
                        <p class="">{{config('const.client_info.info14')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($item_new3 as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$param_new3[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="syousai_title">
                        <p class="">{{config('const.client_info.info15')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($item_new2 as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$param_new2[$key]}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>


                    <div class="syousai_title">
                        <p>{{config('const.client_info.info16')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <div class="last_comment">
                        @if (!empty($shop_comment) && $shop_comment!=="F")
                            <div>{{$shop_comment}}</div>
                        @else
                            <div>記述なし</div>
                        @endif
                        </div>
                    </div>

                </div>
            @endif

        </div>

    </body>
    <!-- @include('client1.component.footer') -->
</html>
