
<div class="site-index">

    <script>

        $(document).ready(function() {

            $("#show_menu").hide();

            $("#show_menu").click(
                function() {
                    $("#menu").show();
                    $("#show_menu").hide();
                    $("#summary").hide();
                });


        });


        function send(controller_str) {

            $.ajax({
                type: "GET",
                url: ""+controller_str+"/",
                success: function(html){
                    $("#summary").html(html);
                }

            });

            $("#show_menu").show();
            $("#summary").show();
            $("#menu").hide();

        }



    </script>

    <div id="menu">
        <button type="button" class="btn btn-success btn-lg btn-block" onclick="send('show-last')">Просмотреть последние логи</button>
        <button type="button" class="btn btn-success btn-lg btn-block" onclick="send('show-not-local')">Просмотреть внешние запросы</button>
        <button type="button" class="btn btn-success btn-lg btn-block" onclick="send('show-date')">Просмотреть логи по дате</button>
        <button type="button" class="btn btn-success btn-lg btn-block" onclick="send('api-permission')">Доступ к API</button>

    </div>

    <div id="show_menu">
        <button type="button" class="btn btn-success btn-lg btn-block" >Меню</button>
    </div>
    <div id="summary" style="text-align: left; overflow: auto"></div>

</div>
