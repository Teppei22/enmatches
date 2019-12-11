// 画像ライブプレビュー
$(function(){
  var $dropArea = $('.js-area-drop');
  var $fileInput = $('.js-input-file');
  $dropArea.on('dragover', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '3px #ccc dashed');
  });
  $dropArea.on('dragleave', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', 'none');
  });
  $fileInput.change(function (e) {

    $dropArea.css('border', 'none');
    var file = this.files[0];
    // console.log(file)
    var $img = $(this).siblings('.js-prev-img');
    var fileReader = new FileReader();

    // 読み込み完了後、imgのsrcにデータをセット
    fileReader.onload = function (event) {
      // 読み込みデータをimgに設定
      $img.attr('src', event.target.result).show();
      $('.js-prof-img').hide();
      // console.log(event.target.result);
    };

    // 画像読み込み
    fileReader.readAsDataURL(file);

  });
})
