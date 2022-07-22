<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title17')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title17')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_influ_2">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msg'))
                <p class="msg_center">{{session('msg')}}</p>
            @endif
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">{{config('const.influ_info.info4')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$user_id}}</p>
                </div>

                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if ($key==="user_instagram_url" || $key==="user_taberogu" || $key==="user_google")
                            @if ($value==="F" || $value==="")
                                <p>登録なし</p>
                            @else
                                <p><a href="{{$value}}">{{$value}}</a></p>
                            @endif
                        @else
                            @if ($value==="T" || $value==="F")
                                <p>{{$arinashi[$value]}}</p>
                            @elseif ($value==="A" || $value==="B" || $value==="C" || $value==="D")
                                <p>{{$follower[$value]}}</p>
                            @else
                                <p>{{$value}}</p>
                            @endif
                        @endif
                    </div>
                @endforeach
                    <div class="syousai_title">
                        <p>{{config('const.influ_info.info8')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($sns_name as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{$param2[$key]}}</li>
                                @elseif ($value!=="T" && $value!=="F")
                                    <li>{{$value}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="syousai_title">
                        <p>{{config('const.influ_info.info9')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($item2 as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{config("list.user_genre.$key")}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="syousai_title">
                        <p>{{config('const.influ_info.info13')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <ul class="t_f">
                            @foreach ($item3 as $key=>$value)
                                @if  ($value==="T")
                                    <li>{{config("list.todouhuken.$key")}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

            </div><br>

            <div class="syousai_area">
                <p class="msg_center">{{config('const.influ_info.info3')}}</p>
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

            <div class="create">
                <form method="POST" action="">
                    @csrf
                    <div class="form_radio2">

                        <div class="form_group">
                            <label>{{config('const.influ_info.info14')}}</label><br>
                            <div class="radio_form2">
                                @foreach ($user_status_list as $key=>$value)

                                    @if ($value===$user_status)
                                        <input type="radio" name="user_status" id="{{$key}}_t" value="{{$value}}" checked><label for="{{$key}}_t">{{config("list.user_status.$value")}}</label>
                                    @else
                                        <input type="radio" name="user_status" id="{{$key}}_f" value="{{$value}}"><label for="{{$key}}_f">{{config("list.user_status.$value")}}</label>
                                    @endif
                                @endforeach

                            </div>
                        </div>

                    </div>

                    <div class="form_radio2">
                        @foreach ($status_magazine as $key=>$value)
                            <div class="form_group">
                                <label>{{$status_magazine_name[$key]}}</label><br>
                                <div class="radio_form2">

                                    @if ($value==="T")
                                        <input type="radio" name="{{$key}}" id="{{$key}}_t" value="T" checked><label for="{{$key}}_t">{{config("list.$key.T")}}</label>
                                        <input type="radio" name="{{$key}}" id="{{$key}}_f" value="F"><label for="{{$key}}_f">{{config("list.$key.F")}}</label>
                                    @else
                                        <input type="radio" name="{{$key}}" id="{{$key}}_t" value="T"><label for="{{$key}}_t">{{config("list.$key.T")}}</label>
                                        <input type="radio" name="{{$key}}" id="{{$key}}_f" value="F" checked><label for="{{$key}}_f">{{config("list.$key.F")}}</label>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="create_submit">
                        <input type="hidden" name="hidden_id" value="{{$user_id}}">
                        <input type="submit" value="更新" class="btn">
                    </div>
                </form>
            </div>

        </div>

    </body>
    @include('administrator.component.footer')
</html>
