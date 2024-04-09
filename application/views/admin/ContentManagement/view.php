<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 25%;">Id</th>
                            <td><?php echo isset($content['id']) ? $content['id'] : '' ?></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td><?php echo isset($content['title']) ? html_entity_decode($content['title']) : '' ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo isset($content['description']) ? html_entity_decode($content['description']) : '' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>