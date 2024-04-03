<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $this->lang->line('lang_title_manage_applicant'); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>"><?php echo $this->lang->line('lang_title_home'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $this->lang->line('lang_title_manage_applicant'); ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
                <div class="col-md-12">
                <!-- general form elements -->

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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $this->lang->line('lang_title_edit_applicant'); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="<?php base_url('students/create') ?>" method="post"  id="student_edit_form">
                            
                            <div class="card-body">
                                <input type="hidden" id="id" name="id" value="<?php echo $student_data['id'] ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username"><?php echo $this->lang->line('lang_field_title_username'); ?> :<span class="asterisk-sign">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo $this->lang->line('lang_placeholder_username'); ?>" autocomplete="off" REQUIRED value="<?php echo $student_data['username'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email"><?php echo $this->lang->line('lang_field_title_email_address'); ?> :<span class="asterisk-sign">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $this->lang->line('lang_field_title_email_address'); ?>" autocomplete="off" REQUIRED value="<?php echo $student_data['email'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname"><?php echo $this->lang->line('lang_field_title_firstname'); ?> :<span class="asterisk-sign">*</span></label>
                                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo $this->lang->line('lang_field_title_firstname'); ?>" autocomplete="off" REQUIRED value="<?php echo $student_data['firstname'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname"><?php echo $this->lang->line('lang_field_title_lastname'); ?> :<span class="asterisk-sign">*</span></label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?php echo $this->lang->line('lang_field_title_lastname'); ?>" autocomplete="off" REQUIRED value="<?php echo $student_data['lastname'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone"><?php echo $this->lang->line('lang_field_title_phoneno'); ?> :<span class="asterisk-sign">*</span></label>
                                            <input type="number" class="form-control" id="phone" name="phone" placeholder="<?php echo $this->lang->line('lang_field_title_phoneno'); ?>" autocomplete="off" REQUIRED value="<?php echo $student_data['phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status"><?php echo $this->lang->line('lang_field_title_status'); ?> :<span class="asterisk-sign">*</span></label>
                                            <select name="status" id="status" class="form-control" REQUIRED>
                                                <option value=""><?php echo $this->lang->line('lang_field_title_status_option'); ?></option>
                                                <option value="1" <?php if($student_data['status']==1){ echo "selected"; } ?>><?php echo $this->lang->line('lang_field_title_status_active'); ?></option>
                                                <option value="0" <?php if($student_data['status']==0){ echo "selected"; } ?>><?php echo $this->lang->line('lang_field_title_status_inactive'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="alert alert-info alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <?php echo $this->lang->line('lang_field_title_password_empty_message'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password"><?php echo $this->lang->line('lang_field_title_password'); ?></label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $this->lang->line('lang_field_title_password'); ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cpassword"><?php echo $this->lang->line('lang_field_title_confim_password'); ?></label>
                                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="<?php echo $this->lang->line('lang_field_title_confim_password'); ?>" autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('lang_button_save'); ?></button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
    $("#studentMainNav").addClass('menu-open');
    $("#createStudentSubNav a").addClass('active');
    $("#studentMainNav #studentMainNava").addClass('active');
});
</script>