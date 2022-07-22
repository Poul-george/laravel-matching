///スキルcheck input_hidden から取得
if ($('.hidden_div_one').length === 0) {

} else {

  if  ($('.hidden_div_one').length !== 0) {

    for (let i = 1;i <= 4;i++) {
      $('.hidden_check_num'+i).each(function( x, hidden ) {
        let value_num = $(hidden).val();
        $('.check_label'+i).each(function( index_i, element ) {
          // console.log(index_i);
          if (index_i === value_num-1) {
            $('.check_input'+i).each(function( index_input, input ) {
              if (index_input === value_num-1) {
                // console.log(index_input);
                $(input).prop('checked', true);
              }
            });
            $(element).addClass('active');
          }
        });
      });
  
    }
  
    $('.hidden_check_num5').each(function( x, hidden ) {
      let value_num = $(hidden).val();
      $('.check_label5').each(function( index_i, element ) {
        // console.log(index_i);
        if (index_i === value_num-35) {
          $('.check_input5').each(function( index_input, input ) {
            if (index_input === value_num-35) {
              // console.log(index_input);
              $(input).prop('checked', true);
            }
          });
          $(element).addClass('active');
        }
      });
    });

  }

}


function cancelsubmit4() {
  let count5 = 0;
  //
  $('.check_input5').each(function( x, item ) {
    if ($(item).prop('checked') === true) {
      count5++;
    }
  });
  console.log(count5);
  if (count5 >= 21) {
    $('.alret_p_num_6').text("こだわり条件は、20つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_6').position().top);
    return false;
  }
}

//check_boxマッチング設定 posi1~3 skill1~7 gyoukai1~3 tec0~3 prosess0~5 sonota0~20
function cancelsubmit3() {

  for(let i = 1;i<= 7;i++) {
    $('.alret_p_num_'+i).removeClass("active").text("");
  }

  let count1 = 0; 
  let count2 = 0;
  let count3 = 0;
  let count4_1 = 0;
  let count4_2 = 0;
  let count4_3 = 0;
  $('.check_input1').each(function( x, item ) {
    if ($(item).prop('checked') === true) {
      count1++;
    }
  });
  if (count1 === 0 || count1 >= 4) {
    $('.alret_p_num_1').text("ポシションは1つ以上、3つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_1').position().top);
    return false;
  }

  $('.check_input2').each(function( x, item ) {
    if ($(item).prop('checked') === true) {
      count2++;
    }
  });
  if (count2 === 0 || count2 >= 8) {
    $('.alret_p_num_2').text("スキルは1つ以上、7つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_2').position().top);
    return false;
  }

  $('.check_input3').each(function( x, item ) {
    if ($(item).prop('checked') === true) {
      count3++;
    }
  });
  if (count3 === 0 || count3 >= 4) {
    $('.alret_p_num_3').text("業界は1つ以上、3つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_3').position().top);
    return false;
  }

  $('.check_input4').each(function( x, item ) {

    if ($(item).prop('checked') === true) {
      if (x < 19) {
        count4_1++;
      }
      if (x >= 19 && x < 34) {
        count4_2++;
      }
      if (x >= 34 && x < 85) {
        count4_3++;
      }
    }
  });
  //
  if (count4_1 >= 4) {
    $('.alret_p_num_4').text("テクノロジーは３つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_4').position().top);
    return false;
  }
  if (count4_2 >= 6) {
    $('.alret_p_num_5').text("工程は5つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_5').position().top);
    return false;
  }
  if (count4_3 >= 21) {
    $('.alret_p_num_6').text("その他は20つ以内でお願いします").addClass("active");
    $(window).scrollTop($('#alret_p_num_6').position().top);
    return false;
  }
}

/////////////////////////////////////////////////////////
$('.unnko').on('click', function(){
  cancelsubmit4();
});



// メッセージでの改行とtextaeea
$(function(){
  $('.message_post_textarea')
  .on('change keyup keydown paste cut', function(){
    if ($(this).height() <= 160) {
      if ($(this).outerHeight() > this.scrollHeight){
        $(this).height(1)
      }
      while ($(this).outerHeight() < this.scrollHeight){
        $(this).height($(this).height() + 1)
      }
    }
    console.log($(this).height());
  });
});

if ($('.message_text_div').length !== 0) {
  $(function(){
  // $('#message_text_div').animate({scrollTop: $('#message_text_div')[0].scrollHeight}, 'fast');
  let height_text = $('#message_text_div').get(0).scrollHeight;
  $('#message_text_div').scrollTop(height_text);
  // console.log($('#message_text_div').get(0).scrollHeight);
});
}

//メッセージ中身なかったら
function cancelsubmit_message_post() {
  if ($('.message_post_textarea').val().replace(/\s+/g, "").length === 0) {
    return false;
  }
}

//admin
$(function(){

  $('.purasu_icon_admin').each(function( x, icon ) {
    $(icon).on('click', function(){
      $('.delete_block_wrap').each(function( xx, icon_btn ) {
        if (x !== xx) {
          $(icon_btn).removeClass("active");
          console.log("jbfa;jfiaje");
        }
      });
      $('.delete_block_wrap').each(function( bb, button ) {
          if (x == bb) {
            if ($(button).hasClass("active")) {
              $(button).removeClass("active");
            } else {
              $(button).addClass("active");
            }
          }
      });
    });
  });
});


//管理者削除確認
function cancelsubmit_delete() {
  if (confirm('このアカウントを削除しますか?')) {
  } else {
    return false
  }
}
//管理者許可確認
function cancelsubmit_permission() {
  if (confirm('このアカウントを許可しますか?')) {
  } else {
    return false
  }
}