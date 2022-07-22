<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title16')}}</title>
    </head>
    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title16')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="admin_influ">戻る</a></li> --}}
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
                        <div class="search1_div2">
                            <input type="text" class="search_text" name="user_name_s" placeholder="名前検索" value="{{$param['user_name_s']}}">
                        </div>
                        <div class="search_select_box">
                            <select name="user_address_s" class="search_select">
                                <option value="">住所（都道府県）</option>
                                @foreach ($todouhuken as $value)
                                    @if (isset($param['user_address_s']) && $param['user_address_s']===$value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="search2">
                        <div class="search_number">
                            <label class="search_label">フォロワー数</label>
                            <div class="search_between">
                                <input type="number" class="search_text" name="user_instagram_num1_s" placeholder="" value="{{$param['user_instagram_num1_s']}}">
                                <label class="between_label">～</label>
                                <input type="number" class="search_text" name="user_instagram_num2_s" placeholder="" value="{{$param['user_instagram_num2_s']}}">
                            </div>
                        </div>
                    </div><br>
                    <div class="search3">
                        <label class="search_label">主な活動エリア</label>
                        <div class="search_checkbox">
                            @foreach ($todouhuken as $key=>$value)
                                @if (isset($checkbox1) && in_array($key,$checkbox1))
                                    <div><input type="checkbox" name="checkbox1[]" id="{{$key}}" value="{{$key}}" checked><label for="{{$key}}">{{$value}}</label></div>
                                @else
                                    <div><input type="checkbox" name="checkbox1[]" id="{{$key}}" value="{{$key}}"><label for="{{$key}}">{{$value}}</label></div>
                                @endif
                            @endforeach
                        </div>
                    </div><br>

                    <div class="search3">
                        <label class="search_label">得意なジャンル</label>
                        <div class="search_checkbox">
                            @foreach ($user_genre as $key=>$value)
                                @if (isset($checkbox2) && in_array($key,$checkbox2))
                                    <div><input type="checkbox" name="checkbox2[]" id="{{$key}}" value="{{$key}}" checked><label for="{{$key}}">{{$value}}</label></div>
                                @else
                                    <div><input type="checkbox" name="checkbox2[]" id="{{$key}}" value="{{$key}}"><label for="{{$key}}">{{$value}}</label></div>
                                @endif
                            @endforeach
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
                'user_name_s',
                'user_address_s',
                'user_instagram_num1_s',
                'user_instagram_num2_s',
            ];
            foreach ($param_list as $values){
                if (empty($param[$values])){
                    $param[$values]="<>";
                }
            }

            if (empty($checkbox1)){
                $checkbox1="<>";
            }else{
                $checkbox1=http_build_query($checkbox1);
            }
            if (empty($checkbox2)){
                $checkbox2="<>";
            }else{
                $checkbox2=http_build_query($checkbox2);
            }

        ?>

        <div class="main_form">
            <form method="POST" action="">
                @csrf
                <div class="table_div">
                    <p>{{config('const.table_info.info1')}}</p>
                    <div class="right_top_link">
                        <a href="./influ_csv/{{$param['user_name_s']}}/{{$param['user_address_s']}}/{{$param['user_instagram_num1_s']}}/{{$param['user_instagram_num2_s']}}/{{$checkbox1}}/{{$checkbox2}}"
                        target="_blank">{{config('const.matter_info.info51')}}</a>
                        <br><br>
                        <a href="./admin_{{config('const.title.title48')}}_template">{{config('const.title.title42')}}</a>
                    </div>
                    <label>
                        <input type="checkbox" name="all" id="check_all" onClick="AllChecked();" />全て選択
                    </label>
                    <table class="table_map">
                        <tr>
                            <th></th>
                            <th>{{config('const.influ_info.info4')}}</th>
                            <th>{{config('const.influ_info.info5')}}</th>
                            <th>{{config('const.influ_info.info7')}}</th>
                            <th>{{config('const.influ_info.info12')}}</th>
                            <th>{{config('const.influ_info.info14')}}</th>
                        </tr>
                        <?php $i=0; ?>
                        @foreach ($item as $value)
                        <tr>
                            <td width="20"><input type="checkbox" name="check[]" id="check1" value="{{$value->user_id}}"></td>
                            <td><a href="admin_{{config('const.title.title48')}}_2_detail/{{$value->user_id}}">{{$value->user_id}}</a></td>
                            <td><a href="admin_{{config('const.title.title48')}}_2_detail/{{$value->user_id}}">{{$value->user_name}}</a></td>
                            <td>{{$value->user_touroku}}</td>
                            <td>{{$value->user_instagram_num}}</td>
                            <td>{{config("list.user_status.$value->user_status")}}</td>
                        </tr>
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
