<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Models\Matter;

class MatterController extends Controller
{
    //運営ログイン時起動
    public function auto_index(){
        $today = date("Y-m-d");

        $item=DB::table('matters')->where('flag','0')
        ->where('gather_before','<=',$today)
        ->get();

        if (isset($item)){
            foreach ($item as $key=>$value){
                $id=$value->id;

                DB::table('matters')->where('id',$id)
                ->update(['flag'=>'1']);
            }
        }

        return view("administrator.main");
    }
    //インフルエンサーからの案件一覧
    public function index(){
        $today = date("Y-m-d");

        $item = DB::table('matters')
        ->select('id','shop_name','gather_after','matter_num','matter_num_now','shop_address','least_follower')
        ->where('end_flag','F')
        ->where('gather_after','>=',$today)
        ->orderBy('gather_after', 'desc')
        ->Paginate(20);

        $shop_name_s="";
        $shop_address_s="";
        $oubo_s="";
        $follower_s="";

        $param=[
            'shop_name_s'=>$shop_name_s,
            'shop_address_s'=>$shop_address_s,
            'oubo_s'=>$oubo_s,
            'follower_s'=>$follower_s,
        ];

        $follower = Config::get('list.follower');

        // $follower=[
        //     'A'=>'5000～',
        //     'B'=>'10,000～',
        //     'C'=>'15,000～',
        //     'D'=>'20,000～',
        //     'E'=>'30,000～',
        // ];

        return view(Config::get('const.title.title48').".matter", ["item"=>$item,'follower'=>$follower,'param'=>$param]);

    }

    //インフルエンサーからの案件検索
    public function client2_find(Request $request){
        if (!session()->has("user_id")){
            return redirect(Config::get('const.title.title48'));
        }
        $influ_id=session()->get('user_id');

        //検索
        $shop_name_s=$request->shop_name;
        $shop_address_s=$request->shop_address_s;
        $oubo_s=$request->oubo;
        $follower_s=$request->follower;


        $query = Matter::query();

        $today = date("Y-m-d");

        $follower = Config::get('list.follower');

        // $follower=[
        //     'A'=>'5000人以上',
        //     'B'=>'10000人以上',
        //     'C'=>'15000人以上',
        // ];

        if(!empty($shop_name_s)){
            $query->where('shop_name', 'like', '%'.$shop_name_s.'%');
        }
        if(!empty($shop_address_s)){
            $query->where('shop_address', 'like', '%'.$shop_address_s.'%');
        }
        if(!empty($oubo_s)){
            $query->where('gather_after', '<=', $oubo_s);
        }
        if(!empty($follower_s)){
            if ($follower_s==="A")
                $query->whereIn('least_follower', ['A','B','C','D','E']);
            elseif ($follower_s==="B"){
                $query->whereIn('least_follower', ['B','C','D','E']);
            }
            elseif ($follower_s==="C"){
                $query->whereIn('least_follower', ['C','D','E']);
            }
            elseif ($follower_s==="D"){
                $query->whereIn('least_follower', ['D','E']);
            }
            elseif ($follower_s==="E"){
                $query->whereIn('least_follower', ['E']);
            }
        }

        $todouhukien_list = Config::get('list.todouhuken');

        $param=[
            'shop_name_s'=>$shop_name_s,
            'shop_address_s'=>$shop_address_s,
            'oubo_s'=>$oubo_s,
            'follower_s'=>$follower_s,
        ];

        //募集案件（ID順）
        $item=$query
        ->where('end_flag','F')
        ->where('gather_after','>=',$today)
        ->orderBy('gather_after', 'desc')
        ->Paginate(20);

        $search_count=$query->select('id','shop_name','gather_after','matter_num','matter_num_now','shop_address','least_follower')
        ->where('end_flag','F')
        ->where('gather_after','>=',$today)
        ->orderBy('id', 'desc')
        ->count();

        $matter_genre_name = Config::get('list.matter_genre');


        //応募済み案件（ID順）
        $item2_1=DB::table('matterstates')
        ->where('influ_id',$influ_id)
        ->whereIn('flag',['0','1','3','4','5'])
        ->orderBy('id', 'desc')
        ->get();

        $matter_already_list=[];
        $matter_flag_list=[];
        foreach ($item2_1 as $key=>$value){
            $matter_already_list[]=$value->matter_id;
            $matter_flag_list[$value->matter_id]=$value->flag;
        }



        $item2=DB::table('matters')
        ->select('id','shop_name','shop_address','least_follower')
        ->whereIn('id',$matter_already_list)
        ->orderBy('updated_at', 'desc')
        ->get();
        // var_dump($item2);
        // exit;


        //日程調整  投稿（やり取り順）
        $item3=DB::table('matterstates')
        ->where('influ_id',$influ_id)
        ->whereIn('flag',['1','3','4','5'])
        ->orderBy('updated_at', 'desc')
        ->get();

        $flag_list=[
            '0'=>'応募中',
            '1'=>'採用',
            '2'=>'未採用',
            '3'=>'日程確定',
            '4'=>'投稿報告1完了',
            '5'=>'投稿報告2完了',
        ];

        //確定時間
        $time_list=[''];
        foreach ($item3 as $value){
            $time_list[$value->id]=date('H:i',  strtotime($value->time_result));
        }


        //チャットの末尾３０文字
        $chat_path_list=[];
        foreach ($item3 as $key=>$value){
            $chat_path_list[$value->id]=$value->chat_path;
        }


        $f_value='';
        $f_list=[];
        foreach ($chat_path_list as $key=>$value){
            $f=file($value);
            $ff_list=[];
            $f_count=count($f)-2;
            for ($i=$f_count;$i>=0;$i--){
                if ($f[$i][0]==="<" && $f[$i][1]===">"){
                    break;
                }
                $ff_list[]=$f[$i];

            }

            $ff_list=array_reverse($ff_list);
            $f_value=implode($ff_list);
            $f_value=mb_substr($f_value,-30);
            $f_list[$key]=$f_value;

        }
        // var_dump($f_list);
        // exit;

        $item4=DB::table('matterstates')
        ->whereIn('flag',['3','4'])
        ->where('come','T')
        ->where('influ_id',$influ_id)
        ->get();



        $request->session()->flash('search_count', $search_count);

        return view(Config::get('const.title.title48').".matter", ["item"=>$item,"item2"=>$item2,"item3"=>$item3,"item4"=>$item4,'matter_flag_list'=>$matter_flag_list,'follower'=>$follower,'param'=>$param,'todouhukien_list'=>$todouhukien_list,'flag_list'=>$flag_list,'f_list'=>$f_list,'time_list'=>$time_list,'matter_genre_name'=>$matter_genre_name]);
    }

    //店舗クライアントからの案件一覧
    public function client1_index(){
        //セッション取得
        if (session()->has('shop_id')){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect(Config::get('const.title.title47'));
        }

        $item = DB::table('matters')
        ->select('id','shop_name','matter_name','gather_before','gather_after','matter_num','flag')
        ->where('shop_id',$shop_id)
        ->orderBy('gather_after', 'desc')
        ->get();

        $flag_list=[
            '0'=>'未公開',
            '1'=>'公開済み',
            '2'=>'来店前',
            '3'=>'来店済み',
            '4'=>'提出済み',
            '5'=>'清算済み',
        ];

        return view(Config::get('const.title.title47').".matter", ["item"=>$item, 'flag_list'=>$flag_list]);

    }

