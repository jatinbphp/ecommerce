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
        success: function(response){
            updateCsrfTokens(response.csrf_token_name, response.csrf_token_value);
        }
    });
}