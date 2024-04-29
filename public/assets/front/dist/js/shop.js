var filter = {};

$( document ).ready(function() {
   $.ajax({
      url: "products/options",
      method: 'GET',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      success: function(response) {
         if (!response.status) return false;
         $.each(response.data, function(index, value) {
            filter[value] = null;
         });
      },

      error: function(jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
      }
   });
}); 


function setOption(event, optionName){
   filter[optionName] = filter[optionName] || [];
   filter[optionName].length = 0;
   $(".option-" + optionName).each(function () {
      if ($(this).is(":checked")) {
         filter[optionName].push(Number($(this).val()));
         console.log(filter);
      }
   });

   handleFilter();
}


function handleFilter(event){
   $.ajax({
      url: "products",
      method: 'GET',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: filter,
      success: function(response) {
         if (!response.status) return false;
         //var products = JSON.parse(JSON.stringify(response.products.data));
         //var totalCount = products.length; 
         //$('#items-found').text(totalCount); 
         //response.is_last ? $("#load-more-btn").addClass('d-none') : $("#load-more-btn").removeClass('d-none');
         $('.rows-products').html(response.html);
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
      }
   });
}



