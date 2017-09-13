<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <link rel="stylesheet" type="text/css" href="../style.css">
        <title>Автосервис/Просмотр</title>
    </head>
    <body>
        <?php
        //подключение библиотек функций
        require_once("../dbcnt.php"); //функции для соединения с сервером
        require_once("show.php"); //функции отображения
        $p = ReadCnf("../cnf.ini"); //чтение параметров
        $firstpage = $p['server']['first']; //начальная страница
        $cnt = Connect($p); //соединение
        SelectDB($p, $cnt); //выбор БД
        echo("<a href=" . $firstpage . "><img src=\"../back.ico\"
width=32" .
        " height=32 alt=\"Вернуться на главную\"
title=\"Назад\"></a><br><br>");
        //если не выбрана таблица, то вывод всех таблиц
        if (empty($_GET)) {
            shop_show($cnt, false);
            order_show($cnt, false);
            master_show($cnt, false);
            works_show($cnt, false);
            client_show($cnt, false);
            auto_show($cnt, false);
            material_show($cnt, false);
        } else {
            //иначе выбор таблицы для просмотра
            $param = filter_input(INPUT_GET, 'id');
            switch ($param) {
                case 'order_detail': //детальный просмотр заказа
                    $id_order = filter_input(INPUT_GET, 'id_order');
                    order_detail($cnt, $id_order);
                    break;
                case 'order': order_show($cnt, false); //заказы
                    break;
                case 'shop': shop_show($cnt, false); //цехи
                    break;
                case 'master': master_show($cnt, false); //мастера
                    break;
                case 'client': client_show($cnt, false); //клиенты
                    break;
                case 'auto': auto_show($cnt, false); //автомобили
                    break;
                case 'material': material_show($cnt, false); //материалы
                    break;
                case 'works': works_show($cnt, false); //работы
                    break;
            }
        }
        Disconnect($cnt); //отключение соединения
        ?>
    </body>
</html>