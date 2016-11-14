
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

<?php /*

use yii\grid\GridView;

?>

<div class="col-sm-10 col-md-12 main">
    <h1 class="page-header">Логи</h1>
    <?php  //var_dump($articles); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $logs,
        'filterModel' => $searchModel,
        'columns' => [
            'ip',
            'body',
            'time',
        ],
    ]); ?>