    //店舗クライアントからの案件一覧（診断書部分）
    public function client1_index2(){
        //セッション取得
        if (session()->has('shop_id')){
            $shop_id=session()->get("shop_id");
        }else{
            return redirect(Config::get('const.title.title47'));
        }

        $item = DB::table('matters')
        ->select('id','gather_before','gather_after','matter_num','flag')
        ->where('shop_id',$shop_id)
        ->whereIn('flag',['4','5'])
        ->orderBy('gather_after', 'desc')
        ->get();

        $flag_list=[
            '0'=>'未公開',
            '1'=>'公開済み',
            '2'=>'来店前',
            '3'=>'来店済み',
            '4'=>'提出済み',
            '5'=>'清算済み',
        ];

        return view(Config::get('const.title.title47').".client_form_before", ["item"=>$item, 'flag_list'=>$flag_list]);

    }



    //インフルエンサーからの案件詳細情報
    public function index_detail($id){
        if (!session()->has("user_id")){
            return redirect(Config::get('const.title.title48'));
        }
        $influ_id=session()->get('user_id');

        $item = DB::table('matters')->where('id',$id)->first();

        $shop_id=$item->shop_id;
        $shop_name=$item->shop_name;

        $item2=DB::table('matterstates')
        ->where('matter_id',$id)
        ->where('influ_id',$influ_id)
        ->count();


        // $url=url()->previous();
        // $keys = parse_url($url); //パース処理
        // $path = explode("/", $keys['path']); //分割処理
        // $last = end($path); //最後の要素を取得
        $last_url="";

        if ($item2===0){
            $last_url="T";
        }

        $items=[
            'shop_name'=>$item->shop_name,
            'shop_address'=>$item->shop_address,
            'shop_phone'=>$item->shop_phone,
            'shop_url'=>$item->shop_url,
            'matter_num'=>$item->matter_num,
            'gather_after'=>$item->gather_after,
            'least_follower'=>$item->least_follower,
            'reward'=>$item->reward,
            'serve_menu'=>$item->serve_menu,
            'serve_value'=>$item->serve_value,
            'companion_num'=>$item->companion_num,
            'hashtag'=>$item->hashtag,
            'tag_account'=>$item->tag_account,
            'location'=>$item->location,
            'post_deadline'=>$item->post_deadline,
            'story_url'=>$item->story_url,
            'able_datetime'=>$item->able_datetime,
            'able_time'=>$item->able_time,
            'not_able_date'=>$item->not_able_date,
        ];


        $items_2=[
            'story_hissu'=>$item->story_hissu,
            'taberogu_hissu'=>$item->taberogu_hissu,
            'google_hissu'=>$item->google_hissu,
            'blog_hissu'=>$item->blog_hissu,
        ];

        $template=[
            'term_template'=>$item->term_template,
            'notice_template'=>$item->notice_template,
        ];

        $term=[
            'term1'=>$item->term1,
            'term2'=>$item->term2,
            'term3'=>$item->term3,
            'term4'=>$item->term4,
            'term5'=>$item->term5,
            'term6'=>$item->term6,
            'term7'=>$item->term7,
            'term8'=>$item->term8,
            'term9'=>$item->term9,
            'term10'=>$item->term10,
            'term11'=>$item->term11,
            'term12'=>$item->term12,
            'term13'=>$item->term13,
            'term14'=>$item->term14,
            'term15'=>$item->term15,
        ];

        $notice=[
            'notice1'=>$item->notice1,
            'notice2'=>$item->notice2,
            'notice3'=>$item->notice3,
            'notice4'=>$item->notice4,
            'notice5'=>$item->notice5,
            'notice6'=>$item->notice6,
            'notice7'=>$item->notice7,
            'notice8'=>$item->notice8,
            'notice9'=>$item->notice9,
            'notice10'=>$item->notice10,
            'notice11'=>$item->notice11,
            'notice12'=>$item->notice12,
            'notice13'=>$item->notice13,
            // 'notice14'=>$item->notice14,
            // 'notice15'=>$item->notice15,
        ];

        $term_content=[
            'term1'=>'料理やサービス、店舗についての感想を丁寧にレビューしてくれる方を希望します。',
            'term2'=>'ランチタイムに訪問してください。',
            'term3'=>'ディナータイムに訪問してください。',
            'term4'=>'来店後アンケート、投稿インサイトの提出が必須となります。',
            'term5'=>'１枚目の画像は人物ではなく、料理写真でお願いいたします。',
            'term6'=>'注文した料理やドリンクの写真は全て、投稿してください。',
            'term7'=>'強制ではありませんが、グルメサイト等に投稿を頂ける方だと、選ばれやすくなります。',
            'term8'=>'店舗の位置情報を設定して、投稿してください。',
            'term9'=>'出来るだけ多くの写真を投稿してください。',
            'term10'=>'URL付きでストーリーズへの投稿を希望します。',
            'term11'=>`$item->term11`,
            'term12'=>`$item->term12`,
            'term13'=>`$item->term13`,
            'term14'=>`$item->term14`,
            'term15'=>`$item->term15`,
        ];


        $notice_content=[
            'notice1'=>Config::get('const.title.title2').'１名のみ、無料招待となります。',
            'notice2'=>'同伴者1名分もサービス提供いたします。',
            'notice3'=>'交通費は事項負担となります。',
            'notice4'=>'無償提供するもの以外のご注文は、自己負担となります。',
            'notice5'=>'投稿やストーリーズをシェアさせていただく場合があります。',
            'notice6'=>'当日の時間変更、キャンセルはご遠慮ください。',
            'notice7'=>'投稿の際、お店の感想以外のコメントが多い場合には、修正依頼をする場合があります。',
            'notice8'=>'小学生以下のお子様のご来店は、ご遠慮ください。',
            'notice9'=>`$item->notice9`,
            'notice10'=>`$item->notice10`,
            'notice11'=>`$item->notice11`,
            'notice12'=>`$item->notice12`,
            'notice13'=>`$item->notice13`,
        ];

        $param=[
            'shop_name'=>'店舗名',
            'shop_address'=>'住所',
            'shop_phone'=>'電話番号',
            'shop_url'=>'店舗URL',
            'shop_tantou'=>'担当者',
            'shop_area'=>'郵便番号',
            'shop_mail'=>'メールアドレス',
            'matter_num'=>'募集人数',
            'gather_before'=>'募集開始日程',
            'gather_after'=>'募集終了日程',
            'able_datetime'=>'予約可能日時',
            'able_time'=>'予約可能時間',
            'not_able_date'=>'予約NG日',
            'least_follower'=>'応募条件（フォロワー数）',
            'reward'=>'報酬',
            'serve_menu'=>'提供メニュー',
            'serve_value'=>'メニュー料金',
            'companion_num'=>'同伴者人数',
            'hashtag'=>'指定ハッシュタグ',
            'tag_account'=>'タグ付け用アカウント',
            'location'=>'位置情報',
            'post_deadline'=>'Instagramへの投稿期限',
            'story_url'=>'ストーリーズ用URL',
        ];

        $param_2=[
            'story_hissu'=>'ストーリーズへの投稿',
            'taberogu_hissu'=>'食べログへの投稿',
            'google_hissu'=>'Google Mapへの投稿',
            'blog_hissu'=>'ブログへの投稿',
        ];

        $follower = Config::get('list.follower');
        $deadline = Config::get('list.deadline');
        $sns_list = Config::get('list.matter_sns');

        // $follower=[
        //     'A'=>'5000人以上',
        //     'B'=>'10000人以上',
        //     'C'=>'15000人以上',
        // ];

        $sns=[
            'instagram'=>$item->instagram,
            'twitter'=>$item->twitter,
            'youtube'=>$item->youtube,
            'tiktok'=>$item->tiktok,
        ];

        // $sns_list=[
        //     'instagram'=>'Instagram',
        //     'twitter'=>'Twitter',
        //     'youtube'=>'YouTube',
        //     'tiktok'=>'TikTok',
        // ];

        // $deadline=[
        //     'A'=>'来店後3日以内',
        //     'B'=>'来店後5日以内',
        //     'C'=>'来店後7日以内',
        // ];

        $arinashi=[
            'T'=>'あり',
            'F'=>'なし',
        ];

        $able=[
            'T'=>'可',
            'F'=>'不可',
        ];

        //画像
        $img_list=[];
        for ($i=1;$i<=5;$i++){
            if (!empty($item->{"matter_img$i"})){
                $filename=$item->{"matter_img$i"};
                $img_list[]="storage/matter_img/$filename";
            }
        }
        $img_list2=[];
        // $img_list=json_encode($img_list);

        // var_dump($img_list);
        // exit;


        $item_shop=DB::table('insyokus')
        ->where('shop_id',$shop_id)->first();

        $matter_genre_name = Config::get('list.matter_genre');
        $weeklist = Config::get('list.weeklist');

        return view(Config::get('const.title.title48').".matter_detail", ['item_shop'=>$item_shop,'matter_genre_name'=>$matter_genre_name,'id'=>$id,'shop_id'=>$shop_id,'shop_name'=>$shop_name,"item"=>$item,"item_2"=>$items_2,'template'=>$template,'term'=>$term,'notice'=>$notice,'term_content'=>$term_content,'notice_content'=>$notice_content,'param'=>$param,'param_2'=>$param_2,'follower'=>$follower,'sns'=>$sns,'sns_list'=>$sns_list,'deadline'=>$deadline,'last_url'=>$last_url,'arinashi'=>$arinashi,'able'=>$able,'weeklist'=>$weeklist,'img_list'=>$img_list]);
    }


