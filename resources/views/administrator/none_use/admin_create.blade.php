<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title7')}}</title>
    </head>
    <body>

        @include('administrator.component.administrator_left')
            <div class="main_div" id="main_div">
            @include('administrator.component.administrator_header')
            <div class="top_title">
                <h3 class="title">{{config('const.title.title7')}}</h3>
            </div>


            <div class="mypage_edit_div">

                <div class="mypage_form_div">
                    <div id="mypage_form_center" class="mypage_form_center">
                        <div class="main_form">
                            <div class="create">
                                @if (isset($account))
                                    <p class="p_center">アカウントID：{{$account}}</p>
                                    <p class="p_center">パスワード：{{$password}}</p>
                                    <br>
                                    <small class="p_center">上記情報はメモしておいてください。</small>
                                @else
                                    <form method="POST" action="" onsubmit="return cancelsubmit_delete()">
                                        @csrf
                                        <div class="form_group">
                                            <label>{{config('const.create_info.info1')}}</label>
                                            <input type="text" name="manager_name" class="form1" required>
                                        </div>
                                        <div class="form_group">
                                            <label>{{config('const.create_info.info2')}}</label>
                                            <input type="email" name="manager_mail" class="form1" required>
                                        </div>
                                        <div class="form_group">
                                            <label>{{config('const.create_info.info3')}}</label>
                                            <input type="tel" name="manager_phone" class="form1" required>
                                        </div>
                                        <div class="create_submit">
                                            <input type="submit" value="作成" class="btn">
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>    
                    </div>
                </div>
            </div>


        </div>

    </body>
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>