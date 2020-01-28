// 最下部に来たときに、float-buttonを隠す
$(function(){
  $(window).on('scroll',function(){
    var document_height = $(document).innerHeight();
    var window_height = $(window).innerHeight();
    var bottom = document_height - window_height;

    if (bottom <= $(window).scrollTop()) {
      
      $('.js-float-button').hide();
    }else{
      $('.js-float-button').show();
    }
  })

})