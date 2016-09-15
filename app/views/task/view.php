<div class="row">
    <div class="col-md-6">



        <h1><?= ucfirst($task['title']) ?></h1>
        <p><b>Description</b><br/><?= $task['description'] ?></p>

        <p><b>From :</b> <?= User::name($task['from_user']) ?></p>
        <p><b>To :</b> <?= User::name($task['to_user']) ?></p>
        <p><b>Status :</b> 
            <?php if ($task['status'] == 'enabled'): ?>
                <a class="btn btn-danger btn-sm">Disabled</a>
            <?php else: ?> 
                <a class="btn btn-success btn-sm">Enabled</a>
            <?php endif; ?>
        </p>
        <a href="<?= url('task') ?>" class="btn btn-success"> Show All</a>

    </div>
    <div class="col-md-6">
        <h2>Message History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Sending Time</th>

                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($history as $m): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= time2str($m['message_send_time']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>