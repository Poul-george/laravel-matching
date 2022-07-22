<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title41')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title41')}}-{{$dates}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        </div>
        <div class="main_form">
            <div class="search_all">
                <a href="javascript:OnLinkClickSearch();"><div class="search_icon"></div><p class="kensaku">検索</p></a>
                <div class="search_box" id="search_dropdown">
                    <form method="GET" action="">
                        @csrf
                        <div class="search1">
                            <div class="search1_div1">
                                <label class="search_label">請求月</label>
                                <input type="month" class="search_text" name="dates" value="{{$dates}}">
                            </div>
                        </div><br>

                        <div class="search_button">
                            <input type="submit" class="search_btn" value="検索">
                        </div>
                    </form>
                </div>
            </div><br>
            <div class="table_div">
                @if (session('msg'))
                    <p class="msg_center">{{session('msg')}}</p><br>
                @endif

                <table class="table_map">
                    <div class="right_top_link">
                        <a href="./payment_csv/3/{{$dates}}" target="_blank">{{config('const.matter_info.info51')}}</a>
                    </div>
                    <tr>
                        <th>{{config('const.influ_info.info4')}}</th>
                        <th>{{config('const.influ_info.info5')}}</th>
                        <th>{{config('const.matter_info.info50')}}</th>
                        <th>{{config('const.matter_info.info49')}}</th>
                    </tr>

                    @foreach ($param_influ as $key=>$value)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$value['influ_name']}}</td>
                        <td>{{$value['matter_num']}}</td>
                        <td>{{$value['pay_all']}}</td>
                    </tr>
                    @endforeach

                </table>

            </div>

        </div>

        <script language="javascript" type="text/javascript">
            function OnLinkClickSearch(){
                const face = document.getElementById('search_dropdown');
                face.classList.toggle('search_box');
                face.classList.toggle('search_box_none');
            }
        </script>

    </body>
    @include('administrator.component.footer')
</html>
