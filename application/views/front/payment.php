<script src="https://js.stripe.com/v3/"></script>
<div class="container">
        <h1>Payment Form</h1>
        <form id="payment-form" class="form-horizontal">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" placeholder="Name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="amount" class="col-sm-2 control-label">Amount</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="amount" placeholder="Amount" required>
                </div>
            </div>
            <div class="form-group p-1">
                <label class="col-sm-2 control-label">Card Details</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                            <div class="col-12">
                                <label for="card-number">Card Number</label>
                                <div id="card-number-element">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="card-expiry">Expiration Date</label>
                                        <div id="card-expiry-element">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="card-cvc">CVC</label>
                                        <div id="card-cvc-element">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="postal-code">Postal Code</label>
                                        <div id="postal-code-element">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" id="submit-button" class="btn btn-primary">Pay</button>
                </div>
            </div>
        </form>
    </div>

    <script src="<?php echo base_url('public/assets/front/dist/js/stripe.js'); ?>"></script>