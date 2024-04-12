
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
                    <div class="card product-attribute" id="options_<?php echo $option->id; ?>">
                        <div class="row p-2">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="options" class="control-label<?php echo isset($isRequired) && $isRequired ? ' required' : ''; ?>">Option Name</label>
                                            <?php echo form_input("options[old][$option->id]", $option->option_name, array('class' => 'form-control', 'placeholder' => "Enter Option Name", 'readonly')); ?>
                                            <?php echo isset($field) && $field === 'options' ? $errors : ''; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8" id="extraValuesOption_<?php echo $option->id; ?>_<?php echo $option->id; ?>">
                                <?php if (count($option->product_option_values) > 0) : ?>
                                    <?php foreach ($option->product_option_values as $vkey => $option_value) : ?>
                                        <?php if ($vkey == 0) : ?>
                                            <div class='row'>
                                                <div class="col-md-12">
                                                    <label for="option_values" class="control-label<?php echo isset($isRequired) && $isRequired ? ' required' : ''; ?>">Option Values</label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row" id="options_values_<?php echo $option_value->id; ?>">
                                            <?php if ($option->option_name != 'COLOR') : ?>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <?php echo form_input("option_values[old][$option->id][$option_value->id]", $option_value->option_value, array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                                        <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="col-md-5">
                                                    <div class="input-group my-colorpicker2 form-group" data-id="<?php echo $option_value->id; ?>">
                                                        <?php echo form_input("option_values[old][$option->id][$option_value->id]", $option_value->option_value, array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-square fa-square_<?php echo $option_value->id; ?>" style="color: <?php echo $option_value->option_value; ?>;"></i></span>
                                                        </div>
                                                        <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-2">
                                                <?php echo form_button('<i class="fa fa-trash"></i>', '', array('type' => 'button', 'class' => 'btn btn-danger', 'onclick' => "removeOptionRow({$option_value->id}, 1)")); ?>
                                                <?php if ($vkey == 0) : ?>
                                                    <?php echo form_button('<i class="fa fa-plus"></i>', '', array('type' => 'button', 'class' => 'btn btn-info add-option', 'onclick' => "optionValuesBtn({$option->id}, {$option->id}, '{$option->option_name}')")); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php $optionValuesCounter = $option_value->id; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="row" id="options_values_1">
                                        <div class="col-md-12">
                                            <label for="option_values" class="control-label<?php echo isset($isRequired) && $isRequired ? ' required' : ''; ?>">Option Values</label>
                                            <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                        </div>
                                        <?php if ($option->option_name != 'COLOR') : ?>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <?php echo form_input("option_values[new][$option->id][]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Value")); ?>
                                                    <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-md-5">
                                                <div class="input-group my-colorpicker2 form-group" data-id="1">
                                                    <?php echo form_input("option_values[new][$option->id][]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Value", 'data-id' => 1)); ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-square fa-square_1"></i></span>
                                                    </div>
                                                    <?php echo isset($field) && $field === 'option_values' ? $errors : ''; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-2">
                                            <?php echo form_button('<i class="fa fa-trash"></i>', '', array('type' => 'button', 'class' => 'btn btn-danger', 'onclick' => 'removeOptionRow(1, 1)')); ?>
                                            <?php echo form_button('<i class="fa fa-plus"></i>', '', array('type' => 'button', 'class' => 'btn btn-info add-option', 'onclick' => 'optionValuesBtn(1, 1)')); ?>
                                        </div>
                                    </div>
                                    <?php $optionValuesCounter = $option->id; ?>
                                <?php endif; ?>
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
                                        <?php echo form_dropdown('options[type][1]', $optionsType,'', ['class' => 'form-control select2', 'style' => 'width:100%']); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Option Name :<span class="text-red">*</span>', 'option_name', ['class' => 'control-label']); ?>
                                    <?php echo form_input("options[new][1]", null, array('class' => 'form-control', 'placeholder' => "Enter Option Name")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-left" id="extraValuesOption_1_1">
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
                                    <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(1, 1)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div id="extraOption"></div>
            <div>
                <button type="button" class="btn btn-info" id="optionBtn"><i class="fa fa-plus"></i> Add New Option</button>
            </div>
        </div>
    </div>
</div>
