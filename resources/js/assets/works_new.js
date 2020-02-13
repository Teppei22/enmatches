// 案件種類のselect-inputによって単価表示を変化
$(function(){

  var select_val = $('.js-type_select').val();
  var $work_price = $('.js-work_price');
  
  

  if (select_val === '1'){

    $work_price.show();

  } else if (select_val === '2') {

    $work_price.hide();

  }

  $('.js-type_select').change(function () {
    select_val = $(this).val();

    if (select_val === '1') {
      // 単発案件

      $work_price.show();

    } else if (select_val === '2') {
      // レベニューシェア案件

      $work_price.hide();

    }

    $('.js-price-min').val(null);
    $('.js-price-max').val(null);
    
  })
});
