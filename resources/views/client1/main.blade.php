<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/client.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title1')}}</title>
    </head>
    <body>
    @include('client1.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title1')}}</h3>
        </div>

        <div class="main_form">
        @if (session('flash_message'))
            <p class="msg_center">{{session('flash_message')}}</p>
        @endif
            <div class="main_page_link">

            </div>
            <div class="main_page_link">
               
            </div>
        </div>

    </body>
    @include('client1.component.footer')
</html>


