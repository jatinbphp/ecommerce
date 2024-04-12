<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($banner['id']) ? $banner['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php $image = (isset($banner['image']) && file_exists($banner['image'])) ? $banner['image'] : 'public/assets/admin/dist/img/no-image.png'  ?>
                                        <img src="<?php echo base_url($image) ?>" style="width:100%"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td><?php echo isset($banner['title']) ? $banner['title'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Subtitle</th>
                            <td><?php echo isset($banner['subtitle']) ? $banner['subtitle'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo isset($banner['description']) ? $banner['description'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php 
                                    $status = isset($banner['status']) ? $banner['status'] : '';
                                    $class = $status == 'active' ? 'success' : 'danger';
                                ?>
                                <span class="badge badge-<?php echo $class ?>"><?php echo ucfirst($status) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td><?php echo isset($banner['created_at']) ? $banner['created_at'] : ''?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>