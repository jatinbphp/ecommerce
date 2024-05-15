<div class='row'>   
    <?php if(isset($allPlans) && count($allPlans)): ?>
        <?php foreach($allPlans as $plan): ?>
            <?php $planId = $plan['id'] ?? 0; ?>
            <?php $planName = $plan['name'] ?? ''; ?>
            <div class='col-md-4 d-flex align-center'>
                <div class="checkbox-wrapper-10">
                    <input class="tgl tgl-flip" data-email='<?php echo $userEmail; ?>' onChange='updatePlan(this)' id="<?php echo $planId; ?>" type="checkbox" <?php echo in_array($planId, $addedPlans) ? 'checked' : '' ?> />
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes!" for="<?php echo $planId; ?>"></label>
                </div>
                <h4 class='widget_title text-dark ft-medium ml-2 text-capitalize'><?php echo $planName; ?></h4>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        <div class='col-md-12'>
            <p>No Subscription Found.</p>
        </div>
    <?php endif; ?>
</div>