<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="{{ secure_asset('/css/tab2.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title21')}}</title>
    </head>
    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title21')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        </div>
        <div class="main_form">

            <div class='tabs'>
                <div class="tab_area">
                    <div class='tab-buttons'>
                        <span id="point" class='content1'>{{config('const.title.title2')}}</span>
                        <span id="" class='content2'>{{config('const.title.title3')}}</span>
                    </div>
                    <div id='lamp' class='content1'></div>
                </div>

                <div class='tab-content'>
                    <div class="content1">

                        <div class="search_all">
                            <a href="javascript:OnLinkClickSearch1();"><div class="search_icon"></div><p class="kensaku">検索</p></a>
                            <div class="search_box" id="search_dropdown1">
                                <form method="GET" action="">
                                    @csrf
                                    <div class="search1">
                                        <div class="search_select_box">
                                            <label class="search_label">返信有無</label>
                                            <select name="state_s" class="search_select">
                                                <option value="">指定なし</option>
                                                @if ($param['state_s']==='0')
                                                    <option value="0" selected>済</option>
                                                    <option value="1">未</option>
                                                @elseif ($param['state_s']==='1')
                                                    <option value="0">済</option>
                                                    <option value="1" selected>未</option>
                                                @else
                                                    <option value="0">済</option>
                                                    <option value="1">未</option>
                                                @endif

                                            </select>
                                        </div>
                                        <div class="search1_div2">
                                            <label class="search_label">名前</label>
                                            <input type="text" class="search_text" name="contact_name_s" placeholder="名前検索" value="{{$param['contact_name_s']}}">
                                        </div>
                                    </div>

                                    <div class="search_button">
                                        <input type="hidden" value="1">
                                        <input type="hidden" name="state_s2" value="{{$param['state_s2']}}">
                                        <input type="hidden" name="contact_name_s2" value="{{$param['contact_name_s2']}}">
                                        <input type="submit" class="search_btn" value="検索">
                                    </div>
                                </form>
                            </div>
                        </div><br>

                        <div class="table_div">
                            <p>{{config('const.table_info.info1')}}</p>
                            <table class="table_map">
                                <tr>
                                    <th>{{config('const.chat_info.info1')}}</th>
                                    <th>{{config('const.chat_info.info3')}}</th>
                                    <th>{{config('const.chat_info.info4')}}</th>
                                    <th>{{config('const.chat_info.info5')}}</th>
                                </tr>
                                @foreach ($item as $value)
                                <tr>
                                    <td><a href="chat_detail/{{$value->id}}">{{$value->id}}</a></td>
                                    <td><a href="chat_detail/{{$value->id}}">{{$value->contact_name}}</a></td>
                                    <td>{{$value->datetimes}}</td>
                                    <td>{{$state[$value->flag]}}</td>
                                </tr>
                                @endforeach
                            </table>
                            <div class="page">
                                {{$item->links('pagination::default')}}
                            </div>
                        </div>
                    </div>

                    <div class="content2">

                        <div class="search_all">
                            <a href="javascript:OnLinkClickSearch2();"><div class="search_icon"></div><p class="kensaku">検索</p></a>
                            <div class="search_box" id="search_dropdown2">
                                <form method="GET" action="">
                                    @csrf
                                    <div class="search1">
                                        <div class="search_select_box">
                                            <label class="search_label">返信有無</label>
                                            <select name="state_s2" class="search_select">
                                                <option value="">指定なし</option>
                                                    @if ($param['state_s2']==='0')
                                                        <option value="0" selected>済</option>
                                                        <option value="1">未</option>
                                                    @elseif ($param['state_s2']==='1')
                                                        <option value="0">済</option>
                                                        <option value="1" selected>未</option>
                                                    @else
                                                        <option value="0">済</option>
                                                        <option value="1">未</option>
                                                    @endif
                                            </select>
                                        </div>
                                        <div class="search1_div2">
                                            <label class="search_label">名前</label>
                                            <input type="hidden" name="state_s" value="{{$param['state_s']}}">
                                            <input type="hidden" name="contact_name_s" value="{{$param['contact_name_s']}}">
                                            <input type="text" class="search_text" name="contact_name_s2" placeholder="名前検索" value="{{$param['contact_name_s2']}}">
                                        </div>
                                    </div>

                                    <div class="search_button">
                                        <input type="hidden" value="2">
                                        <input type="submit" class="search_btn" value="検索">
                                    </div>
                                </form>
                            </div>
                        </div><br>

                        <div class="table_div">
                            <p>{{config('const.table_info.info1')}}</p>
                            <table class="table_map">
                                <tr>
                                    <th>{{config('const.chat_info.info1')}}</th>
                                    <th>{{config('const.chat_info.info3')}}</th>
                                    <th>{{config('const.chat_info.info4')}}</th>
                                    <th>{{config('const.chat_info.info5')}}</th>
                                </tr>
                                @foreach ($item2 as $value)
                                <tr>
                                    <td><a href="chat_detail/{{$value->id}}">{{$value->id}}</a></td>
                                    <td><a href="chat_detail/{{$value->id}}">{{$value->contact_name}}</a></td>
                                    <td>{{$value->datetimes}}</td>
                                    <td>{{$state[$value->flag]}}</td>
                                </tr>
                                @endforeach
                            </table>
                            <div class="page">
                                {{$item->links('pagination::default')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script language="javascript" type="text/javascript">

            function OnLinkClickSearch1(){
                const face = document.getElementById('search_dropdown1');
                face.classList.toggle('search_box');
                face.classList.toggle('search_box_none');
            }
            function OnLinkClickSearch2(){
                const face = document.getElementById('search_dropdown2');
                face.classList.toggle('search_box');
                face.classList.toggle('search_box_none');
            }
        </script>

<script language="javascript" type="text/javascript">
    // $('.tab-content>div').hide();
    // $('.tab-content>div').first().slideDown();
    $('.tab-buttons span').click(function(){
    var thisclass=$(this).attr('class');
    console.log(thisclass);
    localStorage.setItem('current', thisclass);
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

        }
        else{
        $(this).hide();
        }
    });
    });

    window.onload = function() {
        var thisclass = localStorage.getItem('current');
        console.log(thisclass);
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

        }
        else{
        $(this).hide();
        }
    });
        $('#lamp').removeClass().addClass('#lamp').addClass(thisclass);
    };

</script>

    </body>
    @include('administrator.component.footer')
</html>
