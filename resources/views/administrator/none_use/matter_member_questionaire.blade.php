<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title30')}}</title>
    </head>
    <body>
    @include('administrator.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title30')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="admin_influ">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif
            <div class="syousai_area">

                @if ($questionaire==="1")
                    <p class="msg_center">未チェックです。</p>
                @elseif ($questionaire==="2")
                    <p class="msg_center">チェック済みです。</p>
                @endif

                @foreach ($item as $key=>$value)
                    <div class="syousai_title">
                        <p>{{$param[$key]}}</p>
                    </div>
                    <div class="syousai_comment">
                        @if (empty($value))
                            <p>なし</p>
                        @else
                            <p>{{$value}}</p>
                        @endif
                    </div>
                @endforeach

            </div><br>


                <div class="syousai_area">
                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info43')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <div class="last_comment">
                            @if (!empty($service_value_memo))
                                <div>{{$service_value_memo}}</div>
                            @else
                                <div>なし</div>
                            @endif
                        </div>
                    </div>
                </div><br>


            <div class="syousai_area">
                <div class="syousai_title">
                    <p>{{config('const.matter_info.info29')}}</p>
                </div>
                <div class="syousai_comment">
                    <ul class="t_f">
                        @foreach ($item2 as $key=>$value)
                            @if  ($value==="F" || empty($value))
                            @else
                                <li>{{$value}}</li>
                            @endif
                        @endforeach
                        @if (!empty($notice_memo))
                            <li>{{$notice_memo}}</li>
                        @endif
                    </ul>
                </div>
            </div><br>


                <div class="syousai_area">
                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info44')}}</p>
                    </div>
                    <div class="syousai_comment">
                        <div class="last_comment">
                            @if (!empty($notice_other))
                                <div>{{$notice_other}}</div>
                            @else
                                <div>なし</div>
                            @endif
                        </div>
                    </div>
                </div><br>


            @if ($questionaire==="1")
                <div class="create">
                    <p> チェックフォーム</p>
                    <form method="POST" action="">
                        @csrf
                        @foreach ($item as $key=>$value)
                            <div class="form_group">
                                <label>{{$param[$key]}}</label>
                                <input type="text" name="question[]" class="form1" value="{{$value}}">
                            </div>
                        @endforeach

                        <div class="form_group">
                            <label>{{config('const.matter_info.info43')}}</label><br>
                            <textarea class="form_textarea" name="service_value_memo">{{$service_value_memo}}</textarea>
                        </div>

                        <div class="form_group">
                            <label>{{config('const.matter_info.info29')}}</label>
                            <div class="form_checkbox">

                                <?php $i=1; ?>
                                @foreach ($item2 as $key=>$value)
                                    @if (!empty($value) && $value!=="F")
                                        <li><input type="checkbox" name="notice[]" value="{{$value}}" id="{{$i}}" checked><label for="{{$i}}">{{$value}}</label></li>
                                        <?php $i+=1; ?>
                                    @endif
                                @endforeach
                                @if (!empty($notice_memo) && $notice_memo!=="F")
                                    <input type="checkbox" name="notice_memo" value="{{$notice_memo}}" id="notice_memo" checked><label for="notice_memo">{{$notice_memo}}</label>
                                @endif
                            </div>
                        </div>

                        <div class="form_group">
                            <label>{{config('const.matter_info.info44')}}</label><br>
                            <textarea class="form_textarea" name="notice_other">{{$notice_other}}</textarea>
                        </div>



                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">いずれかを選択してください。</option>
                                <option value="1">そのまま登録</option>
                                <option value="2">変更して登録</option>
                            </select>
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="2">
                            <input type="submit" class="btn" name="confirm" value="登録">
                        </div>
                    </form>
                </div><br>
            @endif

        </div>

    </body>
    @include('client1.component.footer')
</html>
