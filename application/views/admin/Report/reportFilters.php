<form id="report-filter-Form">
    <div class="row">
        <?php if (!empty($userFirstNames)): ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Status">User:</label>
                    <select name="user_id" class="form-control" id="user_id">
                        <option value="">Please Select</option>
                        <?php foreach ($userFirstNames as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['first_name']; ?></option>
                        <?php endforeach; ?>
                    </select>           
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="Status">Status:</label>
                <select name="status" class="form-control" id="status">
                    <option value="">Please Select</option>
                    <?php foreach (\Order_model::$allStatus as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo ucfirst($value); ?></option>
                    <?php endforeach; ?>
                </select>       
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="date">Date range:</label>
                <input type="text" name="daterange" class="form-control" placeholder="Please select" id="daterange">
            </div>
        </div>
        <div class="col-md-2" style="margin-top: 30px;">
            <button type="button" id="clear-filter" class="btn btn-danger" data-type="<?php echo $type?>">
                <i class="fa fa-times" aria-hidden="true" ></i>
            </button>
            <button type="button" id="apply-filter" class="btn btn-info" data-type="<?php echo $type?>">
                <i class="fa fa-filter" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</form>
