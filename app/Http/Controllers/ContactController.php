<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Contact;
use App\Models\Config1;
use Illuminate\Support\Facades\Config;

use App\Mail\ToAdminMail;
use App\Mail\FromAdminMail;
use Mail;

class ContactController extends Controller
{

    //運営者へのチャットの状況取得
    public function index_admin(){

        //ID取得
        if (session()->has("user_id")){
            $id=session()->get("user_id");
            $last_path="influ";
            $from="I";
        }else if (session()->has("shop_id")){
            $id=session()->get("shop_id");
            $last_path="client";
            $from="C";
        }else{
            return redirect('/');
        }


        $filename="laravel/public/storage/admin_contact/$last_path/$id.txt";
        if (file_exists($filename)){
            $f=file($filename);

        }else{
            $f="";
        }

        $item = DB::table('contacts')->where('contact_id',$id)->where('contact_from',$from)->first();
        if (isset($item)){
            if (session()->has("user_id")){
                $param=[
                    'name'=>$item->contact_name,
                    'phone'=>$item->contact_phone,
                    'mail'=>$item->contact_mail,
                ];
                $whose=$item->whose;
                // var_dump($f);
                // exit;

                return view(Config::get('const.title.title48').".chat_admin", ["param"=>$param,'msg'=>$f,'whose'=>$whose]);

            }else if (session()->has("shop_id")){
                $param=[
                    'name'=>$item->contact_name,
                    'tantou'=>$item->contact_tantou,
                    'phone'=>$item->contact_phone,
                    'mail'=>$item->contact_mail,
                    'address'=>$item->contact_address,
                    'station'=>$item->contact_station,
                ];
                $whose=$item->whose;

                return view(Config::get('const.title.title47').".chat_admin", ["param"=>$param,'msg'=>$f,'whose'=>$whose]);
            }
        }else{
            if (session()->has("user_id")){
                $item=DB::table('influs')
                ->where('user_id',$id)
                ->select('user_name','user_mail','user_phone')
                ->first();

                return view(Config::get('const.title.title48').".chat_admin",['item'=>$item]);
            }else if (session()->has("shop_id")){
                $item=DB::table('insyokus')
                ->where('shop_id',$id)
                ->select('shop_name','shop_tantou','shop_phone','shop_mail','shop_address','shop_station')
                ->first();

                return view(Config::get('const.title.title47').".chat_admin",['item'=>$item]);
            }
        }
    }

    //運営者への送信部分
    public function to_admin(Request $request){

        //ID取得
        if (session()->has("user_id")){
            $id=session()->get("user_id");
            $last_path="influ";
        }else if (session()->has("shop_id")){
            $id=session()->get("shop_id");
            $last_path="client";
        }else{
            return redirect('/');
        }

        $item_manager=DB::table('managers')->get();

        //全運営者へメール送信
        $to_list=[];
        for ($i=0;$i<count($item_manager);$i++){
            foreach ($item_manager[$i] as $key=>$value){
                if ($key==="manager_mail"){
                    $to_list[]=$value;
                }
            }
        }


        //whose
        $whose_req=$request->whose;
        $whose="{$whose_req}1";

        //日時
        $today = date("Y-m-d H:i:s");

        //requestがなければ新規ではない
        if (!isset($request->name)){
            if (session()->has("user_id")){
                $id=session()->get("user_id");
                $from="I";

                DB::table('contacts')
                        ->where('contact_id', $id)
                        ->where('contact_from','I')
                        ->update(['flag' => '1','datetimes'=>$today,'whose'=>$whose]);

            }else if (session()->has("shop_id")){
                $id=session()->get("shop_id");
                $from="C";
                DB::table('contacts')
                ->where('contact_id', $id)
                ->where('contact_from','C')
                ->update(['flag' => '1','datetimes'=>$today,'whose'=>$whose]);

            }

            $item_contact=DB::table('contacts')
            ->where('contact_id',$id)->where('contact_from',$from)->first();

            $names=$item_contact->contact_name;

        }else{  //新規
            //土のセッションを持っているかで誰からか判断
            // user_id  ならインフルエンサー


            if (session()->has("user_id")){
                $id=session()->get("user_id");
                DB::table('contacts')->insert([
                    'contact_id' => $id,
                    'contact_from' => 'I',
                    'contact_name' => $request->name,
                    'contact_phone' => $request->phone,
                    'contact_mail' => $request->mail,
                    'whose' => '1',
                    'datetimes' => $today,
                    'flag' => '1',
                ]);

            // shop_idならクライアント
            }else if (session()->has("shop_id")){
                $id=session()->get("shop_id");
                DB::table('contacts')->insert([
                    'contact_id' => $id,
                    'contact_from' => 'C',
                    'contact_name' => $request->name,
                    'contact_tantou' => $request->tantou,
                    'contact_phone' => $request->phone,
                    'contact_mail' => $request->mail,
                    'contact_address' => $request->address,
                    'contact_station' => $request->station,
                    'whose' => '1',
                    'datetimes' => $today,
                    'flag' => '1',
                ]);

            }
            $names=$request->name;
        }

        $comment=$request->comment;

        //テキストファイルへの追記処理

        $filename="laravel/public/storage/admin_contact/$last_path/$id.txt";  //ファイル名  id.txt
        //ファイルがなければ作る
        if (!file_exists($filename)){
            touch($filename);
            // $f = fopen($filename, "a+");  //追記モードで開く
            // flock($f, LOCK_EX);
            // fwrite($f, "<>"."\n");  //<>を一行目に入力
            // fclose($f);
        }

        $f = fopen($filename, "a+");  //追記モードで開く
        flock($f, LOCK_EX); // ファイルをロックする

        fwrite($f, "<>\n".$comment."\n");  //<>で追記
        // fwrite($f, "\n");
        fclose($f);



        $param=[
            'name'=>$names,
        ];

        //メール送信処理
        Mail::to($to_list)->send(new ToAdminMail($param));

        //リダイレクトで戻る
        if (session()->has("user_id")){
            return redirect(Config::get('const.title.title48').'/chat_admin');
        }else if (session()->has("shop_id")){
            return redirect(Config::get('const.title.title47').'/chat_admin');
        }


    }

