(function($){
  $(function(){
    var frame;
    var $id = $('#mtq_cabang_icon_media_id');
    var $preview = $('#mtq-cabang-icon-preview');
    var $btnUpload = $('#mtq-cabang-icon-upload');
    var $btnRemove = $('#mtq-cabang-icon-remove');

    if (!$id.length) return;

    $btnUpload.on('click', function(e){
      e.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        title: 'Pilih Ikon',
        button: { text: 'Gunakan Ikon' },
        multiple: false,
        library: { type: ['image','image/svg+xml'] }
      });
      frame.on('select', function(){
        var attachment = frame.state().get('selection').first().toJSON();
        $id.val(attachment.id);
        $preview.html('<img src="'+attachment.url+'" style="max-width:64px; max-height:64px;" />');
        $btnRemove.show();
      });
      frame.open();
    });

    $btnRemove.on('click', function(e){
      e.preventDefault();
      $id.val('0');
      $preview.empty();
      $btnRemove.hide();
    });
  });
})(jQuery);
