<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/matter_syousai.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/matter_syousai.css') }}" rel="stylesheet">
        <title>{{config('const.title.title19')}}</title>
    </head>
    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.title.title19')}}</h3>
        </div>
        <div class="top_right">
            {{-- <li><a href="../admin_influ_2">戻る</a></li> --}}
            {{-- <li><a href="/logout">ログアウト</a></li> --}}
        </div>
        <div class="main_form">
            <div class="main_form_body">
                <div class="syousai_iconbox">
                    <p class="title_p">{{$item->shop_name}}</p>
                    <div class="itiran_location">
                    <div class="location_icon"></div><p class="moyori_p">{{$item_shop->shop_station}}</p>
                    </div>
                    <div class="itiran_follower">
                        <div class="follower_icon"></div><div><p class="follower_p">{{$follower[$item->least_follower]}}</p></div>
                    </div>
                    <div class="itiran_genre">
                        @for ($i=1;$i<=10;$i++)
                            @if ($item->{"matter_genre$i"}==="T")
                                <p class="genre_p">{{$matter_genre_name["matter_genre$i"]}}</p>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class='tabs'>
                    <div class='tab-buttons'>
                      <span id="point" class='content1'>店舗紹介</span>
                      <span id="" class='content2'>SNS条件</span>
                      <span id="" class='content3'>店舗詳細</span>
                    </div>
                      <div id='lamp' class='content1'></div>

                    <div class='tab-content'>

                      <div class='content1'>
                        <main>
                            @for ($i=1;$i<=5;$i++)
                                @if (!empty($item->{"matter_img$i"}) && $item->{"matter_img$i"}!=="")
                                    <?php $imgname=$item->{"matter_img$i"}; ?>
                                    @if ($i===1)
                                        <img class="main block" src="{{ asset("laravel/public/storage/matter_img/$imgname")}}">
                                    @else
                                        <img class="main" src="{{ asset("laravel/public/storage/matter_img/$imgname")}}">
                                    @endif
                                @endif
                            @endfor


                          <nav class="syousai_nav">
                            <ul>
                              <li id="next"><div class="arrow-right"></div></li>
                              <li id="prev" ><div class="arrow-left icon"></div></li>
                            </ul>
                          </nav>

                          <ul class="thumbnails"></ul>
                        </main>

                        <!-- 本文（説明文） -->
                        <div class="main_midasi_bunn">
                          <p class="midasi_bunn_p">{{$item->intro_text}}</p>
                          {{-- <p class="midasi_bunn_p">
                            <label>＜アピールポイント＞</label>
                            <br>
                            テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,テスト,
                          </p> --}}
                        </div>

                      <!-- 店舗URL -->
                        <div class="store_url_div">
                          <p class="store_url_p">
                            店舗URL
                          </p>
                          <p class="store_url_p and_a">
                            <a class="store_url_a" href="{{$item->shop_url}}">{{$item->shop_url}}</a>
                          </p>

                        </div>

                      <!-- 提供内容・条件 -->
                        <div class="store_nakami_div">
                          <hr class="hr_bor">

                          <h3 class="nakami_h3">{{$item->shop_name}}のメニュー情報</h3>

                          <div class="course_menu_div">
                            {{-- <div>
                              <p class="course_p_main">コース料理</p>
                              <p class="course_p">江戸前寿司と江戸スイーツ</p>
                            </div> --}}

                            <p class="teikyou_p">提供メニュー</p>
                            <p class="teikyou_syousai_p">{{$item->serve_menu}}</p>

                            <div class="money_div">
                              <p class="teikyou_p">金額</p>
                              <p class="teikyou_syousai_p">{{$item->serve_value}}</p>
                            </div>

                            <div class="syoutai_div">
                              <p class="teikyou_p">招待人数</p>
                              <p class="teikyou_syousai_p">{{$item->companion_num}}</p>
                            </div>

                            <hr class="hr_bor">
                            <p class="teikyou_p">予約条件</p>
                            <p class="teikyou_syousai_p">予約可能日時</p>
                            <p class="yoyaku_kanou_p">・{{$item->able_datetime}}</p>
                            <p class="teikyou_syousai_p">予約可能時間</p>
                            <p class="yoyaku_kanou_p">・{{$item->able_time}}</p>
                            <p class="teikyou_syousai_p">予約NG日</p>
                            <p class="yoyaku_kanou_p">・{{$item->not_able_date}}</p>


                            <hr class="hr_bor">
                            <div class="money_div">
                              <p class="teikyou_p">報酬</p>
                              <p class="teikyou_syousai_p">{{$item->reward}}円</p>
                            </div>

                            <hr class="hr_bor">
                            <p class="teikyou_p">来店までの流れ</p>
                            <p class="teikyou_syousai_p">{{config('const.title.title2')}}として応募して頂いたあと、採用されましたら、こちらからご連絡を差し上げます。その後、具体的な来店日、報酬、メニュー詳細を決め、ご来店になります。</p>

                            <hr class="hr_bor">
                            <p class="teikyou_p">注意事項</p>
                            @foreach ($term as $key=>$value)
                                @if ($value==="T")
                                    <p class="teikyou_syousai_p">・{{$term_content[$key]}}</p>
                                @elseif ($value!=="" && $value!=="T" && $value!=="F")
                                <p class="teikyou_syousai_p">・{{$value}}</p>
                                @endif
                            @endforeach


                            <div class="money_div">
                              <p class="teikyou_p">募集期限</p>
                              <p class="teikyou_syousai_p">{{$item->gather_after}}</p>
                            </div>


                            <div class="money_div">
                              <p class="teikyou_p">投稿期限</p>
                              <p class="teikyou_syousai_p">{{$deadline[$item->post_deadline]}}</p>
                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- content1 -->


                      <!-- content2 -->
                      <div class='content2'>
                        <div class="sns_icon_div">
                        <div class="bookmark-solid icon"></div>
                        <p class="sns_title_p">SNS投稿条件</p>
                        </div>

                        <div class="sns_setumei_div">

                        <p class="sns_setumei_midasi_p">投稿SNS</p>
                        <div class="sns_post_div">
                            @foreach ($sns as $key=>$value)
                                @if ($value==="T")
                                    <p class="post_sns">{{$sns_list[$key]}}</p>
                                @endif
                            @endforeach
                        </div>

                        <p class="sns_setumei_midasi_p">投稿方法</p>
                        <div class="sns_houhou_div">
                        <p class="post_houhou_p">①キャプチャーのトップ画像または、お料理の写真を載せる。</p>
                        <p class="post_houhou_p">②ハッシュタグ[指定のタグ最低2個以上]を選択し投稿する。</p>
                        <p class="post_houhou_p">③店舗位置情報、店舗アカウントなどを付けて投稿する。</p>
                        </div>

                          <p class="sns_setumei_midasi_p">指定ハッシュタグ</p>
                          <div class="sns_htag_div">
                            <p class="post_h_tag">{{$item->hashtag}}</p>
                            <div class="clip_icon_btn_div">
                              <div class="import icon"></div>
                              <button class="clip_btn" id="btn">タグをコピー</button>
                            </div>
                          </div>



                          <p class="sns_setumei_midasi_p">指定タグ付け・メンション</p>
                          <div class="sns_htag_div">
                            <p class="post_h_tag2">{{$item->tag_account}}</p>
                            <div class="clip_icon_btn_div">
                              <div class="import icon"></div>
                              <button class="clip_btn" id="btn2">タグをコピー</button>
                            </div>
                          </div>

                          <p class="sns_setumei_midasi_p">投稿についてのお願い</p>
                          <div class="sns_houhou_div">
                            @foreach ($notice as $key=>$value)
                                @if ($value==="T")
                                    <p class="post_houhou_p">・{{$notice_content[$key]}}</p>
                                @elseif ($value!=="" && $value!=="T" && $value!=="F")
                                    <p class="post_houhou_p">・{{$value}}</p>
                                @endif
                            @endforeach

                          </div>


                          <p class="sns_setumei_midasi_p">ストーリーズ用URL</p>
                            <a class="sns_url_a" href="{{$item->story_url}}">{{$item->story_url}}</a>

                        </div>


                      </div>
                      <!-- content2 -->


                      <!-- content3 -->
                      <div class='content3'>
                        <p class="tennpo_zyouhou_p">店舗基本情報</p>
                        <p class="sns_setumei_midasi_p">店名</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$item_shop->shop_name}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">TEL</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$item_shop->shop_phone}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">住所</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$item_shop->shop_address}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">最寄り駅</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$item_shop->shop_station}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">営業時間</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$item_shop->shop_open_time}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">定休日</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$item_shop->shop_close_date}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">個室の有無</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$arinashi[$item_shop->shop_single_space]}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">お子様同伴</p>
                        <div class="sns_htag_div">
                          <p class="tennpo_name_p">{{$able[$item_shop->shop_child]}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">ペット同伴</p>
                        <div class="sns_htag_div">
                            <p class="tennpo_name_p">{{$able[$item_shop->shop_pet]}}</p>
                        </div>

                        <p class="sns_setumei_midasi_p">URL</p>
                        <div class="sns_htag_div">
                            <a class="tennpo_name_a" href="{{$item_shop->shop_url}}">{{$item_shop->shop_url}}</a>
                        </div>

                      </div>
                      <!-- content3 -->



                    </div>
                </div>


                @if ($last_url==="T")
                    <div class="chat_submit">
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$id}}">
                            <input type="hidden" name="shop_id" value="{{$shop_id}}">
                            <input type="hidden" name="shop_name" value="{{$shop_name}}">
                            <div class="chat_submit">
                                <input type="submit" class="chat_btn" name="confirm" value="この案件に応募する">
                            </div>

                        </form>
                        {{-- <p class="error_msg">選択してから送信してください。</p> --}}
                    </div>
                @endif

            </div><br>

        </div>

    </body>
    @include('influencer.component.footer')

    <!-- タブメニュー -->
