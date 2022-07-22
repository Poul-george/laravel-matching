<?php
    $account="";
    if (session()->has("user_id")){
        $account="user";
    }elseif (session()->has("shop_id")){
        $account="client";
    }elseif (session()->has("manager_id")){
        $account="admin";
    }else{
    }
    session()->flush();

?>
@if ($account==="user")
    <script>window.location = "/client2";</script>
@elseif ($account==="client")
    <script>window.location = "/client1";</script>
@elseif ($account==="admin")
    <script>window.location = "/administrator";</script>
@else
    <script>window.location = "/";</script>
@endif
