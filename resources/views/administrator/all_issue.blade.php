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
        <title>案件情報</title>
    </head>

    <style>
      .main_div {
        margin: 0;
      }
      .not_disclosure_p {
        text-align: center;
        margin: 10px 0 -10px;
        font-size: 14px;
        color: rgb(50, 50, 50);
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

    <?php
      $search_word = session()->get('issue_search_word');
    ?>

    <body>
        @include('administrator.component.administrator_left')
        <div class="main_div" id="main_div">
            @include('administrator.component.administrator_header')
            @if (session('msgs')) 
              <p class="msg_center">{{session('msgs')}}</p> 
            @endif
              <div class="top_title">
                <h3 class="title">案件管理</h3>
              </div>

              <div class="administrator_account_div">

                <div class="edit_form_div search_from_div">
                  <p class="judge_issue_sub_p">案件検索</p>
                  <div class="input_caution_div ">
                    <div class="input_caution_flex_div ">
                      <p class="input_caution_p">企業id、会社名、案件名で検索ができます。</p>
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

              <div class="administrator_account_title_div">
                <div class="administrator_account_one_div administrator_id">
                  <p class="administrator_account_title_p">matter_name</p>
                </div>
                
                <div class="administrator_account_one_div administrator_name">
                  <p class="administrator_account_title_p">company_name</p>
                </div>
                
                <div class="administrator_account_one_div administrator_phone">
                  <p class="administrator_account_title_p">company_id</p>
                </div>
                
                <div class="purasu_icon_admin_title_div"></div>
              </div>

              @if (count($issue_item) !== 0)
                @foreach ($issue_item as $one_item)
                  @if ($one_item->flag == 0)
                    <p class="not_disclosure_p">掲載許可待ち</p>
                    <div class="administrator_account_info_div" style="background: rgb(230, 230, 230);">
                      <div class="administrator_account_one_div administrator_id">
                        <a class="black_href" href="{{ asset(config('const.title.title49'))}}/issue_detail'/{{$one_item->id}}">
                          <p class="administrator_account_info_p">{{$one_item->matter_name}}</p>
                        </a>
                      </div>
                      
                      <div class="administrator_account_one_div administrator_name">
                        <p class="administrator_account_info_p">{{$one_item->shop_name}}</p>
                      </div>
                      
                      <div class="administrator_account_one_div administrator_phone">
                        <p class="administrator_account_info_p">{{$one_item->shop_id}}</p>
                      </div>
                      <div class="purasu_icon_admin">＋</div>
                      <div class="administrator_account_one_div administrator_delete delete_block_wrap" >
                        <div style="display: flex">

                          <form method="POST" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit_delete()">
                            @csrf
                            <input class="administrator_account_d_sub" type="submit" name="submit_d" value="削除" style="background: rgb(230, 230, 230);">
                            <input class="" type="hidden" name="delete_num" value="{{$one_item->id}}">
                          </form>
                          <!--  -->
                          <form method="POST" action="" enctype="multipart/form-data" onsubmit="return cancelsubmit_permission()">
                            @csrf
                            <input class="administrator_account_d_sub" type="submit" name="submit_p" value="許可" style="background: rgb(230, 230, 230);">
                            <input class="" type="hidden" name="permission_num" value="{{$one_item->id}}">
                          </form>

                        </div>
                      </div>
                    </div>
                  @else
                    <div class="administrator_account_info_div">
                      <div class="administrator_account_one_div administrator_id">
                        <a class="black_href" href="{{ asset(config('const.title.title49'))}}/issue_detail/{{$one_item->id}}">
                          <p class="administrator_account_info_p">{{$one_item->matter_name}}</p>
                        </a>
                      </div>
                      
                      <div class="administrator_account_one_div administrator_name">
                        <a class="black_href" href="{{ asset(config('const.title.title49'))}}/company_account_detail/{{$one_item->shop_number_id}}">
                          <p class="administrator_account_info_p">{{$one_item->shop_name}}</p>
                        </a>
                      </div>
                      
                      <div class="administrator_account_one_div administrator_phone">
                        <a class="black_href" href="{{ asset(config('const.title.title49'))}}/company_account_detail/{{$one_item->shop_number_id}}">
                          <p class="administrator_account_info_p">{{$one_item->shop_id}}</p>
                        </a>
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
                  @endif
                @endforeach
              @else
                <p class="search_none_p">検索結果がありません。</p>
              @endif
            

            </div>

            @if (count($issue_item) !== 0)
            <div class="pagination_div">
                <div class="pagination_ul_div">
                    <ul class="pagination">
                        @if ($prev == 0)
                            <li class="disabled pagination_li" aria-disabled="true">前のページ</li>
                        @else
                            <li class="pagination_li not_disabled"><a rel="prev" href="{{ asset(config('const.title.title49'))}}/all_issue?page={{$prev}}" class="btn prev_next_btn">前のページ</a></li>
                        @endif

                        @if ($next !== 0)
                            <li class="pagination_li not_disabled"><a rel="next" href="{{ asset(config('const.title.title49'))}}/all_issue?page={{$next}}" class="btn prev_next_btn">次のページ</a></li>
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