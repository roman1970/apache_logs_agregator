<table class="table">
    <tbody>
    <tr >
        <td>ip</td>
        <td>время</td>
        <td>лог</td>
    </tr>
<?php  foreach ($logs as $log) : ?>
    <tr >
        <td><?= $log->ip ?></td>
        <td><?= date('Y-m-d H:i:s', $log->time) ?></td>
        <td><?= $log->body ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>