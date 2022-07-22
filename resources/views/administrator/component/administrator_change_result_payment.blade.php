<?php
  $payment_select_submit = session()->get('payment_select_submit');
  // var_dump($payment_select_submit);
?>

<div class="mypage_edit_url_div">
    <ul class="mypage_edit_url_ul">
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if (empty($payment_select_submit) || $payment_select_submit == null)
              <input type="submit" class="select_submit_contacts" value="全て" name="set_session_1" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="全て" name="set_session_1">
            @endif
          </form>
        </li>
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if ($payment_select_submit == "1")
              <input type="submit" class="select_submit_contacts" value="未払い" name="set_session_2" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="未払い" name="set_session_2" >
            @endif
          </form>
        </li>
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if ($payment_select_submit == "2")
              <input type="submit" class="select_submit_contacts" value="支払完了" name="set_session_3" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="支払完了" name="set_session_3" >
            @endif
          </form>
        </li>
    </ul>
</div>
