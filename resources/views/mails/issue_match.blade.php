<p>
  あななたの希望条件とマッチする案件が掲載されました。<br>
</p>
<p>
  掲載案件名：<br>
  {{$mail_param['issue_name']}}<br>
</p>
<p>
  マッチした条件<br>
  @if (count($mail_param['match_position']) !== 0)
    希望ポジション：<br>
    @for ($i = 0;$i <= 6;$i++)
      @foreach ($mail_param['match_position'] as $m_item)
        @foreach ($mail_param['lists'][$i] as $key=>$value)
          @if($m_item == $key)
            {{$value}}、
          @endif
        @endforeach
      @endforeach
    @endfor
  @endif
  <br><br>

  @if (count($mail_param['match_skill']) !== 0)
    希望スキル：<br>
      @for ($i = 7;$i <= 16;$i++)
        @foreach ($mail_param['match_skill'] as $s_item)
          @foreach ($mail_param['lists'][$i] as $key=>$value)
            @if($s_item == $key)
              {{$value}}、
            @endif
          @endforeach
        @endforeach
      @endfor
    @endif
    <br><br>

  @if (count($mail_param['match_industry']) !== 0)
    希望業界・業種：<br>
        @for ($i = 17;$i <= 19;$i++)
          @foreach ($mail_param['match_industry'] as $i_item)
            @foreach ($mail_param['lists'][$i] as $key=>$value)
              @if($i_item == $key)
                {{$value}}、
              @endif
            @endforeach
          @endforeach
        @endfor
      @endif
      <br><br>
</p>

<p>
    下記のURLから案件の確認ができます。<br>
    <a href="http://longopmatch.xsrv.jp/client2/search_detail/{{$mail_param['issue_number']}}">
    http://longopmatch.xsrv.jp/client2/search_detail/{{$mail_param['issue_number']}}
    </a>
</p>
<p>
    案件掲載企業<br>
    <a href="http://longopmatch.xsrv.jp/client2/client_detail/{{$mail_param['shop_number_id']}}">
    http://longopmatch.xsrv.jp/client2/client_detail/{{$mail_param['shop_number_id']}}
    </a>
</p>


<p>
    ーーーーーーーーーーーーー<br>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>

