<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Contact Us</h2>
                    <h3 class="ft-bold pt-3">Get In Touch</h3>
                </div>
            </div>  
            <section class="middle">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="sec_title position-relative text-center">
                                <h2 class="off_title">Contact Us</h2>
                                <h3 class="ft-bold pt-3">Get In Touch</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-start justify-content-between">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="card-wrap-body mb-4">
                                <h4 class="ft-medium mb-3 theme-cl">Store Address</h4>
                                <p><?php echo isset($settingsData['address']) ? $settingsData['address'] : ''; ?></p>
                            </div>
                            <div class="card-wrap-body mb-3">
                                <h4 class="ft-medium mb-3 theme-cl">Make a Call</h4>
                                <h6 class="ft-medium mb-1">Customer Care:</h6>
                                <p class="mb-2"><?php echo isset($settingsData['phone_number']) ? $settingsData['phone_number'] : ''; ?></p>
                            </div>
                            <div class="card-wrap-body mb-3">
                                <h4 class="ft-medium mb-3 theme-cl">Drop A Mail</h4>
                                <p>Fill out our form and we will contact you within 24 hours.</p>
                                <p class="lh-1 text-dark"><?php echo isset($settingsData['email_address']) ? $settingsData['email_address'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                            <?php if($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php elseif($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <?php echo form_open('contact/send_message', ['class' => 'row', 'id' => 'sendMessage']);?>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <?php
                                            echo form_label('Your Name *', '', ['class' => 'small text-dark ft-medium']);
                                            echo form_input(['name' => 'name', 'class' => 'form-control', 'placeholder' => 'Your Name', 'value' => set_value('name')]);
                                            echo form_error('name', '<p class="text-danger">', '</p>');
                                        ?>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <?php
                                            echo form_label('Your Email *', '', ['class' => 'small text-dark ft-medium']);
                                            echo form_input(['name' => 'email', 'class' => 'form-control', 'placeholder' => 'Your Email', 'value' => set_value('email')]);
                                            echo form_error('email', '<p class="text-danger">', '</p>');
                                        ?>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <?php
                                            echo form_label('Subject', '', ['class' => 'small text-dark ft-medium']);
                                            echo form_input(['name' => 'subject', 'class' => 'form-control', 'placeholder' => 'Type Your Subject', 'value' => set_value('subject')]);
                                            echo form_error('subject', '<p class="text-danger">', '</p>');
                                        ?>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <?php
                                            echo form_label('Message', '', ['class' => 'small text-dark ft-medium']);
                                            echo form_textarea(['name' => 'message', 'class' => 'form-control ht-80',' placeholder' => 'Type Your Message', 'value' => set_value('message')]);
                                            echo form_error('message', '<p class="text-danger">', '</p>');
                                        ?>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <?php
                                            echo form_submit(['name' => 'submit', 'class' => 'btn btn-dark'], 'Send Message');
                                        ?>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>