    //店舗クライアントからの案件詳細情報
    public function client1_index_detail($id){
        $item = DB::table('matters')->where('id',$id)->first();

        $able_time1=date('H:i',  strtotime($item->able_time1));

        $items=[
            'shop_name'=>$item->shop_name,
            'shop_tantou'=>$item->shop_tantou,
            'shop_area'=>$item->shop_area,
            'shop_address'=>$item->shop_address,
            'shop_phone'=>$item->shop_phone,
            'shop_url'=>$item->shop_url,
            'shop_close_date'=>$item->shop_close_date,
            'shop_open_time'=>$item->shop_open_time,
            // 'intro_text'=>$item->intro_text,
            'matter_num'=>$item->matter_num,
            'gather_before'=>$item->gather_before,
            'gather_after'=>$item->gather_after,
            'least_follower'=>$item->least_follower,
            'reward'=>$item->reward,
            'serve_menu'=>$item->serve_menu,
            'serve_value'=>$item->serve_value,
            'companion_num'=>$item->companion_num,
            'hashtag'=>$item->hashtag,
            'tag_account'=>$item->tag_account,
            'location'=>$item->location,
            'post_deadline'=>$item->post_deadline,
            'story_url'=>$item->story_url,
            'able_datetime'=>$item->able_datetime,
            'able_time'=>$item->able_time,
            'not_able_date'=>$item->not_able_date,
        ];


        $items_2=[
            'story_hissu'=>$item->story_hissu,
            'taberogu_hissu'=>$item->taberogu_hissu,
            'google_hissu'=>$item->google_hissu,
            'blog_hissu'=>$item->blog_hissu,
        ];

        $template=[
            'term_template'=>$item->term_template,
            'notice_template'=>$item->notice_template,
        ];

        $term=[
            'term1'=>$item->term1,
            'term2'=>$item->term2,
            'term3'=>$item->term3,
            'term4'=>$item->term4,
            'term5'=>$item->term5,
            'term6'=>$item->term6,
            'term7'=>$item->term7,
            'term8'=>$item->term8,
            'term9'=>$item->term9,
            'term10'=>$item->term10,
            'term11'=>$item->term11,
            'term12'=>$item->term12,
            'term13'=>$item->term13,
            'term14'=>$item->term14,
            'term15'=>$item->term15,
        ];

        $notice=[
            'notice1'=>$item->notice1,
            'notice2'=>$item->notice2,
            'notice3'=>$item->notice3,
            'notice4'=>$item->notice4,
            'notice5'=>$item->notice5,
            'notice6'=>$item->notice6,
            'notice7'=>$item->notice7,
            'notice8'=>$item->notice8,
            'notice9'=>$item->notice9,
            'notice10'=>$item->notice10,
            'notice11'=>$item->notice11,
            'notice12'=>$item->notice12,
            'notice13'=>$item->notice13,
            // 'notice14'=>$item->notice14,
            // 'notice15'=>$item->notice15,
        ];

        $term_content=[
            'term1'=>'料理やサービス、店舗についての感想を丁寧にレビューしてくれる方を希望します。',
            'term2'=>'ランチタイムに訪問してください。',
            'term3'=>'ディナータイムに訪問してください。',
            'term4'=>'来店後アンケート、投稿インサイトの提出が必須となります。',
            'term5'=>'１枚目の画像は人物ではなく、料理写真でお願いいたします。',
            'term6'=>'注文した料理やドリンクの写真は全て、投稿してください。',
            'term7'=>'強制ではありませんが、グルメサイト等に投稿を頂ける方だと、選ばれやすくなります。',
            'term8'=>'店舗の位置情報を設定して、投稿してください。',
            'term9'=>'出来るだけ多くの写真を投稿してください。',
            'term10'=>'URL付きでストーリーズへの投稿を希望します。',
            'term11'=>`$item->term11`,
            'term12'=>`$item->term12`,
            'term13'=>`$item->term13`,
            'term14'=>`$item->term14`,
            'term15'=>`$item->term15`,
        ];


        $notice_content=[
            'notice1'=>Config::get('const.title.title2').'１名のみ、無料招待となります。',
            'notice2'=>'同伴者1名分もサービス提供いたします。',
            'notice3'=>'交通費は事項負担となります。',
            'notice4'=>'無償提供するもの以外のご注文は、自己負担となります。',
            'notice5'=>'投稿やストーリーズをシェアさせていただく場合があります。',
            'notice6'=>'当日の時間変更、キャンセルはご遠慮ください。',
            'notice7'=>'投稿の際、お店の感想以外のコメントが多い場合には、修正依頼をする場合があります。',
            'notice8'=>'小学生以下のお子様のご来店は、ご遠慮ください。',
            'notice9'=>`$item->notice9`,
            'notice10'=>`$item->notice10`,
            'notice11'=>`$item->notice11`,
            'notice12'=>`$item->notice12`,
            'notice13'=>`$item->notice13`,
        ];

        $param=[
            'shop_name'=>'店舗名',
            'shop_address'=>'住所',
            'shop_phone'=>'電話番号',
            'shop_url'=>'店舗URL',
            'shop_tantou'=>'担当者',
            'shop_area'=>'郵便番号',
            'shop_mail'=>'メールアドレス',
            'shop_close_date'=>'定休日・店休日',
            'shop_open_time'=>'営業時間',
            'matter_num'=>'募集人数',
            'gather_before'=>'募集開始日程',
            'gather_after'=>'募集終了日程',
            'able_datetime'=>'予約可能日時',
            'able_time'=>'予約可能時間',
            'not_able_date'=>'予約NG日',
            'least_follower'=>'応募条件（フォロワー数）',
            'reward'=>'報酬',
            'serve_menu'=>'提供メニュー',
            'serve_value'=>'メニュー料金',
            'companion_num'=>'同伴者人数',
            'hashtag'=>'指定ハッシュタグ',
            'tag_account'=>'タグ付け用アカウント',
            'location'=>'位置情報',
            'post_deadline'=>'Instagramへの投稿期限',
            'story_url'=>'ストーリーズ用URL',
        ];

        $param_2=[
            'story_hissu'=>'ストーリーズへの投稿',
            'taberogu_hissu'=>'食べログへの投稿',
            'google_hissu'=>'Google Mapへの投稿',
            'blog_hissu'=>'ブログへの投稿',
        ];

        $deadline = Config::get('list.deadline');
        $follower = Config::get('list.follower');
        $sns_list = Config::get('list.matter_sns');

        // $follower=[
        //     'A'=>'5000人以上',
        //     'B'=>'10000人以上',
        //     'C'=>'15000人以上',
        // ];

        $sns=[
            'instagram'=>$item->instagram,
            'twitter'=>$item->twitter,
            'youtube'=>$item->youtube,
            'tiktok'=>$item->tiktok,
        ];

        // $sns_list=[
        //     'instagram'=>'Instagram',
        //     'twitter'=>'Twitter',
        //     'youtube'=>'YouTube',
        //     'tiktok'=>'TikTok',
        // ];

        // $deadline=[
        //     'A'=>'来店後3日以内',
        //     'B'=>'来店後5日以内',
        //     'C'=>'来店後7日以内',
        // ];



        return view(Config::get('const.title.title47').".matter_detail", ['id'=>$id,"item"=>$items,"item_2"=>$items_2,'template'=>$template,'term'=>$term,'notice'=>$notice,'term_content'=>$term_content,'notice_content'=>$notice_content,'param'=>$param,'param_2'=>$param_2,'follower'=>$follower,'sns'=>$sns,'sns_list'=>$sns_list,'deadline'=>$deadline]);
    }

