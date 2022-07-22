<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title25')}}</title>

    </head>
    <body>
        @include('client1.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title25')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        </div>

        <div class="main_form">
        @if (!isset($param))
        <div class="create">
            <form method="POST" action="">
                @csrf
                <input type="hidden" name="name" value="{{$item->shop_name}}">
                <input type="hidden" name="tantou" value="{{$item->shop_tantou}}">
                <input type="hidden" name="phone" value="{{$item->shop_phone}}">
                <input type="hidden" name="mail" value="{{$item->shop_mail}}">
                <input type="hidden" name="address" value="{{$item->shop_address}}">
                <input type="hidden" name="station" value="{{$item->shop_station}}">
                <div class="chat_submit">
                    <textarea name="comment" class="chat_textarea" required></textarea>
                    <input type="submit" class="chat_btn" value="送信">
                </div>

            </form>
        </div>
        @else

            <div class="chat_area">
                @if (isset($msg))
                    @if ($msg!=="")
                    <div class="chat">
                    <?php $i=0; ?>
                    @foreach ($msg as $value)
                        @if ($value[0]=="<" && $value[1]==">")
                            @if ($whose[$i]==="1")
                                @if ($i!==0)
                                    </div><br>
                                @endif
                                <div class="chat_from_aite"><p></p></div>
                                <div class="chat_box_aite">
                            @else
                            @if ($i!==0)
                                    </div><br>
                                @endif
                                <div class="chat_from"><p>{{config('const.chat_info.info11')}}</p></div>
                                <div class="chat_box">

                            @endif
                            <?php $i+=1; ?>
                        @else
                            <div class="chat_content">{{$value}}</div>
                        @endif

                    @endforeach
                    </div>

                    </div><br>
                    @endif
                @endif
                <form method="POST" action="">
                    @csrf
                    <div class="chat_submit">
                        <textarea name="comment" class="chat_textarea" required></textarea>
                        @if (isset($whose))
                            <input type="hidden" name="whose" value="{{$whose}}">
                        @endif
                        <input type="submit" class="chat_btn" value="送信">
                    </div>
                </form>
            </div>
        @endif
        </div>

    </body>
    @include('client1.component.footer')
</html>
