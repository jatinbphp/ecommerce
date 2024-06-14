<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if(isset($ordersData) && count($ordersData)): ?>
                        <?php //$this->load->view('admin/Orders/orderData'); ?>
                        <?php $orderIds = array_keys($ordersData); ?>
                        <?php $i = 1; ?>
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <?php foreach($orderIds as $orderId): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo ($i == 1) ? "active" : ""; ?>" id="custom-content-below-<?php echo $orderId; ?>-tab" data-toggle="pill" href="#custom-content-below-<?php echo $orderId; ?>" role="tab" aria-controls="custom-content-below-<?php echo $orderId; ?>" aria-selected="true">#<?php echo $orderId ?></a>
                                    </li>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </ui>
                        </div>
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <?php $i = 1; ?>
                            <?php foreach($ordersData as $orderId => $data): ?>
                                <div class="tab-pane fade mt-3 <?php echo ($i == 1) ? "active show" : ""; ?>" id="custom-content-below-<?php echo $orderId; ?>" role="tabpanel" aria-labelledby="custom-content-below-<?php echo $orderId; ?>-tab">
                                    <?php //$this->load->view('admin/Orders/orderData', $data); ?>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        No Orders Found.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#custom-tabs-three-tab a').on('show.bs.tab', function (e) {
            var tabId = $(e.target).attr('href'); // newly activated tab
            var orderId = tabId.split('-').pop(); // extract order ID from tab ID

            if (!$(tabId).data('loaded')) { // check if tab content is already loaded
                $.ajax({
                    url: baseUrl + 'admin/dashboard/order/show/'+orderId,
                    method: 'GET',
                    success: function(response) {
                        $(tabId).html(response); // update tab content with AJAX response
                        $(tabId).data('loaded', true); // mark tab as loaded to prevent future AJAX calls
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading tab content:', error);
                    }
                });
            }
        });
        // Trigger click on the first tab to load its content by default
        $('#custom-tabs-three-tab a.active').trigger('show.bs.tab'); 
    });
</script>