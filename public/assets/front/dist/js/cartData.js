function updateCartData(){
    var data = localStorage.getItem('cartData');
    $.ajax({
        type: 'GET',
        url: baseUrl+'saveCartData',
        data: { 'cartData': data },
    }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
        updateCsrfToken();
    });
}