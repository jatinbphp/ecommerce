/*function for filtering proucts based on category in the home page*/
function setTab(event){
	event.preventDefault();
	var categoryId = event.target.getAttribute('data-id');
	var activeTab = $('ul#product-categories').find('.active').attr("id");
	$("#" + activeTab).removeClass('active');
	$("#" + event.target.id).addClass('active');
	getProducts(categoryId);
}

function getProducts(categoryId){
    $('#loader').removeClass('d-none');
	$.ajax({
        url: baseUrl+"products", 
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            filter:{
            	categoryId: categoryId
            }
    	},
        success: function(response) {
            $('#category-section').html(response.html);
            $('#loader').addClass('d-none');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            $('#loader').addClass('d-none');
        }
    });
}

function handleQuickView(event){
    event.preventDefault();
    var productId = event.target.getAttribute('data-id');
    if(!productId) return false;
    $.ajax({
        url: baseUrl+"products/show/" + productId, 
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        success: function(response) {
            if (response.status) {
                $('.modal-body, #quickviewbody').html(response.html);
                initSlickSlider();
                $('#quickview').modal('show');
            } else {
                console.error('Error loading view:', response);
            }
        }
    });
}

$(document).on("click", "#add_to_cartproduct", function(e) {
    e.preventDefault();
    var form = $(this).closest("form");
    var form_type = $(this).attr('data-type');

    $.ajax({
        url: form.attr("action"),
        type: 'POST',
        data: form.serialize(),
        success: function(response){
            if(response.type == 2){
                var msg = 'Something went wrong.';
                SnackbarAlert(msg);
                return;
            }
            if(response.type == 3 && response.addCartData){
                var existingCartData = localStorage.getItem('cartData') ? JSON.parse(localStorage.getItem('cartData')) : [];
                var foundIndex = existingCartData.findIndex(function(item) {
                    return item.product_id === response.addCartData.product_id && 
                        JSON.stringify(item.options) === JSON.stringify(response.addCartData.options);
                });

                if (foundIndex !== -1) {
                    if ('quantity' in existingCartData[foundIndex] && 'quantity' in response.addCartData) {
                        var existingQuantity = parseInt(existingCartData[foundIndex].quantity);
                        var newQuantity = parseInt(response.addCartData.quantity);

                        if (!isNaN(existingQuantity) && !isNaN(newQuantity)) {
                            existingCartData[foundIndex].quantity = (existingQuantity + newQuantity);
                        } 
                    }
                } else {
                    existingCartData.push(response.addCartData);
                }
                localStorage.setItem('cartData', JSON.stringify(existingCartData));
                updateCartData();
                var data = localStorage.getItem('cartData');
                if(data){
                    $('.user-cart-counter').text(JSON.parse(data).length);
                }
            } else {
                $('.user-cart-counter').text(response.cartCounter)
            }
            $('#quickview').modal('hide');
            SnackbarAlert('Your product was added to cart successfully!');
            
        },
        error: function(xhr, status, error){
            SnackbarAlert(error);
        }
    });
});

function initSlickSlider() {
    $('.quick_view_slide').slick({
        slidesToShow: 1,
        arrows: true,
        dots: true,
        infinite: true,
        autoplaySpeed: 2000,
        autoplay: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    arrows: true,
                    dots: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    arrows: true,
                    dots: true,
                    slidesToShow: 1
                }
            }
        ]
    });
}

