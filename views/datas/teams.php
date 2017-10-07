<table class="table">
    <?php if($sum_mish_mark) : ?>
    
        <p>Мишич, у тебя <?=$sum_mish_mark+1000 ?> р</p>
   
    <?php endif; ?>
    <tr>
        <td>Студент</td>
        <td>Количество попыток</td>
        <td>Сумма баллов </td>
    </tr>
        <?php foreach ($marks as $mark) : ?>
            <tr>
                <td><?=$mark->user->name?></td>
                <td><?=$mark->cnt?></td>
                <td><?=$mark->avg?></td>
            </tr>
        <?php endforeach; ?>

</table>
<hr>
<table class="table">
    <tr>
        <td style="text-align: left; width: 20px;">М</td>
        <td style="text-align: left;">Команда</td>
        <td>Матчи</td>
        <td>Очки</td>
    </tr>
    <?php $i=0; foreach ($teams as $mark) : $i++; ?>
        <tr>
            <td style="text-align: left; width: 20px;"><?=$i?>.</td>
            <td style="text-align: left;"><?=$mark->user->name?></td>
            <td><?=$mark->cnt?></td>
            <td><?=$mark->avg?></td>
        </tr>
    <?php endforeach; ?>

</table>