    //運営者からの案件詳細情報
    public function admin_index_detail($id){
        $item = DB::table('matters')->where('id',$id)->first();

        $able_time1=date('H:i',  strtotime($item->able_time1));

        $items=[
            'shop_name'=>$item->shop_name,
            'shop_tantou'=>$item->shop_tantou,
            'shop_area'=>$item->shop_area,
            'shop_address'=>$item->shop_address,
            'shop_phone'=>$item->shop_phone,
            'shop_url'=>$item->shop_url,
            'shop_close_date'=>$item->shop_close_date,
            'shop_open_time'=>$item->shop_open_time,
            'matter_num'=>$item->matter_num,
            'matter_name'=>$item->matter_name,
            'gather_before'=>$item->gather_before,
            'gather_after'=>$item->gather_after,
            'least_follower'=>$item->least_follower,
            'reward'=>$item->reward,
            'intro_text'=>$item->intro_text,
            'serve_menu'=>$item->serve_menu,
            'serve_value'=>$item->serve_value,
            'companion_num'=>$item->companion_num,
            'hashtag'=>$item->hashtag,
            'tag_account'=>$item->tag_account,
            'location'=>$item->location,
            'post_deadline'=>$item->post_deadline,
            'story_url'=>$item->story_url,
            'able_datetime'=>$item->able_datetime,
            'able_time'=>$item->able_time,
            'not_able_date'=>$item->not_able_date,
        ];


        $items_2=[
            'story_hissu'=>$item->story_hissu,
            'taberogu_hissu'=>$item->taberogu_hissu,
            'google_hissu'=>$item->google_hissu,
            'blog_hissu'=>$item->blog_hissu,
        ];

        $genre=[
            'matter_genre1'=>$item->matter_genre1,
            'matter_genre2'=>$item->matter_genre2,
            'matter_genre3'=>$item->matter_genre3,
            'matter_genre4'=>$item->matter_genre4,
            'matter_genre5'=>$item->matter_genre5,
            'matter_genre6'=>$item->matter_genre6,
            'matter_genre7'=>$item->matter_genre7,
            'matter_genre8'=>$item->matter_genre8,
            'matter_genre9'=>$item->matter_genre9,
            'matter_genre10'=>$item->matter_genre10,
        ];

        $template=[
            'term_template'=>$item->term_template,
            'notice_template'=>$item->notice_template,
        ];

        $term=[
            'term1'=>$item->term1,
            'term2'=>$item->term2,
            'term3'=>$item->term3,
            'term4'=>$item->term4,
            'term5'=>$item->term5,
            'term6'=>$item->term6,
            'term7'=>$item->term7,
            'term8'=>$item->term8,
            'term9'=>$item->term9,
            'term10'=>$item->term10,
            'term11'=>$item->term11,
            'term12'=>$item->term12,
            'term13'=>$item->term13,
            'term14'=>$item->term14,
            'term15'=>$item->term15,
        ];

        $term2_1=[
            'term1'=>$item->term1,
            'term2'=>$item->term2,
            'term3'=>$item->term3,
            'term4'=>$item->term4,
            'term5'=>$item->term5,
            'term6'=>$item->term6,
            'term7'=>$item->term7,
            'term8'=>$item->term8,
            'term9'=>$item->term9,
            'term10'=>$item->term10,
        ];

        $term2_2=[
            'term11'=>$item->term11,
            'term12'=>$item->term12,
            'term13'=>$item->term13,
            'term14'=>$item->term14,
            'term15'=>$item->term15,
        ];

        $notice=[
            'notice1'=>$item->notice1,
            'notice2'=>$item->notice2,
            'notice3'=>$item->notice3,
            'notice4'=>$item->notice4,
            'notice5'=>$item->notice5,
            'notice6'=>$item->notice6,
            'notice7'=>$item->notice7,
            'notice8'=>$item->notice8,
            'notice9'=>$item->notice9,
            'notice10'=>$item->notice10,
            'notice11'=>$item->notice11,
            'notice12'=>$item->notice12,
            'notice13'=>$item->notice13,
        ];

        $notice2_1=[
            'notice1'=>$item->notice1,
            'notice2'=>$item->notice2,
            'notice3'=>$item->notice3,
            'notice4'=>$item->notice4,
            'notice5'=>$item->notice5,
            'notice6'=>$item->notice6,
            'notice7'=>$item->notice7,
            'notice8'=>$item->notice8,
        ];

        $notice2_2=[
            'notice9'=>$item->notice9,
            'notice10'=>$item->notice10,
            'notice11'=>$item->notice11,
            'notice12'=>$item->notice12,
            'notice13'=>$item->notice13,
        ];

        $file_list=[
            'matter_img1'=>$item->matter_img1,
            'matter_img2'=>$item->matter_img2,
            'matter_img3'=>$item->matter_img3,
            'matter_img4'=>$item->matter_img4,
            'matter_img5'=>$item->matter_img5,
        ];

        $term_content=[
            'term1'=>'料理やサービス、店舗についての感想を丁寧にレビューしてくれる方を希望します。',
            'term2'=>'ランチタイムに訪問してください。',
            'term3'=>'ディナータイムに訪問してください。',
            'term4'=>'来店後アンケート、投稿インサイトの提出が必須となります。',
            'term5'=>'１枚目の画像は人物ではなく、料理写真でお願いいたします。',
            'term6'=>'注文した料理やドリンクの写真は全て、投稿してください。',
            'term7'=>'強制ではありませんが、グルメサイト等に投稿を頂ける方だと、選ばれやすくなります。',
            'term8'=>'店舗の位置情報を設定して、投稿してください。',
            'term9'=>'出来るだけ多くの写真を投稿してください。',
            'term10'=>'URL付きでストーリーズへの投稿を希望します。',
            'term11'=>`$item->term11`,
            'term12'=>`$item->term12`,
            'term13'=>`$item->term13`,
            'term14'=>`$item->term14`,
            'term15'=>`$item->term15`,
        ];


        $notice_content=[
            'notice1'=>Config::get('const.title.title2').'１名のみ、無料招待となります。',
            'notice2'=>'同伴者1名分もサービス提供いたします。',
            'notice3'=>'交通費は事項負担となります。',
            'notice4'=>'無償提供するもの以外のご注文は、自己負担となります。',
            'notice5'=>'投稿やストーリーズをシェアさせていただく場合があります。',
            'notice6'=>'当日の時間変更、キャンセルはご遠慮ください。',
            'notice7'=>'投稿の際、お店の感想以外のコメントが多い場合には、修正依頼をする場合があります。',
            'notice8'=>'小学生以下のお子様のご来店は、ご遠慮ください。',
            'notice9'=>`$item->notice9`,
            'notice10'=>`$item->notice10`,
            'notice11'=>`$item->notice11`,
            'notice12'=>`$item->notice12`,
            'notice13'=>`$item->notice13`,
        ];

        $param=[
            'shop_name'=>'店舗名',
            'shop_address'=>'住所',
            'shop_phone'=>'電話番号',
            'shop_url'=>'店舗URL',
            'shop_tantou'=>'担当者',
            'shop_area'=>'郵便番号',
            'shop_mail'=>'メールアドレス',
            'shop_close_date'=>'定休日・店休日',
            'shop_open_time'=>'営業時間',
            'matter_num'=>'募集人数',
            'matter_name'=>'案件名',
            'gather_before'=>'募集開始日程',
            'gather_after'=>'募集終了日程',
            'able_datetime'=>'予約可能日時',
            'able_time'=>'予約可能時間',
            'not_able_date'=>'予約NG日',
            'least_follower'=>'応募条件（フォロワー数）',
            'reward'=>'報酬',
            'serve_menu'=>'提供メニュー',
            'intro_text'=>'店舗紹介文',
            'serve_value'=>'メニュー料金',
            'companion_num'=>'同伴者人数',
            'hashtag'=>'指定ハッシュタグ',
            'tag_account'=>'タグ付け用アカウント',
            'location'=>'位置情報',
            'post_deadline'=>'Instagramへの投稿期限',
            'story_url'=>'ストーリーズ用URL',
        ];

        $param_2=[
            'story_hissu'=>'ストーリーズへの投稿',
            'taberogu_hissu'=>'食べログへの投稿',
            'google_hissu'=>'Google Mapへの投稿',
            'blog_hissu'=>'ブログへの投稿',
        ];

        $follower = Config::get('list.follower');
        $deadline = Config::get('list.deadline');
        $matter_genre = Config::get('list.matter_genre');
        $weeklist = Config::get('list.weeklist');

        // $follower=[
        //     'A'=>'5000人以上',
        //     'B'=>'10000人以上',
        //     'C'=>'15000人以上',
        // ];

        $sns=[
            'instagram'=>$item->instagram,
            'twitter'=>$item->twitter,
            'youtube'=>$item->youtube,
            'tiktok'=>$item->tiktok,
        ];

        $sns_list=[
            'instagram'=>'Instagram',
            'twitter'=>'Twitter',
            'youtube'=>'YouTube',
            'tiktok'=>'TikTok',
        ];

        // $deadline=[
        //     'A'=>'来店後3日以内',
        //     'B'=>'来店後5日以内',
        //     'C'=>'来店後7日以内',
        // ];


        $url=url()->previous();
        $keys = parse_url($url); //パース処理
        $path = explode("/", $keys['path']); //分割処理
        $last = end($path); //最後の要素を取得
        $last = prev($path); //最後から一つ戻った要素を取得


        if ($last==="admin_matter_detail"){
            return view("administrator.admin_matter_edit", ['id'=>$id,"item"=>$items,"item_2"=>$items_2,'template'=>$template,'term'=>$term,'notice'=>$notice,'term2_1'=>$term2_1,'notice2_1'=>$notice2_1,'term2_2'=>$term2_2,'notice2_2'=>$notice2_2,'term_content'=>$term_content,'notice_content'=>$notice_content,'param'=>$param,'param_2'=>$param_2,'follower'=>$follower,'sns'=>$sns,'sns_list'=>$sns_list,'deadline'=>$deadline,'genre'=>$genre,'matter_genre'=>$matter_genre,'weeklist'=>$weeklist,'file_list'=>$file_list]);
        }

        return view("administrator.admin_matter_detail", ['id'=>$id,"item"=>$items,"item_2"=>$items_2,'template'=>$template,'term'=>$term,'notice'=>$notice,'term_content'=>$term_content,'notice_content'=>$notice_content,'param'=>$param,'param_2'=>$param_2,'follower'=>$follower,'sns'=>$sns,'sns_list'=>$sns_list,'deadline'=>$deadline,'genre'=>$genre,'matter_genre'=>$matter_genre,'file_list'=>$file_list]);
    }

