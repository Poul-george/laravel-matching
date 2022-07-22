

$(window).on("load", function() {
  let num = $('body').width();
  $('.box1').each(function( x, box ) {
    $(box).append(
      '<style>.box1{right:'+num+'px}'
    );
    console.log(box);
  });
  $('.box2').each(function( x, box ) {
    $(box).append(
      '<style>.box2{left:'+num+'px}'
    );

  });
  let lll = 1000;
  let bbb = 2000;
  $('.box1').each(function( x, box ) {
    $(box).hide().fadeIn("slow").animate({'right':'0', },lll);
    lll = lll+500;
  });
  $('.box2').each(function( x, box ) {
    $(box).hide().fadeIn("slow").animate({'left':'0' },bbb);
    bbb = bbb+500;
  });
});

$(function() {
  $('.fade').on('inview', function(event, isInView){
    $(this).addClass('fade-in');
    // if (isInView) {
    // } else {
    //     $(this).removeClass('fade-in');
    // }
  });
});
$(function() {
  let ppp = 300;
  let xxx = 500;
  $('.in_div_box').on('inview', function(event, isInView){
    if (!$('.in_div_box').hasClass('ccc')) {
      function toggle(){
        if(click){
            clearInterval(roop);
            click = false;
        }else{
            // start();
            click = true;
        }
    }
      var rotate = $(".div_box");
      var click = false;
      var roop;
      var count = 0;

      //回転させる
          roop = setInterval(function(){
              count+=5;
              if(count > 360){
                  count = 0;
              }else{
                  rotate.css("transform", "rotate("+ count +"deg)");
              }
          }, 10);
      $('.div_box').each(function( x, box ) {
        $(box).hide().fadeIn("slow").animate({'right':'0', 'height':'50px', 'width':'50px' },xxx);
        xxx = xxx+1000;
      });


      let count_x = 0;
      $('.div_box').each(function( x, box ) {
        if (!$('.in_div_box').hasClass('ccc') && count_x === 0) {
          if (x === 2) {
            $(box).on('inview', function(l, item) {
              if (count_x === 0) {
                $('.div_box').each(function( x, box ) {
                  $(box).animate({'height':'250px', 'width':'250px',},2000);
                });
              }
              count_x = 1;

            });
          }
        }
      });

    }

    $('.in_div_box').addClass('ccc');
  });
});



$(function() {
  var rotate = $(".rotate");
  var click = false;
  var roop;
  var count = 0;

  //回転させる
  function start(){
      roop = setInterval(function(){
          count++;
          if(count > 360){
              count = 0;
          }else{
              rotate.css("transform", "rotate("+ count +"deg)");
          }
      }, 10);
  }
  //クリックされた時の処理
  rotate.on('click',function(){
      toggle();
  });
  //ループ中かどうか判断する
  function toggle(){
      if(click){
          clearInterval(roop);
          click = false;
      }else{
          start();
          click = true;
      }
  }
});

