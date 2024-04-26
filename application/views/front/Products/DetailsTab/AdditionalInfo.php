<div class="additionals">
    <div class="row justify-content-center">
        <div class="col-6">
            <table class="table">
                <tbody>
                    <tr>
                        <th class="ft-medium text-dark">ID</th>
                        <td>#<?= $product['id'] ?? "-" ?></td>
                    </tr>
                    <tr>
                        <th class="ft-medium text-dark">SKU</th>
                        <td><?= $product['sku'] ?? "-" ?></td>
                    </tr>
                    
                    <?php if(isset($product['options']) && !empty($product['options'])): ?>
                        <?php foreach($product['options'] as $option): ?>
                            <tr>
                                <th class="ft-medium text-dark">
                                    <?php echo isset($option['option_name']) ? $option['option_name'] : ''; ?>
                                </th>
                                <?php if(isset($option['option_values']) && count($option['option_values'])): ?>
                                    <?php $options = []; ?>
                                    <?php foreach($option['option_values'] as $value): ?>
                                        <?php if(isset($option['option_type']) && $option['option_type'] == 'color'): ?>
                                            <?php $options[] = (isset($value['option_value']) ? '<i class="fas fa-square" style="color: '.$value['option_value'].'"></i>' : ''); ?>
                                        <?php else: ?>
                                            <?php $options[] = isset($value['option_value']) ? $value['option_value'] : '' ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <td>
                                        <?php echo implode(' | ', $options); ?>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>