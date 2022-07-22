@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))

<?php

    $url=$_SERVER["REQUEST_URI"];
    $keys = parse_url($url); //パース処理
    $path = explode("/", $keys['path']); //分割処理
    $start = $path[1]; //最後の要素を取得

    $login_url="https://gourmet-casting.net/$start";
?>
<p>もう一度<a href="{{$login_url}}">ログイン</a>をお願いします。</p>
<a href="{{$login_url}}">ログインページ</a>
