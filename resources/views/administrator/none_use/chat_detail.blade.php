<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title8')}}</title>
        <style>
            /* p{
                padding:
            } */
        </style>
    </head>
    <body>

        @include('administrator.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title8')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="../chat">戻る</a></li> --}}
        </div>

        <div class="main_form">

            <div class="syousai_area">
                @foreach ($item as $key=>$values)
                <div class="syousai_title">
                    <p>{{$column[$key]}}</p>
                </div>
                <div class="syousai_comment">
                    <p>{{$values}}</p>
                </div>
                @endforeach
            </div><br>

            <div class="chat_area">
                <div class="chat">
                    <?php $i=0; ?>
                    @foreach ($msg as $value)
                        @if ($value[0]=="<" && $value[1]==">")
                            @if ($whose[$i]==="1")
                                @if ($i!==0)
                                    </div><br>
                                @endif
                                <div class="chat_from"><p>{{$item["contact_name"]}}様</p></div>
                                <div class="chat_box">
                            @else
                                @if ($i!==0)
                                    </div><br>
                                @endif
                                <div class="chat_from_aite"><p>運営側</p></div>
                                <div class="chat_box_aite">
                            @endif
                            <?php $i+=1; ?>
                        @else
                            <div class="chat_content"><p>{{$value}}</p></div>
                        @endif

                    @endforeach
                    </div>
                </div>

                <form method="POST" action="">
                    @csrf
                    <div class="chat_submit">
                        <textarea name="comment" class="chat_textarea" required></textarea>
                        @if (isset($whose))
                            <input type="hidden" name="from" value="{{$from}}">
                            <input type="hidden" name="contact_id" value="{{$contact_id}}">
                            <input type="hidden" name="whose" value="{{$whose}}">
                        @endif
                        <input type="submit" class="chat_btn" value="送信">
                    </div>
                </form>
            </div>

        </div>

    </body>
    @include('administrator.component.footer')
</html>
