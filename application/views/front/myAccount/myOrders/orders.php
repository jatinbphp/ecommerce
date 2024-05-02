<div id="main-wrapper">
    <?php $this->load->view('Breadcrumb',['current' => $title, 'middle' => ['my_account' => 'profile-info']]); ?>
    <section class="middle">    
        <div class="container">
            <div class="row align-items-start justify-content-between">
                <?php $this->load->view('front/myAccount/common-file'); ?>
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center ord_list_wraps">
                    <div class="ord_list_wrap mb-4 mfliud">
                        <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                            <div class="olh_flex">
                                <p class="m-0 p-0"><span class="text-muted">My Orders</span></p>
                            </div>
                        </div>
                        <div class="ord_list_body text-left">
                            <table id="frontordersTable" class="table table-bordered table-striped datatable-dynamic">
                                <tbody class="ord_list_body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#myorderlist").addClass('active');
    });
</script>
