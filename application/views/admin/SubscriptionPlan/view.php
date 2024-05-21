<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($subscriptionData['id']) ? $subscriptionData['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo isset($subscriptionData['name']) ? $subscriptionData['name'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Subscribe Email Address</th>
                            <td><?php echo (isset($subscriptionUsersEmail) && $subscriptionUsersEmail) ? implode(' | ', $subscriptionUsersEmail) : '-' ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php 
                                    $status = isset($subscriptionData['status']) ? $subscriptionData['status'] : '';
                                    $class = $status == 'active' ? 'success' : 'danger';
                                ?>
                                <span class="badge badge-<?php echo $class ?>"><?php echo ucfirst($status) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td><?php echo isset($subscriptionData['created_at']) ? $subscriptionData['created_at'] : ''?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>