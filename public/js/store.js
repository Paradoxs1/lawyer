$(document).ready(function () {
    var countProductInBasket = $('span.count-product');
    var basketPriceDefault = $('span.basket-price');
    var countProduct = countProductInBasket.text();
    var basketPrice = basketPriceDefault.text();

    $(document).on('click', 'a.btn-basket', function (e) {
        e.preventDefault();
        var productPrice = $(this).siblings('.clearfix').children('.shop-price').children('.price').text();

        countProductInBasket.text(++countProduct);
        basketPrice = (+basketPrice + +productPrice);
        basketPriceDefault.text(basketPrice);
    })
});