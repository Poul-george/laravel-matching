<?php

namespace App\Models;
use Illuminate\Support\Facades\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Influ extends Model
{

    public static function edit_get_same($item) {
        //半角空白分割
        function extractKeywords(string $input, int $limit = -1): array
        {
            return preg_split('/ ++/', $input, $limit, PREG_SPLIT_NO_EMPTY);
        }
        $name = extractKeywords($item->user_name);
        $name_fri = extractKeywords($item->user_furigana);
        $name1 = trim($name[0], " ");
        $name2 = trim($name[1]);
        $name_fri1 = trim($name_fri[0], " ");
        $name_fri2 = trim($name_fri[1]);
        $user_image = $item->user_image;

        $data = [$name1,$name2,$name_fri1,$name_fri2,$user_image];
        return $data;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function skill_list_get() {
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
       $qualifications_held_list=Config::get('form_list.qualifications_held');
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
          $qualifications_held_list,
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

    //skill_title
    public static function skill_title_get() {
        $sukil_title1_list=Config::get('form_list.sukil_title1');
        $sukil_title2_list=Config::get('form_list.sukil_title2');
        $sukil_title3_list=Config::get('form_list.sukil_title3');

        $skill_lists = [
            $sukil_title1_list,
            $sukil_title2_list,
            $sukil_title3_list,
        ];

        return $skill_lists;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //希望スキルのデータベース保存配列
    public static function desired_skill_lists_db_get($item) {

        //経験ポジション
        $desired_position = [];
        for ($i = 1; $i <= 3;$i++) {
            $desired_position_name = "desired_position".$i;
            if ($item->$desired_position_name !== null) {
                array_push($desired_position, $item->$desired_position_name);
            } 
        }
        
        //経験スキル
        $desired_skill = [];
        for ($i = 1; $i <= 7;$i++) {
            $desired_skill_name = "desired_skill".$i;
            if ($item->$desired_skill_name !== null) {
                array_push($desired_skill, $item->$desired_skill_name);
            } 
        }
        
        //経験業界
        $desired_industry = [];
        for ($i = 1; $i <= 3;$i++) {
            $desired_industry_name = "desired_industry".$i;
            if ($item->$desired_industry_name !== null) {
                array_push($desired_industry, $item->$desired_industry_name);
            } 
        }
        
        //経験テクノロジー
        $desired_technology = [];
        for ($i = 1; $i <= 3;$i++) {
            $desired_technology_name = "desired_technology".$i;
            if ($item->$desired_technology_name !== null) {
                array_push($desired_technology, $item->$desired_technology_name);
            } 
        }
        
        //経験工程
        $desired_process = [];
        for ($i = 1; $i <= 5;$i++) {
            $desired_process_name = "desired_process".$i;
            if ($item->$desired_process_name !== null) {
                array_push($desired_process, $item->$desired_process_name);
            } 
        }

        //配列結合
        $desired_technology_prosess =array_merge($desired_technology, $desired_process);


        $desired_check_lists = [
            $desired_position,
            $desired_skill,
            $desired_industry,
            $desired_technology_prosess
        ];

        return $desired_check_lists;
    }

    //経験スキルのデータベース保存配列////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function skill_lists_db_get($item) {

        //経験ポジション
        $experience_position = [];
        if ($item->experience_position !== null) {
            $experience_position = explode("/", $item->experience_position);
            array_pop($experience_position);
        } elseif ($item->experience_position === null) {
            $experience_position = [];
        }

        //経験スキル
        $experience_skill = [];
        if ($item->experience_skill !== null) {
            $experience_skill = explode("/", $item->experience_skill);
            array_pop($experience_skill);
        } elseif ($item->experience_skill === null) {
            $experience_skill = [];
        }

        //経験業界
        $experience_industry = [];
        if ($item->experience_industry !== null) {
            $experience_industry = explode("/", $item->experience_industry);
            array_pop($experience_industry);
        } elseif ($item->experience_industry === null) {
            $experience_industry = [];
        }

        //経験テクノロジー
        $experience_technology = [];
        if ($item->experience_technology !== null) {
            $experience_technology = explode("/", $item->experience_technology);
            array_pop($experience_technology);
        } elseif ($item->experience_technology === null) {
            $experience_technology = [];
        }

        //経験工程
        $experience_process = [];
        if ($item->experience_process !== null) {
            $experience_process = explode("/", $item->experience_process);
            array_pop($experience_process);
        } elseif ($item->experience_process === null) {
            $experience_process = [];
        }

        //保有資格
        $qualifications_held = [];
        if ($item->qualifications_held !== null) {
            $qualifications_held = explode("/", $item->qualifications_held);
            array_pop($qualifications_held);
        } elseif ($item->qualifications_held === null) {
            $qualifications_held = [];
        }

        //配列結合
        $experience_technology_prosess =array_merge($experience_technology, $experience_process);

        $experience_check_lists = [
            $experience_position,
            $experience_skill,
            $experience_industry,
            $experience_technology_prosess,
            $qualifications_held,
        ];

        return $experience_check_lists;
    }

    //希望条件配列////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function desired_lists_db_get($item) {

        //ymd
        if (isset($item->interview_place)) {
            $kadou_kaisibi = explode("/", $item->kadou_kaisibi);
            $kadou_kaisibi_y = $kadou_kaisibi[0];
            $kadou_kaisibi_m = $kadou_kaisibi[1];
            $kadou_kaisibi_d = $kadou_kaisibi[2];
        } else {
            $kadou_kaisibi_y = "";
            $kadou_kaisibi_m = "";
            $kadou_kaisibi_d = "";
        }

        //面談方法
        if (isset($item->interview_place)) {
            $interview_place = explode("/", $item->interview_place);
            array_pop($interview_place);
        }else {
            $interview_place = [];
        }

        //優先順位
        $priority = [];
        for ($i = 1; $i <= 4; $i++) {
            $priority_name = "desired_priority".$i;
            if (isset($item->$priority_name)) {
                array_push($priority, $item->$priority_name);
            }else {
                array_push($priority, "");
            }
        }

        //希望金額
        $desired_money = [];
        for ($i = 1; $i <= 2; $i++) {
            $desired_money_name = "desired_money".$i;
            if (isset($item->$desired_money_name)) {
                array_push($desired_money, $item->$desired_money_name);
            }else {
                array_push($desired_money, $item->$desired_money_name);
            }
        }

        //希望契約形態
        $desired_contract_form = [];
        for ($i = 1; $i <= 5; $i++) {
            $desired_contract_form_name = "desired_contract_form".$i;
            if (isset($item->$desired_contract_form_name)) {
                array_push($desired_contract_form, $item->$desired_contract_form_name);
            }else {
                array_push($desired_contract_form, "");
            }
        }

        $item_list = [
            $kadou_kaisibi_y,
            $kadou_kaisibi_m,
            $kadou_kaisibi_d,
            $priority,//
            $interview_place,
            $desired_money,
            $desired_contract_form,//
        ];

        return $item_list;

    }

    //こだわり条件配列////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function user_conditions_db($item) {

        $desired_sonota = [];
        for ($i = 1; $i <= 3;$i++) {
            $desired_sonota_name = "desired_sonota".$i;
            if ($item->$desired_sonota_name !== null) {
                array_push($desired_sonota, $item->$desired_sonota_name);
            } 
        }


        return $desired_sonota;

    }

    ///こだわり条件list////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function user_conditions_list_get() {
        $user_conditions1_list=Config::get('form_list.project_type');
        $user_conditions2_list=Config::get('form_list.development_environment');
        $user_conditions3_list=Config::get('form_list.work_type');
        $user_conditions4_list=Config::get('form_list.work_environment');
        $user_conditions5_list=Config::get('form_list.development_scale');
        $user_conditions6_list=Config::get('form_list.work_feature');
        $user_conditions7_list=Config::get('form_list.dress');
        $user_conditions8_list=Config::get('form_list.working_hours');
        $user_conditions9_list=Config::get('form_list.workdays');

        $user_conditions_title=Config::get('form_list.user_conditions_title');

        $user_conditions_list = [
            $user_conditions1_list,
            $user_conditions2_list,
            $user_conditions3_list,
            $user_conditions4_list,
            $user_conditions5_list,
            $user_conditions6_list,
            $user_conditions7_list,
            $user_conditions8_list,
            $user_conditions9_list,
        ];

        $user_conditions = [
            $user_conditions_list,
            $user_conditions_title,
        ];

        return $user_conditions;
        // return $ogn;
    }

    //希望スキルtestlist
    public static function test_skill_list_get() {
        //半角空白分割
         // checkbox_list
         $experience_position1_list=Config::get('test_list.experience_position1');
         $experience_position2_list=Config::get('test_list.experience_position2');
         $experience_position3_list=Config::get('test_list.experience_position3');
         $experience_position4_list=Config::get('test_list.experience_position4');
         $experience_position5_list=Config::get('test_list.experience_position5');
         $experience_position6_list=Config::get('test_list.experience_position6');
         $experience_position7_list=Config::get('test_list.experience_position7');
        /////////
        $experience_position_list = [
            $experience_position1_list, 
            $experience_position2_list, 
            $experience_position3_list, 
            $experience_position4_list, 
            $experience_position5_list, 
            $experience_position6_list, 
            $experience_position7_list
        ];        

         //
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
         $experience_skill = [
             $experience_skill1_list, 
             $experience_skill2_list, 
             $experience_skill3_list, 
             $experience_skill4_list, 
             $experience_skill5_list, 
             $experience_skill6_list, 
             $experience_skill7_list, 
             $experience_skill8_list, 
             $experience_skill9_list, 
             $experience_skill10_list
        ];

         //
         $experience_industry1_list=Config::get('test_list.experience_industry1');
         $experience_industry2_list=Config::get('test_list.experience_industry2');
         $experience_industry3_list=Config::get('test_list.experience_industry3');
        /////
        $experience_industry = [
            $experience_industry1_list,
            $experience_industry2_list,
            $experience_industry3_list,
        ];

         //
         $experience_technology_list=Config::get('test_list.experience_technology');
         $experience_process_list=Config::get('test_list.experience_process');
         $qualifications_held_list=Config::get('test_list.qualifications_held');

        $lists = [
            //
            $experience_position1_list, 
            $experience_position2_list, 
            $experience_position3_list, 
            $experience_position4_list, 
            $experience_position5_list, 
            $experience_position6_list, 
            $experience_position7_list,
            //
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
            $qualifications_held_list,
        ];
        return $lists;
    }


    ///こだわり条件list_test////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function test_user_conditions_list_get() {
        $user_conditions1_list=Config::get('test_list.project_type');
        $user_conditions2_list=Config::get('test_list.development_environment');
        $user_conditions3_list=Config::get('test_list.work_type');
        $user_conditions4_list=Config::get('test_list.work_environment');
        $user_conditions5_list=Config::get('test_list.development_scale');
        $user_conditions6_list=Config::get('test_list.work_feature');
        $user_conditions7_list=Config::get('test_list.dress');
        $user_conditions8_list=Config::get('test_list.working_hours');
        $user_conditions9_list=Config::get('test_list.workdays');

        $user_conditions_title=Config::get('test_list.user_conditions_title');

        $user_conditions_list = [
            $user_conditions1_list,
            $user_conditions2_list,
            $user_conditions3_list,
            $user_conditions4_list,
            $user_conditions5_list,
            $user_conditions6_list,
            $user_conditions7_list,
            $user_conditions8_list,
            $user_conditions9_list,
        ];

        $user_conditions = [
            $user_conditions_list,
            $user_conditions_title,
        ];

        return $user_conditions;
        // return $ogn;
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



    //////////////////////////////////////////////////////////////////////
    // 企業詳細　％
    public static function company_rate_list($item) {

        $relation_industry1 = [];
        $relation_industry2 = [];
        $company_qualification = [];
        
        $relation_industry_rate_1 = [];
        $relation_industry_rate_2 = [];
        $company_qualification_rate_1 = [];

        //title配列
        for ($i = 1;$i <= 4;$i++) {
            $relation_industry1_name = "relation_industry1_".$i;
            $relation_industry_rate_1_name = "relation_industry_rate_1_".$i;
            if ($item->$relation_industry1_name !== NULL) {
                array_push($relation_industry1, $item->$relation_industry1_name);
            }
            if ($item->$relation_industry_rate_1_name !== NULL) {
                array_push($relation_industry_rate_1, $item->$relation_industry_rate_1_name);
            }
        }
        if (count($relation_industry1) == 0) {
            $relation_industry_rate_1 = [];
        }

        ///////
        for ($i = 1;$i <= 4;$i++) {
            $relation_industry2_name = "relation_industry2_".$i;
            $relation_industry_rate_2_name = "relation_industry_rate_2_".$i;
            if ($item->$relation_industry2_name !== NULL) {
                array_push($relation_industry2, $item->$relation_industry2_name);
            }
            if ($item->$relation_industry_rate_2_name !== NULL) {
                array_push($relation_industry_rate_2, $item->$relation_industry_rate_2_name);
            }
        }
        if (count($relation_industry2) == 0) {
            $relation_industry_rate_2 = [];
        }

        ////////
        for ($i = 1;$i <= 4;$i++) {
            $company_qualification_name = "company_qualification".$i;
            $company_qualification_rate_1_name = "company_qualification_rate_".$i;
            if ($item->$company_qualification_name !== NULL) {
                array_push($company_qualification, $item->$company_qualification_name);
            }
            if ($item->$company_qualification_rate_1_name !== NULL) {
                array_push($company_qualification_rate_1, $item->$company_qualification_rate_1_name);
            }
        }
        if (count($company_qualification) == 0) {
            $company_qualification_rate_1 = [];
        }

        //レートの合計
        $rate_1 = 0;
        $rate_2 = 0;
        $rate_3 = 0;
        foreach ($relation_industry_rate_1 as $rate) {
           $rate_1 = $rate_1 +  intval($rate);
        }
        foreach ($relation_industry_rate_2 as $rate) {
           $rate_2 = $rate_2 +  intval($rate);
        }
        foreach ($company_qualification_rate_1 as $rate) {
           $rate_3 = $rate_3 +  intval($rate);
        }

        $lists = [
            $relation_industry1,
            $relation_industry2,
            $company_qualification,
            
            $relation_industry_rate_1,
            $relation_industry_rate_2,
            $company_qualification_rate_1,

            $rate_1,
            $rate_2,
            $rate_3,
        ];

        return $lists;
    }


    // 未読メッセージ数取得 (新着メッセージ数)
    public static function new_messages_alert($user_id) {
        $new_messages = DB::table('message')->where('delete_flag','0')->where('destination_id',$user_id)->where('show_flag','0')->get();
        $new_messages = count($new_messages);

        return $new_messages;
    }


}
