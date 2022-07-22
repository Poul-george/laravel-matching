<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        {{-- <link href="{{ asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ secure_asset('/css/influ.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('/css/payment.css') }}" rel="stylesheet">
        <title>{{config('const.payment_info.info1')}}</title>
    </head>
    <body>
    @include('influencer.component.header')
        <div class="top_title">
            <h3 class="title">{{config('const.payment_info.info1')}}</h3>
        </div>

        <div class="main_form">
            <div class="siharai_body">
                <div class="siharai_div">

                  <h3 class="siharai_midashi">{{$month_only}}月分のお支払通知書</h3>
                  {{-- <p class="center_p">{{config('const.payment_info.info1')}}</p> --}}

                  <div class="date_company_div">
                    <div class="company_div">
                      <p class="date_company_p"><label class="p_label">{{config('const.payment_info.info2')}}：</label>{{config('const.title.title46'}}株式会社</p>
                    </div>

                    <div class="date_div">
                      <div class="p_label_div">
                        <label class="p_label_flex"></label><p class="date_company_p_flex">{{config('const.payment_info.info3')}}：{{$last_date}}</p>
                      </div>
                    </div>
                  </div>

                  @foreach ($item_influ as $value)
                    <div class="money_div">
                        <label class="p_label_flex2">{{config('const.payment_info.info4')}}： {{$value->shop_name}}</label><p class="money_p_flex">¥{{$value->reward}}(税込)</p>
                    </div>
                　@endforeach


                  <div class="money_div">
                    <label class="p_label_flex2">{{config('const.payment_info.info6')}}</label><p class="money_p_flex2">-¥{{$tax}}</p>
                  </div>

                  <div class="money_div">
                    <label class="p_label_flex2">{{config('const.payment_info.info7')}}</label><p class="money_p_flex2">¥{{$reward_result}}</p>
                  </div>

                  <div class="bank_div">
                    <p class="post_money_p">{{config('const.payment_info.info8')}}</p>
                    <p class="bank_p">{{config('const.payment_info.info10')}}：{{$item2->bank}}</p>
                    <p class="bank_p">{{config('const.payment_info.info11')}}：{{$item2->bank_type}}</p>
                    {{-- <p class="bank_p">{{$item2->bank_number}}</p>
                    <p class="bank_p">{{config('const.payment_info.info9')}} {{$item2->cash_name}}</p> --}}
                  </div>

                </div>

              </div>
        </div>

    </body>
    @include('influencer.component.footer')
</html>
