<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($contactus['id']) ? "#".$contactus['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo isset($contactus['name']) ? $contactus['name'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo isset($contactus['email']) ? $contactus['email'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Subject</th>
                            <td><?php echo isset($contactus['subject']) ? $contactus['subject'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td><?php echo isset($contactus['message']) ? $contactus['message'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td><?php echo isset($contactus['created_at']) ? $contactus['created_at'] : ''?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>