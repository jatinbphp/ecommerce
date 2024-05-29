function updateCartData(){
    var data = localStorage.getItem('cartData');
    var tockenName = getTockenName();
    var tockenValue = getTockenValue();
    var dataObj = { 'cartData': data };
    dataObj[tockenName] = tockenValue;
    $.ajax({
        type: 'POST',
        url: baseUrl+'saveCartData',
        data: dataObj,
    }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
        updateCsrfToken();
    });
}