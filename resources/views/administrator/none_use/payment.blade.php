<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title37')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title37')}}-{{$dates}}</h3>
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
                    <p class="msg_center">案件</p>
                    <div class="right_top_link">
                        <a href="./payment_csv/1/{{$dates}}" target="_blank">{{config('const.matter_info.info51')}}</a>
                    </div>
                    <tr>
                        <th>{{config('const.matter_info.info1')}}</th>
                        <th>{{config('const.matter_info.info7')}}</th>
                        <th>{{config('const.matter_info.info46')}}</th>
                        <th>{{config('const.matter_info.info47')}}</th>
                        <th>{{config('const.matter_info.info48')}}</th>
                        <th>{{config('const.matter_info.info49')}}</th>
                    </tr>

                    @foreach ($item as $value)
                    @if (empty($value->id))
                        <p>今月の請求はありません。</p>
                    @else
                    <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->shop_name}}</td>
                        <td>{{$value->end_date}}</td>
                        <td>{{$value->reward}}</td>
                        <td>{{$value->matter_num_now}}</td>
                        <?php $pay_all = $value->matter_num_now * $value->reward; ?>
                        <td>{{$pay_all}}</td>
                    </tr>
                    @endif
                    @endforeach

                </table><br><hr>

                <table class="table_map">
                    <p class="msg_center">店舗</p>
                    <div class="right_top_link">
                        <a href="./payment_csv/2/{{$dates}}" target="_blank">{{config('const.matter_info.info51')}}</a>
                    </div>
                    <tr>
                        <th>{{config('const.client_info.info1')}}</th>
                        <th>{{config('const.client_info.info8')}}</th>
                        <th>{{config('const.matter_info.info50')}}</th>
                        <th>{{config('const.matter_info.info48')}}</th>
                        <th>{{config('const.matter_info.info49')}}</th>
                    </tr>

                    @foreach ($param_shop as $key=>$value)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$value['shop_name']}}</td>
                        <td>{{$value['matter_num']}}</td>
                        <td>{{$value['member_num']}}</td>
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