    //問い合わせ一覧取得
    public function index(Request $request){
        if (isset($request->hidden)){
            $hidden_id=$request->hidden;
        }else{
            $hidden_id="1";
        }

        //インフルエンサーから
        $contact_name_s=$request->contact_name_s;
        $state_s=$request->state_s;

        $query = Contact::query();

        if(!empty($contact_name_s)){
            $query->where('contact_name', 'like', '%'.$contact_name_s.'%');
        }
        if(!empty($state_s) || $state_s==="0" || $state_s==="1"){
            $query->where('flag', '=', "$state_s");
        }

        $item = $query
        ->select('id','contact_id','contact_name','datetimes','flag')
        ->where('contact_from','I')
        ->orderBy('datetimes', 'desc')
        ->Paginate(20);


        //クライアントから
        $contact_name_s2=$request->contact_name_s2;
        $state_s2=$request->state_s2;

        $query2 = Contact::query();

        if(!empty($contact_name_s2)){
            $query2->where('contact_name', 'like', '%'.$contact_name_s2.'%');
        }
        if(!empty($state_s2) || $state_s2==="0" || $state_s2==="1"){
            $query2->where('flag', '=', "$state_s2");
        }

        $item2 = $query2
        ->select('id','contact_id','contact_name','datetimes','flag')
        ->where('contact_from','C')
        ->orderBy('datetimes', 'desc')
        ->Paginate(20);



        $state=[
            '0'=>'済',
            '1'=>'未',
        ];

        $param=[
            'contact_name_s'=>$contact_name_s,
            'state_s'=>$state_s,
            'contact_name_s2'=>$contact_name_s2,
            'state_s2'=>$state_s2,
        ];

        $param_list=[
            "item"=>$item,
            "item2"=>$item2,
            'param'=>$param,
            'state'=>$state,
            'hidden_id'=>$hidden_id,
        ];

        return view("administrator.chat", $param_list);
    }

    //チャット情報詳細
    public function index_detail($id){


        $item = DB::table('contacts')->where('id', $id)
        ->first();
        $contact_from=$item->contact_from;

        if ($contact_from==="I"){
            $param=[
                'contact_name'=>$item->contact_name,
                'contact_phone'=>$item->contact_phone,
                'contact_mail'=>$item->contact_mail,
            ];

            $last_path="influ";

            $column=[
                'contact_name'=>'氏名',
                'contact_phone'=>'電話番号',
                'contact_mail'=>'メールアドレス',
            ];
        }elseif ($contact_from==="C"){
            $param=[
                'contact_name'=>$item->contact_name,
                'contact_tantou'=>$item->contact_tantou,
                'contact_phone'=>$item->contact_phone,
                'contact_mail'=>$item->contact_mail,
                'contact_address'=>$item->contact_address,
                'contact_station'=>$item->contact_station,
            ];

            $column=[
                'contact_name'=>'企業名（店舗名）',
                'contact_tantou'=>'担当者名',
                'contact_phone'=>'電話番号',
                'contact_mail'=>'メールアドレス',
                'contact_address'=>'店舗住所',
                'contact_station'=>'最寄り駅',
            ];

            $last_path="client";
        }else{

        }
        $contact_id=$item->contact_id;
        $whose=$item->whose;

        $filename="laravel/public/storage/admin_contact/$last_path/$contact_id.txt";
        $f=file($filename);

        return view("administrator.chat_detail", ['from'=>$contact_from,'msg'=>$f,'whose'=>$whose,'item'=>$param,'column'=>$column,'contact_id'=>$contact_id]);
    }

    //運営者チャット返信
    public function admin_post(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $contact_id=$request->contact_id;
        $whose_kari=$request->whose;
        $from=$request->from;
        $whose="{$whose_kari}0";

        $comment=$request->comment;
        $today = date("Y-m-d H:i:s");

        $item = DB::table('contacts')->where('contact_id', $contact_id)
        ->where('contact_from',$from)->first();
        $id=$item->id;
        $contact_mail=$item->contact_mail;
        $contact_from=$item->contact_from;

        if ($contact_from==="I"){
            $last_path="influ";
        }else{
            $last_path="client";
        }

        DB::table('contacts')
        ->where('contact_id', $contact_id)
        ->where('contact_from',$from)
        ->update(['flag' => '0','datetimes'=>$today,'whose'=>$whose]);

        $filename="laravel/public/storage/admin_contact/$last_path/$contact_id.txt";
        $f = fopen($filename, "a+");  //追記モードで開く
        flock($f, LOCK_EX); // ファイルをロックする

        fwrite($f, "<>\n".$comment."\n");  //<>で追記
        // fwrite($f, "\n");
        fclose($f);

        //メール送信処理
        Mail::to($contact_mail)->send(new FromAdminMail());

        //リダイレクトで戻る
        // return redirect("administrator/chat_detail/$id", 302, [], true);
        return redirect("administrator/chat_detail/$id");


    }

}


