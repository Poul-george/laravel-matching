<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title38')}}</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title38')}}</h3>
        </div>
        @if ($hurry!=="")
            <p class="error">{{$hurry}}</p>
        @endif

        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif

            {{-- フラグが３の時 --}}
            @if ($flag==="3")
                <div class="syousai_area">
                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info9')}}期限</p>
                    </div>
                    <div class="syousai_comment">
                        <p>{{$post_deadline1}}</p>
                    </div>
                </div><br>
                <div class="create">
                    <p>{{config('const.matter_info.info9')}}</p>

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



                        <div class="chat_submit">
                            {{-- <select class="select_2separate" name="selector1" required>
                                <option value="">「登録」を選択してください。</option>
                                <option value="1">登録</option>
                            </select> --}}
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="3">
                            <input type="submit" class="chat_btn" name="confirm" value="登録">
                        </div>
                    </form>
                </div><br>
            @endif

            @if ($questionaire==="0")
                <div class="create">
                    <p>{{config('const.title.title34')}}</p>
                        <form method="POST" action="">
                            @csrf
                            <div class="form_group">
                                <label>美味しかったメニュー</label><small>※必須</small>
                                <input type="text" name="menu1" class="form1" required>
                            </div>
                            <div class="form_group">
                                <label>美味しくなかったメニュー</label><small>※必須</small>
                                <input type="text" name="menu2" class="form1" required>
                            </div>
                            <div class="form_group">
                                <div class="radio_box">
                                    <label>接客評価 10段階評価</label><br>
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
                            </div>
                            <div class="form_group">
                                <label>接客評価について悪いor良いと思った点をお書きください。</label><small>※必須</small>
                                <textarea class="form_textarea" name="service_value_memo" required></textarea>
                            </div>

                            <div class="form_group">
                                <div class="radio_box">
                                    <label>価格への満足度 5段階評価</label><br>
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
                            </div>

                            <div class="form_group">
                                <label>気になる事はありましたか？</label>
                                <div class="form_checkbox">
                                    <?php $i=1; ?>
                                    @foreach ($item_ques as $key=>$value)
                                        @if (!empty($value))
                                            <li><input type="checkbox" name="notice[]" value="{{$value}}" id="box-{{$i}}"><label for="box-{{$i}}">{{$value}}</label></li>
                                        @endif
                                        <?php $i+=1; ?>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form_group">
                                <label>その他、気になる事はありましたか？</label>
                                <textarea class="form_textarea" name="notice_memo"></textarea>
                            </div>
                            <div class="form_group">
                                <label>その他、お伝えしたい事があれば、ご記入ください。</label>
                                <textarea class="form_textarea" name="notice_other"></textarea>
                            </div>

                            {{-- <div class="select_submit"> --}}
                            <div class="chat_submit">
                                {{-- <select class="select_2separate" name="selector1" required>
                                    <option value="">「登録」を選択してください。</option>
                                    <option value="1">登録</option>
                                </select> --}}
                                <input type="hidden" name="hidden_id" value="{{$id}}">
                                <input type="hidden" name="hidden" value="5">
                                <input type="submit" class="chat_btn" name="confirm" value="登録">
                            </div>
                        </form>
                </div><br>
            @endif

            @if ($flag==="4")
                {{-- <div class="syousai_area">
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
                </div><br> --}}
                <div class="syousai_area">
                    <div class="syousai_title">
                        <p>{{config('const.matter_info.info10')}}期限</p>
                    </div>
                    <div class="syousai_comment">
                        <p>{{$post_deadline2}}</p>
                    </div>
                </div><br>

                <div class="create">
                    <p>{{config('const.matter_info.info10')}}</p>

                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form_group">
                            @for ($i=1;$i<=5;$i++)
                                @if ($i===1)
                                    <label>{{config('const.influ_info.info3')}}-{{$i}}</label><small>※必須</small>
                                    <input type="file" name="insite[]" class="form1" accept=".png, .jpg, .jpeg" required>
                                @else
                                    <label>{{config('const.influ_info.info3')}}-{{$i}}</label>
                                    <input type="file" name="insite[]" class="form1" accept=".png, .jpg, .jpeg">
                                @endif
                                <br>
                            @endfor
                        </div>

                        {{-- <div class="select_submit"> --}}
                        <div class="chat_submit">
                            {{-- <select class="select_2separate" name="selector1" required>
                                <option value="">「登録」を選択してください。</option>
                                <option value="1">登録</option>
                            </select> --}}
                            <input type="hidden" name="hidden_id" value="{{$id}}">
                            <input type="hidden" name="hidden" value="4">
                            <input type="submit" class="chat_btn" name="confirm" value="登録">
                        </div>
                    </form>
                </div><br>
            @endif
        </div>

    </body>
    @include('influencer.component.footer')
</html>
