<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($product['id']) ? $product['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th style="width: 25%;">Category</th>
                            <td><?php echo isset($product['category_id']) ? $product['category_id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th style="width: 25%;">Product Name</th>
                            <td><?php echo isset($product['product_name']) ? $product['product_name'] : '' ?></td>
                        </tr>
                        <tr>
                            <th style="width: 25%;">Sku</th>
                            <td><?php echo isset($product['sku']) ? $product['sku'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo isset($product['description']) ? $product['description'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><?php echo isset($product['price']) ? $product['price'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                <div class="row">
                                    <?php if(isset($product_image) && count($product_image)): ?>
                                        <?php foreach ($product_image as $data): ?>
                                            <div class="col-md-2">
                                                <?php $image = (isset($data['image']) && file_exists($data['image'])) ? $data['image'] : 'public/assets/admin/dist/img/no-image.png'  ?>
                                                <img src="<?php echo base_url($image) ?>" style="width:100%"/>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Options</th>
                            <td>
                                <?php if(isset($product_options)): ?>
                                    <?php foreach($product_options as $option): ?>
                                        <strong><?php echo isset($option['option_name']) ? $option['option_name'] : ''; ?> :</strong>
                                        <?php if(isset($option['option_values']) && count($option['option_values'])): ?>
                                            <?php $options = []; ?>
                                            <?php foreach($option['option_values'] as $value): ?>
                                                <?php $options[] = isset($value['option_value']) ? $value['option_value'] : '' ?>
                                            <?php endforeach ?>
                                            <?php echo implode(', ', $options); ?>
                                            <br>
                                        <?php endif ?>    
                                    <?php endforeach ?>
                                <?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php 
                                    $status = isset($product['status']) ? $product['status'] : '';
                                    $class = $status == 'active' ? 'success' : 'danger';
                                ?>
                                <span class="badge badge-<?php echo $class ?>"><?php echo ucfirst($status) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td><?php echo isset($product['created_at']) ? $product['created_at'] : ''?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>