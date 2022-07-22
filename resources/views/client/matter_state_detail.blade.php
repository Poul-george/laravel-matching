<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title22')}}</title>
    </head>

    <body>
    @include('client.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title22')}}</h3>
        </div>
        <div class="main_form">
        @if (session('msgs'))
            <p class="msg_center">{{session('msgs')}}</p>
        @endif

        {{-- チャット  フラグが５以外 --}}
        @if ($flag!=="5")

            <div class="chat_area">
                <p>{{$influ_name}}</p>
                <div class="chat">
                    @if ($whose!=="" && isset($whose))

                            <?php $y=0; ?>
                            <?php $i=0; ?>
                            <?php $dates=""; ?>
                            @if ($whose[0]==="0")
                                <div class="chat_box">
                                    <P>{{$whose[0]}}</p>
                            @else
                                <div class="chat_box_aite">
                            @endif

                            @foreach ($msg as $value)
                                <?php $y+=1; ?>
                                @if ($value[0]=="<" && $value[1]==">")
                                <?php $i+=1; ?>

                                <?php $dates=substr($value,2); ?>
                                    </div>
                                    @if ($whose[$i-1]==="0")
                                        <div class="chat_dates">{{$dates}}</div>
                                    @else
                                        <div class="chat_dates_aite">{{$dates}}</div>
                                    @endif
                                    <br>
                                    @if ($y===count($msg))
                                        @break
                                    @endif
                                    @if ($whose[$i]==="0")

                                        <div class="chat_box">
                                    @else

                                        <div class="chat_box_aite">

                                    @endif


                                @else
                                    <div class="chat_content"><p>{{$value}}</p></div>
                                @endif

                            @endforeach
                            @if ($i!==0)
                                {{-- </div> --}}
                            @endif
                        @endif
                </div>

                <form method="POST" action="">
                    @csrf
                    <div class="chat_submit">
                        <?php $chat_template=""; ?>
                        @if ($whose==="")
                            <?php $chat_template="この度はご応募いただきまして誠にありがとうございます。\n返信が遅くなってしまい、大変申し訳ございません。\n是非{$influ_name}様に、お願いしたいです。\n宜しくお願い致します。"; ?>
                        @endif
                        <textarea name="comment" class="chat_textarea" required>{{$chat_template}}</textarea>
                        @if (isset($whose))

                            <input type="hidden" name="whose" value="{{$whose}}">
                        @endif
                        <input type="hidden" name="hidden_id" value="{{$id}}">
                        <input type="hidden" name="hidden" value="1">
                        <input type="submit" class="chat_btn" value="送信">
                    </div>
                </form>
            </div>
        @endif

        <div class="syousai_area">
            <div class="syousai_title">
                <p>{{config('const.matter_info.info31')}}</p>
            </div>
            <div class="syousai_comment">
                @if (empty($reserve_name))
                    <p>未定</p>
                @else
                    <p>{{$reserve_name}}</p>
                @endif
            </div>
            <div class="syousai_title">
                <p>{{config('const.matter_info.info60')}}</p>
            </div>
            <div class="syousai_comment">
                @if (empty($bikou))
                    <p>未定</p>
                @else
                    <p>{{$bikou}}</p>
                @endif
            </div>
            @if (!empty($post_deadline1))
                <div class="syousai_title">
                <p>{{config('const.matter_info.info9')}}期限</p>
            </div>
            <div class="syousai_comment">
                <p>{{$post_deadline1}}</p>
            </div>
            @endif

            @if (!empty($post_deadline2))
                <div class="syousai_title">
                <p>{{config('const.matter_info.info10')}}期限</p>
            </div>
            <div class="syousai_comment">
                <p>{{$post_deadline2}}</p>
            </div>
            @endif

            <div class="syousai_title">
                <p>{{config('const.matter_info.info32')}}</p>
            </div>
            <div class="syousai_comment">
                <ul class="t_f">
                    @foreach ($allergy_list as $key=>$value)
                        @if  ( $value==="F" || empty($value))
                        @else
                            <li>{{$value}}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div><br>

        <div class="create">
            <p>{{config('const.matter_info.info31')}}・{{config('const.matter_info.info32')}}の更新</p>
            <form method="POST" action="">
                @csrf
                <div class="form_group">
                    <label>{{config('const.matter_info.info31')}}</label>
                    <input type="text" name="reserve_name" class="form1" value="{{$reserve_name}}">
                </div>
                <div class="form_group">
                    @for ($i=1;$i<=5;$i++)
                        <label>{{config('const.matter_info.info32')}}{{$i}}</label>
                        <input type="text" name="allergy[]" class="form1" value="{{$allergy_list["allergy$i"]}}">
                    @endfor
                </div>
                <div class="form_group">
                    <label>{{config('const.matter_info.info60')}}</label>
                    <input type="text" name="bikou" class="form1" value="{{$bikou}}">
                </div>

                <div class="chat_submit">
                    <input type="hidden" name="hidden_id" value="{{$id}}">
                    <input type="hidden" name="hidden" value="kihon">
                    <input type="submit" class="chat_btn" value="登録">
                </div>
            </form>
        </div>

            @if ($flag==="1")
                <div class="table_div">
                    <p>{{config('const.matter_info.info33')}}</p>

                    <table class="table_map">
                        <tr>
                            <th></th>
                            <th>日付</th>
                            <th>時間</th>
                            <th>人数</th>
                        </tr>

                        <?php $i=1; ?>
                        <?php $j=2; ?>
                        <tr>
                            <td>希望1</td>
                        @foreach ($item as $value)
                                <td>{{$value}}</td>
                            @if ($i===3 || $i===6)
                                </tr>
                                <tr>
                                    <td>希望{{$j}}</td>
                                <?php $j+=1; ?>
                            @endif
                            <?php $i+=1; ?>
                        @endforeach
                        </tr>
                    </table>
                </div><br>
                <?php $hourminute=config('list.hourminute'); ?>
                <div class="create">
                    <p>{{config('const.matter_info.info34')}}</p>
                    <form method="POST" action="">
                        @csrf
                        <div class="form_group">
                            <label>{{config('const.matter_info.info35')}}</label>
                            <input type="date" name="dates" class="form1" required>
                        </div>
                        <div class="form_group">
                            <label>{{config('const.matter_info.info36')}}</label>
                            <select name="times" required>
                                <option value="">選択してください</option>
                                @foreach ($hourminute as $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form_group">
                            <label>{{config('const.matter_info.info37')}}</label>
                            <input type="number" name="members" class="form1" required>
                        </div>
                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">いずれかを選択してください。</option>
                                <option value="1">希望1</option>
                                <option value="2">希望2</option>
                                <option value="3">希望3</option>
                                <option value="4">確定</option>
                            </select>
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="2">
                            <input type="submit" class="btn" name="confirm" value="決定">
                        </div>
                    </form>
                </div><br>
            @endif

            {{-- フラグが３、4，5の時 --}}
            @if ($flag==="3")
                @if ($come==='T')
                    <div class="syousai_area">
                    @if ($questionaire==="2")
                        <div class="right_top_link">
                            <a href="../matter_questionaire/{{$id}}">{{config('const.matter_info.info16')}}</a>
                        </div>
                    @endif
                        @foreach ($item as $key=>$value)
                            <div class="syousai_title">
                                <p>{{$param[$key]}}</p>
                            </div>
                            <div class="syousai_comment">
                                <p>{{$value}}</p>
                            </div>
                        @endforeach
                    </div><br>
                @endif

                @if ($come==="F")
                    <div class="create">
                        <p>{{config('const.matter_info.info38')}}</p>
                        <form method="POST" action="">
                            @csrf
                            <div class="select_submit">
                                <select class="select_2separate" name="selector1" required>
                                    <option value="">来店確認後、選択してください。</option>
                                    <option value="1">{{config('const.matter_info.info38')}}</option>
                                </select>
                                <input type="hidden" name="hidden_id" value="{{$id}}">
                                <input type="hidden" name="hidden" value="raiten">
                                <input type="submit" class="btn" name="confirm" value="確認">
                            </div>
                        </form>
                    </div><br>
                @endif


            @endif

            @if ($flag==="4")
                <div class="syousai_area">
                    <p>{{config('const.matter_info.info9')}}</p>
                    @if ($questionaire==="2")
                        <div class="right_top_link">
                            <a href="../matter_questionaire/{{$id}}">{{config('const.matter_info.info16')}}</a>
                        </div>
                    @endif
                    @foreach ($item as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if (empty($value))
                                <p>投稿なし</p>
                            @else
                                <p><a href="{{$value}}">{{$value}}</a></p>
                            @endif
                        </div>
                    @endforeach
                </div><br>

            @endif

            @if ($flag==="5")
                <div class="syousai_area">
                    <p>{{config('const.matter_info.info9')}}</p>
                    @if ($questionaire==="2")
                        <div class="right_top_link">
                            <a href="../matter_questionaire/{{$id}}">{{config('const.matter_info.info16')}}</a>
                        </div>
                    @endif
                    @foreach ($item as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if (empty($value))
                                <p>投稿なし</p>
                            @else
                                <p><a href="{{$value}}">{{$value}}</a></p>
                            @endif
                        </div>
                    @endforeach
                </div><br>

                <div class="syousai_area">
                    <p>{{config('const.matter_info.info10')}}</p>
                    <div class="img_area">
                        @foreach ($item2 as $key=>$value)
                            @if (!empty($value))
                                <div class="img_box">
                                    <img src="{{ asset("laravel/public/storage/matterstate/$value") }}" alt="insite">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </body>
    @include('client.component.footer')
</html>
