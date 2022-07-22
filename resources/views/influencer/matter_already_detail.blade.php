<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title22')}}</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title22')}}</h3>
        </div>

        @if (isset($hurry))
            <p class="msg_center">{{$hurry}}</p>
        @endif

        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif

            @if ($flag==="0")
                <div class="table_div">
                    <p>まだ未採用です。</p>
                    <p>採用の有無については、決定次第ご登録いただいたメールアドレス宛に
                    お知らせいたしますので、それまでお待ちください。</p>
                </div>
            @endif

            @if ($flag!=="0")
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
            @endif

            @if ($flag==="1")
                <div class="table_div">
                    <p>{{config('const.matter_info.info33')}}</p>
                    <table class="table_map">
                        <tr>
                            <th></th>
                            <th>{{config('const.matter_info.info35')}}</th>
                            <th>{{config('const.matter_info.info36')}}</th>
                            <th>{{config('const.matter_info.info37')}}</th>
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

                <div class="create">
                    <p>予約名・アレルギー登録</p>
                    <form method="POST" action="">
                        @csrf
                        <div class="form_group">
                            <label>{{config('const.matter_info.info31')}}</label>
                            <input type="text" name="reserve_name" class="form1">
                        </div>
                        @for ($i=1;$i<=5;$i++)
                            <div class="form_group">
                                <label>{{config('const.matter_info.info32')}}{{$i}}</label>
                                <input type="text" name="allergy[]" class="form1">
                            </div>
                        @endfor

                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">「登録」を選択してください。</option>
                                <option value="1">登録</option>
                            </select>
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="2">
                            <input type="submit" class="btn" name="confirm" value="登録">
                        </div>
                    </form>
                </div><br>
            @endif

            {{-- フラグが３の時 --}}
            @if ($flag==="3")
                <div class="syousai_area">
                    @foreach ($item as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            <p>{{$value}}</p>
                        </div>
                    @endforeach
                </div><br>
                @if ($come==='T')
                    <div class="create">
                        <p>{{config('const.matter_info.info9')}}</p>
                        @if ($questionaire==="0")
                            <div class="right_top_link">
                                <a href="../questionaire_form/{{$id}}">{{config('const.matter_info.info42')}}</a>
                            </div>
                        @endif
                        <form method="POST" action="">
                            @csrf
                            <div class="form_group">
                                <label>インスタグラムURL1</label><small>※必須</small>
                                <input type="text" name="instagram1" class="form1" required>
                            </div>
                            <div class="form_group">
                                <label>インスタグラムURL2</label><small>※任意</small>
                                <input type="text" name="instagram2" class="form1">
                            </div>
                            <div class="form_group">
                                <label>インスタグラムURL3</label><small>※任意</small>
                                <input type="text" name="instagram3" class="form1">
                            </div>
                            <div class="form_group">
                                <label>インスタグラムURL4</label><small>※任意</small>
                                <input type="text" name="instagram4" class="form1">
                            </div>
                            <div class="form_group">
                                <label>インスタグラムURL5</label><small>※任意</small>
                                <input type="text" name="instagram5" class="form1">
                            </div>

                            <div class="form_group">
                                @if ($hissu_list['story1']==="T")
                                    <label>ストーリーズURL1</label><small>※必須</small>
                                    <input type="text" name="story1" class="form1" required>
                                @else
                                    <label>ストーリーズURL1</label><small>※任意</small>
                                    <input type="text" name="story1" class="form1">
                                @endif
                            </div>
                            <div class="form_group">
                                @if ($hissu_list['story2']==="T")
                                    <label>ストーリーズURL2</label><small>※必須</small>
                                    <input type="text" name="story2" class="form1" required>
                                @else
                                    <label>ストーリーズURL2</label><small>※任意</small>
                                    <input type="text" name="story2" class="form1">
                                @endif
                            </div>
                            <div class="form_group">
                                @if ($hissu_list['story3']==="T")
                                    <label>ストーリーズURL3</label><small>※必須</small>
                                    <input type="text" name="story3" class="form1" required>
                                @else
                                    <label>ストーリーズURL3</label><small>※任意</small>
                                    <input type="text" name="story3" class="form1">
                                @endif
                            </div>
                            <div class="form_group">
                                @if ($hissu_list['taberogu']==="T")
                                    <label>食べログURL</label><small>※必須</small>
                                    <input type="text" name="taberogu" class="form1" required>
                                @else
                                    <label>食べログURL</label><small>※任意</small>
                                    <input type="text" name="taberogu" class="form1">
                                @endif
                            </div>
                            <div class="form_group">
                                @if ($hissu_list['google']==="T")
                                    <label>Google Map URL</label><small>※必須</small>
                                    <input type="text" name="google" class="form1" required>
                                @else
                                    <label>Google Map URL</label><small>※任意</small>
                                    <input type="text" name="google" class="form1">
                                @endif
                            </div>
                            <div class="form_group">
                                @if ($hissu_list['blog']==="T")
                                    <label>ブログURL</label><small>※必須</small>
                                    <input type="text" name="blog" class="form1" required>
                                @else
                                    <label>ブログURL</label><small>※任意</small>
                                    <input type="text" name="blog" class="form1">
                                @endif
                            </div>

                            <div class="form_group">
                                <label>その他1</label><small>※任意</small>
                                <input type="text" name="other1" class="form1">
                            </div>
                            <div class="form_group">
                                <label>その他2</label><small>※任意</small>
                                <input type="text" name="other2" class="form1">
                            </div>
                            <div class="form_group">
                                <label>その他3</label><small>※任意</small>
                                <input type="text" name="other3" class="form1">
                            </div>
                            <br>

                            <p>{{config('const.title.title34')}}</p>
                            <div class="form_group">
                                <label>美味しかったメニュー</label><small>※必須</small>
                                <input type="text" name="menu1" class="form1" required>
                            </div>
                            <div class="form_group">
                                <label>美味しくなかったメニュー</label><small>※必須</small>
                                <input type="text" name="menu2" class="form1" required>
                            </div>
                            <div class="radio_box">
                                <p>接客評価 10段階評価</p><br>
                                <div class="radio_order">
                                    <p>とても悪い</p>
                                    @for ($i=1;$i<=10;$i++)
                                        <div class="radio_order_sub">
                                            <label for="radio{{$i}}" class="radio_tate">{{$i}}</label>
                                            <input type="radio" name="selector1" class="" id="radio{{$i}}" required>
                                        </div>
                                    @endfor
                                    <p>とても良い</p>
                                </div>
                            </div>
                            <div class="form_group">
                                <label>接客評価について悪いor良いと思った点をお書きください。</label><br>
                                <textarea class="form_textarea" name="service_value_memo" required></textarea>
                            </div>

                            <div class="radio_box">
                                <p>接客評価 10段階評価</p><br>
                                <div class="radio_order">
                                    <p>満足度が低い</p>
                                    @for ($i=1;$i<=5;$i++)
                                        <div class="radio_order_sub">
                                            <label for="radio2{{$i}}" class="radio_tate">{{$i}}</label>
                                            <input type="radio" name="selector2" class="" id="radio2{{$i}}" required>
                                        </div>
                                    @endfor
                                    <p>満足度が高い</p>
                                </div>
                            </div>

                            <div class="form_group">
                                <label>その他、気になる事はありましたか？</label><br>
                                <textarea class="form_textarea" name="notice_memo"></textarea>
                            </div>
                            <div class="form_group">
                                <label>その他、お伝えしたい事があれば、ご記入ください。</label><br>
                                <textarea class="form_textarea" name="notice_other"></textarea>
                            </div>

                            <div class="select_submit">
                                <select class="select_2separate" name="selector1" required>
                                    <option value="">「登録」を選択してください。</option>
                                    <option value="1">登録</option>
                                </select>
                                <input type="hidden" name="hidden_id" value="{{$id}}">
                                <input type="hidden" name="hidden" value="3">
                                <input type="submit" class="btn" name="confirm" value="登録">
                            </div>
                        </form>
                    </div><br>
                @endif
            @endif

            @if ($flag==="4")
                <div class="syousai_area">
                    <p>{{config('const.matter_info.info9')}}</p>
                    @foreach ($item as $key=>$value)
                        <div class="syousai_title">
                            <p>{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            @if (empty($value))
                                <p>投稿なし</p>
                            @else
                                <p>{{$value}}</p>
                            @endif
                        </div>
                    @endforeach
                </div><br>

                <div class="create">
                    <p>{{config('const.matter_info.info10')}}</p>

                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form_group">
                            <label>{{config('const.influ_info.info3')}}（最大5つ）</label><small>※一つは必須</small>
                            <input type="file" multiple name="insite[]" class="form1" accept=".png, .jpg, .jpeg" required>
                        </div>

                        <div class="select_submit">
                            <select class="select_2separate" name="selector1" required>
                                <option value="">「登録」を選択してください。</option>
                                <option value="1">登録</option>
                            </select>
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="4">
                            <input type="submit" class="btn" name="confirm" value="登録">
                        </div>
                    </form>
                </div><br>
            @endif

            @if ($flag==="5")
                <div class="syousai_area">
                    <p>{{config('const.matter_info.info9')}}</p>
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

    {{-- チャット  フラグが５以外 --}}
            @if ($flag!=="5" && $flag!=="0")

                <div class="chat_area">
                    <p>{{$shop_name}}様</p>
                    <div class="chat">
                            @if ($whose!=="")

                                <?php $y=0; ?>
                                <?php $i=0; ?>
                                <?php $dates=""; ?>
                                @if ($whose[0]==="1")
                                    <div class="chat_box">
                                @else
                                    <div class="chat_box_aite">
                                @endif

                                @foreach ($msg as $value)
                                    <?php $y+=1; ?>
                                    @if ($value[0]=="<" && $value[1]==">")
                                    <?php $i+=1; ?>

                                    <?php $dates=substr($value,2); ?>
                                        </div>
                                        @if ($whose[$i-1]==="1")
                                            <div class="chat_dates">{{$dates}}</div>
                                        @else
                                            <div class="chat_dates_aite">{{$dates}}</div>
                                        @endif
                                        <br>
                                        @if ($y===count($msg))
                                            @break
                                        @endif
                                        @if ($whose[$i]==="1")
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
                    <div>
                        <form method="POST" action="">
                            @csrf
                            <div class="chat_submit">
                                <textarea name="comment" class="chat_textarea" required></textarea>
                                @if (isset($whose))

                                    <input type="hidden" name="whose" value="{{$whose}}">
                                @endif
                                <input type="hidden" name="hidden_id" value="{{$id}}">
                                <input type="hidden" name="hidden" value="1">
                                <input type="submit" class="chat_btn" value="送信">
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>

    </body>
    @include('influencer.component.footer')
</html>
