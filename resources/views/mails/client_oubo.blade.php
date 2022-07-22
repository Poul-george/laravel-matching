<p>
    {{$param['shop_name']}}　{{$param['shop_tantou']}}様
</p>
@if ($param['result']==="採用")
    <p>この度は{{config('const.title.title45')}}をご利用いただきまして、誠にありがとうございます。</p>

    <p>システム利用につきまして、IDとパスワードのご連絡をさせていただきます。</p>

    <p>ID：</p>
    <p>{{$param['account']}}</p>
    <br>
    <p>パスワード：</p>
    <p>{{$param['password']}}</p>
    <br>

    <p>下記より、本登録をお願いいたします。<br>
        <a href="https://longopmatch.jsrx/{{config('const.title.title47')}}">https://longopmatch.jsrx.jp/{{config('const.title.title47')}}</a>
    </p>
@else
    <p>この度は{{config('const.title.title45')}}をご利用いただきまして、誠にありがとうございます。</p>

    <p>残念ですが、不採用となりました。</p>
@endif

<p>☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆</p>
<br>
<p>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>
