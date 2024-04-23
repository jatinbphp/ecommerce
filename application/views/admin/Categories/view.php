<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($categoryData['id']) ? $categoryData['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php $image = (isset($categoryData['image']) && file_exists($categoryData['image'])) ? $categoryData['image'] : 'public/assets/admin/dist/img/no-image.png'  ?>
                                        <img src="<?php echo base_url($image) ?>" style="width:100%"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo isset($categoryData['name']) ? $categoryData['name'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Path</th>
                            <td><?php echo isset($categoryData['path']) ? $categoryData['path'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php 
                                    $status = isset($categoryData['status']) ? $categoryData['status'] : '';
                                    $class = $status == 'active' ? 'success' : 'danger';
                                ?>
                                <span class="badge badge-<?php echo $class ?>"><?php echo ucfirst($status) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td><?php echo isset($categoryData['created_at']) ? $categoryData['created_at'] : ''?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>