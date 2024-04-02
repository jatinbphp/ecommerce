    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div>
                    <h2 class="text-center mb-4">Sign In</h2>

                    <?php if ($this->session->flashdata('success_message')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('success_message'); ?>
                        </div>
                    <?php endif; ?>
                     <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php } ?>

                    <?php echo form_open('authUser'); ?>
                        <div class="form-group">
                            <?php echo form_label('Email', 'email'); ?>
                            <?php echo form_input(array('type' => 'email', 'class' => 'form-control', 'id' => 'email', 'name' => 'email', 'required' => 'required','placeholder' => 'Enter your email')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Password', 'password'); ?>
                            <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'id' => 'password', 'name' => 'password', 'required' => 'required', 'placeholder' => 'Enter your password')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit(array('class' => 'btn btn-primary btn-block', 'value' => 'Sign In')); ?>
                        </div>
                    <?php echo form_close(); ?>
                    <p class="text-center">Don't have an account? <?php echo anchor('signup', 'Sign Up'); ?></p>
                </div>
            </div>
        </div>
    </div>
