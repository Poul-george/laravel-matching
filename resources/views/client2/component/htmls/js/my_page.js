$(function(){
  // input 文字数カウント
  if ($('#reibun_div1_input').length === 0) {
  }else {
    inputCount();
  }
  // input 文字数カウント
  if ($('.ex_companies_input_text').length === 0) {
  }else {
    inputCount2();
  }
  // input 文字数カウント
  if ($('.tokuhitu_textarea').length === 0) {
  }else {
    inputCount3();
  }
});

   // 人物チェック
   $('.zinbutu_user_div').on('click', function(){
    var index = $('.zinbutu_user_div').index(this);
    var count = 1;
    $('.zinbutu_user_label_div').each(function( x, aaa ) {
      if ($(aaa).hasClass("active")) {
        count++;
      }
    });
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
          // inputにテェックを入れる　三つより多くチェックさせない
          if (count <= 3) {
            $('.zinbutu_user').each(function( index_input, input ) {
              if (index_input === index) {
                $(input).prop('checked', true);
                console.log(count);
              }
            });
            $(element).addClass('active');
          }
        }
      }
    });
  });

   // 経験スキル
   $('.sukil_check_restriction_none').on('click', function(){
    var index = $('.sukil_check_restriction_none').index(this);
    $('.zinbutu_user_label_div').each(function( x, aaa ) {
      if ($(aaa).hasClass("active")) {
        // count++;
      }
    });
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



  ///delete_check experienced_companies_form_div
  if ($('.experienced_companies_form_div').length === 0) {
  } else {
    let i_count = $('.experienced_companies_form_div').length
    for (let i = 1;i <= i_count;i++) {
      $('#ex_companies_delete'+i).click(function(){
        if ($('#ex_companies_check'+i).prop('checked') === false) {
          $('#ex_companies_check'+i).prop('checked', true);
          $('#ex_companies_delete'+i).prop('disabled', true);
          $('#ex_companies_dlabel_div'+i).addClass('active');
        } else {
          $('#ex_companies_check'+i).prop('checked', false);
          $('#ex_companies_delete'+i).prop('disabled', false);
          $('#ex_companies_dlabel_div'+i).removeClass('active');
        }
      });
    }
  }

  ///delete_check
  for (let i = 1;i <= 3;i++) {
    $('#thumbnai_delete'+i).click(function(){
      if ($('#user_thumbnail'+i).prop('files')[0] === undefined) {
        if ($('#file_delete_check'+i).prop('checked') === false) {
          $('#file_delete_check'+i).prop('checked', true);
          $('#user_thumbnail'+i).prop('disabled', true);
          $('#file_name_span'+i).addClass('active');
          $('#delete_label_div'+i).addClass('active');
        } else {
          $('#file_delete_check'+i).prop('checked', false);
          $('#user_thumbnail'+i).prop('disabled', false);
          $('#file_name_span'+i).removeClass('active');
          $('#delete_label_div'+i).removeClass('active');
        }
      } 
    });
    function selectFile() {
      if ($('#user_thumbnail'+i).value === "") {
        $('#file_delete_check'+i).disabled = false;
      }
      else {
        $('#file_delete_check'+i).disabled = true;
      }
    }
    // ファイルの名前を表示
    $('#user_thumbnail'+i).on('change', function () {
      var file = $(this).prop('files')[0];
      if (file === undefined) {
        $('#file_name_span'+i).text("選択されていません");
        console.log("から");
      } else {
        $('#file_name_span'+i).text(file.name);
        console.log("ある");
      }
     });
  }
/////////////////////////////////////////////////////////////////////////////////

  //メニューバー
  $('#mypage_menu').click(function(){
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

  //url変更
  $('.mypage_edit_url_a').each(function(index, list) {
    $(this).removeClass('active');
  });
  const url_list = ["/client2/user_account/edit","/client2/user_account/self_introduction/edit","/client2/user_account/biography_works/edit","/client2/user_account/experienced_companies/edit", "/client2/user_account/experienced_skill/edit","/client2/user_account/desired_conditions/edit","/client2/user_account/desired_skills/edit","/client2/user_account/user_conditions/edit"];
  let url_i = 0;
  $('.mypage_edit_url_a').each(function(index, list) {
    if (location.pathname === url_list[url_i]) {
      if (index === url_i) {
        $(this).addClass('active');
      }
    } 
    url_i++;
  });

  //ダウンロードボタン
for (let i = 1;i <= 2;i++)
  if ($('#user_now_file'+i).length === 0) {
  }else {
    if ($('#user_now_file'+i).val() === "") {
      $('#biography_works_file_download'+i).prop('disabled', true);
    } else {
      $('#biography_works_file_download'+i).prop('disabled', false);
  }
}

  //例文追加処理 経験企業
  let text = ["PHP上級エンジニア／ECサイト・ソーシャルアプリの開発経験が豊富", "・PHP、Java、HTML5によるプロジェクト経験6件\n" + "・システムエンジニアとしての実務経験8年\n" +"・金融システム開発におけるコンサルティングが得意\n" +"・大手Web制作会社でWebデザイナー4年間の就業経験\n" + "・プログラマー、ディレクター、Webデザイナー計7名のマネジメント経験\n" + "・自分のキャリアを発揮したプロジェクトマネージャーになりたい\n" +"・大規模案件を成功に導くプロジェクトマネージャーを目指します", "１．最新技術を利用しており経験を積むことができる現場\n２．大規模トラフィックに対応するような業務（ソーシャルゲーム以外）\n３．PHP or RubyのMVC環境による開発業務\n４．デザイナーとして参画し、ディレクターも経験できる現場\n５．企画立案から関われる事業／またはエンジニアのマネジメント"];

  let text2 = ["【環境】\n"+"言語：Java,Ruby,PHP,VB.NET,C#.NET,VB6,Javascript,Python,Perl,Scala,C/C++,COBOL\n"+"OS：Linux,Windows,iOS,Android,フィーチャーフォン,汎用機,AWS,Azure,GAE\n"+"DB：Oracle,MySQL,PostgreSQL,SQL,Server,MongoDB,SQLite\n"+"\n"+"【業務内容】\n"+"役職／役割：PMO,PM,PL,SE,PG,テスター,SESコーディネーター,DBA\n"+"担当工程：要件・調査,基本設計,詳細設計,コーディング,単体テスト,結合テスト,運用テスト\n"+"チーム体制：3～4名\n"+"内容：●●●●●●●●●●●●", 
  "【環境】\n"+"ツール：Photoshop,Illustrator,Flash,Dreamweaver\n"+"言語：HTML4/5,CSS2/3,javascript,ActionScript\n"+"\n"+"【業務内容】\n"+"役職／役割：UX・企画,IA・サイト設計,進行管理,UIデザイン,Webデザイン,広告デザイン,コーディング,フロント開発\n"+"チーム体制：3～4名\n"+"内容：●●●●●●●●●●●●",
  "【環境】\n"+"ツール：Photoshop,Fireworks,Illustrator,Flash,QuarkXPress,InDesign,AfterEffects,SAI,Painter\n"+"テイスト：萌え･美少女系,乙女系,モンスター系,かわいい(ほのぼの)系,アメコミ系,和風･戦国系,ロボット･SF系,厚塗り,アニメ塗り\n"+"\n"+"【業務内容】\n"+"役職／役割：ラフ,キャラクターデザイン,線画,着彩(塗り),背景,マップ,パーツ(アイテム等),レタッチ,ドット絵\n"+"チーム体制：3～4名\n"+"内容：●●●●●●●●●●●●"];

//自己紹介
  for (let i = 0;i <= 2;i++) {
    let i_1 = i + 1;
    $('#reibun_div'+i_1).click(function(){
      addActive();
        $('#reibun_alert_div'+i_1).addClass('active');
    });
    //キャンセルしたら 自己紹介
    $('#reibun_button_cancel'+i_1).click(function(){
      allCancel();
    });
    //yseしたら 自己紹介
    $('#reibun_button_yes'+i_1).click(function(){
      if ($('#reibun_alert_shadow_div').hasClass("active")) {
        yesAllCancel();
        //例文挿入処理
        $('#reibun_div'+i_1+'_input').val(text[i]);
        let count = text[i].length;
        $('#input_count_span'+i_1).text(count);
      }
    });
  }
  //黒背景押したら
  $('#reibun_alert_shadow_div').click(function(){
    allCancel();
  });
  
  // kyoytuu
  function addActive() {
    $('#reibun_alert_shadow_div').addClass('active');
    $('#reibun_alert_div').addClass('active');
    $('#html').addClass('none_scroll');
  }//
  function allCancel() {
    if ($('#reibun_alert_shadow_div').hasClass("active")) {
      $('#reibun_alert_shadow_div').removeClass('active');
      $('#reibun_alert_div').removeClass('active');
      $('#html').removeClass('none_scroll');
      //自己紹介
      for (let i = 1;i <= 3;i++) {
        $('#reibun_alert_div'+i).removeClass('active');
      }
      //職務経歴
      for (let i = 0;i <= 2;i++) {
        $('.reibun_div_onec').removeClass('active');
      }
      if ($('.experienced_companies_form_div').length === 0) {
      } else {
        let i_count = $('.experienced_companies_form_div').length
        for (let i = 1;i <= i_count;i++) {
          $('.box_number'+i).removeClass('active');
        }
      }
    }
  }
  function yesAllCancel() {
    $('#reibun_alert_shadow_div').removeClass('active');
    $('#reibun_alert_div').removeClass('active');
    $('#html').removeClass('none_scroll');
    //自己紹介
    for (let i = 1;i <= 3;i++) {
      $('#reibun_alert_div'+i).removeClass('active');
    }
    //職務経歴
    for (let i = 0;i <= 2;i++) {
      $('.reibun_div_onec').removeClass('active');
    }
    if ($('.experienced_companies_form_div').length === 0) {
    } else {
      let i_count = $('.experienced_companies_form_div').length
      for (let i = 1;i <= i_count;i++) {
        $('.box_number'+i).removeClass('active');
      }
    }
  }
  // 自己紹介
  function inputCount() {
    for (let i = 1;i <= 3;i++) {
      let count = $('#reibun_div'+i+'_input').val().length;
      $('#input_count_span'+i).text(count);
    }
  }
  for (let i = 1;i <= 3;i++) {
    $('#reibun_div'+i+'_input').change(function() {
      //値が変更されたときの処理
      let count = $('#reibun_div'+i+'_input').val().length;
      $('#input_count_span'+i).text(count);
    });
  }

// //ボタンを押したら (職務経歴)

if ($('.experienced_companies_form_div').length === 0) {
} else {
  let i_count = $('.experienced_companies_form_div').length
  for (let i = 1;i <= i_count;i++) {

    $(".ex_companies_reibunn_div"+i).click(function(){
      var index = $('.ex_companies_reibunn_div'+i).index(this);
      $(".reibun_div_onec").each(function( x, aaa ) {
        if (x === index) {
          if ($(aaa).hasClass("active")) {
            $(aaa).removeClass("active");
            $('#reibun_alert_shadow_div').removeClass('active');
            $('#reibun_alert_div').removeClass('active');
            $('#html').removeClass('none_scroll');
            $('.box_number'+i).removeClass('active');
          } else {
            console.log($(".ex_companies_reibunn_div"+i));
            $(aaa).addClass("active");
            $('#reibun_alert_shadow_div').addClass('active');
            $('#reibun_alert_div').addClass('active');
            $('#html').addClass('none_scroll');
            $('.box_number'+i).addClass('active');
          }
        }
      });
    });

  }
}

//キャンセルしたら 職務経歴
$('.reibun_button_cancel').click(function(){
  allCancel();
});

 //yseしたら 職務経歴  
 $('.reibun_button_yes1').click(function(){
  if ($('#reibun_alert_shadow_div').hasClass("active")) {
    if ($('.experienced_companies_form_div').length === 0) {
    } else {
      let i_count = $('.experienced_companies_form_div').length
      for (let i = 1;i <= i_count;i++) {
        //どのbox_numberがactiveka
        if ($('.box_number'+i).hasClass("active")) {
            //例文挿入処理
          $(".reibun_div_onec").each(function( x, aaa ) {
            if ($(aaa).hasClass("active")) {
              $('.textarea_number'+i).val(text2[x]);
              let count = text2[x].length;
              // label三つ目
              $('.input_count_span'+i).each(function( y, span ) {
                if (y === 2) {
                  $(span).text(count);
                }
              });
            }
          });
        }
      }
    }
    yesAllCancel();
  }
});

//職務経歴
function inputCount2() {
  if ($('.experienced_companies_form_div').length === 0) {
  } else {
    let i_count = $('.experienced_companies_form_div').length
    for (let i = 1;i <= i_count;i++) {
      $('.input_group'+i).each(function( x, input ) {
        let count = $(input).val().length;
        xx = x +1;
        $('.input_count_span'+i).each(function( y, span ) {
          if (x === y) {
            $(span).text(count);
          }
        });
      });
    }
  }
  // onチェンジ
  if ($('.experienced_companies_form_div').length === 0) {
  } else {
    let i_count = $('.experienced_companies_form_div').length
    for (let i = 1;i <= i_count;i++) {
      $('.input_group'+i).each(function( x, input ) {
        $(input).change(function() {
          //値が変更されたときの処理
          let count = $(input).val().length;
        $('.input_count_span'+i).each(function( y, span ) {
          if (x === y) {
            $(span).text(count);
          }
        });
        }); 
      });
    }
  }
}

//職務経歴 入力フォーム 見え隠れ
if ($('.experienced_companies_form_div').length === 0) {
} else {
  $('.experienced_companies_num_div').each(function( x, box ) {
    $(box).click(function(){
      console.log(x);
      let xx = x+1;
      if ($(".dispalu_none_"+xx).hasClass("active")) {
        $(".dispalu_none_"+xx).removeClass('active');
      } else {
        $(".dispalu_none_"+xx).addClass("active");
      }
    });
  });
}

//職務経歴box_form_count
if ($('.experienced_companies_form_div').length === 0) {
  $("#box_form_count").val(0);
} else {
  $("#box_form_count").val($('.experienced_companies_form_div').length);
}



 ///勤務続けているか experienced_companies_form_div
 if ($('.experienced_companies_form_div').length === 0) {
} else {
  let i_count = $('.experienced_companies_form_div').length
  for (let i = 1;i <= i_count;i++) {
    $('#ex_companies_checked_div'+i).click(function(){
      if ($('#ex_companies_checked'+i).prop('checked') === false) {
        //input
        $('#ex_companies_checked'+i).prop('checked', true);
        //input
        $('#ex_companies_checked_div'+i).prop('disabled', true);
        //thumbnai_deleteのdiv
        $('#ex_companies_chlabel_div'+i).addClass('active');
        //labelのdiv
      } else {
        $('#ex_companies_checked'+i).prop('checked', false);
        $('#ex_companies_checked_div'+i).prop('disabled', false);
        $('#ex_companies_chlabel_div'+i).removeClass('active');
      }
    });
  }
}

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


//特筆事項
function inputCount3() {
  if ($('.tokuhitu_textarea').length === 0) {
  } else {
    let i_count = $('.tokuhitu_textarea').length
    for (let i = 1;i <= i_count;i++) {
      $('.tokuhitu_textarea').each(function( x, input ) {
        let count = $(input).val().length;
        xx = x +1;
        $('.input_count_span').each(function( y, span ) {
          if (x === y) {
            $(span).text(count);
          }
        });
      });
    }
  }
  // onチェンジ
  if ($('.tokuhitu_textarea').length === 0) {
  } else {
    let i_count = $('.tokuhitu_textarea').length
    for (let i = 1;i <= i_count;i++) {
      $('.tokuhitu_textarea').each(function( x, input ) {
        $(input).change(function() {
          //値が変更されたときの処理
          let count = $(input).val().length;
        $('.input_count_span').each(function( y, span ) {
          if (x === y) {
            $(span).text(count);
          }
        });
        }); 
      });
    }
  }
}


///スキルcheck input_hidden から取得
if ($('.experienced_skill_blade').length === 0) {

} else {
  let l_count = $('.hidden_div_one').length;
  // console.log(l_count);
 if  ($('.hidden_div_one').length !== 0) {
   for (let i = 1;i <= 23;i++) {
     $('.hidden_check_num'+i).each(function( x, hidden ) {
       // console.log($(hidden).val());
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
     // console.log("///////////////");
   }
 }
}


//test

function cancelsubmit() {


  if ($('.money_width1').val() === $('.money_width2').val() || $('.money_width2').val() == Number($('.money_width1').val()) + 5) {
    // return true;
  }else {
    // console.log($('.money_width2').val());
    // console.log(Number($('.money_width1').val()) + 5);
    $('.alret_p').addClass("active");
    $('.alret_p').text("差額は5万円以内でお願いします");
    $('.money_width1').focus();
    $('.money_width2').focus();
    return false;
  }
}



