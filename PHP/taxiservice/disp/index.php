<!DOCTYPE HTML>
<html>
    <head>
        <title>Такси-сервис</title>
        <link rel="stylesheet" href="../styles/style.css">
        <link rel="stylesheet" href="../scripts/jquery-ui-1.12.1.custom/jquery-ui.css">
        <script type="text/javascript" src="../scripts/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="../scripts/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script type="text/javascript" src="../scripts/grid.js"></script>
    </head>
    <body>
        <table id="tmain">
            <tr>
                <td>№</td>
                <td>ФИО</td>
                <td>Email</td>
                <td>Откуда</td>
                <td>Куда</td>
                <td>Класс автомобиля</td>
                <td>Статус заказа</td>
                <td></td>
            </tr>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                var num_row = 0;
                var id = 0;
                setInterval(function () {
                $.post("getdata.php", {'num_row': id}, function (data) {
                    if (data.trim() != "not") {
                        document.data_json = JSON.parse(data);

                        for (i = 0; document.data_json.length; i++, id++) {
                            tr = $('<tr>');

                            td = $('<td>', {
                                text: id + 1
                            }).appendTo(tr);

                            $('<td>', {
                                text: document.data_json[i].fio
                            }).appendTo(tr);


                            $('<td>', {
                                text: document.data_json[i].email
                            }).appendTo(tr);

                            $('<td>', {
                                text: document.data_json[i].departure
                            }).appendTo(tr);

                            $('<td>', {
                                text: document.data_json[i].destination
                            }).appendTo(tr);

                            switch (document.data_json[i].car) {
                                case 'economy':
                                    document.temp = 'Эконом';
                                    break;
                                case 'comfort':
                                    document.temp = 'Комфорт';
                                    break;
                                case 'business':
                                    document.temp = 'Бизнес';
                                    break;
                            }
                            $('<td>', {
                                text: document.temp
                            }).appendTo(tr);

                            switch (document.data_json[i].status) {
                                case '0':
                                    document.temp = 'Ожидает подтверждения';
                                    break;
                                case '1':
                                    document.temp = 'Подтверждено';
                                    break;
                            }
                            $('<td>', {
                                id: "status{i}".replace('{i}', i),
                                text: document.temp,
                            }).appendTo(tr);

                            td = $('<td>').appendTo(tr);
                            button = $('<button>', {
                                id: document.data_json[i].id,
                                text: 'Подтвердить',
                                click: function () {
                                    $.post('confirm.php', {'id': this.id}, function (data) {
                                        if (data.trim() == '1') {
                                            //$("#status" + s).attr('text', 'ok');
                                            window.location.reload();
                                        } else
                                            //document.status.text = 'Не подтвержден';
                                            window.location.reload();
                                    })
                                }
                            });
                            button.appendTo(td);

                            tr.appendTo('#tmain');
                        }
                    }
                });
                }, 1000);
            });
        </script>
    </body>
</html>