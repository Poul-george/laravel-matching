<?php
  $contacts_select_submit = session()->get('contacts_select_submit');
  // var_dump($contacts_select_submit);
?>

<div class="mypage_edit_url_div">
    <ul class="mypage_edit_url_ul">
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if (empty($contacts_select_submit) || $contacts_select_submit == null)
              <input type="submit" class="select_submit_contacts" value="全て" name="set_session_1" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="全て" name="set_session_1">
            @endif
          </form>
        </li>
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if ($contacts_select_submit == "2")
              <input type="submit" class="select_submit_contacts" value="満了三日以内" name="set_session_2" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="満了三日以内" name="set_session_2" >
            @endif
          </form>
        </li>
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if ($contacts_select_submit == "3")
              <input type="submit" class="select_submit_contacts" value="契約満了" name="set_session_3" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="契約満了" name="set_session_3">
            @endif
          </form>
        </li>
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if ($contacts_select_submit == "4")
              <input type="submit" class="select_submit_contacts" value="人材非稼働" name="set_session_4" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="人材非稼働" name="set_session_4">
            @endif
          </form>
        </li>
        <li class="mypage_edit_url_li">
          <form method="POST" action="">
            @csrf
            @if ($contacts_select_submit == "5")
              <input type="submit" class="select_submit_contacts" value="未払い" name="set_session_5" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="未払い" name="set_session_5">
            @endif
          </form>
        </li>
          <form method="POST" action="">
            @csrf
            @if ($contacts_select_submit == "6")
              <input type="submit" class="select_submit_contacts" value="支払完了" name="set_session_6" style="background: #00CC00; color:#fff">
            @else
              <input type="submit" class="select_submit_contacts" value="支払完了" name="set_session_6">
            @endif
          </form>
        </li>
    </ul>
</div>
