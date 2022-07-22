<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/administrator.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>管理者</title>
    </head>

    <style>
      .top_title {
        /* display:flex; */
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
      @media screen and (max-width: 799px) {
        .administrator_account_create_p {
          font-size: 12px;
          width: 85px;
        }
        .administrator_account_create_a {
          margin: 0 10px 10px;
          display: block;
        }
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
                <h3 class="title">管理者ページ</h3>
              </div>
              <a class="administrator_account_create_a" href="{{ asset(config('const.title.title49'))}}/account_create">
                <p class="administrator_account_create_p">アカウント作成</p>
              </a>


            <div class="administrator_account_div">
            <div class="administrator_account_title_div">
              <div class="administrator_account_one_div administrator_id">
                <p class="administrator_account_title_p">id_name</p>
              </div>
              
              <div class="administrator_account_one_div administrator_name">
                <p class="administrator_account_title_p">name</p>
              </div>
              
              <div class="administrator_account_one_div administrator_phone">
                <p class="administrator_account_title_p">phone</p>
              </div>
              
              <div class="administrator_account_one_div administrator_delete">
                <p class="administrator_account_title_p">delete</p>
              </div>
              <div class="purasu_icon_admin_title_div"></div>
            </div>


            @foreach ($item as $one_item)
            <div class="administrator_account_info_div">
              <div class="administrator_account_one_div administrator_id">
                <a >
                  <p class="administrator_account_info_p">{{$one_item->manager_id}}</p>
                </a>
              </div>
              
              <div class="administrator_account_one_div administrator_name">
                <p class="administrator_account_info_p">{{$one_item->manager_name}}</p>
              </div>
              
              <div class="administrator_account_one_div administrator_phone">
                <p class="administrator_account_info_p">{{$one_item->manager_phone}}</p>
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

          </div>


        </div>

    </body>
</html>
<script type="text/javascript" src="{{ asset('js/my_page.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/test_2.js')}}"></script>