<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/tab4.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/tab4.css') }}" rel="stylesheet">
        <title>{{config('const.title.title24')}}</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title24')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p><br>
            @endif

            <div class='tabs'>
                <div class="tab_area">
                    <div class='tab-buttons'>
                        <span id="point" class='content1'>{{config('const.matter_info.info52')}}</span>
                        <span id="" class='content2'>{{config('const.matter_info.info53')}}</span>
                        <span id="" class='content3'>{{config('const.matter_info.info54')}}</span>
                        <span id="" class='content4'>{{config('const.matter_info.info55')}}</span>
                    </div>
                    <div id='lamp' class='content1'></div>
                </div>

                <div class='tab-content'>
                    <div class="content1">
                        @if (session('search_count'))
                            <p class="msg_center">{{session('search_count')}}件見つかりました。</p><br>
                        @endif

                        <div class="search_all">
                            <a href="javascript:OnLinkClickSearch();"><div class="search_icon"></div><p class="kensaku">検索</p></a>
                            <div class="search_box" id="search_dropdown">
                                <form method="GET" action="">
                                    @csrf
                                    <div class="search1">
                                        <div class="search1_div1">
                                            <input type="text" class="search_text" name="shop_name" placeholder="店名検索" value="{{$param['shop_name_s']}}">
                                        </div>
                                        <div class="search_select_box">
                                            <select name="shop_address_s" class="search_select">
                                                <option value="">都道府県</option>
                                                @for ($i=1;$i<=47;$i++)
                                                    @if ($param["shop_address_s"]===$todouhukien_list["todouhuken$i"])
                                                        <option value="{{config("list.todouhuken.todouhuken$i")}}" selected>{{config("list.todouhuken.todouhuken$i")}}</option>
                                                    @else
                                                        <option value="{{config("list.todouhuken.todouhuken$i")}}">{{config("list.todouhuken.todouhuken$i")}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="search2">
                                        <div class="search_date">
                                            <label class="search_label">応募期限</label>
                                            <input type="date" class="" name="oubo" value="{{$param['oubo_s']}}">
                                        </div>
                                        <div class="search_select_box">
                                            <label class="search_label">最低フォロワー数</label>
                                            <select name="follower" class="search_select">
                                                @foreach ($follower as $key=>$value)
                                                    @if ($key===$param['follower_s'])
                                                        <option value="{{$key}}" selected>{{$value}}</option>
                                                    @else
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="search_button">
                                        <input type="submit" class="search_btn" value="検索">
                                    </div>
                                </form>
                            </div>
                        </div><br>

                        <div class="itiran_all">
                            @foreach ($item as $value)

                                <div class="itiran_once">
                                    <a href="matter_detail/{{$value->id}}">
                                        <div class="itiran_box">
                                            <div class="itiran_left">
                                                <div class="itiran_title">
                                                    <img class="itiran_img" src="{{ asset("laravel/public/storage/matter_img/$value->matter_img1")}}" >
                                                    <p>{{$value->shop_name}}</p>
                                                </div>
                                                <div class="itiran_location">
                                                    <div class="location_icon"></div><p>{{$value->shop_address}}</p>
                                                </div>
                                                <div class="itiran_follower">
                                                    <div class="follower_icon"></div><p>{{$follower[$value->least_follower]}}</p>
                                                </div>
                                                <div class="itiran_period">
                                                    <div class="period_icon"></div><p>～{{$value->gather_after}}</p>
                                                </div>
                                                <div class="itiran_genre">
                                                    @for ($i=1;$i<=10;$i++)
                                                        @if ($value->{"matter_genre$i"}==="T")
                                                            <p class="genre_p">{{$matter_genre_name["matter_genre$i"]}}</p>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="itiran_right">
                                                <div class="itiran_right_box">
                                                    <div class="itiran_right_profile">
                                                        <div class="profile icon a"></div>
                                                        <div class="profile icon b"></div>
                                                    </div>
                                                    <div class="nokori_title">
                                                        <p>予約状況</p>
                                                    </div>
                                                    <div class="nokori_content">
                                                        <p>{{$value->matter_num_now}}&nbsp;/&nbsp;{{$value->matter_num}}</p>
                                                    </div>
                                                    <div class="nokori_people">
                                                        <?php $matter_nokori=$value->matter_num - $value->matter_num_now; ?>
                                                        <p class="">残り<label>{{$matter_nokori}}</label>枠</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="page">
                            {{$item->appends(request()->query())->links('pagination::default')}}
                        </div>
                    </div>

                    <div class="content2">

                        <div class="itiran_all">
                            @foreach ($item2 as $value)

                                <div class="itiran_once">
                                    <a href="matter_detail/{{$value->id}}">
                                        <div class="itiran_box">
                                            <div class="itiran_left">
                                                <div class="itiran_title">
                                                    <p>{{$value->shop_name}}</p>
                                                </div>
                                                <div class="itiran_location">
                                                    <div class="location_icon"></div><div><p>{{$value->shop_address}}</p></div>
                                                </div>
                                                <div class="itiran_follower">
                                                    <div class="follower_icon"></div><div><p>{{$follower[$value->least_follower]}}</p></div>
                                                </div>
                                            </div>
                                            <div class="itiran_right">
                                                <div class="itiran_right_box">
                                                    <div class="nokori_title">
                                                        <p>進行状況</p>
                                                    </div>

                                                    <div class="nokori_people">
                                                        <p class=""><label>{{$flag_list[$matter_flag_list[$value->id]]}}</label></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="content3">
                        <div class="yoyaku_all">
                            @foreach ($item3 as $key=>$value)
                                <a href="../influencer/chat_matter/{{$value->id}}">
                                    <div class="yoyaku_box">
                                        <div class="yoyaku_title">{{$value->shop_name}}</div>
                                        <div class="yoyaku_msg">
                                            @if (isset($f_list[$value->id]))
                                                {{$f_list[$value->id]}}
                                            @endif
                                        </div>
                                        @if (empty($value->date_result))
                                            <div class="yoyaku_div">来店日時：--&nbsp;--</div>
                                            <div class="yoyaku_div">予約名・人数：--</div>
                                        @else
                                            <div class="yoyaku_div">来店日時：{{$value->date_result}}&nbsp;{{$time_list[$value->id]}}</div>
                                            <div class="yoyaku_div">予約名・人数：{{$value->reserve_name}}&nbsp;&nbsp;{{$value->member_result}}名</div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="content4">
                        <div class="yoyaku_all">
                            @foreach ($item4 as $key=>$value)
                                <a href="../influencer/matter_format/{{$value->id}}">
                                    <div class="yoyaku_box">
                                        <div class="yoyaku_title">{{$value->shop_name}}</div>
                                        <div class="yoyaku_msg">
                                            @if (isset($f_list[$value->id]))
                                                {{$f_list[$value->id]}}
                                            @endif
                                        </div>
                                        <div class="yoyaku_div">{{config('const.matter_info.info9')}}期限：{{$value->post_deadline1}}</div>
                                        <div class="yoyaku_div">{{config('const.matter_info.info10')}}期限：{{$value->post_deadline2}}</div><br>
                                        @if ($value->questionaire==="0")
                                            <div class="yoyaku_div">{{config('const.matter_info.info20')}}：未完了</div>
                                        @else
                                            <div class="yoyaku_div">{{config('const.matter_info.info20')}}：完了</div>
                                        @endif
                                        @if ($value->flag==="4")
                                            <div class="yoyaku_div">{{config('const.matter_info.info9')}}：完了</div>
                                            <div class="yoyaku_div">{{config('const.matter_info.info10')}}：未完了</div>
                                        @elseif ($value->flag==="3")
                                        <div class="yoyaku_div">{{config('const.matter_info.info9')}}：未完了</div>
                                        <div class="yoyaku_div">{{config('const.matter_info.info10')}}：未完了</div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <script language="javascript" type="text/javascript">
            function OnLinkClickSearch(){
                const face = document.getElementById('search_dropdown');
                face.classList.toggle('search_box');
                face.classList.toggle('search_box_none');
            }
    </script>

    {{-- <!-- タブメニュー --> --}}
    <script language="javascript" type="text/javascript">
        $('.tab-content>div').hide();
        $('.tab-content>div').first().slideDown();
        $('.tab-buttons span').click(function(){
        var thisclass=$(this).attr('class');
        console.log(thisclass);
        $('#lamp').removeClass().addClass('#lamp').addClass(thisclass);
        $('.tab-content>div').each(function(){
            if($(this).hasClass(thisclass)){
            $(this).fadeIn(800);
            if (thisclass == "content1") {
                var id =  $('.tab-buttons>span').removeAttr('id');
                var conte = $('.tab-buttons>.content1').attr('id', 'point');
            }
            if (thisclass == "content2") {
                var id =  $('.tab-buttons>span').removeAttr('id');
                var conte = $('.tab-buttons>.content2').attr('id', 'point');
            }
            if (thisclass == "content3") {
                var id =  $('.tab-buttons>span').removeAttr('id');
                var conte = $('.tab-buttons>.content3').attr('id', 'point');
            }
            if (thisclass == "content4") {
                var id =  $('.tab-buttons>span').removeAttr('id');
                var conte = $('.tab-buttons>.content4').attr('id', 'point');
            }


            }
            else{
            $(this).hide();
            }
        });
        });

    </script>
    @include('influencer.component.footer')
</html>
