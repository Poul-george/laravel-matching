
<p>{{$mail_param['influ_name']}}様</p>
<p>いつも{{config('const.title.title45')}}をご利用いただき、ありがとうございます。</p>

@if ($mail_param['result']==="採用")
    <p>ご応募いただきました{{$mail_param['matter_name']}}採用のご連絡です。
            管理画面へログイン後、詳細の確認と日程調整を、3日以内にお願いいたします。</p>
    <br>
    <a href="http://longopmatch/{{config('const.title.title48')}}">http://longopmatch/{{config('const.title.title48')}}</a>
    <br>
    <p>よろしくお願いいたします。</p><br>
@else
    <p>ご応募いただきました{{$mail_param['matter_name']}}は不採用となりました。申し訳ございません。</p>
    <p>また、他の案件でも募集がございますので、もしよろしければご応募くださいませ。</p>
    <p>今後とも、よろしくお願いいたします。</p>

    <a href="http://longopmatch/{{config('const.title.title48')}}">http://longopmatch/{{config('const.title.title48')}}</a>
    <br><br>
@endif

<p>☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆</p>
<p>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>
