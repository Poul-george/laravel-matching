$(function () {
  Chart.defaults.global.defaultFontColor = '#fff';
  Chart.defaults.global.defaultFontSize = '12';

  //list_itemに値を挿入
  let list_item = [
    [],
    [],
    [],
  ];
  let list_num = 0;
  for (let i = 1;i <= 3;i++) {
    if ($('.hidden_lata_num'+i).length !== 0) {
      $('.hidden_lata_num'+i).each(function( num, item ) {
        list_item[list_num].push(Number($(item).val()));
      });
    }
    list_num++;
  }
  console.log(list_item);

  let xxx = 0;

  //list_item内が何%か
  for (let i = 0;i <= 2;i++) {
    console.log(list_item[i].length);
    //list個数確認
    let list_count = 0;
    if (list_item[i].length === 4 || list_item[i].length == 0) {

    } else {
      list_count = 4 - list_item[i].length;
      for (let ii = 1;ii <= list_count;ii++) {
        list_item[i].push(0);
      }

    }
    let total= 0;
    if (list_item[i].length !== 0) {
      $(list_item[i]).each(function( num, item ) {
        total = total + Number(item);
      });
      let husoku = 100 - total;
      if (husoku !== 0) {
        list_item[i].push(husoku);
      }

    }
    // console.log(list_count);


    // console.log(list_item[i]);
  }


  for (let i = 1;i <= 3;i++) {

    var ctx = $('#chart'+i);
    if (ctx.length !== 0) {

      var mychart = new Chart(ctx, {
          type: 'pie',
          data: {
              datasets: [{
                  label: 'サンプルグラフ',
                  data: list_item[xxx],
                  backgroundColor: [
                      'rgba(241, 107, 141, 1)',
                      'rgba(64, 224,  208, 1)',
                      'rgba(93, 153,  255, 1)',
                      'rgba( 144, 87, 255, 1)',
                      'rgba(50,  50, 50, 1)'
                  ],
              }],
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          display: false,
                          beginAtZero: true,
                      },
                      gridLines: {
                          display: false
                      }
                  }]
              }
          }
      });
    }

    xxx++;
  }

});