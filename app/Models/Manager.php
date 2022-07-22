<?php

namespace App\Models;
use Illuminate\Support\Facades\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Manager extends Model
{
    use HasFactory;

     // 未読メッセージ数取得 (新着メッセージ数)
     public static function new_messages_alert() {
        $new_messages = DB::table('mg_message')->where('delete_flag','0')->where('destination_mg','administrator')->where('show_flag','0')->get();
        $new_messages = count($new_messages);

        return $new_messages;
    }
}
