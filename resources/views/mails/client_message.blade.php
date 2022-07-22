<p>{{$mail_param["form_name"]}}からメッセージが届いています。<br>
</p>

<p>
    下記のURLからメッセージを確認できます。<br>
    @if (!empty($mail_param["send_administrator"]))
      @if ($mail_param["send_administrator"] == "1")
      <a href="http://longopmatch.xsrv.jp/administrator/messages">
      http://longopmatch.xsrv.jp/administrator/messages
      </a>
      @endif
    @endif

    @if (!empty($mail_param["send_user"]))
      @if ($mail_param["send_user"] == "1")
      <a href="http://longopmatch.xsrv.jp/client2/user_account/messages">
      http://longopmatch.xsrv.jp/client2/user_account/messages
      </a>
      @endif
    @endif

    @if (!empty($mail_param["send_client"]))
      @if ($mail_param["send_client"] == "1")
      <a href="http://longopmatch.xsrv.jp/client1/client_account/messages">
      http://longopmatch.xsrv.jp/client1/client_account/messages
      </a>
      @endif
    @endif
</p>

<p>
    ーーーーーーーーーーーーー<br>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>