<html>
<head>
<style>
    .comment{
        white-space: pre-wrap;
	    word-wrap: break-word;
    }
</style>
</head>
<body>
@if ($param['whose']==="I")

@elseif ($param['whose']==="C")

@endif
<br>
<div class="comment">{{$param['comment']}}</div>
<br>

<p>☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆o｡:･;;.｡:*･☆</p>
<p>
    お問い合わせ先<br>
    {{config('const.title.title46')}}株式会社　{{config('const.title.title45')}}事業部<br>
    <a href="mailto:info@gourmet-casting.com">info@gourmet-casting.com</a><br>
    平日：10：00～18：00
</p>
</body>
</html>
