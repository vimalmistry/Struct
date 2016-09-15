
<div class="row">
    <div class="col-md-6">


        <h2><?= $title ?></h2>
          <!--<p>The .table-bordered class adds borders to a table:</p>-->            
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Total Notification Send</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $user): ?>
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['sendMessage'] ?></td>
                    </tr>
                <?php endforeach; ?>


            </tbody>
        </table>
    </div>
</div>