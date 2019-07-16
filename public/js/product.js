$(document).ready(function () {
    var countProductInBasket = $('span.count-product');
    var basketPriceDefault = $('span.basket-price');
    var basketPrice = basketPriceDefault.text();
    var productPrice = $('span.price').text();

    $('.counter-right').click(function(){
        var num = $(this).prev().val();
        num++;
        $(this).prev().val(num);
        basketPrice = (+basketPrice + +productPrice);
        setNewValueInBasket(num, basketPrice);

    });
    $('.counter-left').click(function(){
        var num = $(this).next().val();
        if( num>1 ){
            num--;
            $(this).next().val(num);
            basketPrice = (+basketPrice - +productPrice);
            setNewValueInBasket(num, basketPrice);
        }
    });

    function setNewValueInBasket(num, basketPrice) {
        countProductInBasket.text(num);
        basketPriceDefault.text(basketPrice);
    }
});
