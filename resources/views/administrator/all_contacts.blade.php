<?php
  $contacts_select_submit = session()->get('manager_id');
      $search_word = session()->get('contacts_search_word');
?>

<?php


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('css/form.css')}}"> 
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/main.css')}}"> 
        <link href="{{ asset('/css/administrator.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>契約情報</title>
    </head>

    <style>
      .main_div {
        margin: 0;
      }
      .search_word_submit {
        height: auto;
      }
      .administrator_account_info_div {
          background: #fff;
      }
      .administrator_account_create_p {
        font-size: 14px;
        color: rgb(50, 50, 50);
        width: 100px;
        margin-left: auto;
      }
      .administrator_account_create_a {
        margin: 0 40px 10px;
        display: block;
      }
      .search_none_p {
        font-size: 14px;
        text-align: center;
        margin:20px;
      }
      .black_href {
        text-decoration-color: rgb(50,50,50);
      }
      .mypage_edit_url_ul {
        padding:10px;
      }
      .not_disclosure_p {
        text-align: center;
        margin: 10px 0 -10px;
        font-size: 14px;
        color: rgb(50, 50, 50);
      }
      @media screen and (max-width: 799px) {
        .administrator_account_create_p {
          font-size: 12px;
          width: 85px;
        }
        .administrator_account_create_a {
          margin: 0 10px 10px;
          display: block;
        }
        .search_none_p {
        font-size: 12px;
        }
      }
      .btn, .apply_submit, a.btn, button.btn {
        color: #fff;
      }
      .edit_form_div {
          margin: 15px 0 40px;
      }
    </style>

    <body>
        @include('administrator.component.administrator_left')
        <div class="main_div" id="main_div">
            @include('administrator.component.administrator_header')
            @if (session('msgs')) 
              <p class="msg_center">{{session('msgs')}}</p> 
            @endif
              <div class="top_title">
                <h3 class="title">契約管理</h3>
              </div>

              <div class="administrator_account_div">

                <div class="edit_form_div search_from_div">
                  <p class="judge_issue_sub_p">契約検索</p>
                  <div class="input_caution_div ">
                    <div class="input_caution_flex_div ">
                      <p class="input_caution_p">契約ID、案件ID、企業_id、企業名で検索ができます。</p>
                    </div>
                  </div>
                  <form method="POST" action="" enctype="multipart/form-data">
                  @csrf
                    <div class="word_search_div">
                        <input id="" class="input_text max_input_text"  type="text" name="search_word" value="{{$search_word}}" >
                        <input class="search_word_submit" name="search_word_submit" type="submit" value="検索">
                      </div>
                  </form>
                </div>

                @include('administrator.component.administrator_change_result')

              <div class="administrator_account_title_div">
                <div class="administrator_account_one_div administrator_id">
                  <p class="administrator_account_title_p">契約ID</p>
                </div>
                
                <div class="administrator_account_one_div administrator_name">
                  <p class="administrator_account_title_p">案件ID</p>
                </div>
                
                <div class="administrator_account_one_div administrator_phone">
                  <p class="administrator_account_title_p">契約満了日</p>
                </div>
                
                <div class="purasu_icon_admin_title_div"></div>
              </div>

              @if (count($contacts_item) !== 0)
                @foreach ($contacts_item as $one_item)

                <?php
                  $one_item_judge = "";
                  $over_time="";
                  $three_month_Date = new DateTime(date("{$one_item->contract_expiration_3month}"));

                  $todayDate = new DateTime(date("Y-m-d"));
                  $intvl = $three_month_Date->diff($todayDate);

                  $payment_term_Date = new DateTime(date("{$one_item->payment_term}"));


                  //契約満了
                  if ($three_month_Date <= $todayDate){
                    //3monthが今日を含む過去
                    if ($one_item->payment_judge == null && $one_item->user_judge == '0') {
                        //未払い：未人材確認
                        $one_item_judge = "1";
                    }
                  }

                  //人材非稼働
                  if ($three_month_Date <= $todayDate){
                    //3monthが今日を含む過去
                    if ($one_item->payment_judge == null && $one_item->user_judge == '1') {
                        //未払い：未人材確認
                        $one_item_judge = "2";
                    }
                  }
                  
                  //未払い
                  if ($three_month_Date <= $todayDate){
                    //3monthが今日を含む過去
                    if ($one_item->payment_judge == null && $one_item->user_judge == '2') {
                        //未払い：未人材確認
                        $one_item_judge = "3";
                    }
                  }
                  
                  //支払完了
                  if ($three_month_Date <= $todayDate){
                    //3monthが今日を含む過去
                    if ($one_item->payment_judge == '1' && $one_item->user_judge == '2') {
                        //未払い：未人材確認
                        $one_item_judge = "4";
                    }
                  }


                  //契約満了：未払：未人材確認１週間経過
                  $over_time="";
                  if ($three_month_Date <= $todayDate){
                    //3monthが今日を含む過去
                    if ($one_item->payment_judge == null && $one_item->user_judge == '0') {
                      //未払い：未人材確認
                      $one_week_progress = date("Y-m-d",strtotime($one_item->contract_expiration_3month . "+1 week"));
                      if ($one_week_progress <= date("Y-m-d")) {
                          //１週間けいか
                          $over_time="1";
                      }
                    }
                  }

                  if ($one_item->payment_judge == null) {
                      //支払期限超過
                      if ($payment_term_Date <= $todayDate){
                          $over_time="2";
                      }
                  }
                ?>

                  @if ($one_item_judge == '1')
                    @if ($over_time == "1")
                      <p class="not_disclosure_p">人材稼働確認が１週間以上行われていません。</p>
                    @endif
                    <div class="administrator_account_info_div" style="background:#FFABCE">
                  @elseif ($one_item_judge == '2')
                    <div class="administrator_account_info_div" style="background: rgb(220, 220, 220);">
                  @elseif ($one_item_judge == '3')
                    @if ($over_time == "2")
                      <p class="not_disclosure_p">支払期限超過</p>
                    @endif
                    <div class="administrator_account_info_div" style="background: #AAFFFF">
                  @elseif ($one_item_judge == '4')
                    <div class="administrator_account_info_div" style="background: #93FFAB">
                  @else
                    <div class="administrator_account_info_div">
                  @endif

                      <div class="administrator_account_one_div administrator_id">
                        <a class="black_href" href="{{ asset(config('const.title.title49'))}}/contacts_detail/{{$one_item->id}}">
                          <p class="administrator_account_info_p">{{$one_item->contacts_id}}</p>
                        </a>
                      </div>
                      
                      <div class="administrator_account_one_div administrator_name">
                        <a class="black_href" href="{{ asset(config('const.title.title49'))}}/issue_detail/{{$one_item->issue_id}}">
                          <p class="administrator_account_info_p">{{$one_item->issue_id}}</p>
                        </a>
                      </div>
                      
                      <div class="administrator_account_one_div administrator_phone">
                        <p class="administrator_account_info_p">{{$one_item->contract_expiration_3month}}</p>
                      </div>
                      <div class="purasu_icon_admin">＋</div>
                      <div class="administrator_account_one_div administrator_delete delete_block_wrap">
                        <form method="POST" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit_delete()">
                          @csrf
                          <input class="administrator_account_d_sub" type="submit" name="submit_d" value="削除">
                          <input class="" type="hidden" name="delete_num" value="{{$one_item->id}}">
                        </form>
                      </div>
                    </div>
                @endforeach
              @else
                <p class="search_none_p">検索結果がありません。</p>
              @endif
            

            </div>

            @if (count($contacts_item) !== 0)
            <div class="pagination_div">
                <div class="pagination_ul_div">
                    <ul class="pagination">
                        @if ($prev == 0)
                            <li class="disabled pagination_li" aria-disabled="true">前のページ</li>
                        @else
                            <li class="pagination_li not_disabled"><a rel="prev" href="{{ asset(config('const.title.title49'))}}/all_contacts?page={{$prev}}" class="btn prev_next_btn">前のページ</a></li>
                        @endif

                        @if ($next !== 0)
                            <li class="pagination_li not_disabled"><a rel="next" href="{{ asset(config('const.title.title49'))}}/all_contacts?page={{$next}}" class="btn prev_next_btn">次のページ</a></li>
                        @else
                            <li class="disabled pagination_li" aria-disabled="true">次のページ</li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif


        </div>

    </body>
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/main_page.js')}}"></script> -->
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>