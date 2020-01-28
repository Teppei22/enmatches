// タブ切り替え機能
$(function(){
  $(".js-tab_label").on('click',function(){
    var index = $(this).index();
    var $tab_labels = $(this).siblings(".js-tab_label")
    var $tab_panels = $(this).parents('.js-tab_labels').siblings('.js-tab_panels').find(".js-tab_panel")

    $tab_labels.removeClass("is-active");
    $tab_panels.removeClass("is-active");

    $(this).addClass("is-active");
    $tab_panels.eq(index).addClass("is-active");
  })
  
})