/*function for filtering proucts based on category in the home page*/
function setTab(event){
	event.preventDefault();
	var categoryId = event.target.getAttribute('data-id');
	var activeTab = $('ul#product-categories').find('.active').attr("id");
	$("#" + activeTab).removeClass('active');
	$("#" + event.target.id).addClass('active');
	getProducts(categoryId);
}

$(window).on("load", function() {
  	var categoryId = $('ul#product-categories').find('.active').attr("data-id");
    if (categoryId) {
        getProducts(categoryId);
    }
});

function getProducts(categoryId){
	$.ajax({
        url: "products/get_products", 
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
        	categoryId: categoryId 
    	},
        success: function(response) {
            if (response.success) {
            	$('#category-section').html(response.html);
        	} else {
            	console.error('Error loading view:', response);
        	}
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });
}

function prodAddToCart()
{
    var formData = $('#addToCartDataFrm').serialize();
     $.ajax({
        url: "cart/add-product-to-cart",
        method: 'POST',
        data: formData,
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        success: function(response) {

            $(".user-cart-counter").html(response);
            $('#quickviewMdl').modal('hide');
                
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });

}

function deleteCartItem(cartId) {
    
        $.ajax({
        url: "cart/delete-user-item",
        method: 'POST',
        data: {
            cartId: cartId 
        },
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        success: function(response) {

            $("#usrCartDataMenu").html(response.cartView);
            $(".user-cart-counter").html(response.cartCounter);
                
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });
}






