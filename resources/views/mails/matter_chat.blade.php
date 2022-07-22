@if ($mail_param['from']==="I")
    @if ($mail_param['hidden']==="1")
        {{-- チャット処理 --}}
        <p>{{$mail_param['mail_name']}}様よりメッセージが届きました。</p>
    @elseif ($mail_param['hidden']==="2")
        {{-- アレルギー・予約名登録 --}}
        <p>{{$mail_param['mail_name']}}様よりアレルギー・予約名登録が行われました。</p>
    @elseif ($mail_param['hidden']==="3")
        <p>{{$mail_param['mail_name']}}様より投稿報告1が行われました。</p>
    @elseif ($mail_param['hidden']==="4")
        <p>{{$mail_param['mail_name']}}様より投稿報告2が行われました。</p>
    @endif
    
@else
    @if ($mail_param['hidden']==="1")
        <p>{{$mail_param['mail_name']}}様よりメッセージが届きました。</p>
    @elseif ($mail_param['hidden']==="2")
        @if ($mail_param['where']==="4")
            <p>{{$mail_param['mail_name']}}様より来店日時と同伴人数の確定登録が行われました。</p>
        @else
            <p>{{$mail_param['mail_name']}}様より来店日時と同伴人数の希望登録が行われました。</p>
        @endif

        <p>日付：{{$mail_param['date']}}</p>
        <p>時間：{{$mail_param['time']}}</p>
        <p>同伴人数：{{$mail_param['member']}}</p>

    @endif

@endif
<p>ご確認ください。</p>