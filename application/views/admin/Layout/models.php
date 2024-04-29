<div class="modal fade" id="viewShowModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body card card-info card-outline">
                <div id="viewModalBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Review Desc Modal -->
<div class="modal fade" id="reviewDesc" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body card card-info card-outline">
                <div id="reviewDescbody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderInfoModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Date Ordered</th>
                                                    <th>Status</th>
                                                </tr>
                                                <tr>
                                                    <td>INV-2024-123</td>
                                                    <td>John Doe (john@example.com)</td>
                                                    <td>2024-04-08 15:30:00</td>
                                                    <td><span class="badge badge-success">Complete</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>SKU</th>
                                                <th>Quantity</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="main-div d-flex">
                                                        <div class="image-div"> 
                                                            <img src="<?php echo base_url('images/1.jpg') ?>" alt="..." width="50px">
                                                        </div>
                                                        <div class="info-div pl-3">
                                                            Hoodie Sweatshirt
                                                            </br><small><b>COLOR :</b> <i class="fas fa-square" style="color: green"></i></small></br><small><b>Size :</b> 26</small>
                                                        </div>
                                                    </div>
                                                </td>   
                                                <td>FS139</td>
                                                <td>1</td>
                                                <td class="text-right">550.00</td>
                                                <td class="text-right">550.00</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="main-div d-flex">
                                                        <div class="image-div"> 
                                                            <img src="<?php echo base_url('images/2.jpg') ?>" alt="..." width="50px">
                                                        </div>
                                                        <div class="info-div pl-3">
                                                            Slim Fit Cargo Pants
                                                            </br><small><b>COLOR :</b> <i class="fas fa-square" style="color: red"></i></small></br><small><b>Size :</b> 30</small>
                                                        </div>
                                                    </div>
                                                </td>   
                                                <td>FS137</td>
                                                <td>4</td>
                                                <td class="text-right">800.00</td>
                                                <td class="text-right">3,200.00</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="main-div d-flex">
                                                        <div class="image-div"> 
                                                            <img src="<?php echo base_url('images/3.jpg') ?>" alt="..." width="50px">
                                                        </div>
                                                        <div class="info-div pl-3">
                                                            Chinos For Man
                                                            </br><small><b>COLOR :</b> <i class="fas fa-square" style="color: #27C682"></i></small></br><small><b>Size :</b> 32</small>
                                                        </div>
                                                    </div>
                                                </td>   
                                                <td>FS134</td>
                                                <td>4</td>
                                                <td class="text-right">800.00</td>
                                                <td class="text-right">3,200.00</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right" colspan="4">Sub-Total</th>
                                                <td class="text-right" id="grand_total">6,950.00</td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="4">Total</th>
                                                <td class="text-right" id="grand_total">6,950.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Address</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Nx Developer
                                                    <br><b>Nxsol Team</b>
                                                    <br>nxsol
                                                    <br>Rajkot,
                                                    <br>365241 - Rajkot, Gujarat, India,
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Comment</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Delivery Method</th>
                                    </tr>
                                    <tr>
                                        <td>FEDEX</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
