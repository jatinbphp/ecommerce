<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row additionalImageClass">
                <div class="col-lg-12 mb-2">
                    <h5>Add Product Images</h5>
                </div>
                <?php if (!empty($product_images)): ?>
                    <?php foreach ($product_images as $key => $value): ?>
                        <?php if(file_exists($value['image'])): ?>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="<?php echo isset($value['id']) ? $value['id'] : '' ?>">
                                <div class="imagePreviewPlus">
                                    <div class="text-left">
                                        <button type="button" class="btn btn-danger removeImage text-left" onclick="removeAdditionalProductImg('<?php echo isset($value['image']) ? $value['image'] : ''; ?>','<?php echo isset($value['id']) ? $value['id'] : ''; ?>','<?php echo $value['product_id']; ?>');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                    <img style="width: inherit; height: inherit;" <?php if (isset($value['image']) && !empty($value['image'])) { ?> src="<?php echo base_url($value['image']); ?>" <?php } ?> alt="">
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php else: ?>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                        <div class="boxImage imgUp imagediv">
                            <div class="loader-contetn loader1">
                                <div class="loader-01"> </div>
                            </div>
                            <div class="imagePreview"></div>
                            <label class="btn btn-primary">
                                Upload<input type="file" name="file[]" class="uploadFile img" id="file-1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1">
                            </label>
                        </div>
                    </div>
                <?php endif ?>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 imgAdd">
                    <div class="imagePreviewPlus imgUp"><i class="fa fa-plus fa-4x"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
