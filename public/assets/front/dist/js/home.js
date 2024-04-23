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
	$.ajax({
        url: "products", 
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
        	categoryId: categoryId 
    	},
        success: function(response) {
            if (response.status) {
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

function handleQuickView(event){
    event.preventDefault();
    var productId = event.target.getAttribute('data-id');
    if(!productId) return false;
    $.ajax({
        url: "products/show/" + productId, 
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
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });
}
