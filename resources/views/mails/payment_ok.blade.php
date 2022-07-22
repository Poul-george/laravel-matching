

<p>お支払いID：{{$mail_param['form_name']}}のお支払いが完了しました。<br>
</p>

<p>
  支払い情報<br><br>
  支払情報ID：{{$mail_param['form_name']}}<br>
  支払金額：{{$mail_param['payment_money']}}円<br>
  支払期限：{{$mail_param['payment_term']}}<br>
  支払日時：{{$mail_param['payment_day']}}<br>
</p>

<p>
    領収書発行は、支払情報、支払完了情報から一度のみ発行できます。<br>
</p>
<p>
    ご利用ありがとうございました。<br>
</p>

<p>
    下記のURLから支払済み一覧が確認ができます。<br>
    <a href="http://longopmatch.xsrv.jp/client1/client_account/payment">
    http://longopmatch.xsrv.jp/client1/client_account/payment
    </a>
</p>


<p>
    ーーーーーーーーーーーーー<br>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>