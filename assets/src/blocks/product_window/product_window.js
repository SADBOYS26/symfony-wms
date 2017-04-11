require('./product_window.less');
import Popup from '../popup/popup';

$(document).on('click', '.product-js', function () {
    const id = $(this).data('id');
    const popup = new Popup('product_detail', id);
    popup.getContent();
});





