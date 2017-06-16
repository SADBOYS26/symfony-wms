function clearSelect($select) {
    $select.html('<option selected>Не выбрано</option>').trigger('change');
    $('.warehouse__info').html('');
}

$(document).ready(function () {

    var $warehouse = $('#warehouse');
    var $product = $('#product');
    var $productMap = $('#product-map');
    var $warehouseCategoryContent = $('#warehouse-category').html();

   $(document).on('change', '#warehouse-category', function () {
       var id = $(this).val();
       clearSelect($warehouse);
       clearSelect($product);
       clearSelect($productMap);
       if(!isNaN(id)) {
           $.ajax({
               url : '/get-warehouses/'+id,
               type : 'post',
               success: function (response) {
                   var warehouses = response.warehouses;
                   var products = response.products;
                   if(warehouses !== undefined){
                       warehouses.forEach(function (item) {
                           $warehouse.append($('<option>', {value: item.id, text: item.name}));
                       });
                   }
                   if(products !== undefined){
                       products.forEach(function (item) {
                           $product.append($('<option>', {value: item.id, text: item.name}));
                       });
                   }
               }
           })
       }
   });

   $(document).on('change', '#warehouse', function () {
       var id = $(this).val();
       $('.warehouse__info').html('');
       clearSelect($productMap);
       if(!isNaN(id)) {
           $.ajax({
               url : '/get-warehouse/'+id,
               type : 'post',
               success: function (response) {
                   $('.warehouse__info').html(response.html);
                   var freeMaps = response.freeMaps;
                   freeMaps.forEach(function (item) {
                       $productMap.append($('<option>', {value: item.id, text: item.name}));
                   });
               }
           })
       }
   });

    $(document).on('change', '#product', function () {
        var id = $(this).val();
        if(isNaN(id)) {
            $('.product__info').html('');
        } else {
            $.ajax({
                url : '/get-product/'+id,
                type : 'post',
                success: function (response) {
                    $('.product__info').html(response);
                }
            })
        }
    });

    $('.product-receipt').on('change', 'select', function () {
        if(!isNaN($warehouse.val()) && !isNaN($product.val())){
            $('.product-receipt__send').css('display', 'flex');
        } else {
            $('.product-receipt__send').hide();
        }
    });
    
    $(document).on('click', '#product-send__button', function () {
        var productId = $product.val();
        var mapId = $productMap.val();
        if(!isNaN(mapId) && !isNaN(mapId)){
            $.ajax({
                url: '/add-to-map/',
                type: 'post',
                data: {
                    mapId: mapId,
                    productId: productId
                },
                success: function (response) {
                    if(response.result === true) {
                        alert('Товар успешно добавлен на склад');
                        clearSelect($warehouse);
                        clearSelect($product);
                        clearSelect($productMap);
                        $('#warehouse-category').html($warehouseCategoryContent).trigger('change');
                        $('.product__info').html('');
                    } else {
                        alert('Произошла ошибка добавления товара');
                    }
                }
            })
        } else {
            alert('Не выбрано место на складе или товар');
        }
    });

    $(document).on('click', '#product__shipment', function () {
        var id = $('#product-mapped').val();
        $.ajax({
            url: '/product-shipment/'+id,
            type: 'post',
            success: function (response) {
                if(response.result === true) {
                    alert('Товар успешно отгружен');
                    location.reload();
                } else {
                    alert('Произошла ошибка отгрузки товара');
                }
            }
        })
    });
});