    //運営側案件一覧
    public function admin_index(Request $request){

        $matter_id_s=$request->matter_id_s;
        $shop_name_s=$request->shop_name_s;
        $flag_s=$request->flag_s;
        // echo $flag_s;
        // exit;



        $query = Matter::query();

        if(!empty($matter_id_s)){
            $query->where('id', $matter_id_s);
        }
        if(!empty($shop_name_s)){
            $query->where('shop_name', 'like', '%'.$shop_name_s.'%');
        }
        if(!empty($flag_s) || $flag_s==="0"){
            $query->where('flag', '=', "$flag_s");
        }


        $item = $query->select('id','shop_id','shop_name','matter_name','gather_before','gather_after','flag')
        ->orderBy('gather_after', 'desc')
        ->Paginate(20);

        $flag_list=[
            '0'=>'未公開',
            '1'=>'公開済み',
            '2'=>'来店前',
            '3'=>'来店済み',
            '4'=>'提出済み',
            '5'=>'清算済み',
        ];

        $param=[
            'matter_id_s'=>$matter_id_s,
            'shop_name_s'=>$shop_name_s,
            'flag_s'=>"$flag_s",
        ];

        return view("administrator.matter", ['item'=>$item,'param'=>$param,'flag_list'=>$flag_list]);

    }



