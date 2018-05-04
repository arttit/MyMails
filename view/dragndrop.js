/* DRAG N DROP */
$(document).on('dragenter', '#dropfile', function() {
  $(this).css('border', '3px dashed red');
  return false;
});
 
$(document).on('dragover', '#dropfile', function(e){
  e.preventDefault();
  e.stopPropagation();
  $(this).css('border', '3px dashed red');
  return false;
});
 
$(document).on('dragleave', '#dropfile', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).css('border', '3px dashed #BBBBBB');
  return false;
});

$(document).on('drop', '#dropfile', function(e) {
  if(e.originalEvent.dataTransfer){
    if(e.originalEvent.dataTransfer.files.length) {
      e.preventDefault();
      e.stopPropagation();
      $(this).css('border', '3px dashed green');
      upload(e.originalEvent.dataTransfer.files);
    }  
  }
  else {
    $(this).css('border', '3px dashed #BBBBBB');
  }
  return false;
});

function upload(files) {
  var f = files[0] ;
  if (!f.type.match('image/jpeg')) {
     alert('The file must be a jpeg image') ;
     return false ;
  }
  var reader = new FileReader();
  reader.onload = handleReaderLoad;
  reader.readAsDataURL(f);            
}
function handleReaderLoad(evt) {
  var pic = {};
  pic.file = evt.target.result.split(',')[1];

  var str = jQuery.param(pic);
console.log(pic);
  $.ajax({
          type: 'POST',
          url: '../model/drag_n_drop.php',
          data: str,
          success: function(data) {
            console.log(data);
          }
  });
}