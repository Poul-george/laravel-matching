<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.config_info.info3')}}</title>
    </head>
    <body>

        @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.config_info.info4')}}</h3>
        </div>
        @if (session('msgs'))
            <p class="msg_center">{{session('msgs')}}</p>
        @endif

        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            <?php $y=1;; ?>

            <form method="POST" action="">
                @csrf
                <div class="create">
                <p>{{config('const.config_info.info5')}}</p>

                    <div class="form_radio2">
                        <?php $i=1; ?>
                        @foreach ($item as $key=>$value)
                            <div class="form_group">
                                <label>{{$param[$key]}}</label><br>
                                <div class="radio_form2">

                                    @if ($value==="T")
                                        <input type="radio" name="radio{{$y}}" id="radio{{$i}}" value="T" checked><label for="radio{{$i}}">必須</label>
                                        <input type="radio" name="radio{{$y}}" id="radio_2{{$i}}" value="F"><label for="radio_2{{$i}}">任意</label>
                                    @else
                                        <input type="radio" name="radio{{$y}}" id="radio{{$i}}" value="T"><label for="radio{{$i}}">必須</label>
                                        <input type="radio" name="radio{{$y}}" id="radio_2{{$i}}" value="F" checked><label for="radio_2{{$i}}">任意</label>
                                    @endif
                                </div>
                            </div>
                            <?php $i+=1; ?>
                            <?php $y+=1; ?>
                        @endforeach
                    </div>

                </div><br>
                <div class="create">
                    <p>{{config('const.config_info.info6')}}</p>
                    <div class="form_radio2">
                        <?php $i=1; ?>
                        @foreach ($item2 as $key=>$value)
                            <div class="form_group">
                                <label>{{$param[$key]}}</label><br>
                                <div class="radio_form2">

                                    @if ($value==="T")
                                        <input type="radio" name="radio{{$y}}" id="radio_3{{$i}}" value="T" checked><label for="radio_3{{$i}}">必須</label>
                                        <input type="radio" name="radio{{$y}}" id="radio_4{{$i}}" value="F"><label for="radio_4{{$i}}">任意</label>
                                    @else
                                        <input type="radio" name="radio{{$y}}" id="radio_3{{$i}}" value="T"><label for="radio_3{{$i}}">必須</label>
                                        <input type="radio" name="radio{{$y}}" id="radio_4{{$i}}" value="F" checked><label for="radio_4{{$i}}">任意</label>
                                    @endif
                                </div>
                            </div>
                            <?php $i+=1; ?>
                            <?php $y+=1; ?>
                        @endforeach
                    </div>

                </div><br>
                <div class="create">
                    <p>{{config('const.config_info.info7')}}</p>

                    <div class="form_radio2">
                        <?php $i=1; ?>
                        @foreach ($item3 as $key=>$value)
                            <div class="form_group">
                                <label>{{$param[$key]}}</label><br>
                                <div class="radio_form2">

                                    @if ($value==="T")
                                        <input type="radio" name="radio{{$y}}" id="radio_5{{$y}}" value="T" checked><label for="radio_5{{$y}}">必須</label>
                                        <input type="radio" name="radio{{$y}}" id="radio_6{{$y}}" value="F"><label for="radio_6{{$y}}">任意</label>
                                    @else
                                        <input type="radio" name="radio{{$y}}" id="radio_5{{$y}}" value="T"><label for="radio_5{{$y}}">必須</label>
                                        <input type="radio" name="radio{{$y}}" id="radio_6{{$y}}" value="F" checked><label for="radio_6{{$y}}">任意</label>
                                    @endif
                                </div>
                            </div>
                            <?php $i+=1; ?>
                            <?php $y+=1; ?>
                        @endforeach
                    </div>
                    <div class="create_submit">
                        <input type="hidden" name="hidden" value="1">
                        <input type="submit" value="更新" class="btn">
                    </div>
                </div>
            </form>
        </div>

    </body>
    @include('administrator.component.footer')
</html>
