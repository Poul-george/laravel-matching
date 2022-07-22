<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title35')}}</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title35')}}</h3>
        </div>


        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif
            <div class="syousai_area">
                <div class="right_top_link">
                    <a href="./user_account_edit">{{config('const.influ_info.info10')}}</a><br>
                    <a href="./user_account_password">パスワードの{{config('const.influ_info.info10')}}</a>
                </div>
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
        </div>

    </body>
    @include('influencer.component.footer')
</html>