<script type="text/javascript">
    $('.tab-content>div').hide();
    $('.tab-content>div').first().slideDown();
    $('.tab-buttons span').click(function(){
      var thisclass=$(this).attr('class');
      console.log(thisclass);
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
          if (thisclass == "content3") {
            var id =  $('.tab-buttons>span').removeAttr('id');
            var conte = $('.tab-buttons>.content3').attr('id', 'point');
          }


        }
        else{
          $(this).hide();
        }
      });
    });

  </script>



    <script>



          var btn = document.getElementById('btn');
            btn.addEventListener('click', function(e) {
                var copyTarget = document.querySelectorAll(".post_h_tag");
                let p_outerText = [];
                let text_dd = "";

                copyTarget.forEach(function (a) {
                  p_outerText.push(a.outerText);
                  text_dd = text_dd + " " + a.outerText;

                });
                console.log(text_dd);

                let clipboardText = "ggg";

                copy_to_clipboard(text_dd);
            });

          var btn = document.getElementById('btn2');
            btn.addEventListener('click', function(e) {
                var copyTarget = document.querySelectorAll(".post_h_tag2");
                let p_outerText = [];
                let text_dd = "";

                copyTarget.forEach(function (a) {
                  p_outerText.push(a.outerText);
                  text_dd = text_dd + " " + a.outerText;

                });
                console.log(text_dd);

                let clipboardText = "ggg";

                copy_to_clipboard(text_dd);
            });

            function copy_to_clipboard(value) {
                if(navigator.clipboard) {
                    var copyText = value;
                    navigator.clipboard.writeText(copyText).then(function() {
                        alert('コピーしました。');
                    });
                } else {
                    alert('対応していません。');
                }
            }


      </script>

