<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title4')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title4')}}</h3>
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
                                <input type="text" class="search_text" name="matter_id_s" placeholder="ID検索" value="{{$param['matter_id_s']}}">
                            </div>
                            <div class="search1_div2">
                                <input type="text" class="search_text" name="shop_name_s" placeholder="店舗名検索" value="{{$param['shop_name_s']}}">
                            </div>
                        </div>
                        <div class="search2">

                            <div class="search_select_box">
                                <label class="search_label">ステータス</label>
                                <select name="flag_s" class="search_select">
                                    <option value="">指定なし</option>
                                    @foreach ($flag_list as $key=>$value)
                                        @if ($param['flag_s']==$key)
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

            <div class="table_div">
                @if (session('msg'))
                    <p class="msg_center">{{session('msg')}}</p><br>
                @endif
                <div class="right_top_link">
                    <a href="./create_matter">{{config('const.title.title28')}}はこちら</a><br>
                </div>
                <table class="table_map">
                    <tr>
                        <th>{{config('const.matter_info.info1')}}</th>
                        <th>{{config('const.matter_info.info7')}}</th>
                        <th>{{config('const.matter_info.info48')}}</th>
                        <th>{{config('const.matter_info.info26')}}</th>
                        <th>{{config('const.matter_info.info27')}}</th>
                        <th>{{config('const.matter_info.info19')}}</th>
                        <th></th>
                        <th></th>
                    </tr>

                    @foreach ($item as $value)
                    @if (empty($value->id))
                        <p>現在、案件はありません。</p>
                    @else
                    <tr>
                        <td><a href="matter_member/{{$value->id}}/{{$value->flag}}">{{$value->id}}</a></td>
                        <td><a href="matter_member/{{$value->id}}/{{$value->flag}}">{{$value->shop_name}}</a></td>
                        <td><a href="matter_member/{{$value->id}}/{{$value->flag}}">{{$value->matter_name}}</a></td>
                        <td>{{$value->gather_before}}</td>
                        <td>{{$value->gather_after}}</td>
                        <td>{{$flag_list[$value->flag]}}</td>
                        <td><a href="admin_matter_detail/{{$value->id}}">案件詳細</a></td>
                        <td><a href="admin_{{config('const.title.title47')}}_2_detail/{{$value->shop_id}}">店舗詳細</a></td>
                    </tr>
                    @endif
                    @endforeach

                </table>
                <div class="page">
                    {{$item->links('pagination::default')}}
                </div>
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
