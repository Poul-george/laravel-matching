<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ secure_asset('/css/admin.css') }}" rel="stylesheet">
  {{-- <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet"> --}}
  <link href="{{ secure_asset('/css/form.css') }}" rel="stylesheet">
  <title>{{config('const.title.title28')}}</title>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  {{-- @include('client.component.header') --}}
  <h3>{{config('const.title.title28')}}</h3>

  @if (session('msgs'))
    <p class="error">{{session('msgs')}}</p>
  @endif

  <form class="questionnaire_form" action="./create_matter_confirm" method="post" enctype="multipart/form-data">
    @csrf
    <p class="questionnaire_input_p">{{config('const.title.title3')}}ID<small class="hissu">※必須</small></p>
    <input class="input_text" type="text" name="shop_id" value="{{$param['shop_id']}}" required>
    @if ($item_config->client_name==="T")
        <p class="questionnaire_input_p">企業名（店舗名）<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="name" value="{{$param['shop_name']}}" required>
    @else
        <p class="questionnaire_input_p">企業名（店舗名）</p>
        <input class="input_text" type="text" name="name" value="{{$param['shop_name']}}">
    @endif

    @if ($item_config->client_tantou==="T")
        <p class="questionnaire_input_p">ご担当者名<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="tantou" value="{{$param['shop_tantou']}}" required>
    @else
        <p class="questionnaire_input_p">ご担当者名</p>
        <input class="input_text" type="text" name="tantou" value="{{$param['shop_tantou']}}">
    @endif

    @if ($item_config->client_mail==="T")
        <p class="questionnaire_input_p">ご連絡先(電話番号)<small class="hissu">※必須</small></p>
        <input class="input_text" type="tel" name="tel01" value="{{$param['shop_phone']}}" required>
    @else
        <p class="questionnaire_input_p">ご連絡先(電話番号)</p>
        <input class="input_text" type="tel" name="tel01" value="{{$param['shop_phone']}}">
    @endif

    @if ($item_config->client_area==="T")
        <p class="questionnaire_input_p">郵便番号 (例 100-0000 or 1000000)<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="area" value="{{$param['shop_area']}}" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" required>
    @else
        <p class="questionnaire_input_p">郵便番号 (例 100-0000 or 1000000)</p>
        <input class="input_text" type="text" name="area" value="{{$param['shop_area']}}" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');">
    @endif

    @if ($item_config->client_address==="T")
        <p class="questionnaire_input_p">所在地<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="address" value="{{$param['shop_address']}}" size="60" required>
    @else
        <p class="questionnaire_input_p">所在地</p>
        <input class="input_text" type="text" name="address" value="{{$param['shop_address']}}" size="60">
    @endif

    @if ($item_config->client_url==="T")
        <p class="questionnaire_input_p">URL<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="shop_url" value="{{$param['shop_url']}}" required>
    @else
        <p class="questionnaire_input_p">URL</p>
        <input class="input_text" type="text" name="shop_url" value="{{$param['shop_url']}}">
    @endif

    @if ($item_config->close_date==="T")
        <p class="questionnaire_input_p">定休日・店休日<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="close_date" value="{{$param['shop_close_date']}}" required>
    @else
        <p class="questionnaire_input_p">定休日・店休日</p>
        <input class="input_text" type="text" name="close_date" value="{{$param['shop_close_date']}}">
    @endif

    @if ($item_config->open_time==="T")
        <p class="questionnaire_input_p">営業時間<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="open_time" value="{{$param['shop_open_time']}}" required>
    @else
        <p class="questionnaire_input_p">営業時間</p>
        <input class="input_text" type="text" name="open_time" value="{{$param['shop_open_time']}}">
    @endif

    @if ($item_config->gather_before==="T" && $item_config->gather_after==="T")
        <p class="questionnaire_input_p">募集期間<small class="hissu">※必須</small></p>
    @elseif ($item_config->gather_before==="T" && $item_config->gather_after==="F")
        <p class="questionnaire_input_p">募集期間<small class="hissu">※募集開始日のみ必須</small></p>
    @elseif ($item_config->gather_before==="F" && $item_config->gather_after==="T")
        <p class="questionnaire_input_p">募集期間<small class="hissu">※募集期限日のみ必須</small></p>
    @else
        <p class="questionnaire_input_p">募集期間<small class="hissu">※任意</small></p>
    @endif
    <div class="cp_ipselect_div">
      <div class="cp_ipselect">
        @if ($item_config->gather_before==="T")
          <select class="cp_sl06" name="year1" required>
        @else
          <select class="cp_sl06" name="year1">
        @endif
          <option value="" hidden disabled selected></option>
          @if ($param['year1']===$thisyear)
            <option value="{{$thisyear}}" selected>{{$thisyear}}</option>
          @else
            <option value="{{$thisyear}}">{{$thisyear}}</option>
          @endif
          @if ($param['year1']===$nextyear)
            <option value="{{$nextyear}}" selected>{{$nextyear}}</option>
          @else
            <option value="{{$nextyear}}">{{$nextyear}}</option>
          @endif
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect mounth">
          @if ($item_config->gather_before==="T")
            <select class="cp_sl06" name="month1" required>
          @else
            <select class="cp_sl06" name="month1">
          @endif
          <option value="" hidden disabled selected></option>
          @for ($i=1;$i<=12;$i++)
            @if ($param['month1']===strval($i))
                <option value="{{$i}}" selected>{{$i}}</option>
            @else
                <option value="{{$i}}">{{$i}}</option>
            @endif
          @endfor
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect day">
        @if ($item_config->gather_before==="T")
            <select class="cp_sl06" name="date1" required>
        @else
            <select class="cp_sl06" name="date1">
        @endif
          <option value="" hidden disabled selected></option>
          @for ($i=1;$i<=31;$i++)
            @if ($param['date1']===strval($i))
                <option value="{{$i}}" selected>{{$i}}</option>
            @else
                <option value="{{$i}}">{{$i}}</option>
            @endif
          @endfor
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>
    </div>

    <p class="kigo">～</p>

    <div class="cp_ipselect_div">
      <div class="cp_ipselect">
        @if ($item_config->gather_after==="T")
            <select class="cp_sl06" name="year2" required>
        @else
            <select class="cp_sl06" name="year2">
        @endif
          <option value="" hidden disabled selected></option>
          @if ($param['year2']===$thisyear)
            <option value="{{$thisyear}}" selected>{{$thisyear}}</option>
          @else
            <option value="{{$thisyear}}">{{$thisyear}}</option>
          @endif
          @if ($param['year2']===$nextyear)
            <option value="{{$nextyear}}" selected>{{$nextyear}}</option>
          @else
            <option value="{{$nextyear}}">{{$nextyear}}</option>
          @endif
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect mounth">
        @if ($item_config->gather_after==="T")
            <select class="cp_sl06" name="month2" required>
        @else
            <select class="cp_sl06" name="month2">
        @endif
          <option value="" hidden disabled selected></option>
          @for ($i=1;$i<=12;$i++)
            @if ($param['month2']===strval($i))
                <option value="{{$i}}" selected>{{$i}}</option>
            @else
                <option value="{{$i}}">{{$i}}</option>
            @endif
          @endfor
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>

      <div class="cp_ipselect day">
        @if ($item_config->gather_after==="T")
            <select class="cp_sl06" name="date2" required>
        @else
            <select class="cp_sl06" name="date2">
        @endif
          <option value="" hidden disabled selected></option>
          @for ($i=1;$i<=31;$i++)
            @if ($param['date2']===strval($i))
                <option value="{{$i}}" selected>{{$i}}</option>
            @else
                <option value="{{$i}}">{{$i}}</option>
            @endif
          @endfor
        </select>
        <span class="cp_sl06_highlight"></span>
        <span class="cp_sl06_selectbar"></span>
      </div>
    </div><br>

    @if ($item_config->matter_img==="T" && empty($filepath_list))
        <div class="attachment">
            <p class="questionnaire_input_p">イメージ画像（3～5枚）<small class="hissu">※必須</small></p>
            @for ($i=1;$i<=5;$i++)
                <div id="attachment{{$i}}" class="file_up_div">
                    @if ($i<=3)
                        <label><input type="file" multiple name="matter_img[]" value="matter_img" class="fileinput" accept=".png, .jpg, .jpeg" required>ファイルを添付する</label>
                    @else
                        <label><input type="file" multiple name="matter_img[]" value="matter_img" class="fileinput" accept=".png, .jpg, .jpeg">ファイルを添付する</label>
                    @endif
                        <span class="filename">選択されていません</span>
                </div>
            @endfor
        </div><br>

        <input type="hidden" name="filepath[]" value="">
    @else
        <div class="attachment">
            <p class="questionnaire_input_p">イメージ画像<small class="hissu"></small></p>
            @for ($i=1;$i<=5;$i++)
                <div id="attachment{{$i}}" class="file_up_div">
                    <label><input type="file" multiple name="matter_img[]" value="matter_img" class="fileinput" accept=".png, .jpg, .jpeg">ファイルを添付する</label>
                    <span class="filename">選択されていません</span>
                </div>
            @endfor
        </div><br>
        @if (!empty($filepath_list))
            <p>※変更する場合は下記の画像も重複してご登録ください。</p>
            <div class="img_area">
                @foreach ($filepath_list as $value)
                    @if (!empty($value))
                        <div class="img_box">
                            <img src="{{ asset("laravel/public/storage/matter_img/$value") }}" alt="img">
                        </div>
                        <input type="hidden" name="filepath[]" value="{{$value}}">
                    @endif
                @endforeach
            </div>
        @endif
    @endif

    @if ($item_config->matter_genre==="T")
        <p class="questionnaire_input_p">ジャンル・カテゴリ<small class="hissu">※一つ以上必須</small></p>
        <div class="checkbox_div">
        <?php $i=1; ?>
        @foreach ($matter_genre as $key=>$value)
            @if (in_array($key,$checkbox))
                <div><input class="input_checkbox check_once" name="checkbox[]" value="{{$key}}" type="checkbox" id="genre-{{$i}}" checked><label for="genre-{{$i}}">{{$value}}</label></div>
            @else
                <div><input class="input_checkbox check_once" name="checkbox[]" value="{{$key}}" type="checkbox" id="genre-{{$i}}"><label for="genre-{{$i}}">{{$value}}</label></div>
            @endif
            <?php $i+=1; ?>
        @endforeach
        </div>
    @else
        <p class="questionnaire_input_p">ジャンル・カテゴリ</p>
        <div class="checkbox_div">
        <?php $i=1; ?>
        @foreach ($matter_genre as $key=>$value)
            @if (in_array($key,$checkbox))
                <div><input class="input_checkbox" name="checkbox[]" value="{{$key}}" type="checkbox" id="genre-{{$i}}"><label for="genre-{{$i}}" checked>{{$value}}</label></div>
            @else
                <div><input class="input_checkbox" name="checkbox[]" value="{{$key}}" type="checkbox" id="genre-{{$i}}"><label for="genre-{{$i}}">{{$value}}</label></div>
            @endif
            <?php $i+=1; ?>
        @endforeach
        </div>
    @endif

    @if ($item_config->intro_text==="T")
        <p class="questionnaire_input_p">店舗紹介文<small class="hissu">※必須</small></p>
        <textarea class="input_textarea" placeholder="" name="intro_text" required>{{$param['intro_text']}}</textarea>
    @else
        <p class="questionnaire_input_p">店舗紹介文</p>
        <textarea class="input_textarea" placeholder="" name="intro_text">{{$param['intro_text']}}</textarea>
    @endif

    @if ($item_config->able_date1==="T")
        <p class="questionnaire_input_p">予約可能日時<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" name="able_datetime" value="{{$param['able_datetime']}}" size="60" required>
    @else
        <p class="questionnaire_input_p">予約可能日時</p>
        <input class="input_text" type="text" name="able_datetime" value="{{$param['able_datetime']}}" size="60">
    @endif

    <p class="questionnaire_input_p">予約可能時間</p>
    <input class="input_text" type="text" name="able_time" value="{{$param['able_time']}}" size="60">

    <p class="questionnaire_input_p">予約NG日</p>
    <input class="input_text" type="text" name="not_able_date" value="{{$param['not_able_date']}}" size="60">



    @if ($item_config->least_follower==="T")
        <p class="questionnaire_input_p">応募条件(フォロワー数)<small class="hissu">※必須</small></p>
    @else
        <p class="questionnaire_input_p">応募条件(フォロワー数)</p>
    @endif
    <div class="radio_div">
      <ul>
        <?php $j=0; ?>
        @foreach ($follower as $key=>$value)
            @if ($j>0)
                <li>
                    @if ($item_config->least_follower==="T")
                        @if ($param['least_follower']===$key)
                            <input type="radio" id="{{$j}}-follower" name="selector1" value="{{$key}}" checked required>
                        @else
                            <input type="radio" id="{{$j}}-follower" name="selector1" value="{{$key}}" required>
                        @endif
                    @else
                        @if ($param['least_follower']===$key)
                            <input type="radio" id="{{$j}}-follower" name="selector1" value="{{$key}}" checked>
                        @else
                            <input type="radio" id="{{$j}}-follower" name="selector1" value="{{$key}}">
                        @endif
                    @endif
                <label for="{{$j}}-follower">{{$value}}</label>
                <div class="check"></div>
                </li>
            @endif
            <?php $j+=1; ?>
        @endforeach
        {{-- <li>
          <input type="radio" id="2-follower" name="selector1" value="B">
          <label for="2-follower">10000人以上</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="3-follower" name="selector1" value="C">
          <label for="3-follower">15000人以上</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="4-follower" name="selector1" value="D">
          <label for="4-follower">20000人以上</label>
          <div class="check"><div class="inside"></div></div>
        </li>
        <li>
          <input type="radio" id="5-follower" name="selector1" value="E">
          <label for="5-follower">30000人以上</label>
          <div class="check"><div class="inside"></div></div> --}}
        {{-- </li> --}}
      </ul>
    </div>

    <p class="questionnaire_input_p">募集人数<small class="hissu">※必須</small></p>
    <input class="input_text" type="number" placeholder="募集人数の記入(数字のみ)" name="matter_num" value="{{$param['matter_num']}}" required>


    @if ($item_config->reward==="T")
        <p class="questionnaire_input_p">報酬内容<small class="hissu">※必須</small></p>
        <input class="input_text" type="number" placeholder="報酬の記入(数字のみ)" name="reward" value="{{$param['reward']}}" required>
    @else
        <p class="questionnaire_input_p">報酬内容</p>
        <input class="input_text" type="number" placeholder="報酬の記入(数字のみ)" name="reward" value="{{$param['reward']}}">
    @endif

    @if ($item_config->serve_menu==="T")
        <p class="questionnaire_input_p">提供メニュー<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="" name="menu" value="{{$param['serve_menu']}}" required>
    @else
        <p class="questionnaire_input_p">提供メニュー</p>
        <input class="input_text" type="text" placeholder="" name="menu" value="{{$param['serve_menu']}}">
    @endif

    @if ($item_config->serve_value==="T")
        <p class="questionnaire_input_p">メニュー料金 例)10,000円相当<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="" name="serve_value" value="{{$param['serve_value']}}" required>
    @else
        <p class="questionnaire_input_p">メニュー料金 例)10,000円相当</p>
        <input class="input_text" type="text" placeholder="" name="serve_value" value="{{$param['serve_value']}}">
    @endif

    @if ($item_config->companion_num==="T")
        <p class="questionnaire_input_p">同伴者人数<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="" name="companion_num" value="{{$param['companion_num']}}" required>
    @else
        <p class="questionnaire_input_p">同伴者人数</p>
        <input class="input_text" type="text" placeholder="" name="companion_num" value="{{$param['companion_num']}}">
    @endif


    @if ($item_config->post_sns==="T")
        <p class="questionnaire_input_p">投稿SNS<small class="hissu">※一つ以上必須</small></p>
        <div class="checkbox_div">
            <?php $j=1; ?>
            @foreach ($matter_sns as $key=>$value)
                @if (in_array($key,$checkbox1))
                    <div><input class="input_checkbox check_once1" name="checkbox1[]" value="{{$key}}" type="checkbox" id="box-{{$j}}" checked><label for="box-{{$j}}">{{$value}}</label></div>
                @else
                    <div><input class="input_checkbox check_once1" name="checkbox1[]" value="{{$key}}" type="checkbox" id="box-{{$j}}"><label for="box-{{$j}}">{{$value}}</label></div>
                @endif
                <?php $j+=1; ?>
            @endforeach
        </div>
    @else
        <p class="questionnaire_input_p">投稿SNS</p>
        <div class="checkbox_div">
            <?php $j=1; ?>
            @foreach ($matter_sns as $key=>$value)
                @if (in_array($key,$checkbox1))
                    <div><input class="input_checkbox check_once1" name="checkbox1[]" value="{{$key}}" type="checkbox" id="box-{{$j}}" checked><label for="box-{{$j}}">{{$value}}</label></div>
                @else
                    <div><input class="input_checkbox check_once1" name="checkbox1[]" value="{{$key}}" type="checkbox" id="box-{{$j}}"><label for="box-{{$j}}">{{$value}}</label></div>
                @endif
                <?php $j+=1; ?>
            @endforeach
        </div>
    @endif

    @if ($item_config->term==="T")
        <p class="questionnaire_input_p">投稿条件<small class="hissu">※一つ以上必須</small></p>
    @else
        <p class="questionnaire_input_p">投稿条件</p>
    @endif
    <div class="checkbox_div">
        @if ($item_config->term==="T")
            @for ($i=1;$i<=10;$i++)
                @if (in_array(strval($i),$checkbox2))
                    <div><input class="input_checkbox check_once2" name="checkbox2[]" value="{{$i}}" type="checkbox" id="term-{{$i}}" checked><label for="term-{{$i}}">{{config("list.term.term$i")}}</label></div>
                @else
                    <div><input class="input_checkbox check_once2" name="checkbox2[]" value="{{$i}}" type="checkbox" id="term-{{$i}}"><label for="term-{{$i}}">{{config("list.term.term$i")}}</label></div>
                @endif
            @endfor
        @else
            @for ($i=1;$i<=10;$i++)
                @if (in_array(strval($i),$checkbox2))
                    <div><input class="input_checkbox check_once2" name="checkbox2[]" value="{{$i}}" type="checkbox" id="term-{{$i}}" checked><label for="term-{{$i}}">{{config("list.term.term$i")}}</label></div>
                @else
                    <div><input class="input_checkbox check_once2" name="checkbox2[]" value="{{$i}}" type="checkbox" id="term-{{$i}}"><label for="term-{{$i}}">{{config("list.term.term$i")}}</label></div>
                @endif
            @endfor
        @endif

    </div>

    <p class="questionnaire_input_p">その他投稿条件がある場合は記入をお願いします。</p>
    @foreach ($post_conditions as $value)
        <input class="input_text" type="text" placeholder="自由記入" name="post_conditions[]" value="{{$value}}">
    @endforeach

    @if ($item_config->hashtag==="T")
        <p class="questionnaire_input_p">指定ハッシュタグ<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="ハッシュタグの記入" name="hashtag" value="{{$param['hashtag']}}" required>
    @else
        <p class="questionnaire_input_p">指定ハッシュタグ</p>
        <input class="input_text" type="text" placeholder="ハッシュタグの記入" name="hashtag" value="{{$param['hashtag']}}">
    @endif

    @if ($item_config->tag_account==="T")
        <p class="questionnaire_input_p">タグ付け用アカウント<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="" name="tag_account" value="{{$param['tag_account']}}" required>
    @else
        <p class="questionnaire_input_p">タグ付け用アカウント</p>
        <input class="input_text" type="text" placeholder="" name="tag_account" value="{{$param['tag_account']}}">
    @endif

    @if ($item_config->location==="T")
        <p class="questionnaire_input_p">位置情報<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="" name="location" value="{{$param['location']}}" required>
    @else
        <p class="questionnaire_input_p">位置情報</p>
        <input class="input_text" type="text" placeholder="" name="location" value="{{$param['location']}}">
    @endif

    @if ($item_config->post_deadline==="T")
        <p class="questionnaire_input_p">Instagramへの投稿期限<small class="hissu">※必須</small></p>
    @else
        <p class="questionnaire_input_p">Instagramへの投稿期限</p>
    @endif
    <div class="radio_div">
      <ul>
        <?php $j=3; ?>
        @foreach ($deadline as $key=>$value)
            @if ($j>3)
                <li>
                    @if ($item_config->post_deadline==="T")
                        @if ($param['post_deadline']===$key)
                            <input type="radio" id="{{$j}}-option" name="selector2" value="{{$key}}" checked required>
                        @else
                            <input type="radio" id="{{$j}}-option" name="selector2" value="{{$key}}" required>
                        @endif
                    @else
                        @if ($param['post_deadline']===$key)
                            <input type="radio" id="{{$j}}-option" name="selector2" value="{{$key}}" checked>
                        @else
                            <input type="radio" id="{{$j}}-option" name="selector2" value="{{$key}}">
                        @endif
                    @endif
                <label for="{{$j}}-option">{{$value}}</label>
                <div class="check"></div>
                </li>
            @endif
            <?php $j+=1; ?>
        @endforeach
      </ul>
    </div>

    @if ($item_config->story_url==="T")
        <p class="questionnaire_input_p">ストーリーズ用URL<small class="hissu">※必須</small></p>
        <input class="input_text" type="text" placeholder="URL" name="story_url" value="{{$param['story_url']}}" required>
    @else
        <p class="questionnaire_input_p">ストーリーズ用URL</p>
        <input class="input_text" type="text" placeholder="URL" name="story_url" value="{{$param['story_url']}}">
    @endif

    @if ($item_config->notice==="T")
        <p class="questionnaire_input_p">投稿に関する注意事項<small class="hissu">※一つ以上必須</small></p>
    @else
        <p class="questionnaire_input_p">投稿に関する注意事項</p>
    @endif
    <div class="checkbox_div">
        @if ($item_config->term==="T")
            @for ($i=1;$i<=8;$i++)
                @if (in_array(strval($i),$checkbox3))
                    <div><input class="input_checkbox check_once3" name="checkbox3[]" value="{{$i}}" type="checkbox" id="notice-{{$i}}" checked><label for="notice-{{$i}}">{{config("list.notice.notice$i")}}</label></div>
                @else
                    <div><input class="input_checkbox check_once3" name="checkbox3[]" value="{{$i}}" type="checkbox" id="notice-{{$i}}"><label for="notice-{{$i}}">{{config("list.notice.notice$i")}}</label></div>
                @endif
            @endfor
        @else
            @for ($i=1;$i<=8;$i++)
                @if (in_array(strval($i),$checkbox3))
                    <div><input class="input_checkbox" name="checkbox3[]" value="{{$i}}" type="checkbox" id="notice-{{$i}}" checked><label for="notice-{{$i}}">{{config("list.notice.notice$i")}}</label></div>
                @else
                    <div><input class="input_checkbox" name="checkbox3[]" value="{{$i}}" type="checkbox" id="notice-{{$i}}"><label for="notice-{{$i}}">{{config("list.notice.notice$i")}}</label></div>
                @endif
            @endfor
        @endif
    </div>
    <p class="questionnaire_input_p">その他投稿に関する注意事項がある場合は記入をお願いします。</p>
    @foreach ($post_conditions2 as $value)
        <input class="input_text" type="text" placeholder="自由記入" name="post_conditions2[]" value="{{$value}}">
    @endforeach





    <div class="space_div" ></div>

    <input type="hidden" name="hidden" value="admin">
    <input class="input_submit" type="submit" onClick="Check_checkbox()" value="送信">

  </form>

