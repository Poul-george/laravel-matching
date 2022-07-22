<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title8')}}</title>
    </head>

    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title8')}}</h3>
        </div>

        @if (isset($hurry))
            <p class="msg_center">{{$hurry}}</p>
        @endif

        <div class="main_form">
            @if (session('msgs'))
                <p class="msg_center">{{session('msgs')}}</p>
            @endif



            <div class="chat_area">
                <p>{{$shop_name}}様</p>
                <div class="chat">
                        @if ($whose!=="" && isset($whose))

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

        </div>

    </body>
    @include('influencer.component.footer')
</html>
