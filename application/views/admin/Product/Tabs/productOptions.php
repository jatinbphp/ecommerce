<?php $optionValuesCounter = 1?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <p class="h5">Add Option Values</p>
                </div>
            </div>
            <?php if (isset($product_options) && count($product_options) > 0) : ?>
                <?php foreach ($product_options as $key => $option) : ?>
                    <?php $optionId = isset($option['id']) ? $option['id'] : ''; ?>
                    <?php $optionName = isset($option['option_name']) ? $option['option_name'] : ''; ?>
                    <?php $optionType = isset($option['option_type']) ? $option['option_type'] : ''; ?>
                    <?php $productOptionValues = isset($option['option_values']) ? $option['option_values'] : []; ?>
                    <div class="card product-attribute" id="options_<?php echo $optionId ?>">
                        <div class="row p-2">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <?php echo form_label('Option Type :<span class="text-red">*</span>', 'option_type', ['class' => 'control-label', 'is_required' => true]); ?>
                                            <?php echo form_dropdown("options[old][$optionId][type]", $optionsType,$optionType, ['class' => 'form-control select2', 'style' => 'width:100%', 'onChange' => "updateOptions(this, $optionId)"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <?php echo form_label('Option Name :<span class="text-red">*</span>', 'option_name', ['class' => 'control-label']); ?>
                                            <?php echo form_input("options[old][$optionId][name]", $optionName, array('class' => 'form-control', 'placeholder' => "Enter Option Name", 'readonly')); ?>
                                            <?php echo isset($field) && $field === 'options' ? $errors : ''; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 border-left">
                                <div id="extraValuesOption_<?php echo $optionId; ?>_<?php echo $optionId; ?>">
                                    <?php if (count($productOptionValues) > 0) : ?>
                                        <?php foreach ($productOptionValues as $vkey => $option_value) : ?>
                                            <?php $optionValueId = isset($option_value['id']) ? $option_value['id'] : ''; ?>
                                            <?php if ($vkey == 0) : ?>
                                                <div class='row'>
                                                    <div class="col-md-6">
                                                        <?php echo form_label('Option Values: <span class="text-red">*</span>', 'option_values', ['class' => 'control-label']); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="row" id="options_values_<?php echo $optionValueId; ?>">
                                                <?php if ($optionType != 'color') : ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php echo form_input("option_values[old][$optionId][$optionValueId]", $option_value['option_value'], array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                                            <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="col-md-6">
                                                        <div class="input-group my-colorpicker2 form-group" data-id="<?php echo $optionValueId; ?>">
                                                            <?php echo form_input("option_values[old][$optionId][$optionValueId]", $option_value['option_value'], array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fas fa-square fa-square_<?php echo $optionValueId; ?>" style="color: <?php echo $option_value['option_value']; ?>;"></i></span>
                                                            </div>
                                                            <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-danger" onclick="removeOptionRow(<?php echo $optionValueId ?>, 1)">
                                                            <i class="fa fa-trash"></i>
                                                    </button>
                                                    <?php if ($vkey == 0) : ?>
                                                        <!-- <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,<?php echo $optionId ?>, <?php echo $optionId ?>, '<?php $optionType ?>')">
                                                            <i class="fa fa-plus"></i>
                                                        </button> -->
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php $optionValuesCounter = $optionValueId; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="row" id="options_values_1">
                                            <div class="col-md-12">
                                                <?php echo form_label('Option Values: <span class="text-red">*</span>', 'option_values', ['class' => 'control-label']); ?>
                                                <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                            </div>
                                            <?php if ($optionName != 'COLOR') : ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo form_input("option_values[new][$optionId][]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                                        <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="col-md-6">
                                                    <div class="input-group my-colorpicker2 form-group" data-id="1">
                                                        <?php echo form_input("option_values[new][$optionId][]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Value", 'data-id' => 1)); ?>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-square fa-square_1"></i></span>
                                                        </div>
                                                        <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-danger" onclick="removeOptionRow(<?php echo $optionId ?>, 1)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,<?php echo $optionId ?>, <?php echo $optionId ?>, '<?php echo $optionName ?>')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php $optionValuesCounter = $optionId; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,<?php echo $optionId ?>, <?php echo $optionId ?>, '<?php $optionType ?>')">
                                            <i class="fa fa-plus"></i> Add New Values
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="card product-attribute" id="options_1">
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <?php echo form_label('Option Type :<span class="text-red">*</span>', 'option_type', ['class' => 'control-label', 'is_required' => true]); ?>
                                        <?php echo form_dropdown('options[new][1][type]', $optionsType,null, ['class' => 'form-control select2', 'style' => 'width:100%', 'onChange' => "updateOptions(this, 1)"]); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Option Name :<span class="text-red">*</span>', 'option_name', ['class' => 'control-label']); ?>
                                    <?php echo form_input("options[new][1][name]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Name")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-left">
                            <div id="extraValuesOption_1_1">
                                <div class='row'>
                                    <div class="col-md-6">
                                        <?php echo form_label('Option Values: <span class="text-red">*</span>', 'option_values', ['class' => 'control-label']); ?>
                                    </div>
                                </div>
                                <div class="row" id="options_values_1">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo form_input("option_values[new][1][]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-danger" onclick="removeOptionRow(1, 1)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <!-- <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,1, 1)">
                                            <i class="fa fa-plus"></i>
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,1, 1)">
                                        <i class="fa fa-plus"></i> Add New Values
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div id="extraOption"></div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-info" id="optionBtn"><i class="fa fa-plus"></i> Add New Option</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var optionName = <?php echo $optionValuesCounter ?>;

$('#optionBtn').on('click', function(){
    optionName = optionName + 1;

    var name = "options[new][" + optionName + "][type]";


    var options = `<?php echo form_dropdown("' + name + '", $optionsType, "", array("class" => "form-control select2", "style" => "width:100%")); ?>`;

    var exOptionContent = '<div class="card product-attribute" id="options_'+optionName+'">'+
            '<div class="row p-2">'+
                '<div class="col-md-6">'+
                    '<div class="row">'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="options">Option Type :<span class="text-red">*</span></label>'+
                            '<div class="form-group">' +
                                '<select name="' + name + '" class="form-control select2" onChange="updateOptions(this,'+optionName+')" style="width:100%">'+
                                    '<option value="select">Select</option>'+
                                    '<option value="color">Color</option>'+
                                    '<option value="radio">Radio Button</option>'+
                                '</select>' +
                            '</div>' +
                        '</div>'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="options">Option Name :<span class="text-red">*</span></label>'+
                            '<div class="form-group">'+
                                '<input type="text" name="options[new]['+optionName+'][name]" class="form-control" placeholder="Enter Option Name">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger" onClick="removeOptionRow('+optionName+', 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-6 border-left">'+
                    '<div id="extraValuesOption_'+optionName+'_'+optionName+'">'+
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
                                // '<button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,'+optionName+', '+optionName+')"><i class="fa fa-plus"></i> </button>'+
                            '</div>'+                    
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-12">'+
                            '<button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,'+optionName+', '+optionName+')">'+
                                '<i class="fa fa-plus"></i> Add New Values'+
                            '</button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
    $('.select2').select2();
});

function optionValuesBtn(button, option_value_number, option_number, option_type) {
    optionName = optionName + 1;
    var data = $(button).closest('.product-attribute').find('select').val();
    var className = '';
    if(option_type=='color' || data=='color'){
        var className = 'input-group my-colorpicker2';
    }

    var exOptionContent = `
    <div class="row" id="options_values_${optionName}">
        <div class="col-md-6">
            <div class="${className} form-group" data-id="${optionName}">
                <input type="text" name="option_values[new][${option_value_number}][]" class="form-control" placeholder="Enter Option Value" data-id="${optionName}">
                ${option_type == 'color' || data=='color' ? `
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

function updateOptions(select, optionId){
    var selectedOptions = $(select).val();
    var className = '';
    var colorElement = '';
    if(selectedOptions == 'color'){     
        className = 'input-group my-colorpicker2';
        colorElement = '<div class="input-group-append"><span class="input-group-text"><i class="fas fa-square fa-square_'+optionName+'"></i></span></div>';
    }

    var data = '<div class="row">'+
                    '<div class="col-md-6">'+
                        '<label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-md-6">'+
                        '<div class="'+className+' form-group" data-id="'+optionName+'" id="options_values_'+optionName+'">'+
                            '<input type="text" name="option_values[new]['+optionName+'][]" data-id="'+optionName+'" class="form-control" placeholder="Enter Option Value">'+colorElement+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-6">'+
                        '<button type="button" class="btn btn-danger mr-1" onClick="removeOptionRow('+optionId+', 1)"><i class="fa fa-trash"></i></button>'+
                        //'<button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(this,'+optionId+', '+optionId+')"><i class="fa fa-plus"></i> </button>'+
                    '</div>'+                    
                '</div>';
    $('#extraValuesOption_'+optionId+'_'+optionId).empty().append(data);
    $('.my-colorpicker2').colorpicker();
}

</script>