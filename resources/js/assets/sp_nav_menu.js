// SPメニューの開閉動作
$(function(){

  $('.js-toggle-sp-menu').on('click', function () {
    $(this).toggleClass('is-active');
    $('.js-toggle-sp-menu-target').toggleClass('is-active');

  });

  $('.js-toggle-sp-menu-target').on('click', function () {

    var $menu = $('.js-toggle-sp-menu');

    var $target = $(this);
    if ($menu.hasClass('is-active')) {
      $menu.removeClass('is-active');
      $target.removeClass('is-active');
    }
  });
})