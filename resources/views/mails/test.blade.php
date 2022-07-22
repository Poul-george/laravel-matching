↓このしたのテキストは動的に取得↓<br>
{{ $mail_text }}<br>

↓ここから下は固定の文書↓<br>
このような文面でメールを送信しますよ！


<!-- Mail::raw('Test Mail', function($message) { $message->to('ago.kilon@gmail.com')->subject('test'); }); -->