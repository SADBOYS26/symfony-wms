function clearSelect($select) {
    $select.html('<option selected>Не выбрано</option>').trigger('change')
}

$(document).ready(function () {
   $(document).on('change', '#wholesale-category', function () {
       var id = $(this).val();
       if(isNaN(id)) {
           clearSelect($('#wholesale'));
       } else {
           $.ajax({
               url : '/get-warehouses/'+id,
               type : 'post',
               success: function (response) {
                   if(response.length){
                       var $warehouseSelect = $('#wholesale');
                       response.forEach(function (item) {
                           console.log(item.id);
                           $warehouseSelect.append($('<option>', {value: item.id, text: item.name}));
                       });
                   } else {
                       clearSelect($('#wholesale'));
                   }
               }
           })
       }
   });
});