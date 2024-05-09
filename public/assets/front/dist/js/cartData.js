function updateCartData(){
    var data = localStorage.getItem('cartData');
    $.ajax({
        type: 'POST',
        url: baseUrl+'saveCartData',
        data: { cartData: data },
    });
}