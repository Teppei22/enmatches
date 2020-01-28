// 案件種類のselect-inputによって単価の種類を変化
$(function(){
  var target = $('.js-type_select').val();
  var $single = $('.js-single_price');
  var $revsh = $('.js-revsh_price');
  if (target === '1'){
    $single.show();
    $revsh.hide();
  } else if (target === '2') {
    $single.hide();
    $revsh.show();
  }
  $('.js-type_select').change(function () {
    target = $(this).val();
    if (target === '1') {
      $single.show();
      $revsh.hide();
    } else if (target === '2') {
      $single.hide();
      $revsh.show();
    }
  })
});
