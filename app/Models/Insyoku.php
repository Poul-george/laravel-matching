<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Insyoku extends Model
{
    use HasFactory;

    public static function edit_get_same($item) {
        //半角空白分割
        function extractKeywords(string $input, int $limit = -1): array
        {
            return preg_split('/ ++/', $input, $limit, PREG_SPLIT_NO_EMPTY);
        }

        //面談方法
        if (isset($item->interview_format)) {
            $interview_format = explode("/", $item->interview_format);
            array_pop($interview_format);
        }else {
            $interview_format = [];
        }

        $name = extractKeywords($item->tantou_name);
        $name_fri = extractKeywords($item->tantou_name_fri);
        $name1 = trim($name[0], " ");
        $name2 = trim($name[1]);
        $name_fri1 = trim($name_fri[0], " ");
        $name_fri2 = trim($name_fri[1]);
        $shop_name = $item->shop_name;
        $client_image = $item->client_image;
        $data =  [$name1,$name2,$name_fri1,$name_fri2,$shop_name,$client_image,$interview_format,];
        return $data;
    }

    //業種、業界、保有資格、％データベース配列にする
    public static function company_db_list_get($item) {
        //業種
        $relation_industry = [];
        for ($i = 1; $i <= 4; $i++) {
            $relation_industry_name = "relation_industry1_".$i;
            if (isset($item->$relation_industry_name)) {
                array_push($relation_industry, $item->$relation_industry_name);
            }else {
                array_push($relation_industry, "");
            }
        }
        
        //業種％
        $relation_industry_rate = [];
        for ($i = 1; $i <= 4; $i++) {
            $relation_industry_rate_name = "relation_industry_rate_1_".$i;
            if (isset($item->$relation_industry_rate_name)) {
                array_push($relation_industry_rate, $item->$relation_industry_rate_name);
            }else {
                array_push($relation_industry_rate, "");
            }
        }

        //業界
        $relation_industry2 = [];
        for ($i = 1; $i <= 4; $i++) {
            $relation_industry2_name = "relation_industry2_".$i;
            if (isset($item->$relation_industry2_name)) {
                array_push($relation_industry2, $item->$relation_industry2_name);
            }else {
                array_push($relation_industry2, "");
            }
        }
        
        //業界％
        $relation_industry_rate_2 = [];
        for ($i = 1; $i <= 4; $i++) {
            $relation_industry_rate_2_name = "relation_industry_rate_2_".$i;
            if (isset($item->$relation_industry_rate_2_name)) {
                array_push($relation_industry_rate_2, $item->$relation_industry_rate_2_name);
            }else {
                array_push($relation_industry_rate_2, "");
            }
        }

         //保有資格
         $company_qualification = [];
         for ($i = 1; $i <= 4; $i++) {
             $company_qualification_name = "company_qualification".$i;
             if (isset($item->$company_qualification_name)) {
                 array_push($company_qualification, $item->$company_qualification_name);
             }else {
                 array_push($company_qualification, "");
             }
         }
         
         //保有資格％
         $company_qualification_rate = [];
         for ($i = 1; $i <= 4; $i++) {
             $company_qualification_rate_name = "company_qualification_rate_".$i;
             if (isset($item->$company_qualification_rate_name)) {
                 array_push($company_qualification_rate, $item->$company_qualification_rate_name);
             }else {
                 array_push($company_qualification_rate, "");
             }
         }


         $lists =  [
            $relation_industry,
            $relation_industry_rate,
            $relation_industry2,
            $relation_industry_rate_2,
            $company_qualification,
            $company_qualification_rate
        ];
        return $lists;
    }

    //マッチングlist_title
    public static function matching_list_title_get() {
        $matching_title1_list=Config::get('test_list.sukil_title1');
        $matching_title2_list=Config::get('test_list.sukil_title2');
        $matching_title3_list=Config::get('test_list.sukil_title3');
        $matching_title4_list=Config::get('test_list.sukil_title4');
        $matching_title5_list=Config::get('test_list.user_conditions_title');

        $title_lists = [
            $matching_title1_list,
            $matching_title2_list,
            $matching_title3_list,
            $matching_title4_list,
            $matching_title5_list,
        ];

        return $title_lists;
    }

    //マッチングlist
    public static function matching_list_get() {
        //半角空白分割
         // posi

         $experience_position1_list=Config::get('test_list.experience_position1');
         $experience_position2_list=Config::get('test_list.experience_position2');
         $experience_position3_list=Config::get('test_list.experience_position3');
         $experience_position4_list=Config::get('test_list.experience_position4');
         $experience_position5_list=Config::get('test_list.experience_position5');
         $experience_position6_list=Config::get('test_list.experience_position6');
         $experience_position7_list=Config::get('test_list.experience_position7');
        /////////     

         //skill
         $experience_skill1_list=Config::get('test_list.experience_skill1');
         $experience_skill2_list=Config::get('test_list.experience_skill2');
         $experience_skill3_list=Config::get('test_list.experience_skill3');
         $experience_skill4_list=Config::get('test_list.experience_skill4');
         $experience_skill5_list=Config::get('test_list.experience_skill5');
         $experience_skill6_list=Config::get('test_list.experience_skill6');
         $experience_skill7_list=Config::get('test_list.experience_skill7');
         $experience_skill8_list=Config::get('test_list.experience_skill8');
         $experience_skill9_list=Config::get('test_list.experience_skill9');
         $experience_skill10_list=Config::get('test_list.experience_skill10');
         /////////

         //業界
         $experience_industry1_list=Config::get('test_list.experience_industry1');
         $experience_industry2_list=Config::get('test_list.experience_industry2');
         $experience_industry3_list=Config::get('test_list.experience_industry3');
        /////

         //工程,テクノロジー
         $experience_technology_list=Config::get('test_list.experience_technology');
         $experience_process_list=Config::get('test_list.experience_process');
         ////////


         //その他、特徴
         $project_type=Config::get('test_list.project_type');
         $development_environment=Config::get('test_list.development_environment');
         $work_type=Config::get('test_list.work_type');
         $work_environment=Config::get('test_list.work_environment');
         $development_scale=Config::get('test_list.development_scale');
         $work_feature=Config::get('test_list.work_feature');
         $dress=Config::get('test_list.dress');
         $working_hours=Config::get('test_list.working_hours');
         $workdays=Config::get('test_list.workdays');
         ////////
        


        $lists = [
            //
            $experience_position1_list, 
            $experience_position2_list, 
            $experience_position3_list, 
            $experience_position4_list, 
            $experience_position5_list, 
            $experience_position6_list, 
            $experience_position7_list,
            
            $experience_skill1_list, 
            $experience_skill2_list, 
            $experience_skill3_list, 
            $experience_skill4_list, 
            $experience_skill5_list, 
            $experience_skill6_list, 
            $experience_skill7_list, 
            $experience_skill8_list, 
            $experience_skill9_list, 
            $experience_skill10_list,
            //
            $experience_industry1_list,
            $experience_industry2_list,
            $experience_industry3_list,

            $experience_technology_list,
            $experience_process_list,
            //
            $project_type,
            $development_environment,
            $work_type,
            $work_environment,
            $development_scale,
            $work_feature,
            $dress,
            $working_hours,
            $workdays,
        ];
        return $lists;
    }


    //マッチングスキルのデータベース保存配列
    public static function matching_skill_lists_db_get($item) {

        //マッチングポジション
        $matching_positions = [];
        foreach ($item as $list) {
            $matching_position = [];

            for ($i = 1; $i <= 3;$i++) {
                $matching_position_name = "matching_position".$i;
                if ($list->$matching_position_name !== null) {
                    array_push($matching_position, $list->$matching_position_name);
                } 
            }
            array_push($matching_positions, $matching_position);
        }
        // var_dump($matching_positions);
        
        // //マッチングスキル
        $matching_skills = [];
        foreach ($item as $list) {
            $matching_skill = [];

            for ($i = 1; $i <= 7;$i++) {
                $matching_skill_name = "matching_skill".$i;
                if ($list->$matching_skill_name !== null) {
                    array_push($matching_skill, $list->$matching_skill_name);
                } 
            }
            array_push($matching_skills, $matching_skill);
        }
        // var_dump($matching_skills);
        
        // //マッチング業界
        $matching_industrys = [];
        foreach ($item as $list) {
            $matching_industry = [];

            for ($i = 1; $i <= 3;$i++) {
                $matching_industry_name = "matching_industry".$i;
                if ($list->$matching_industry_name !== null) {
                    array_push($matching_industry, $list->$matching_industry_name);
                } 
            }
            array_push($matching_industrys, $matching_industry);
        }


        $matching_check_lists = [
            $matching_positions,
            $matching_skills,
            $matching_industrys,
            // $matching_technology_prosess_sonota,
        ];

        return $matching_check_lists;
    }

    //データベースマッチングチェック 詳細
    public static function one_matching_skill_lists_db_get($item) {

        //マッチングポジション
        $matching_position = [];
        for ($i = 1; $i <= 3;$i++) {
            $matching_position_name = "matching_position".$i;
            if ($item->$matching_position_name !== null) {
                array_push($matching_position, $item->$matching_position_name);
            } 
        }
        
        // //マッチングスキル
        $matching_skill = [];
        for ($i = 1; $i <= 7;$i++) {
            $matching_skill_name = "matching_skill".$i;
            if ($item->$matching_skill_name !== null) {
                array_push($matching_skill, $item->$matching_skill_name);
            } 
        }
        
        // //マッチング業界
        $matching_industry = [];
        for ($i = 1; $i <= 3;$i++) {
            $matching_industry_name = "matching_industry".$i;
            if ($item->$matching_industry_name !== null) {
                array_push($matching_industry, $item->$matching_industry_name);
            } 
        }

        //マッチングテクノロジー
        $matching_technology = [];
        for ($i = 1; $i <= 3;$i++) {
            $matching_technology_name = "matching_technology".$i;
            if ($item->$matching_technology_name !== null) {
                array_push($matching_technology, $item->$matching_technology_name);
            } 
        }
        //マッチング工程
        $matching_prosess = [];
        for ($i = 1; $i <= 5;$i++) {
            $matching_prosess_name = "matching_prosess".$i;
            if ($item->$matching_prosess_name !== null) {
                array_push($matching_prosess, $item->$matching_prosess_name);
            } 
        }

        //マッチングその他
        $matching_sonota = [];
        for ($i = 1; $i <= 20;$i++) {
            $matching_sonota_name = "matching_sonota".$i;
            if ($item->$matching_sonota_name !== null) {
                array_push($matching_sonota, $item->$matching_sonota_name);
            } 
        }

        //配列結合
        $matching_technology_prosess_sonota =array_merge($matching_technology, $matching_prosess);
        $matching_technology_prosess_sonota =array_merge($matching_technology_prosess_sonota, $matching_sonota);

        $matching_check_lists = [
            $matching_position,
            $matching_skill,
            $matching_industry,
            $matching_technology_prosess_sonota,
        ];

        return $matching_check_lists;
    }


    //人材の経験スキルlist取得
    public static function apply_user_experience_skill_get($item) {
        //経験ポジション
        $experience_positions = [];
        foreach ($item as $list) {

            $experience_position = [];
            if ($list->experience_position !== null) {
                $experience_position = explode("/", $list->experience_position);
                array_pop($experience_position);
            } elseif ($list->experience_position === null) {
                $experience_position = [];
            }
            array_push($experience_positions, $experience_position);
        }
        // var_dump($experience_positions);

        //経験スキル
        $experience_skills = [];
        foreach ($item as $list) {

            $experience_skill = [];
            if ($list->experience_skill !== null) {
                $experience_skill = explode("/", $list->experience_skill);
                array_pop($experience_skill);
            } elseif ($list->experience_skill === null) {
                $experience_skill = [];
            }
            array_push($experience_skills, $experience_skill);
        }
        // var_dump($experience_skills);

        //経験スキル
        $experience_industrys = [];
        foreach ($item as $list) {

            $experience_industry = [];
            if ($list->experience_industry !== null) {
                $experience_industry = explode("/", $list->experience_industry);
                array_pop($experience_industry);
            } elseif ($list->experience_industry === null) {
                $experience_industry = [];
            }
            array_push($experience_industrys, $experience_industry);
        }
        // var_dump($experience_industrys);


        $experience_check_lists = [
            $experience_positions,
            $experience_skills,
            $experience_industrys,
        ];

        return $experience_check_lists;
    }
        
    
    // 未読メッセージ数取得 (新着メッセージ数)
    public static function new_messages_alert($shop_id) {
        $mg_new_messages = DB::table('mg_message')->where('delete_flag','0')->where('destination_shop_id',$shop_id)->where('show_flag','0')->get();
        $new_messages = DB::table('message')->where('delete_flag','0')->where('destination_id',$shop_id)->where('show_flag','0')->get();
        $new_messages = count($new_messages) + count($mg_new_messages);

        return $new_messages;
    }
}