<script type="text/javascript">
    'use strict';

  {


    const next = document.getElementById('next');
    next.addEventListener('click', () => {


    const mainImage = document.querySelectorAll('.main');
    let img_class = [];

     mainImage.forEach(function (a) {
       img_class.push(a.className);
     });
     console.log(img_class);

    let i = 1;
    let img_i = 1;
     img_class.forEach(function (a) {
       if (a === "main block") {
         img_i = i;
       }
       i++;
     });

    let count_i = 1;
      if (img_i !== img_class.length+1) {
        img_i += 1;
      }
      if (img_i == img_class.length+1) {
        img_i = 1;
      }
      console.log(img_i);

      mainImage.forEach(function (a) {
       a.classList.remove("block");
     });

      mainImage.forEach(function (a) {
        if (count_i === img_i) {
          a.classList.add("block");
        }
        count_i++;
      });

    });

    const prev = document.getElementById('prev');
    prev.addEventListener('click', () => {


    const mainImage = document.querySelectorAll('.main');
    let img_class = [];

     mainImage.forEach(function (a) {
       img_class.push(a.className);
     });
     console.log(img_class);

    let i = 1;
    let img_i = 1;
     img_class.forEach(function (a) {
       if (a === "main block") {
         img_i = i;
       }
       i++;
     });

    let count_i = 1;
      if (img_i !== 0) {
        img_i -= 1;
      }
      if (img_i == 0) {
        img_i = img_class.length;
      }

      console.log(img_i);

      mainImage.forEach(function (a) {
       a.classList.remove("block");
     });

      mainImage.forEach(function (a) {
        if (count_i === img_i) {
          a.classList.add("block");
        }
        count_i++;
      });


    });


  }
  </script>

</html>
