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
         filter[optionName].push($(this).val());
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
   var slider = $('#rangeSlider').data("ionRangeSlider");
   if(slider){
      filter['priceRange'] = [];
      filter['priceRange'].push(Number(slider.result.from));
      filter['priceRange'].push(Number(slider.result.to));
   }
   if(filterCategory && filterCategory != 0){
      filter['categoryId'] = [Number(filterCategory)];
   }
   $('#loader').removeClass('d-none');
   $.ajax({
      url: baseUrl+"products",
      method: 'GET',
      data: {
         filter: filter,
         viewType:'filter',
      },
      success: function(response) {
         $('.rows-products').html(response.html);
         $('#filterCount').html($(".product_grid").length);
         $('#loader').addClass('d-none');
         if($('.ti-view-list').parent('a').hasClass('active')){
            $('.filters').removeClass().addClass('col-12 filters');
            $('.product-detail-description').removeClass('d-none');
         } else {
            $('.product-detail-description').addClass('d-none');
         }
         $('#search-text').text('').removeClass('d-none');
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         $('#loader').addClass('d-none');
         $('#search-text').text('').removeClass('d-none');
      }
   }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
      updateCsrfToken();
  });
}

// Range Slider Script
$(".js-range-slider").ionRangeSlider({
   type: "double",
   min: 1,
   max: 10000,
   from:100,
   to:7500,
   grid: true,
   onFinish: function (data) {
      setOption(event, 'priceRange')
   },
});

