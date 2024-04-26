<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
                        <?php if(isset($middle) && $middle && count($middle)): ?>
                            <?php foreach($middle as $key => $path): ?>
                                <?php $title = ucwords(str_replace("_", " ", $key)); ?>
                                <li class="breadcrumb-item"><a href="<?php echo base_url($path); ?>"><?php echo $title; ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo ($current ?? '') ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>