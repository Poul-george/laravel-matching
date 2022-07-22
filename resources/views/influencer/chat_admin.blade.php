<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="{{ secure_asset('/css/tab2.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <title>{{config('const.title.title25')}}</title>
    </head>

    <body>
    @include('influencer.component.header')

        <div class="top_title">
            <h3 class="title">{{config('const.title.title25')}}</h3>
        </div>

        <div class="top_right">
            {{-- <li><a href="main">戻る</a></li> --}}
        </div>

        <div class="main_form">

            <div class='tabs'>
                <div class="tab_area">
                    <div class='tab-buttons'>
                        <span id="point" class='content1'>{{config('const.chat_info.info13')}}</span>
                        <span id="" class='content2'>{{config('const.chat_info.info12')}}</span>
                    </div>
                    <div id='lamp' class='content1'></div>
                </div>

                <div class='tab-content'>
                    <div class="content1">

                        <div class="syousai_area">
                            <p>{{config('const.chat_info.info10')}}</p>
                            <a href="javascript:OnLinkClickVisibly1();" class="a_kirikae"><p>案件について</p></a>
                            <div id="question_content1">
                                <div class="syousai_title">
                                    <p>案件をキャンセルしたい</p>
                                </div>
                                <div class="syousai_comment">
                                    <small>
                                        案件のキャンセルは原則、受け付けておりません。
                                        やむを得ない事情により、キャンセルせざるを得ない場合は、お問い合わせフォームへご連絡ください。<br>
                                        ※商品をすでに受け取っている場合は、商品をご返送いただく場合や商品代金のご負担をいただく場合がございます。
                                    </small>
                                </div>
                                <div class="syousai_title">
                                    <p>案件の審査基準を知りたい</p>
                                </div>
                                <div class="syousai_comment">
                                    <small>
                                        案件の審査につきましては、該当の飲食店舗様への適性を見極めて、{{config('const.title.title2')}}様へご依頼をいたします。<br>
                                        ※具体的な審査基準につきましては、飲食店様により異なる為、お問い合わせをいただいても、お答えできかねます。
                                    </small>
                                </div>
                            </div>

                            <a href="javascript:OnLinkClickVisibly2();" class="a_kirikae"><p>謝礼のお支払について</p></a>
                            <div id="question_content2">
                                <div class="syousai_title">
                                    <p>お支払期限について</p>
                                </div>
                                <div class="syousai_comment">
                                    <small>
                                        案件終了後の翌月末に、ご登録いただきました銀行口座にお振込みいたします。
                                    </small>
                                </div>
                            </div>
                            <a href="javascript:OnLinkClickVisibly3();" class="a_kirikae"><p>登録について</p></a>
                            <div id="question_content3">
                                <div class="syousai_title">
                                    <p>退会したい</p>
                                </div>
                                <div class="syousai_comment">
                                    <small>
                                        退会をご希望の場合は、お問い合わせフォームより、退会申請のご連絡をお願いいたします。<br>
                                        事務局にて、退会処理を行わせていただきます。<br>
                                        尚、案件進行中の場合は、原則として退会はできませんので、案件終了後にお問い合わせください。
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content2">

                        <div class="chat_area">
                            <p>お問い合わせフォーム</p>
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
                                            <div class="chat_content"><p>{{$value}}</p></div>
                                        @endif

                                    @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        <form method="POST" action="">
                            @csrf
                            <div class="chat_submit">
                                <textarea name="comment" class="chat_textarea" required></textarea>
                                @if (isset($whose))
                                    {{-- <input type="hidden" name="contact_id" value="{{$contact_id}}"> --}}
                                    <input type="hidden" name="whose" value="{{$whose}}">
                                @endif
                                @if (!isset($param))
                                    <input type="hidden" name="name" value="{{$item->user_name}}">
                                    <input type="hidden" name="mail" value="{{$item->user_mail}}">
                                    <input type="hidden" name="phone" value="{{$item->user_phone}}">
                                @endif
                                <input type="submit" class="chat_btn" value="送信">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script language="javascript" type="text/javascript">
            //タブ切り替え
            $('.tab-buttons span').click(function(){
            var thisclass=$(this).attr('class');
            console.log(thisclass);
            localStorage.setItem('current', thisclass);
            $('#lamp').removeClass().addClass('#lamp').addClass(thisclass);
            $('.tab-content>div').each(function(){
                if($(this).hasClass(thisclass)){
                    $(this).fadeIn(800);
                    if (thisclass == "content1") {
                        var id =  $('.tab-buttons>span').removeAttr('id');
                        var conte = $('.tab-buttons>.content1').attr('id', 'point');
                    }
                    if (thisclass == "content2") {
                        var id =  $('.tab-buttons>span').removeAttr('id');
                        var conte = $('.tab-buttons>.content2').attr('id', 'point');
                    }

                }
                else{
                $(this).hide();
                }
            });
            });

            // 初期時は非表示
            document.getElementById("question_content1").style.display ="none";
            document.getElementById("question_content2").style.display ="none";
            document.getElementById("question_content3").style.display ="none";

            function OnLinkClickVisibly1(){
                const question_status = document.getElementById("question_content1");

                if(question_status.style.display=="block"){
                    // noneで非表示
                    question_status.style.display ="none";
                }else{
                    // blockで表示
                    question_status.style.display ="block";
                }
            }
            function OnLinkClickVisibly2(){
                const question_status = document.getElementById("question_content2");

                if(question_status.style.display=="block"){
                    // noneで非表示
                    question_status.style.display ="none";
                }else{
                    // blockで表示
                    question_status.style.display ="block";
                }
            }
            function OnLinkClickVisibly3(){
                const question_status = document.getElementById("question_content3");

                if(question_status.style.display=="block"){
                    // noneで非表示
                    question_status.style.display ="none";
                }else{
                    // blockで表示
                    question_status.style.display ="block";
                }
            }
        </script>
    </body>
    @include('influencer.component.footer')
</html>
