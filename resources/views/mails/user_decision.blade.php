<?php

  $contracts_num = 0;
  $contracts_user_num = 0;

?>

<p>案件名：{{$mail_param['form_name']}}の人材確定が完了しました。<br>
</p>

<p>人材確定契約情報<br>
</p>
<p>契約人数：{{$mail_param['users_count']}}名<br>
</p>
@foreach ($mail_param['all_contacts_id'] as $contracts_id)
<?php $contracts_user_num=0?>
<p>
  契約ID：{{$contracts_id}}<br>
  @foreach ($mail_param['all_users_name'] as $contracts_user_name)
    @if ($contracts_num == $contracts_user_num)
      契約人材名：{{$contracts_user_name}}<br>
    @endif
      <?php $contracts_user_num++?>
  @endforeach
</p>
<?php $contracts_num++?>
@endforeach

<p>
    下記のURLから契約情報の一覧が確認ができます。<br>
    <a href="http://longopmatch.xsrv.jp/client1/client_account/my_contracts_all">
    http://longopmatch.xsrv.jp/client1/client_account/my_contracts_all
    </a>
</p>


<p>
    ーーーーーーーーーーーーー<br>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>