</body>

<script type="text/javascript">
  $('#attachment1 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment1').find('.filename').text(file.name);
   });
  $('#attachment2 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment2').find('.filename').text(file.name);
   });
  $('#attachment3 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment3').find('.filename').text(file.name);
   });
  $('#attachment4 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment4').find('.filename').text(file.name);
   });
  $('#attachment5 .fileinput').on('change', function () {
    var file = $(this).prop('files')[0];
    $(this).closest('#attachment5').find('.filename').text(file.name);
   });

   function Check_checkbox() {
	var checkbox1 = document.getElementById("genre-1");
	var checkbox2 = document.getElementById("box-1");
	var checkbox3 = document.getElementById("term-1");
	var checkbox4 = document.getElementById("notice-1");

    if (checkbox1.classList.contains('check_once')){
        var arr_checkBoxes = document.getElementsByClassName("check_once");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
        } else {
            window.alert("ジャンル・カテゴリの項目を1つ以上選択してください。");
            return false;
        }
    }
    if (checkbox2.classList.contains('check_once1')){

        var arr_checkBoxes = document.getElementsByClassName("check_once1");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
        } else {
            window.alert("投稿SNSの項目を1つ以上選択してください。");
            return false;
        }
    }
    if (checkbox3.classList.contains('check_once2')){
        var arr_checkBoxes = document.getElementsByClassName("check_once2");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
        } else {
            window.alert("投稿条件の項目を1つ以上選択してください。");
            return false;
        }
    }
    if (checkbox4.classList.contains('check_once3')){
        var arr_checkBoxes = document.getElementsByClassName("check_once3");
        var count = 0;
        for (var i = 0; i < arr_checkBoxes.length; i++) {
            if (arr_checkBoxes[i].checked) {
                count++;
            }
        }
        if (count > 0) {
            return true;
        } else {
            window.alert("投稿に関する注意事項の項目を1つ以上選択してください。");
            return false;
        }
    }
}
</script>

</html>


