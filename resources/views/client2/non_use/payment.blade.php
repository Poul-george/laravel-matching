<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title40')}}</title>
    </head>
    <body>
    @include('client2.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title40')}}</h3>
        </div>

        <div class="main_form">
            <div class="syousai_area">
                <div class="right_top_link">
                    <a href="../payment/1">すべて見る</a>
                </div>
                @foreach ($month_list as $value)
                    <?php $month=date('Y年m月',strtotime($value)); ?>
                    <div class="syousai_title">
                        <p><a class="no_link_format" href="../payment_detail/{{$value}}">{{$month}}分の支払通知書</a></p>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>

    </body>
    @include('client2.component.footer')
</html>
