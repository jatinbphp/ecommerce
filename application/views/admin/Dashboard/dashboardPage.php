<div class="content-wrapper">
	<section class="content">
		<div class="container-fluid">
			<div class="row mt-3">
	            <div class="col-md-12">
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
	            </div>
	        </div>
			<div class="row">
				<div class="col-12 col-sm-6 col-md-3 mt-2">
					<div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
						<div class="info-box-content">
							<span class="info-box-text">Total Users</span>
							<span class="info-box-number">123</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#dashboard").addClass('active');
});
</script>