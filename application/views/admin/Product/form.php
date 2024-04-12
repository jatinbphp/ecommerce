<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link product-info  <?php if(!isset($nextTab)) echo 'active'; ?> product-tabs" id="tab1" data-type="product-info" data-toggle="tab" href="#product-info">General Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link product-image product-tabs <?php if(isset($nextTab) && $nextTab == 'product-image') echo 'active'; ?> <?php if(!isset($product_data)) echo 'disabled'; ?>" id="tab2" data-type="product-image" data-toggle="tab" href="#product-image">Product Images</a>
    </li>
    <li class="nav-item">
        <a class="nav-link product-options product-tabs <?php if(isset($nextTab) && $nextTab == 'product-options') echo 'active' ?>  <?php if(!isset($product_data)) echo 'disabled'; ?>" id="tab3" data-type="product-options" data-toggle="tab" href="#product-options">Options</a>
    </li>
</ul>
<style type="text/css">
    .nav-tabs .active {color: #007bff !important;}
</style>
<div class="tab-content mt-2">
    <div class="row tab-pane fade <?php if(!isset($nextTab)) echo 'show active'; ?> tab-product-data" id="product-info">
        <?php $this->load->view('admin/Product/Tabs/productInfo'); ?>
    </div>
    <div class="row tab-pane fade  <?php if(isset($nextTab) && $nextTab == 'product-image') echo 'show active'; ?> tab-product-data" id="product-image">
        <?php $this->load->view('admin/Product/Tabs/productImage'); ?>
    </div>
    <div class="row tab-pane fade <?php if(isset($nextTab) && $nextTab == 'product-options') echo 'show active'; ?> tab-product-data" id="product-options">
        <?php $this->load->view('admin/Product/Tabs/productOptions'); ?>
    </div>
    <?php $optionValuesCounter = 1?>
</div>

<script type="text/javascript">
var optionName = <?php echo $optionValuesCounter ?>;

$('#optionBtn').on('click', function(){
    optionName = optionName + 1;

    var options = `<?php echo form_dropdown("options[type][1]", $optionsType, "", array("class" => "form-control select2", "style" => "width:100%")); ?>`;

    var exOptionContent = '<div class="card product-attribute" id="options_'+optionName+'">'+
            '<div class="row p-2">'+
                '<div class="col-md-6">'+
                    '<div class="row">'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="options">Option Type :<span class="text-red">*</span></label>'+
                            '<div class="form-group">' +
                                options +
                            '</div>' +
                        '</div>'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="options">Option Name :<span class="text-red">*</span></label>'+
                            '<div class="form-group">'+
                                '<input type="text" name="options[new]['+optionName+']" class="form-control" placeholder="Enter Option Name">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger" onClick="removeOptionRow('+optionName+', 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-6 border-left" id="extraValuesOption_'+optionName+'_'+optionName+'">'+
                    '<div class="row">'+
                        '<div class="col-md-6">'+
                            '<label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row" id="options_values_'+optionName+'">'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="text" name="option_values[new]['+optionName+'][]" class="form-control" placeholder="Enter Option Value">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<button type="button" class="btn btn-danger mr-1" onClick="removeOptionRow('+optionName+', 1)"><i class="fa fa-trash"></i></button>'+
                            '<button type="button" class="btn btn-info add-option" onclick="optionValuesBtn('+optionName+', '+optionName+')"><i class="fa fa-plus"></i> </button>'+
                        '</div>'+                    
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
    $('.select2').select2();
});

function optionValuesBtn(option_value_number, option_number, option_name) {
    optionName = optionName + 1;

    var className = '';
    if(option_name=='COLOR'){
        var className = 'input-group my-colorpicker2 ';
    }

    var exOptionContent = `
    <div class="row" id="options_values_${optionName}">
        <div class="col-md-6">
            <div class="${className} form-group" data-id="${optionName}">
                <input type="text" name="option_values[new][${option_value_number}][]" class="form-control" placeholder="Enter Option Value" data-id="${optionName}">
                ${option_name == 'COLOR' ? `
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-square fa-square_${optionName}"></i></span>
                </div>` : ''}
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger mr-1" onClick="removeOptionRow('${optionName}', 1)"><i class="fa fa-trash"></i></button>
        </div>                    
    </div>`;

    $('#extraValuesOption_'+option_value_number+'_'+option_number).append(exOptionContent);

    // Reinitialize color picker for the newly added elements
    $('.my-colorpicker2').colorpicker(); // Assuming you're using a color picker plugin
}

function removeOptionRow(divId, type){
    const removeRowAlert = createOptionAlert("Are you sure?", "Do want to delete this row", "warning");
    swal(removeRowAlert, function(isConfirm) {
        if (isConfirm) {
            var flag =  deleteRow(divId, type);
            if(flag){
                swal.close();
            }
        } else{
             swal("Cancelled", "Your data safe!", "error");
        }
    });
}

//remove the row
function deleteRow(divId, type){
    if(type==1){
        console.log($('#options_values_'+divId).parent('div').children('div').length);
        if($('#options_values_'+divId).parent('div').children('div').length <= 2){
            swal("Error", "You cannot remove all option values. If you wish to remove them, you must delete the entire option.", "error");
            return 0;
        }
        var mainDiv = $('#options_values_'+divId);
        var divWithAddOptionClass = mainDiv.find('.add-option').closest('.row');
        if(divWithAddOptionClass.length > 0){
            var addButton = divWithAddOptionClass.find('.add-option');
            var secondDiv = mainDiv.next('.row');
            var colMd2Div = secondDiv.find('.col-md-2');
            addButton.detach();
            colMd2Div.append(addButton);
        }
        $('#options_values_'+divId).remove();
    } else {
        $('#options_'+divId).remove();
        if ($(".product-attribute").length == 0) {
            $('#optionBtn').click();
        }
    }
    return 1;  
}

function createOptionAlert(title, text, type) {
    return {
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    };
}

var i = 2;
$(".imgAdd").click(function(){

    var html = '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_'+i+'">'+
                    '<div class="boxImage imgUp imagediv">'+
                        '<div class="loader-contetn loader'+i+'"><div class="loader-01"></div></div>'+
                        '<div class="imagePreview">'+
                            '<div class="text-right">'+
                                '<button class="btn btn-danger deleteProdcutImage" data-id="'+i+'"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                            '</div>'+
                        '</div>'+
                        '<label class="btn btn-primary"> Upload<input type="file" id="file-'+i+'" class="uploadFile img" name="file[]" value="Upload Photo" style="width: 0px; height: 0px; overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1" />'+
                        '</label>'+
                    '</div>'+
                '</div>';

    $(this).closest(".row").find('.imgAdd').before(html);

    i++;
});

$(document).on("click", ".deleteProdcutImage" , function() {
    var id = $(this).data('id');
    $(document).find('#imgBox_'+id).remove(); 
});

$(function() {
    $(document).on("change",".uploadFile", function(){
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAdditionalProductImg(img_name, image_id, product_id){
    swal({
            title: "Are you sure?",
            text: "You want to delete this image",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:  baseUrl+"admin/product/removeimage",
                type: "POST",
                data: {
                    'id': image_id,
                    'product_id': product_id,
                    'img_name': img_name,
                 },
                success: function(data){                        
                    swal("Deleted", "Your image successfully deleted!", "success");
                    $('#'+image_id).remove();
                }
            });
        } else {
            swal("Cancelled", "Your data safe!", "error");
        }
    });
}
</script>
