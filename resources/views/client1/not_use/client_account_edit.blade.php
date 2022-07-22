<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title35')}}</title>
    </head>
    <body>
    @include('client1.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title35')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_{{config('const.title.title47')}}_1">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">{{config('const.client_info.info1')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$shop_id}}</p>
                </div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="create">
                    @foreach ($item as $key=>$value)

                        @if ($key==="shop_address1" || $key==="shop_address2" || $key==="shop_single_space" || $key==="shop_child" || $key==="shop_pet" || $key==="shop_tanka" || $key==="shop_gender")
                        @else
                            <div class="form_group">
                                @if ($key==="shop_phone")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input type="tel" name="{{$key}}" value="{{$value}}" required>
                                @elseif ($key==="shop_mail")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input type="email" name="{{$key}}" value="{{$value}}" required>
                                @elseif ($key==="shop_area")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input class="" placeholder="郵便番号 (例 100-0000 or 1000000)" type="text" name="{{$key}}" value="{{$value}}" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','shop_address','shop_address');" required>
                                    <br><label>住所<small>必須</small></label>
                                    <input type="text" name="shop_address" value="{{$shop_address}}">
                                @else
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input type="text" name="{{$key}}" value="{{$value}}" required>
                                @endif
                            </div>

                        @endif
                    @endforeach
                </div>

                <div class="create">
                    <div class="form_radio">
                        @foreach ($item as $key=>$value)
                            @if ($key==="shop_single_space")
                                <div class="form_group">
                                    <label>{{$param[$key]}}</label><br>
                                    <div class="radio_form2">

                                        @if ($value==="T")
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}T" value="T" checked><label for="{{$key}}T">あり</label></div>
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}F" value="F"><label for="{{$key}}F">なし</label></div>
                                        @else
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}T" value="T"><label for="{{$key}}T">あり</label></div>
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}F" value="F" checked><label for="{{$key}}F">なし</label></div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($key==="shop_tanka")
                                <div class="form_group">
                                    <label>{{$param[$key]}}</label><br>
                                    <div class="radio_form">
                                        @foreach ($tanka as $keys=>$values)
                                            @if ($value===$keys)
                                                <div><input type="radio" name="{{$key}}" id="{{$keys}}tanka" value="{{$keys}}" checked><label for="{{$keys}}tanka">{{$values}}</label></div>
                                            @else
                                                <div><input type="radio" name="{{$key}}" id="{{$keys}}tanka" value="{{$keys}}"><label for="{{$keys}}tanka">{{$values}}</label></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($key==="shop_gender")
                                <div class="form_group">
                                    <label>{{$param[$key]}}</label><br>
                                    <div class="radio_form">
                                        @foreach ($gender as $keys=>$values)
                                            @if ($value===$keys)
                                                <div><input type="radio" name="{{$key}}" id="{{$keys}}age" value="{{$keys}}" checked><label for="{{$keys}}age">{{$values}}</label></div>
                                            @else
                                                <div><input type="radio" name="{{$key}}" id="{{$keys}}age" value="{{$keys}}"><label for="{{$keys}}age">{{$values}}</label></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($key==="shop_child" || $key==="shop_pet")
                                <div class="form_group">
                                    <label>{{$param[$key]}}</label><br>
                                    <div class="radio_form2">

                                        @if ($value==="T")
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}T" value="T" checked><label for="{{$key}}T">可</label></div>
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}F" value="F"><label for="{{$key}}F">不可</label></div>
                                        @else
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}T" value="T"><label for="{{$key}}T">可</label></div>
                                            <div><input type="radio" name="{{$key}}" id="{{$key}}F" value="F" checked><label for="{{$key}}F">不可</label></div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <?php $i=1; ?>
                <div class="create">
                    <div class="form_group">
                        <label>{{config('const.client_info.info2')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item_2 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_2[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_2[$key]}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="form_group">
                        <label>{{config('const.client_info.info3')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item_3 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox2[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_3[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox2[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_3[$key]}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>
                    <div class="form_group">
                        <label>{{config('const.client_info.info4')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item_4 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox3[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_4[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbok3[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_4[$key]}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="form_group">
                        <label>{{config('const.client_info.info5')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item_5 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox4[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_5[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox4[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_5[$key]}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="form_group">
                        <label>{{config('const.client_info.info6')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item_6 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox5[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_6[$key]}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox5[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_6[$key]}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="form_group">
                        <label>{{config('const.client_info.info17')}}</label><small></small>
                        <input type="file" name="icon_img" class="form1" accept=".png, .jpg, .jpeg">
                    </div>

                </div>



                @if ($shop_new==="T")
                    <div class="create">
                        <p>新規オープン</p>
                        <div class="form_group">
                            <label>{{config('const.client_info.info12')}}</label>
                            <div class="form_checkbox2">
                                <?php $i=1; ?>
                                @foreach ($item_new as $key=>$value)
                                    @if  ($value==="T")
                                        <li><input type="checkbox" name="checkbox6[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_new[$key]}}</label></li>
                                    @else
                                        <li><input type="checkbox" name="checkbox6[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_new[$key]}}</label></li>
                                    @endif
                                    <?php $i+=1; ?>
                                @endforeach
                            </div>
                        </div><br>

                        <div class="form_group">
                            <label>{{config('const.client_info.info13')}}</label><br>
                            <div class="radio_form">
                                @foreach ($tanka as $key=>$value)
                                @if ($key===$shop_new_tanka)
                                    <div><input type="radio" name="shop_new_tanka" id="{{$key}}T" value="{{$key}}" checked><label for="{{$key}}T">{{$tanka[$key]}}</label></div>
                                @else
                                    <div><input type="radio" name="shop_new_tanka" id="{{$key}}F" value="{{$key}}"><label for="{{$key}}F">{{$tanka[$key]}}</label></div>
                                @endif
                                @endforeach
                            </div>
                        </div><br>

                        <div class="form_group">
                            <label>{{config('const.client_info.info14')}}</label>
                            <div class="form_checkbox2">
                                <?php $i=1; ?>
                                @foreach ($item_new2 as $key=>$value)
                                    @if  ($value==="T")
                                        <li><input type="checkbox" name="checkbox7[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_new2[$key]}}</label></li>
                                    @else
                                        <li><input type="checkbox" name="checkbox7[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_new2[$key]}}</label></li>
                                    @endif
                                    <?php $i+=1; ?>
                                @endforeach
                            </div>
                        </div><br>

                        <div class="form_group">
                            <label>{{config('const.client_info.info15')}}</label>
                            <div class="form_checkbox2">
                                <?php $i=1; ?>
                                @foreach ($item_new3 as $key=>$value)
                                    @if  ($value==="T")
                                        <li><input type="checkbox" name="checkbox8[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{$param_new3[$key]}}</label></li>
                                    @else
                                        <li><input type="checkbox" name="checkbox8[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{$param_new3[$key]}}</label></li>
                                    @endif
                                    <?php $i+=1; ?>
                                @endforeach
                            </div>
                        </div><br>

                        <div class="form_group">
                            <label>{{config('const.client_info.info16')}}</label>
                            <textarea name="shop_comment" class="form_textarea">{{$shop_comment}}</textarea>
                        </div>

                    </div>
                @endif
                <div class="chat_submit">
                    <input type="hidden" name="hidden_new" value="{{$shop_new}}">
                    <input type="submit" class="chat_btn" value="更新">
                </div>
            </form>
        </div>

    </body>
    @include('client1.component.footer')
</html>
