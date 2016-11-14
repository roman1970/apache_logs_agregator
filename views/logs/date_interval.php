<script>

    $(document).ready(function() {

        var from = $("#from");
        var to = $("#to");

        $("#show_in_interval").click(
            function () {
                
                sendMess(from.val(), to.val());
                
            });
    });

    function sendMess(from, to) {

        $.ajax({
            type: "GET",
            url: "show-date/",
            data: "from="+from+"&to="+to,
            success: function(html){
                $("#resp").html(html);
            }

        });

    }

</script>
<div class="form-group" id="resp">
    <form class="form-inline" role="form" id="team">
        <h3>Для просмотра логов введите интервал дат</h3>

            <input id="from" size="20" value="<?= date('Y-m-d', time()) ?>"  />
            <input id="to" size="0" value="<?= date('Y-m-d', time()) ?>" />
            <p>
<?php /*
                <?= \yii\jui\DatePicker::widget([
                    'name'  => 'from_date',
                    'value'  => date('Y-m-d', time()),
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['title' => 'От'],
                    //'inline' => true,
                    'containerOptions' => ['width' => '100']
                ]);
                ?>

                <?= \yii\jui\DatePicker::widget([
                    'name'  => 'to_date',
                    'value'  => date('Y-m-d', time()),
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['title' => 'До'],
                    //'inline' => true,
                    'containerOptions' => ['width' => '100']
                ]);
                ?>
 */ ?>
                <button type="button" class="btn btn-success" id="show_in_interval" >Показать</button>
            </p>


    </form>

</div>