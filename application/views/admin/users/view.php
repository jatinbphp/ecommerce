<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($user['id']) ? $user['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php $image = (isset($user['image']) && file_exists($user['image'])) ? $user['image'] : 'public/assets/admin/dist/img/no-image.png'  ?>
                                        <img src="<?php echo base_url($image) ?>" style="width:100%"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo isset($user['first_name']) ? $user['first_name'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo isset($user['email']) ? $user['email'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?php echo isset($user['phone']) ? $user['phone'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php 
                                    $status = isset($user['status']) ? $user['status'] : '';
                                    $class = $status == 'active' ? 'success' : 'danger';
                                ?>
                                <span class="badge badge-<?php echo $class ?>"><?php echo ucfirst($status) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td><?php echo isset($user['created_at']) ? $user['created_at'] : ''?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>