    //案件作成ふぃふぉーまっと
    public function matter_format(){
        $thisyear=date('Y');
        $nextyear=date('Y', strtotime('+1 year'));

        $matter_genre = Config::get('list.matter_genre');
        $item_config=DB::table('configs')->where('id','1')->first();

        $url=url()->previous();
        $keys = parse_url($url); //パース処理
        $path = explode("/", $keys['path']); //分割処理
        $last = end($path); //最後の要素を取得
        $last = prev($path); //最後から一つ戻った要素を取得

        $matter_genre = Config::get('list.matter_genre');
        $follower = Config::get('list.follower');
        $matter_sns = Config::get('list.matter_sns');
        $term = Config::get('list.term');
        $deadline = Config::get('list.deadline');
        $notice = Config::get('list.notice');

        $param=[
            'year1'=>'',
            'month1'=>'',
            'date1'=>'',
            'year2'=>'',
            'month2'=>'',
            'date2'=>'',
            'shop_id'=>'',
            'shop_name'=>'',
            'shop_tantou'=>'',
            'shop_phone'=>'',
            'shop_area'=>'',
            'shop_address'=>'',
            'intro_text'=>'',
            'shop_url'=>'',
            'shop_close_date'=>'',
            'shop_open_time'=>'',
            'matter_num'=>'',
            'able_datetime'=>'',
            'able_time'=>'',
            'not_able_date'=>'',
            'least_follower'=>'',
            'reward'=>'',
            'serve_menu'=>'',
            'serve_value'=>'',
            'companion_num'=>'',
            'hashtag'=>'',
            'tag_account'=>'',
            'location'=>'',
            'post_deadline'=>'',
            'story_url'=>'',
        ];

        $send_param=[
            'param'=>$param,
            'post_conditions'=>['','','','',''],
            'post_conditions2'=>['','','','',''],
            'checkbox'=>[],
            'checkbox1'=>[],
            'checkbox2'=>[],
            'checkbox3'=>[],
            'matter_genre'=>$matter_genre,
            'follower'=>$follower,
            'matter_sns'=>$matter_sns,
            'term'=>$term,
            'deadline'=>$deadline,
            'notice'=>$notice,
            'filepath_list'=>[],
            'thisyear'=>$thisyear,
            'nextyear'=>$nextyear,
            'item_config'=>$item_config,
        ];

        if ($last===Config::get('const.title.title47')){
            return view(Config::get('const.title.title47').".create_matter", $send_param);
        }elseif ($last==="administrator"){
            return view("administrator.create_matter", $send_param);
        }else{
            return redirect('/');
        }
    }

