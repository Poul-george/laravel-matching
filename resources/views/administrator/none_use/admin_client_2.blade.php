<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title11')}}</title>
    </head>
    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title11')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="admin_client">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>

        @if (session('msg'))
            <p class="msg_center">{{session('msg')}}</p>
        @endif

        <div class="search_all">
            <a href="javascript:OnLinkClickSearch();"><div class="search_icon"></div><p class="kensaku">検索</p></a>
            <div class="search_box" id="search_dropdown">
                <form method="GET" action="">
                    @csrf
                    <div class="search1">
                        <div class="search_select_box">
                            <select name="shop_status_s" class="search_select">
                                <option value="">{{config('const.client_info.info11')}}</option>
                                @foreach ($shop_status as $key=>$value)
                                    @if (isset($param['shop_status_s']) && $param['shop_status_s']==$key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="search_select_box">
                            <select name="shop_address_s" class="search_select">
                                <option value="">店舗住所（都道府県）</option>
                                @foreach ($todouhuken as $value)
                                    @if (isset($param['shop_address_s']) && $param['shop_address_s']===$value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
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

        <?php
            $param_list=[
                'shop_status_s',
                'shop_address_s',
            ];
            foreach ($param_list as $values){
                if (!isset($param[$values])){
                    $param[$values]="<>";
                }
            }


        ?>

        <div class="main_form">
            <form method="post" action="">
                @csrf
                <div class="table_div">
                    <p>{{config('const.table_info.info1')}}</p>
                    <div class="right_top_link">
                        <a href="./client_csv/{{$param['shop_status_s']}}/{{$param['shop_address_s']}}"
                        target="_blank">{{config('const.matter_info.info51')}}</a>
                        <br><br>
                        <a href="./admin_{{config('const.title.title47')}}_template">{{config('const.title.title42')}}</a>
                    </div>
                    <label>
                        <input type="checkbox" name="all" id="check_all" onClick="AllChecked();" />全て選択
                    </label>
                    <table class="table_map">
                        <tr>
                            <th></th>
                            <th>{{config('const.client_info.info1')}}</th>
                            <th>{{config('const.client_info.info8')}}</th>
                            <th>{{config('const.client_info.info10')}}</th>
                            <th>{{config('const.client_info.info11')}}</th>
                        </tr>
                        <?php $i=0; ?>
                        @foreach ($item as $value)
                        <tr>
                        <td width="20"><input type="checkbox" name="check[]" value="{{$value->shop_id}}"></td>
                            <td><a href="admin_{{config('const.title.title47')}}_2_detail/{{$value->shop_id}}">{{$value->shop_id}}</a></td>
                            <td><a href="admin_{{config('const.title.title47')}}_2_detail/{{$value->shop_id}}">{{$value->shop_name}}</a></td>
                            @if (empty($value->shop_touroku))
                                <td>未登録</td>
                            @else
                                <td>{{$value->shop_touroku}}</td>
                            @endif
                            <td>{{config("list.shop_status.$value->shop_status")}}</td>
                        </tr>
                        <?php $i+=1; ?>
                        @endforeach
                    </table>
                    <div class="page">
                        {{$item->links('pagination::default')}}
                    </div>
                </div><br>

                <div class="chat_area">
                    <div class="template_link">
                        <?php $i=1; ?>
                        @foreach ($template_list as $value)
                            <a tabindex="-1" onclick="OnLinkClickTemplate(this)" id="{{$i}}"><small>テンプレート{{$i}}</small></a><br>
                            <div style="display: none;" id="template{{$i}}">{{$value}}</div>
                            <?php $i+=1; ?>
                        @endforeach
                    </div>
                    <div class="form_group">
                        <label>タイトル</label>
                        <input type="text" name="subject" required>
                    </div>
                    <div class="form_group">
                        <label>本文</label>
                        <textarea name="comment" class="chat_textarea" id="mail_text" required></textarea>
                    </div>
                    <div class="chat_submit">
                        <input type="submit" class="chat_btn" value="送信">
                    </div>
                </div>
            </form>
        </div><br><br>

        <div class="main_form">
            <div class="mail_history">
                <p class="mail_history_title">{{config('const.title.title44')}}</p>
                <div class="mail_history_click">
                    <a href="javascript:OnLinkClickMailHistory();">全て閲覧</a>
                </div>
                <div class="mail_history1">
                    @for ($i=0;$i<=9;$i++)
                        @if (!empty($subject_list[$i]))
                            <div class="mail_history_subject">
                                <p>～{{$subject_list[$i]}}～</p>
                            </div>
                            <div class="main_history_date">
                                <p>{{$date_list[$i]}}</p>
                            </div>
                            <div class="mail_history_to">
                                <p>送信先</p>
                                <ul>
                                    @foreach ($id_list[$i] as $value)
                                        @if (!empty($value) && $value!=="")
                                            <li>{{$value}}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mail_history_comment">
                                <div class="last_comment">
                                    <div>{{$comment_list[$i]}}</div>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>

                <div class="mail_history1 mail_history_none" id="history_dropdown">
                    <?php $last_count=count($subject_list); ?>
                    @if ($last_count>9)
                        @for ($i=10;$i<=$last_count;$i++)
                            @if (!empty($subject_list[$i]))
                                <div class="mail_history_subject">
                                    <p>～{{$subject_list[$i]}}～</p>
                                </div>
                                <div class="mail_history_to">
                                    <p>送信先</p>
                                    <ul>
                                        @foreach ($id_list[$i] as $value)
                                            @if (!empty($value))
                                                <li>{{$value}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="mail_history_comment">
                                    <div class="last_comment">
                                        <div>{{$comment_list[$i]}}</div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    @endif
                </div>
            </div>
        </div>

        <script language="javascript" type="text/javascript">
            function OnLinkClickSearch(){
                const face = document.getElementById('search_dropdown');
                face.classList.toggle('search_box');
                face.classList.toggle('search_box_none');
            }

            function OnLinkClickMailHistory(){
                const face = document.getElementById('history_dropdown');
                face.classList.toggle('mail_history_none');
            }

            function OnLinkClickTemplate(num){
                var ids='template'+num.id;
                var UserString = document.getElementById(ids).textContent;
                document.getElementById('mail_text').value += UserString + "\n";
            }

            function AllChecked(){
                const checkbox_all = document.getElementById("check_all");
                const checkbox1 = document.getElementsByName("check[]");
                for(i = 0; i < checkbox1.length; i++) {
                    if(checkbox_all.checked==true){
                        checkbox1[i].checked = true;
                    }else{
                        checkbox1[i].checked = false;
                    }
                }
            }
        </script>

    </body>
    @include('administrator.component.footer')
</html>
