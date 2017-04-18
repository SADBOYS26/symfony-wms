require('./product.less');
import Popup from '../popup/popup';

$(document).on('click', '.product-js-show', function () {
    const id = $(this).data('id');
    const popup = new Popup('product_detail', id);
    popup.getContent();
});

$(document).on('click', '.product-js-edit', function () {
    const id = $(this).data('id');
    const popup = new Popup('product_edit', id);
    popup.getContent();
});

$(document).on('click', '.product-js-edit-save', function (event) {
    event.preventDefault();
    const formData = $(this).parent('form').serialize();
    const popup = new Popup('product_edit', 3, formData);
    popup.getContent();
});