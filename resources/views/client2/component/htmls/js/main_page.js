
//メニューバー
$('#openbtn4').click(function(){
  if ($(this).hasClass("active")) {
    $(this).removeClass('active');
    $('#box_left').removeClass('active');
    $('#main_div').removeClass('active');
    $('#left_shadow').removeClass('active');
    $('#mypage_form_center').removeClass('width_active');
  } else {
    $(this).addClass('active');
    $('#box_left').addClass('active');
    $('#main_div').addClass('active');
    $('#left_shadow').addClass('active');
    $('#mypage_form_center').addClass('width_active');
  }
});
$('#left_shadow').click(function(){
  if ($(this).hasClass("active")) {
    $(this).removeClass('active');
    $('#openbtn4').removeClass('active');
    $('#box_left').removeClass('active');
    $('#main_div').removeClass('active');
    $('#left_shadow').removeClass('active');
    $('#mypage_form_center').removeClass('width_active');
  } 
});

//mypage_header.balde.php アイコンタップ
$('#user_icon_div').click(function(){
  if ($('#user_operate_div').hasClass("active")) {
    $('#user_operate_div').removeClass('active');
  } else {
    $('#user_operate_div').addClass('active');
    $('.user_operate_div').css('display', 'none');
    $('.user_operate_div').delay(600).fadeIn(100);
  }
});

// sub_menu
//leftコンポーネント サブメニュー
$('.sub_menu_have').on('click', function(){
  console.log($('.sub_menu_have').index(this));
  var number_index = $('.sub_menu_have').index(this);

  $('.sub_menu_ul').each(function( index, sub_menu ) {
    if (index === number_index) {
      if ($(this).hasClass("active")) {
        $(this).removeClass('active');
      } else {
        $(this).addClass('active');
      }
    }
  });
});




// 経験スキル checkbox 見え隠れ


if ($('.edit_checkbox_plural_p').length === 0) {
} else {
  $('.edit_checkbox_plural_p').each(function( x, p ) {
    $(p).click(function(){
      $('.checkbox_group_div').each(function( s, box ) {
        if (x === s) {
          if ($(box).hasClass("active")) {
            $(box).removeClass('active');
            $(p).removeClass('active');
          } else {
            $(box).addClass("active");
            $(p).addClass("active");
          }
        }
      });

    });
  });
}

//checkbox
$('.sukil_check_restriction_none').on('click', function(){
  var index = $('.sukil_check_restriction_none').index(this);
  // $('.zinbutu_user_label_div').each(function( x, aaa ) {
  //   if ($(aaa).hasClass("active")) {
  //   }
  // });
  $('.zinbutu_user_label_div').each(function( index_i, element ) {
    if (index_i === index) {
      if ($(element).hasClass("active")) {
        $(element).removeClass('active');
        $('.zinbutu_user').each(function( index_input, input ) {
          if (index_input === index) {
            $(input).prop('checked', false);
          }
        });
      } else {
        // 
          $('.zinbutu_user').each(function( index_input, input ) {
            if (index_input === index) {
              $(input).prop('checked', true);
            }
          });
          $(element).addClass('active');
      }
    }
  });
});






$(function () {
  if ($('.tab-buttons>span').length !==0) {

    $('.tab-buttons>span').first().addClass('active');
    $('.check_content_div').first().addClass('active');
  
    $('.tab-buttons>span').each(function( x, p ) {
      $(p).click(function(){
        console.log(x);
        $('.tab-buttons>span').removeClass('active');
        $('.check_content_div').removeClass('active');
        $('.check_content_div').each(function( s, box ) {
  
        $(p).addClass('active');
        if (s == x) {
          $(box).addClass('active');
        }
        });
      });
    });
  }
  
});


//応募ボタン
if ($('#apply_div_fixed').length !==0) {

  $('.apply_div_bottom').on('inview', function(event, isInView){
    console.log("bjrag;b;b;agao;goeb");
    if (isInView) {
      $('#apply_div_fixed').addClass("active");
    } else {
      $('#apply_div_fixed').removeClass("active");
    }
  }); 
  //click
  $('.apply_btn_div').on('click', function(event, ooo){
    $('.id_submit_form').submit();
  });
}


