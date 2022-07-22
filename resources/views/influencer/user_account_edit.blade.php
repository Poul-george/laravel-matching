<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <title>{{config('const.title.title35')}}編集</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title35')}}編集</h3>
        </div>


        <div class="main_form">
            <div class="syousai_area">
                <div class="syousai_title">
                    <p class="">{{config('const.influ_info.info4')}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$user_id}}</p>
                </div>
                @foreach ($item as $key=>$value)
                    @if ($key==="user_touroku" || $key==="user_birth" || $key==="user_gender")
                        <div class="syousai_title">
                            <p class="">{{$param[$key]}}</p>
                        </div>
                        <div class="syousai_comment">
                            <p>{{$value}}</p>
                        </div>
                    @endif
                @endforeach
            </div>


            <form method="POST" action="" enctype="multipart/form-data">
                <div class="create">
                    @csrf
                    @foreach ($item as $key=>$value)
                        @if ($key==="user_touroku" || $key==="user_birth" || $key==="user_gender" || $key==="user_address1" || $key==="user_address2")
                        @else
                            <div class="form_group">

                                @if ($key==="user_child" || $key==="user_pet" || $key==="user_zimusyo")
                                @elseif ($key==="user_mail")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input type="email" name="{{$key}}" value="{{$value}}" required>
                                @elseif ($key==="user_phone")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input type="tel" name="{{$key}}" value="{{$value}}" required>
                                @elseif ($key==="user_instagram_num")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input type="number" name="{{$key}}" value="{{$value}}" required>
                                @elseif ($key==="bank_number")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input class="" type="text" placeholder="" name="{{$key}}" value="{{$value}}" oninput="value = value.replace(/[０-９]/g,s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');" required>
                                @elseif ($key==="user_area")
                                    <label>{{$param[$key]}}<small>必須</small></label>
                                    <input class="" placeholder="郵便番号 (例 100-0000 or 1000000)" type="text" name="{{$key}}" value="{{$value}}" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','user_address','user_address');" required>
                                    <br><label>住所<small>必須</small></label>
                                    <input type="text" name="user_address" value="{{$user_address}}">
                                @elseif ($key==="user_taberogu" || $key==="user_google")
                                    <label>{{$param[$key]}}</label>
                                    @if ($value==="F" || $value==="")
                                        <input type="text" name="{{$key}}" value="">
                                    @else
                                        <input type="text" name="{{$key}}" value="{{$value}}">
                                    @endif
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
                        @if ($key==="user_child" || $key==="user_pet" || $key==="user_zimusyo")
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
                        @endforeach
                    </div>
                </div>

                <?php $i=1; ?>
                <div class="create">
                @foreach ($sns_name as $key=>$value)
                    <div class="form_group">
                        <label>{{config('const.influ_info.info8')}}{{$i}}</label>
                        @if  ($value==="F" || $value==="")
                            <input type="text" name="{{$key}}" value="">
                        @else
                            <input type="text" name="{{$key}}" value="{{$value}}">
                        @endif
                    </div>
                    <?php $i+=1; ?>
                @endforeach
                </div>


                <div class="create">
                    <div class="form_group">
                        <label>{{config('const.influ_info.info9')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item2 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{config("list.user_genre.$key")}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{config("list.user_genre.$key")}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="form_group">
                        <label>{{config('const.influ_info.info13')}}</label>
                        <div class="form_checkbox2">
                            <?php $i=1; ?>
                            @foreach ($item3 as $key=>$value)
                                @if  ($value==="T")
                                    <li><input type="checkbox" name="checkbox2[]" value="{{$i}}" id="{{$key}}" checked><label for="{{$key}}">{{config("list.todouhuken.$key")}}</label></li>
                                @else
                                    <li><input type="checkbox" name="checkbox2[]" value="{{$i}}" id="{{$key}}"><label for="{{$key}}">{{config("list.todouhuken.$key")}}</label></li>
                                @endif
                                <?php $i+=1; ?>
                            @endforeach
                        </div>
                    </div><br>

                    <div class="form_group">
                        <label>{{config('const.influ_info.info11')}}</label><small></small>
                        <input type="file" name="icon_img" class="form1" accept=".png, .jpg, .jpeg">
                    </div>

                    <div class="chat_submit">
                        <input type="submit" class="chat_btn" value="更新">
                    </div>

                </div><br>
            </form>

        </div>

    </body>
    @include('influencer.component.footer')
</html>
