<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title15')}}</title>
    </head>

    <body>
        @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title15')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="../admin_influ_1">戻る</a></li> --}}
        </div>

        <div class="main_form">
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">ID</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$id}}</p>
                </div>
                <div class="syousai">
                    @foreach ($item as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if ($value==="" || $value==="F")
                                <p>未登録</p>
                            @else
                                <p>{{$value}}</p>
                            @endif
                        </div>
                    @endforeach

                    @foreach ($item_2 as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param_2[$key]}}</p>
                        </div>
                        <div class="syousai_comment">

                            @if  ($value==="F" || $value==="")
                                <p>未登録</p>
                            @else
                                <p><a href="{{$value}}">{{$value}}</a></p>
                            @endif

                        </div>
                    @endforeach

                    @if (isset($user_comment))
                        <div class="syousai_title">
                            <p>{{config('const.influ_info.info2')}}</p>
                        </div>
                        <div class="syousai_comment">
                            <div class="last_comment">
                                <div>{{$user_comment}}</div>
                            </div>
                        </div>
                    @endif
                {{-- </div><br> --}}

                {{-- <div class="syousai_area"> --}}
                    <div class="syousai_title">
                        <p class="msg_center">{{config('const.influ_info.info3')}}</p>
                    </div>
                    <div class="img_area">
                        @foreach ($insite as $key=>$value)
                            @if (!empty($value))
                                <div class="img_box">
                                    <img src="{{ asset("laravel/public/storage/insite/$value") }}" alt="insite">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div><br>

                <div class="submit_bottom_2">
                    <form action="" method="POST">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$id}}">
                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">登録可否を選択してください。</option>
                                <option value="T">採用</option>
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
