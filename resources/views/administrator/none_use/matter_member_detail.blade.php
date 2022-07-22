<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title22')}}</title>
    </head>

    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title22')}}</h3>
        </div>
        <div class="main_form">
        @if (session('msgs'))
            <p class="msg_center">{{session('msgs')}}</p>
        @endif

        @if (!empty($hurry))
            <p class="msg_center">{{$hurry}}</p>
        @endif

        <div class="syousai_area">

            <div class="syousai_title">
                <p>{{config('const.matter_info.info8')}}</p>
            </div>
            <div class="syousai_comment">
                <p>{{$flag_list[$flag]}}</p>
            </div>
        </div><br>



        {{-- フラグが３の時 --}}
        @if ($flag==="3")
            <div class="syousai_area">
                @if ($come==='T')
                    <p>{{config('const.matter_info.info11')}}</p>

                    @if ($questionaire==="2")
                        <p>{{config('const.matter_info.info12')}}</p>
                        <div class="right_top_link">
                            <a href="../matter_member_questionaire/{{$id}}/{{$questionaire}}">{{config('const.matter_info.info16')}}</a>
                        </div>
                    @elseif ($questionaire==="1")
                        <p>{{config('const.matter_info.info13')}}</p>
                        <div class="right_top_link">
                            <a href="../matter_member_questionaire/{{$id}}/{{$questionaire}}">{{config('const.matter_info.info17')}}</a>
                        </div>
                    @elseif ($questionaire==="0")
                        <p>{{config('const.matter_info.info14')}}</p>
                    @endif
                @else
                    <p>{{config('const.matter_info.info15')}}</p>

                @endif
                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        <p>{{$value}}</p>
                    </div>
                @endforeach
            </div><br>

        @endif

        @if ($flag==="4")
            <div class="syousai_area">
                <p>{{config('const.matter_info.info9')}}</p>
                 @if ($questionaire==="2")
                    <p>{{config('const.matter_info.info12')}}</p>
                    <div class="right_top_link">
                        <a href="../matter_member_questionaire/{{$id}}/{{$questionaire}}">{{config('const.matter_info.info16')}}</a>
                    </div>
                @elseif ($questionaire==="1")
                    <p>{{config('const.matter_info.info13')}}</p>
                    <div class="right_top_link">
                        <a href="../matter_member_questionaire/{{$id}}/{{$questionaire}}">{{config('const.matter_info.info17')}}</a>
                    </div>
                @elseif ($questionaire==="0")
                    <p>{{config('const.matter_info.info14')}}</p>
                @endif
                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if (empty($value))
                            <p>投稿なし</p>
                        @else
                            <p>{{$value}}</p>
                        @endif
                    </div>
                @endforeach
            </div><br>

        @endif

        @if ($flag==="5")
            <div class="syousai_area">
                <p>{{config('const.matter_info.info9')}}</p>
                @if ($questionaire==="2")
                    <div class="right_top_link">
                        <a href="../matter_questionaire/{{$id}}">{{config('const.matter_info.info16')}}</a>
                    </div>
                @endif
                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if (empty($value))
                            <p>投稿なし</p>
                        @else
                            <p>{{$value}}</p>
                        @endif
                    </div>
                @endforeach
            </div><br>

            <div class="syousai_area">
                <p>{{config('const.matter_info.info10')}}</p>
                <div class="img_area">
                    @foreach ($item2 as $key=>$value)
                        @if (!empty($value))
                            <div class="img_box">
                                <img src="{{ asset("laravel/public/storage/matterstate/$value") }}" alt="insite">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    </body>
    @include('administrator.component.footer')
</html>
