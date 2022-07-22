/////////////////////////////////////////////////////////////////////////////////



  //url変更
  $('.mypage_edit_url_a2').each(function(index, list) {
    $(this).removeClass('active');
  });
  const url_list2 = ["/client1/client_account/edit","/client1/client_account/self_introduction/edit"];
  let url_i2 = 0;
  $('.mypage_edit_url_a2').each(function(index, list) {
    if (location.pathname === url_list2[url_i2]) {
      if (index === url_i2) {
        $(this).addClass('active');
      }
    } 
    url_i2++;
  });

  //%の計算　同じものの選択の判別
  function cancelsubmit2() {


    for (let oi = 1;oi <= 3;oi++) {

      let array = [];
      let array2 = [];
      for (let i = 1;i <= 4;i++) {
        let item = $('.hanbetu'+oi+'_'+i).val();
        if (item !== "") {
          array.push(item);
        }
      }
      for (let i = 1;i <= 4;i++) {
        let item = $('.total'+oi+'_'+i).val();
        if (item !== "") {
          array2.push(item);
        }
      }

      //計算
      let total =0;
      $(array2).each(function( num, item ) {
        total = total + Number(item);
      });
      if (total >= 101) {
        $('.alret_p_num_'+oi).addClass("active");
        $('.alret_p_num_'+oi).text("トータルが100％を超えています");
        $('.total'+oi+'_1').focus();
        return false;
      }

      //重複取得
      let out_list = array.filter(function (x, i, self) {
        return self.indexOf(x) !== self.lastIndexOf(x);
      });
      if (out_list.length !== 0) {
        $('.alret_p_num_'+oi).addClass("active");
        $('.alret_p_num_'+oi).text("重複項目があります");
        $('.hanbetu'+oi+'_1').focus();
        return false;
      }

    }

    

  }


if ($('.rate').length !== 0) {
  for (let l = 1;l <= $('.rate').length;l++) {
    $('.rate_num'+l).hover(
        function() {
            
            //マウスカーソルが重なった時の処理
            $('#rate_info_div'+l).addClass('active');
            
        },
        function() {
            
            //マウスカーソルが離れた時の処理
            $('#rate_info_div'+l).removeClass('active');
            
        }
    );
  }
}



//お気に入りボタン押す
if ($('.rate').length !== 0) {
  for (let l = 1;l <= $('.rate').length;l++) {
    $('.rate_num'+l).on('click', function(event, input){
      $('.issue_apply_user_form'+l).submit();
    });
  }
}


//見送りかくにん
function cancelsubmit_defeated() {
  if (confirm('応募を見送りますか？')) {
  } else {
    return false
  }
}

//人材選定 人材を一人以上選んでいるか
function cancelsubmit_user_num() {
  let user_check_count = 0;
  $('.user_select_alert_p').text("").removeClass("active");
  $('#year_month_day').text("").removeClass("active");

  //日付
  var today = new Date();
  let today_year = today.getFullYear();
  let today_month = today.getMonth();
  let today_day = today.getDate();


  if ($('.select_year').val() == today_year) {
    if ($('.select_month').val() < today_month + 1) {
      $('#year_month_day').text("今月以降の月を入力してください").addClass("active");
      $(window).scrollTop($('#year_month_day_div').position().top);
      return false;
    }

    if ($('.select_month').val() == today_month + 1) {
      // console.log("okkkk");
      if ($('.select_day').val() <= today_day) {
        // console.log("hhhhhkdabvkajvsbvks");
        $('#year_month_day').text("本日以降の日付を入力してください").addClass("active");
        $(window).scrollTop($('#year_month_day_div').position().top);
        return false;
      }
    }
  }

  //人材選定 人材を一人以上選んでいるか
  $('.zinbutu_user').each(function(index, user_check) {
    if ($(user_check).prop('checked')) {
      user_check_count++;
    } 
  });
  if (user_check_count == 0) {
    $('#user_select_check_num').text("人材を一人以上選択してください").addClass("active");
    $(window).scrollTop($('#user_select_check').position().top);
    return false;
  }
}



///user_select hidden から取得
if ($('.user_select_hidden_div_one').length === 0) {

} else {

  if  ($('.user_select_hidden_div_one').length !== 0) {
    
      $('.user_select_input_check_num').each(function( x, hidden ) {
        let value_num = $(hidden).val();
        $('.check_input').each(function( index_input, input ) {
          if ($(input).val() == value_num) {
            $(input).prop('checked', true);
            $('.check_label').each(function( index_i, element ) {
              if (index_i === index_input) {
                $(element).addClass('active');
              }
            });
          }
        });
      });

  }

}

function user_judge_submit() {
  if ($("#1-option:checked").val() == undefined && $("#2-option:checked").val() == undefined) {
    alert('稼働確認を選択してください。');
    return false;
  }
  if ($("#1-option:checked").val() == '1') {
    if ($.trim($('#user_judge_textarea').val()) == "") {
      alert('人材が稼働できなかった場合は、理由をご記入ください。');
      return false;
    }
  }
}