var filter = {};

// $( document ).ready(function() {
//    $.ajax({
//       url: baseUrl+"products/options",
//       method: 'GET',
//       headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
//       success: function(response) {
//          if (!response.status) return false;
//          $.each(response.data, function(index, value) {
//             filter[value] = null;
//          });
//          handleFilter();
//       },

//       error: function(jqXHR, textStatus, errorThrown) {
//          console.error('AJAX Error:', textStatus, errorThrown);
//       }
//    });
// });

function setOption(event, optionName){
   filter[optionName] = filter[optionName] || [];
   filter[optionName].length = 0;
   $(".option-" + optionName).each(function () {
      if ($(this).is(":checked")) {
         filter[optionName].push(Number($(this).val()));
      }
   });
   if(optionName == 'priceRange'){
      var slider = $('#rangeSlider').data("ionRangeSlider");
      filter[optionName].push(Number(slider.result.from));
      filter[optionName].push(Number(slider.result.to));
   }
   handleFilter();
}

$('#sort-filters').change(function(){
   handleFilter();
});


function handleFilter(){
   filter['sort'] = $('#sort-filters').val();
   var filterCategory = $('#shop-categories').attr('data-filter-category-id');
   if(filterCategory && filterCategory != 0){
      filter['categoryId'] = [Number(filterCategory)];
   }
   $.ajax({
      url: baseUrl+"products",
      method: 'GET',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: filter,
      success: function(response) {
         $('.rows-products').html(response.html);
         $('#filterCount').html($(".product_grid").length);
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
      }
   });
}

