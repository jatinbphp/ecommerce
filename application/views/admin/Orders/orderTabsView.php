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
                                    <?php $this->load->view('admin/Orders/orderData', $data); ?>
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