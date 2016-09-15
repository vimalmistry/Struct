

<h2>All Tasks <a href="<?= url('task/new') ?>" class="btn  btn-success">New Task</a> </h2> 
    <!--<a href="<?= url('task/history') ?>" class="btn  btn-success">Show History</a></h2>-->
    <!--<p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>-->            
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
            <th>Remind Hour</th>
            <th>Send Messages</th>
            <th>Created</th>   
            <!--<th>Updated</th>-->

            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><a href="<?= url('task/view?id=' . $task['id']) ?>"><?= ucfirst($task['title']) ?></a></td>
        <!--<td><?= ucfirst($task['title']) ?></td>-->
                <td><?= User::name($task['from_user']) ?></td>
                <td><?= User::name($task['to_user']) ?></td>
                <td><?= ($task['status'] == 'enabled') ? '<label class="label label-success">Enabled</label>' : '<label class="label label-danger">Disabled</label>' ?></td>
                <td><?= $task['hours'] . ' Hours' ?></td>
                <td><?=(Task::countMessage($task['id'])) ?></td>
                <td><?= time2str($task['created_at']) ?></td>
                <!--<td><?= $task['updated_at'] ?></td>-->
                <td>


                    <?php if ($task['status'] == 'enabled'): ?>
                        <a class="btn btn-danger btn-sm" href="<?= url('task/action?action=desable&id=' . $task['id']) ?>">Disable</a>
                    <?php else: ?> 
                        <a class="btn btn-success btn-sm" href="<?= url('task/action?action=enable&id=' . $task['id']) ?>">Enable</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>