<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title23')}}</title>
    </head>
    <body>
    @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title23')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msg'))
                <p class="msg_center">{{session('msg')}}</p><br>
            @endif
            <div class="syousai_area">
                    <div class="syousai_title">
                        <p>現在のステータス</p>
                    </div>
                    <div class="syousai_comment">
                        <p>{{$matter_list[$matter_flag]}}</p>
                    </div>
            </div><br>

            <div class="table_div">
                <p>{{$shop_name}}</p>

                <table class="table_map">
                    <tr>
                        <th>{{config('const.matter_info.info18')}}</th>
                        <th>{{config('const.matter_info.info19')}}</th>
                        <th>{{config('const.matter_info.info20')}}</th>
                        <th></th>
                    </tr>

                    @foreach ($item as $value)
                    <tr>
                        <td><a href="../../matter_member_detail/{{$value->id}}">{{$value->influ_name}}</a></td>
                        <td>{{$flag_list[$value->flag]}}</td>
                        <td>{{$questionaire_list[$value->questionaire]}}</td>
                        <td><a href="../../admin_{{config('const.title.title48')}}_2_detail/{{$value->influ_id}}">{{config('const.title.title2')}}詳細</a></td>
                    </tr>
                    @endforeach

                </table>
            </div><br>

            @if ($survey==="F")
                <div class="create">
                    <p> {{config('const.matter_info.info21')}}</p>
                    <form method="POST" action="">
                        @csrf
                            <div class="form_group">
                                <label>{{config('const.matter_info.info22')}}</label><br>
                                <textarea class="form_textarea" name="survey1" required></textarea>
                            </div>
                            <div class="form_group">
                                <label>{{config('const.matter_info.info23')}}</label><br>
                                <textarea class="form_textarea" name="survey2" required></textarea>
                            </div>
                            <div class="form_group">
                                <label>{{config('const.matter_info.info24')}}</label><br>
                                <textarea class="form_textarea" name="survey3" required></textarea>
                            </div>
                            <div class="form_group">
                                <label>{{config('const.matter_info.info25')}}</label><br>
                                <textarea class="form_textarea" name="survey4"></textarea>
                            </div>
                            <div class="select_submit">
                                <select class="select_2separate" name="selector1" required>
                                    <option value="">「登録」を選択してください。</option>
                                    <option value="1">登録</option>
                                </select>
                                <input type="hidden" name="hidden_id" value="{{$id}}">
                                <input type="hidden" name="hidden" value="1">
                                <input type="submit" class="btn" name="confirm" value="変更">
                            </div>
                    </form>
                </div><br>
            @elseif ($survey==="T")
                <div class="syousai_area">
                    @foreach ($survey_list as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$survey_list2[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if ($value==="F" || empty($value))
                                <p>記入なし</p>
                            @else
                                <div class="last_comment">
                                    <p>{{$value}}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div><br>
            @endif

            <div class="create">
                <p> {{config('const.matter_info.info8')}}の変更</p>
                <form method="POST" action="">
                    @csrf
                        <div class="form_group">
                            <div class="radio_form">
                                <?php $i=0; ?>
                                @foreach ($matter_list as $value)
                                    <div><input type="radio" name="radio" id="radio{{$i}}" value="{{$i}}"><label for="radio{{$i}}">{{$value}}</label></div>
                                    <?php $i+=1; ?>
                                @endforeach
                            </div>
                        </div>
                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">「変更」を選択してください。</option>
                                <option value="1">変更</option>
                            </select>
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="2">
                            <input type="submit" class="btn" name="confirm" value="変更">
                        </div>
                </form>
            </div><br>

        </div>

    </body>
    @include('administrator.component.footer')
</html>
