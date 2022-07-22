<p>契約ID：{{$mail_param['form_name']}}の人材稼働確認が完了しました。<br>
</p>

@if ($mail_param['user_judge'] == '2')
<p>契約ID：{{$mail_param['form_name']}}<br>
</p>
<p>契約人材：{{$mail_param['contract_user_name']}}<br>
</p>
<p>人材稼働確認結果：稼働できた<br>
</p>
<p>人材が3ヶ月稼働できたので、システム利用料のお支払いがあります。<br>
以下お支払い内容になります。<br>
</p>

<p>
  支払い情報<br><br>
  支払情報ID：{{$mail_param['form_name']}}<br>
  支払金額：{{$mail_param['payment_money']}}円<br>
  支払期限：{{$mail_param['payment_term']}}<br>
</p>

<p>
    お支払いページ<br>
    <a href="http://longopmatch.xsrv.jp/client1/client_account/payment">
    http://longopmatch.xsrv.jp/client1/client_account/payment
    </a><br>
</p>

<p>期限日までにお支払いいただきますようお願いします。<br>
</p>
@endif

@if ($mail_param['user_judge'] == '1')
<p>契約ID：{{$mail_param['form_name']}}<br>
</p>
<p>契約人材：{{$mail_param['contract_user_name']}}<br>
</p>
<p>人材稼働確認結果：稼働できなかった<br>
</p>
<p>稼働できなかった理由：{{$mail_param['reason_textarea']}}<br>
</p>
<p>今回人材の３ヶ月以上稼働ができなかったため、システム利用料のお支払いはありません。<br>
</p>
@endif

<p>
    longopmatchログイン<br>
    <a href="http://longopmatch.xsrv.jp/client1/client_account/my_all_issues">
    http://longopmatch.xsrv.jp/client1/client_account/my_all_issues
    </a>
</p>


<p>
    ーーーーーーーーーーーーー<br>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>