<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title12')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title12')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_client_1">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">

            @if (!isset($item))
                @if (!isset($shop_id))
                    <div class="syousai_area">
                        <div class="syousai_title">
                            <p>まだ本登録が済んでいません。</p>
                        </div>
                    </div>
                @else
                <div class="syousai_area">
                    <div class="syousai_title">
                        <p>検討中です。</p>
                    </div>
                </div>
                <div class="submit_bottom_2">
                    <form action="" method="POST">
                        @csrf
                        <input type="hidden" name="hidden" value="1">
                        <input type="hidden" name="hidden_id" value="{{$shop_id}}">
                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">登録可否を選択してください。</option>
                                <option value="T">進行</option>
                                <option value="F">不採用</option>
                            </select>
                            <input type="submit" class="btn" name="confirm" value="送信">
                        </div>

                    </form>
                </div>
                @endif
            @else
                @if (session('msg'))
                    <p class="msg_center">{{session('msg')}}</p>
                @endif
                <div class="syousai_area">
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
                            <p class="">ジャンル・カテゴリ</p>
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
                            <p class="">客単価</p>
                        </div>
                        <div class="syousai_comment">
                            <p>{{$tanka[$shop_new_tanka]}}</p>
                        </div>

                        <div class="syousai_title">
                            <p class="">ターゲットの年齢</p>
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
                            <p class="">ターゲットの性別</p>
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
                            <p>コンセプト</p>
                        </div>
                        <div class="syousai_comment">
                            <div class="last_comment">
                            @if (!empty($shop_comemnt) && $shop_comment==="F")
                                <div>{{$shop_comment}}</div>
                            @else
                                <div>記述なし</div>
                            @endif
                            </div>
                        </div>

                    </div><br>

                @endif

                <div class="create">
                    <form method="POST" action="">
                        @csrf
                        <div class="form_radio2">
                            <div class="form_group">
                                <label>{{config('const.client_info.info11')}}</label><br>
                                <div class="radio_form2">

                                    @for ($i=0;$i<=2;$i++)
                                        @if ($shop_status==$i)
                                            <input type="radio" name="shop_status" id="status_{{$i}}" value="{{$i}}" checked><label for="status_{{$i}}">{{config("list.shop_status.$i")}}</label>
                                        @else
                                            <input type="radio" name="shop_status" id="status_{{$i}}" value="{{$i}}"><label for="status_{{$i}}">{{config("list.shop_status.$i")}}</label>
                                        @endif
                                    @endfor

                                </div>
                            </div>
                        </div>
                        <div class="create_submit">
                            <input type="hidden" name="hidden_id" value="{{$shop_id}}">
                            <input type="submit" value="更新" class="btn">
                        </div>
                    </form>
                </div>
            @endif

        </div>

    </body>
    @include('administrator.component.footer')
</html>
