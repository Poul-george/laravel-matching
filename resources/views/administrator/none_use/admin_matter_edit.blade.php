<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title39')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title39')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_influ_2">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>

        <div class="main_form">
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">{{config('const.matter_info.info1')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$id}}</p>
                </div>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="create">

                    @csrf
                    @foreach ($item as $key=>$value)

                        @if ($key==="least_follower")
                            <div class="form_radio">
                                <div class="form_group">
                                    <label>{{$param[$key]}}</label>
                                    <div class="radio_form2">
                                        @foreach ($follower as $key2=>$value2)
                                            @if ($key2===$value)
                                                <div><input type="radio" name="{{$key}}" id="{{$key2}}" value="{{$key2}}" checked><label for="{{$key2}}">{{$value2}}</label></div>
                                            @else
                                                <div><input type="radio" name="{{$key}}" id="{{$key2}}" value="{{$key2}}"><label for="{{$key2}}">{{$value2}}</label></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif ($key==="post_deadline")
                            <div class="form_radio">
                                <div class="form_group">
                                    <label>{{$param[$key]}}</label>
                                    <div class="radio_form2">
                                        @foreach ($deadline as $key2=>$value2)
                                            @if ($key2===$value)
                                                <div><input type="radio" name="{{$key}}" id="{{$key2}}d" value="{{$key2}}" checked><label for="{{$key2}}d">{{$value2}}</label></div>
                                            @else
                                                <div><input type="radio" name="{{$key}}" id="{{$key2}}d" value="{{$key2}}"><label for="{{$key2}}d">{{$value2}}</label></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif ($key==="reward" || $key==="matter_num")
                            <div class="form_group">
                                <label>{{$param[$key]}}</label>
                                <input type="number" name="{{$key}}" value="{{$value}}">
                            </div>
                        @elseif ($key==="gather_before" || $key==="gather_after" || $key==="able_date1" || $key==="able_date2" || $key==="able_date3")
                            <div class="form_group">
                                <label>{{$param[$key]}}</label>
                                <input type="date" name="{{$key}}" value="{{$value}}">
                            </div>
                        @elseif ($key==="able_time1" || $key==="able_time2" || $key==="able_time3")
                            <div class="form_group">
                                <label>{{$param[$key]}}</label>
                                <input type="time" name="{{$key}}" value="{{$value}}">
                            </div>
                        @elseif ($key==="intro_text")
                            <div class="form_group">
                                <label>{{$param[$key]}}</label>
                                <textarea class="form_textarea" name="{{$key}}">{{$value}}</textarea>
                            </div>
                        @else
                            <div class="form_group">
                                <label>{{$param[$key]}}</label>
                                <input type="text" name="{{$key}}" value="{{$value}}">
                            </div>
                        @endif
                    @endforeach

                </div><br>

                <div class="create">

                    <div class="form_group">
                        <p>{{config('const.matter_info.info56')}}</p>
                        <div class="form_checkbox2">
                            @foreach ($genre as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox[]" value="{{$key}}" id="{{$key}}" checked><label for="{{$key}}">{{$matter_genre[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox[]" value="{{$key}}" id="{{$key}}"><label for="{{$key}}">{{$matter_genre[$key]}}</label></li>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div><br>

                <div class="create">

                    <div class="form_group">
                        <p>{{config('const.matter_info.info2')}}</p>
                        <div class="form_checkbox2">
                            @foreach ($sns as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox1[]" value="{{$key}}" id="{{$key}}" checked><label for="{{$key}}">{{$sns_list[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox1[]" value="{{$key}}" id="{{$key}}"><label for="{{$key}}">{{$sns_list[$key]}}</label></li>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div><br>

                <div class="create">

                    <div class="form_group">
                        <p>{{config('const.matter_info.info4')}}</p>
                        <div class="form_checkbox">
                            @foreach ($term2_1 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox2[]" value="{{$key}}" id="{{$key}}" checked><label for="{{$key}}">{{$term_content[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox2[]" value="{{$key}}" id="{{$key}}"><label for="{{$key}}">{{$term_content[$key]}}</label></li>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <?php $i=1; ?>
                    @foreach ($term2_2 as $key=>$value)
                        <div class="form_group">
                            <label>記述式{{$i}}</label>
                            @if ($value!=="F" && !empty($value))
                                <input type="text" name="post_conditions[]" value="{{$value}}">
                            @else
                                <input type="text" name="post_conditions[]" value="">
                            @endif
                        </div>
                        <?php $i+=1; ?>
                    @endforeach
                </div><br>

                <div class="create">

                    <div class="form_group">
                        <p>{{config('const.matter_info.info4')}}</p>
                        <div class="form_checkbox">
                            @foreach ($notice2_1 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox3[]" value="{{$key}}" id="{{$key}}" checked><label for="{{$key}}">{{$notice_content[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox3[]" value="{{$key}}" id="{{$key}}"><label for="{{$key}}">{{$notice_content[$key]}}</label></li>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <?php $i=1; ?>
                    @foreach ($notice2_2 as $key=>$value)
                        <div class="form_group">
                            <label>記述式{{$i}}</label>
                            @if ($value!=="F" && !empty($value))
                                <input type="text" name="post_conditions2[]" value="{{$value}}">
                            @else
                                <input type="text" name="post_conditions2[]" value="">
                            @endif
                        </div>
                        <?php $i+=1; ?>
                    @endforeach

                    <div class="form_group">
                        <p>{{config('const.matter_info.info58')}}</p>
                        <small>修正時は既に登録している画像も含めて選択</small>
                        <div class="form_checkbox">
                            @for ($i=1;$i<=5;$i++)
                                <input type="file" name="matter_img[]" accept=".png, .jpg, .jpeg">
                            @endfor
                        </div>
                    </div>

                    <div class="chat_submit">
                        <input type="hidden" name="hidden" value="{{$id}}">
                        <input type="submit" class="chat_btn" value="送信">
                    </div>

                </div><br>
            </form>


        </div>

    </body>
    @include('administrator.component.footer')
</html>
