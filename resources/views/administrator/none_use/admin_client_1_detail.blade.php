<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link rel="stylesheet" type="text/css" href="style.css">
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title10')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title10')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_{{config('const.title.title47')}}_1">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">{{config('const.client_info.info1')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$id}}</p>
                </div>
                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if ($key==="shop_tanka")
                            <p>{{$tanka[$value]}}</p>
                        @elseif ($key==="shop_gender")
                            <p>{{$gender[$value]}}</p>
                        @elseif ($key==="shop_url")
                            <p><a href="{{$value}}">{{$value}}</a></p>
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

                @if (isset($shop_question))
                    <div class="syousai_title">
                        <p>{{config('const.client_info.info7')}} </p>
                    </div>
                    <div class="syousai_comment">
                        <div class="last_comment">
                            <div>{{$shop_question}}</div>
                        </div>
                    </div>
                @endif
                <div class="submit_bottom_2">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="hidden_id" value="{{$id}}">
                    <div class="select_submit">
                        <select class="select_2separate" name="selector1" required>
                            <option value="">登録可否を選択してください。</option>
                            <option value="T">進行</option>
                            @if ($shop_flag==='0')
                                <option value="N">検討中</option>
                            @endif
                            <option value="F">不採用</option>
                        </select>
                        <input type="submit" class="btn" name="confirm" value="送信">
                    </div>

                </form>
                {{-- <p class="error_msg">選択してから送信してください。</p> --}}
            </div>
            </div>

        </div>

    </body>
    @include('administrator.component.footer')
</html>