    //案件作成確認画面へ
    public function create_matter(Request $request){
        $hidden=$request->hidden;
        if ($hidden==="client"){
            if (session()->has('shop_id')){
                $shop_id=session()->get("shop_id");

                $param=[
                    'year1'=>$request->year1,
                    'month1'=>$request->month1,
                    'date1'=>$request->date1,
                    'year2'=>$request->year2,
                    'month2'=>$request->month2,
                    'date2'=>$request->date2,
                    'shop_id'=>$shop_id,
                    'shop_name'=>$request->name,
                    'shop_tantou'=>$request->tantou,
                    'shop_phone'=>$request->tel01,
                    'shop_area'=>$request->area,
                    'shop_address'=>$request->address,
                    'shop_url'=>$request->shop_url,
                    'shop_close_date'=>$request->close_date,
                    'shop_open_time'=>$request->open_time,
                ];

                $send_param=[
                    'param'=>$param,
                ];
            }else{
                return redirect(Config::get('const.title.title47'));
            }
        }

        if ($hidden==="admin"){

            $item_config=DB::table('configs')
            ->where('id','1')->first();

            if (session()->has('manager_id')){
                $manager_id=session()->get("manager_id");
                $shop_id=$request->shop_id;

                $param=[
                    'year1'=>$request->year1,
                    'month1'=>$request->month1,
                    'date1'=>$request->date1,
                    'year2'=>$request->year2,
                    'month2'=>$request->month2,
                    'date2'=>$request->date2,
                    'shop_id'=>$shop_id,
                    'shop_name'=>$request->name,
                    'shop_tantou'=>$request->tantou,
                    'shop_phone'=>$request->tel01,
                    'shop_area'=>$request->area,
                    'shop_address'=>$request->address,
                    'intro_text'=>$request->intro_text,
                    'shop_url'=>$request->shop_url,
                    'shop_close_date'=>$request->close_date,
                    'shop_open_time'=>$request->open_time,
                    'matter_num'=>$request->matter_num,
                    'able_datetime'=>$request->able_datetime,
                    'able_time'=>$request->able_time,
                    'not_able_date'=>$request->not_able_date,
                    'least_follower'=>$request->selector1,
                    'reward'=>$request->reward,
                    'serve_menu'=>$request->menu,
                    'serve_value'=>$request->serve_value,
                    'companion_num'=>$request->companion_num,
                    'hashtag'=>$request->hashtag,
                    'tag_account'=>$request->tag_account,
                    'location'=>$request->location,
                    'post_deadline'=>$request->selector2,
                    'story_url'=>$request->story_url,
                ];


                $post_conditions=$request->input("post_conditions");
                $post_conditions2=$request->input("post_conditions2");
                $checkbox=$request->input("checkbox");
                $checkbox1=$request->input("checkbox1");
                $checkbox2=$request->input("checkbox2");
                $checkbox3=$request->input("checkbox3");
                $filepath=$request->input("filepath");

                $matter_genre = Config::get('list.matter_genre');
                $follower = Config::get('list.follower');
                $matter_sns = Config::get('list.matter_sns');
                $term = Config::get('list.term');
                $deadline = Config::get('list.deadline');
                $notice = Config::get('list.notice');

                //ランダムな文字列を生成する
                $rand_str = chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90)) .chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90));

                $files=$request->file('matter_img');
                $dir_path="public/matter_img/";
                $file_path="matter-$rand_str-$shop_id/";

                $filepath_list=[];
                if (!empty($files)){


                    if (file_exists($dir_path.$file_path)){
                        rmdir($dir_path.$file_path);
                    }

                    $i=1;
                    foreach ($files as $file){
                        if (!empty($file)){
                            $file_kari= $file->getClientOriginalName();
                            $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
                            $file_name="matter{$i}.{$extension}";


                            $file->storeAS('',$dir_path.$file_path.$file_name);
                            $filepath_list[$i]=$file_path.$file_name;

                            $i+=1;
                        }

                    }
                }elseif (!empty($filepath)){
                    $i=1;
                    foreach ($filepath as $file){
                        if (!empty($file)){
                            $filepath_list[$i]=$file;

                            $i+=1;
                        }

                    }
                }


                $send_param=[
                    'param'=>$param,
                    'post_conditions'=>$post_conditions,
                    'post_conditions2'=>$post_conditions2,
                    'checkbox'=>$checkbox,
                    'checkbox1'=>$checkbox1,
                    'checkbox2'=>$checkbox2,
                    'checkbox3'=>$checkbox3,
                    'files'=>$files,
                    'matter_genre'=>$matter_genre,
                    'follower'=>$follower,
                    'matter_sns'=>$matter_sns,
                    'term'=>$term,
                    'deadline'=>$deadline,
                    'notice'=>$notice,
                    'filepath_list'=>$filepath_list,
                ];
            }else{
                return redirect('administrator');
            }
        }








        if ($hidden==="client"){
            return view('client.create_matter_confirm',$send_param);
        }elseif ($hidden==="admin"){
            return view('administrator.create_matter_confirm',$send_param);
        }else{
            return redirect('/');
        }
    }
    //案件作成
    public function create_matter_confirm(Request $request){
        $hidden=$request->hidden;
        if ($hidden==="client"){
            if (session()->has('shop_id')){
                $shop_id=session()->get("shop_id");
            }else{
                return redirect(Config::get('const.title.title47'));
            }
        }

        if ($hidden==="admin"){
            if (session()->has('manager_id')){
                $manager_id=session()->get("manager_id");
                $shop_id=$request->shop_id;
            }else{
                return redirect('administrator');
            }
        }

        $item_config=DB::table('configs')
        ->where('id','1')->first();

        if ($request->has('submit1')){  //再入力

            $thisyear=date('Y');
            $nextyear=date('Y', strtotime('+1 year'));

            $item_config=DB::table('configs')->where('id','1')->first();

            $url=url()->previous();
            $keys = parse_url($url); //パース処理
            $path = explode("/", $keys['path']); //分割処理
            $last = end($path); //最後の要素を取得
            $last = prev($path); //最後から一つ戻った要素を取得

            if ($hidden==="client"){

                $param=[
                    'year1'=>$request->year1,
                    'month1'=>$request->month1,
                    'date1'=>$request->date1,
                    'year2'=>$request->year2,
                    'month2'=>$request->month2,
                    'date2'=>$request->date2,
                    'shop_id'=>$shop_id,
                    'shop_name'=>$request->name,
                    'shop_tantou'=>$request->tantou,
                    'shop_phone'=>$request->tel01,
                    'shop_area'=>$request->area,
                    'shop_address'=>$request->address,
                    'shop_url'=>$request->shop_url,
                    'shop_close_date'=>$request->close_date,
                    'shop_open_time'=>$request->open_time,
                ];

                $send_param=[
                    'param'=>$param,
                    'item_config'=>$item_config,
                    'thisyear'=>$thisyear,
                    'nextyear'=>$nextyear,
                ];

            }elseif ($hidden==="admin"){



                $param=[
                    'year1'=>$request->year1,
                    'month1'=>$request->month1,
                    'date1'=>$request->date1,
                    'year2'=>$request->year2,
                    'month2'=>$request->month2,
                    'date2'=>$request->date2,
                    'shop_id'=>$shop_id,
                    'shop_name'=>$request->name,
                    'shop_tantou'=>$request->tantou,
                    'shop_phone'=>$request->tel01,
                    'shop_area'=>$request->area,
                    'shop_address'=>$request->address,
                    'intro_text'=>$request->intro_text,
                    'shop_url'=>$request->shop_url,
                    'shop_close_date'=>$request->close_date,
                    'shop_open_time'=>$request->open_time,
                    'matter_num'=>$request->matter_num,
                    'able_datetime'=>$request->able_datetime,
                    'able_time'=>$request->able_time,
                    'not_able_date'=>$request->not_able_date,
                    'least_follower'=>$request->selector1,
                    'reward'=>$request->reward,
                    'serve_menu'=>$request->menu,
                    'serve_value'=>$request->serve_value,
                    'companion_num'=>$request->companion_num,
                    'hashtag'=>$request->hashtag,
                    'tag_account'=>$request->tag_account,
                    'location'=>$request->location,
                    'post_deadline'=>$request->selector2,
                    'story_url'=>$request->story_url,
                ];


                $post_conditions=$request->input("post_conditions");
                $post_conditions2=$request->input("post_conditions2");
                $checkbox=$request->input("checkbox");
                $checkbox1=$request->input("checkbox1");
                $checkbox2=$request->input("checkbox2");
                $checkbox3=$request->input("checkbox3");
                $filepath_list=$request->input("matter_img");

                $matter_genre = Config::get('list.matter_genre');
                $follower = Config::get('list.follower');
                $matter_sns = Config::get('list.matter_sns');
                $term = Config::get('list.term');
                $deadline = Config::get('list.deadline');
                $notice = Config::get('list.notice');

                // var_dump($filepath_list);
                // exit;


                $send_param=[
                    'param'=>$param,
                    'post_conditions'=>$post_conditions,
                    'post_conditions2'=>$post_conditions2,
                    'checkbox'=>$checkbox,
                    'checkbox1'=>$checkbox1,
                    'checkbox2'=>$checkbox2,
                    'checkbox3'=>$checkbox3,
                    'matter_genre'=>$matter_genre,
                    'follower'=>$follower,
                    'matter_sns'=>$matter_sns,
                    'term'=>$term,
                    'deadline'=>$deadline,
                    'notice'=>$notice,
                    'filepath_list'=>$filepath_list,
                    'item_config'=>$item_config,
                    'thisyear'=>$thisyear,
                    'nextyear'=>$nextyear,
                ];
            }

            if ($hidden==="client"){
                return view(Config::get('const.title.title47').'.create_matter',$send_param);
            }elseif ($hidden==="admin"){
                return view('administrator.create_matter',$send_param);
            }else{
                return redirect('/');
            }

        }elseif ($request->has('submit2')){  //登録

            //募集期間
            $year1=$request->year1;
            $month1=$request->month1;
            $date1=$request->date1;

            if (empty($year1)){
                $year1="2020";
            }
            if (empty($month1)){
                $month1="1";
            }
            if (empty($date1)){
                $date1="1";
            }

            $gather_before="{$year1}-{$month1}-{$date1}";

            $year2=$request->year2;
            $month2=$request->month2;
            $date2=$request->date2;

            if (empty($year2)){
                $year2=date('Y', strtotime('+1 year'));
            }
            if (empty($month2)){
                $month2="1";
            }
            if (empty($date2)){
                $date2="1";
            }

            $gather_after="{$year2}-{$month2}-{$date2}";

            if ($hidden==="client"){

                $param=[
                    'shop_id'=>$shop_id,
                    'shop_name'=>$request->name,
                    'shop_tantou'=>$request->tantou,
                    'shop_phone'=>$request->tel01,
                    'shop_area'=>$request->area,
                    'shop_address'=>$request->address,
                    'shop_url'=>$request->shop_url,
                    'shop_close_date'=>$request->close_date,
                    'shop_open_time'=>$request->open_time,
                    'flag'=>'0',
                ];

            }elseif ($hidden==="admin"){

                $param=[
                    'shop_id'=>$shop_id,
                    'shop_name'=>$request->name,
                    'shop_tantou'=>$request->tantou,
                    'shop_phone'=>$request->tel01,
                    'shop_area'=>$request->area,
                    'shop_address'=>$request->address,
                    'intro_text'=>$request->intro_text,
                    'shop_url'=>$request->shop_url,
                    'shop_close_date'=>$request->close_date,
                    'shop_open_time'=>$request->open_time,
                    'matter_num'=>$request->matter_num,
                    'gather_before'=>$gather_before,
                    'gather_after'=>$gather_after,
                    'able_datetime'=>$request->able_datetime,
                    'able_time'=>$request->able_time,
                    'not_able_date'=>$request->not_able_date,
                    'least_follower'=>$request->selector1,
                    'reward'=>$request->reward,
                    'serve_menu'=>$request->menu,
                    'serve_value'=>$request->serve_value,
                    'companion_num'=>$request->companion_num,
                    'hashtag'=>$request->hashtag,
                    'tag_account'=>$request->tag_account,
                    'location'=>$request->location,
                    'post_deadline'=>$request->selector2,
                    'flag'=>'0',
                ];

                if (!empty($request->story_url)){
                    $param['story_url']=$request->story_url;
                }

                // for ($i=1;$i<=3;$i++){
                //     if (!empty($request->{"dates$i"}) || !empty($request->{"weekday$i"})){
                //         $param["able_umu$i"]=$request->{"date_select$i"};
                //         $param["able_dates$i"]=$request->{"dates$i"};
                //         $param["able_weekday$i"]=$request->{"weekday$i"};
                //     }
                // }

                $post_conditions=$request->input("post_conditions");
                $post_conditions2=$request->input("post_conditions2");
                $checkbox=$request->input("checkbox");
                $checkbox1=$request->input("checkbox1");
                $checkbox2=$request->input("checkbox2");
                $checkbox3=$request->input("checkbox3");

                $matter_genre = Config::get('list.matter_genre');
                $matter_genre_count=count($matter_genre);

                for ($i=0;$i<$matter_genre_count;$i++){
                    if (!empty($checkbox[$i])){
                        $param[$checkbox[$i]]="T";
                    }
                }

                for ($i=0;$i<4;$i++){
                    if (!empty($checkbox1[$i])){
                        $param[$checkbox1[$i]]="T";
                    }
                }

                for ($i=0;$i<10;$i++){
                    if (!empty($checkbox2[$i])){
                        $check_name="term$checkbox2[$i]";
                        $param[$check_name]="T";
                    }
                }

                for ($i=0;$i<8;$i++){
                    if (!empty($checkbox3[$i])){
                        $check_name="notice$checkbox3[$i]";
                        $param[$check_name]="T";
                    }
                }

                $i=11;
                foreach ($post_conditions as $value){
                    if (!empty($value)){
                        $param["term$i"]=$value;

                    }else{
                        $param["term$i"]='F';
                    }
                    $i+=1;
                }

                $i=9;
                foreach ($post_conditions2 as $value){
                    if (!empty($value)){
                        $param["notice$i"]=$value;

                    }else{
                        $param["notice$i"]='F';
                    }
                    $i+=1;
                }

                //ランダムな文字列を生成する
                $rand_str = chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90)) .chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90));


                $files=$request->input("matter_img");
                $dir_path="public/matter_img/";
                $file_path="matter-$rand_str-$shop_id/";

                if (!empty($files)){

                    $i=1;
                    foreach ($files as $file){
                        if (!empty($file)){
                            // $file_kari= $file->getClientOriginalName();
                            // $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
                            // $file_name="matter{$i}.{$extension}";


                            // $file->storeAS('',$dir_path.$file_path.$file_name);
                            $param["matter_img$i"]=$file;

                            $i+=1;
                        }

                    }
                }
            }



            $flash_message='案件を作成しました。';
            DB::table('matters')->insert($param);

            if ($hidden==="client"){
                return redirect(Config::get('const.title.title47').'/main')->with('flash_message',$flash_message);
            }elseif ($hidden==="admin"){
                return redirect('administrator/matter')->with('msg',$flash_message);
            }else{
                return redirect('/');
            }
        }else{
            $flash_message='案件作成中に何らかのエラーが発生しました。';
            if ($hidden==="client"){
                return redirect(Config::get('const.title.title47').'/main')->with('flash_message',$flash_message);
            }elseif ($hidden==="admin"){
                return redirect('administrator/matter')->with('msg',$flash_message);
            }else{
                return redirect('/');
            }
        }
    }

    //運営側の案件修正
    public function admin_matter_edit(Request $request){

        $id=$request->hidden;

        $items=DB::table('matters')->where('id',$id)->select('shop_id')->first();
        $shop_id=$items->shop_id;

        $param=[
            'shop_name'=>$request->shop_name,
            'shop_tantou'=>$request->shop_tantou,
            'shop_phone'=>$request->shop_phone,
            'shop_area'=>$request->shop_area,
            'shop_address'=>$request->shop_address,
            'intro_text'=>$request->intro_text,
            'shop_url'=>$request->shop_url,
            'shop_close_date'=>$request->shop_close_date,
            'shop_open_time'=>$request->shop_open_time,
            'able_datetime'=>$request->able_datetime,
            'able_time'=>$request->able_time,
            'not_able_date'=>$request->not_able_date,
            'matter_num'=>$request->matter_num,
            'matter_name'=>$request->matter_name,
            'gather_before'=>$request->gather_before,
            'gather_after'=>$request->gather_after,
            'least_follower'=>$request->least_follower,
            'reward'=>$request->reward,
            'serve_menu'=>$request->serve_menu,
            'serve_value'=>$request->serve_value,
            'companion_num'=>$request->companion_num,
            'hashtag'=>$request->hashtag,
            'tag_account'=>$request->tag_account,
            'location'=>$request->location,
            'post_deadline'=>$request->post_deadline,
        ];

        if (!empty($request->story_url)){
            $param['story_url']=$request->story_url;
        }


        $post_conditions=$request->input("post_conditions");
        $post_conditions2=$request->input("post_conditions2");
        $checkbox=$request->input("checkbox");
        $checkbox1=$request->input("checkbox1");
        $checkbox2=$request->input("checkbox2");
        $checkbox3=$request->input("checkbox3");

        $matter_genre = Config::get('list.matter_genre');
        $matter_genre_count=count($matter_genre);

        $sns=[
            'instagram',
            'twitter',
            'youtube',
            'tiktok',
        ];

        //初期化
        for ($i=0;$i<4;$i++){
            $param[$sns[$i]]="F";
        }
        for ($i=1;$i<=$matter_genre_count;$i++){
            $param["matter_genre$i"]="F";
        }
        for ($i=1;$i<=10;$i++){
            $param["term$i"]="F";
        }
        for ($i=1;$i<=8;$i++){
            $param["notice$i"]="F";
        }

        for ($i=1;$i<=$matter_genre_count;$i++){
            if (!empty($checkbox[$i-1])){
                $param[$checkbox[$i-1]]="T";
            }
        }



        for ($i=0;$i<4;$i++){
            if (!empty($checkbox1[$i])){
                $param[$checkbox1[$i]]="T";
            }
        }



        for ($i=1;$i<=10;$i++){
            if (!empty($checkbox2[$i-1])){
                $param[$checkbox2[$i-1]]="T";
            }
        }

        for ($i=1;$i<=8;$i++){
            if (!empty($checkbox3[$i-1])){
                $param[$checkbox3[$i-1]]="T";
            }
        }

        $i=11;
        foreach ($post_conditions as $value){
            if (!empty($value)){
                $param["term$i"]=$value;

            }else{
                $param["term$i"]='F';
            }
            $i+=1;
        }

        $i=9;
        foreach ($post_conditions2 as $value){
            if (!empty($value)){
                $param["notice$i"]=$value;

            }else{
                $param["notice$i"]='F';
            }
            $i+=1;
        }

        //画像保存

        //ランダムな文字列を生成する
        $rand_str = chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90)) .chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90));

        $files=$request->file('matter_img');
        $dir_path="public/matter_img/";
        $file_path="matter-$rand_str-$shop_id/";

        $filepath_list=[];
        if (!empty($files)){

            if (file_exists($dir_path.$file_path)){
                rmdir($dir_path.$file_path);
            }

            $i=1;
            foreach ($files as $file){
                if (!empty($file)){
                    $file_kari= $file->getClientOriginalName();
                    $extension = pathinfo($file_kari, PATHINFO_EXTENSION);//拡張子のみ
                    $file_name="matter{$i}.{$extension}";


                    $file->storeAS('',$dir_path.$file_path.$file_name);
                    $param["matter_img$i"]=$file_path.$file_name;

                    $i+=1;
                }

            }
        }



        DB::table('matters')
        ->where('id',$id)
        ->update($param);

        $msgs="案件を編集しました。";

        return redirect("administrator/admin_matter_detail/{$id}")->with('msgs',$msgs);
    }

    //案件ステータスPOST処理
    public function question_form(Request $request){
        if (!session()->has('manager_id')){
            return redirect('administrator');
        }

        $hidden=$request->hidden;
        $id=$request->hidden_id;

        $item=DB::table('matters')->where('id',$id)->first();

        $flag=$item->flag;

        if ($hidden==="1"){  //診断書登録
            $param=[
                'survey'=>'T',
                'survey1'=>$request->survey1,
                'survey2'=>$request->survey2,
                'survey3'=>$request->survey3,
            ];

            if (!empty($request->survey4)){
                $param['survey4']=$request->survey4;
            }else{
                $param['survey4']='F';
            }

            DB::table('matters')->where('id',$id)
            ->update($param);

            return redirect("administrator/matter_member/{$id}/{$flag}")->with('msg','診断書を作成しました。');

        }elseif ($hidden==="2"){  //ステータス変更
            $radio=$request->radio;
            DB::table('matters')->where('id',$id)
            ->update(['flag'=>$radio]);

            return redirect("administrator/matter_member/{$id}/{$radio}")->with('msg','案件ステータスを変更しました。');

        }
    }


}
