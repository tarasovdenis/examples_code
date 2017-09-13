<?php

/* ------------------Вывод заказа подробно---------------------
  -------------- */

function order_detail($dbcnt, $id_order) {
//проверка соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существованя записи
    $query = "SELECT * FROM Orders WHERE id_Orders=" . $id_order;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Получение информации о
заказе</font>");
        return 1;
    }
    $order = mysql_fetch_assoc($result);
//получение информации о цехе
    $id_shop = $order['id_Shop'];
    $query = "SELECT * FROM Shop WHERE id_Shop=" . $id_shop;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        $shop = "<font color=#049E00>Не найдено</font>";
    } else {
        $r = mysql_fetch_assoc($result);
        $shop = "<b>Описание: </b>" . $r['description'] . "<br>" .
                "<b>Адрес: </b>" . $r['address'] . "<br>";
    }
//получение информации о клиенте
    $id_client = $order['id_Client'];
    $query = "SELECT * FROM Client WHERE id_Client=" . $id_client;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        $client = "<font color=#049E00>Не найдено</font>";
    } else {
        $r = mysql_fetch_assoc($result);
        $client = "<b>ФИО: </b>" . $r['fio'] . "<br>" .
                "<b>Водительское удостоверения: </b>" .
                $r['document'] . "<br>" .
                "<b>Телефон 1: </b>" . $r['phone1'] . "<br>";
        if ($r['phone2'] == '0') {
            $client = $client . "<b>Телефон 2:</b> не указан<br>";
        } else {
            $client = $client . "<b>Телефон 2: </b>" . $r['phone2'] .
                    "<br>";
        }
    }
//получение информации о автомобиле
    $id_auto = $order['id_Auto'];
    $query = "SELECT * FROM Auto WHERE id_Auto=" . $id_auto;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        $auto = "<font color=#049E00>Не найдено</font>";
    } else {
        $r = mysql_fetch_assoc($result);
        $auto = "<b>VIN: </b>" . $r['VIN'] . "<br>" .
                "<b>Модель: </b>" . $r['model'] . "<br>" .
                "<b>Гос.номер: </b>" . $r['st_num'] . "<br>";
        //получение информации о владельце автомобиля
        //если владелец и клиент одно лицо
        if ($id_client == $r['id_Client']) {
            $auto = $auto . "<b>Владелец автомобиля: </b>Клиент<br>";
        } else {
            //если указан другой клиент в качестве владельца
            $query = "SELECT fio, document FROM Client WHERE id_Client=" .
                    $r['id_Client'];
            $res = mysql_query($query, $dbcnt);
            //если владелец не найден
            if (!mysql_num_rows($res)) {
                $auto = $auto . "<b>Владелец автомобиля: </b>" .
                        "<font color=#049E00>Не найден</font><br>";
            } else {
                //владелец найден
                $auto = $auto . "<b>Владелец автомобиля: </b>" .
                        mysql_result($res, 0, 'fio') . " (" .
                        mysql_result($res, 0, 'document') . ")<br>";
            }
        }
    }
//разбор строки дата оформления
    $dat = $order['dat'];
    $format = "Y-n-d G:i:s";
    $temp = date_parse_from_format($format, $dat);
    if (strlen($temp['day']) == 1)
        $temp['day'] = "0" . $temp['day'];
    if (strlen($temp['month']) == 1)
        $temp['month'] = "0" . $temp['month'];
    if (strlen($temp['hour']) == 1)
        $temp['hour'] = "0" . $temp['hour'];
    if (strlen($temp['minute']) == 1)
        $temp['minute'] = "0" . $temp['minute'];
    if (strlen($temp['second']) == 1)
        $temp['second'] = "0" . $temp['second'];
    $dat = "<b>Дата оформления: </b>" .
            $temp['day'] . "." . $temp['month'] . "." .
            $temp['year'] . " " .
            $temp['hour'] . ":" . $temp['minute'] . ":" .
            $temp['second'] . "<br>";
//состояние заказа
    $status = (int) $order['status'];
    if (!$status) {
        $status = "<b>Состояние: </b>Не выполнено<br>";
    } else {
        $status = "<b>Состояние: </b>Выполнено<br>";
    }
//получение перечня работ для заказа
    $works = "<b>Список работ: </b><br>";
    $query = "SELECT workname FROM Works, WorksOrders WHERE " .
            "WorksOrders.id_Orders=" . $id_order . " AND " .
            "WorksOrders.id_Works=Works.id_Works";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        $works = $works . "<font color=#049E00>Не найден</font><br>";
    } else {
        while ($str = mysql_fetch_row($result)) {
            $works = $works . $str[0] . "<br>";
        }
    }
    echo $shop;
    echo $client;
    echo $auto;
    echo $status;
    echo $dat;
    echo $works;
    return 0;
}

/* ------------------Вывод записей таблицы Orders(Заказы)------
  -------------- */

function order_show($dbcnt, $param = true) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<table class=\"show\">");
        echo("<caption>ЗАКАЗЫ</caption>");
        echo("<tr><td>");
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        echo("</td></tr></table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>ЗАКАЗЫ</caption>");
//получение списка имен столбцов
    $query = "SHOW COLUMNS FROM Orders";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
//вывод имен столбцов
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    } else {
        //иначе вывод имен столбцов в понятной форме
        $columns = array("№ заказа", "Цех", "ФИО клиента", "Автомо-
биль",
            "Дата оформления", "Состояние");
        $num_columns = sizeof($columns); //количество столбцов
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//получение информации из Orders
    $query = "SELECT * FROM Orders";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    while ($str = mysql_fetch_assoc($result)) {
//получение адреса цеха
        $id_shop = $str['id_Shop'];
        $query = "SELECT address FROM Shop WHERE id_Shop=" . $id_shop;
        $res = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($res)) {
            $shop = "<font color=#049E00>Не найден</font>";
        } else {
            $shop = mysql_result($res, 0);
        }
        //получение ФИО и данных о документе клиента
        $id_client = $str['id_Client'];
        $query = "SELECT fio, document FROM Client WHERE id_Client="
                . $id_client;
        $res = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($res)) {
            $client = "<font color=#049E00>Не найден</font>";
        } else {
            $r = mysql_fetch_assoc($res);
            $client = $r['fio'] . " (" . $r['document'] . ")";
        }
        //получение информации о автомобиле
        $id_auto = $str['id_Auto'];
        $query = "SELECT * FROM Auto WHERE id_Auto=" . $id_auto;
        $res = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($res)) {
            $auto = "<font color=#049E00>Не найден</font>";
        } else {
            $r = mysql_fetch_assoc($res);
            $auto = "<b>Модель:</b>" . $r['model'] . "<br>" .
                    "<b>VIN:</b>" . $r['VIN'] . "<br>" .
                    "<b>Гос.номер:</b>" . $r['st_num'];
        }
        //разбор строки дата оформления
        $dat = $str['dat'];
        $format = "Y-n-d G:i:s";
        $temp = date_parse_from_format($format, $dat);
        if (strlen($temp['day']) == 1)
            $temp['day'] = "0" . $temp['day'];
        if (strlen($temp['month']) == 1)
            $temp['month'] = "0" . $temp['month'];
        if (strlen($temp['hour']) == 1)
            $temp['hour'] = "0" . $temp['hour'];
        if (strlen($temp['minute']) == 1)
            $temp['minute'] = "0" . $temp['minute'];
        if (strlen($temp['second']) == 1)
            $temp['second'] = "0" . $temp['second'];
        $dat = $temp['day'] . "." . $temp['month'] . "." .
                $temp['year'] . " " .
                $temp['hour'] . ":" . $temp['minute'] . ":" .
                $temp['second'];
        //получение состояния заказа
        $status = (int) $str['status'];
        !$status ? $status = "Не выполнено" : $status = "Выполнено";
//вывод
        $out = array($str['id_Orders'], $shop, $client, $auto, $dat,
            $status);
        $num_out = sizeof($out);
        echo("<tr>");
        for ($i = 0; $i < $num_out; $i++) {
            echo("<td align=left>" . $out[$i] . "</td>");
        }
        //вывод функционала
        $id_order = $str['id_Orders'];
        echo("<td>");
        echo("<a href=../show/?id=order_detail&id_order=" . $out[0] .
        "><img src=\"../show.ico\" width=16 height=16
title=\"Посмотреть\" alt=\"Посмотреть\"></a>");
        echo("<a href=\"../add/?page=orders&event=edit&id=" .
        $id_order . "\"><img src=\"../update.ico\" width=16 height=16
title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=order&id_order=" . $id_order .
        "\"><img src=\"../delete.ico\" width=16 height=16
title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table><br><br>");
    return 0;
}

/* --------------------Вывод записей таблицы Shop(Цех)---------
  -------------- */

function shop_show($dbcnt, $param = true) {
//проверка соединения
    if (!$dbcnt) {
        echo("<table class=\"show\"><caption>ЦЕХИ</caption>");
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Соединение с сервером отсутст-
вует</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>ЦЕХИ</caption>");
//запрос на пролучение списка имен столбцов
    $query = "SHOW COLUMNS FROM Shop";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
        //вывод
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td>works</td>");
        echo("<td></td>");
        echo("</tr>");
    } else {
        //альтернативные имена
        $columns = array("№", "Описание", "Адрес", "Выполняемые рабо-
ты");
        $num_columns = sizeof($columns);
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//вывод хранимой информации
//запрос на получение
    $query = "SELECT * FROM Shop";
    $result = mysql_query($query, $dbcnt);
    $num_str = mysql_num_rows($result);
//если таблица не содержит никаких записей
    if (!$num_str) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод записей
    $n = 0; //номер записи
    while ($str = mysql_fetch_row($result)) {
        echo("<tr>");
        //вывод информации из таблицы shop
        //вывод номера записи в зависимости от param
        if ($param) {
            echo("<td>" . $str[0] . "</td>");
        } else {
            echo("<td>" . ++$n . "</td>");
        }
        //вывод остальной информации
        for ($i = 1; $i < sizeof($str); $i++) {
            echo("<td>" . $str[$i] . "</td>");
        }
        //получение и вывод информации о выполняемых работах
//str[0] - Shop(id_Shop)
        $query = "SELECT DISTINCT workname FROM " .
                "Works, Master, MasterWorks, Shop WHERE " .
                "MasterWorks.id_Works = Works.id_Works AND " .
                "MasterWorks.id_Master = Master.id_Master AND " .
                "Master.id_Shop = " . (int) $str[0];
        $works = mysql_query($query, $dbcnt);
        $num_works = mysql_num_rows($works);
//если список пуст, то "не найдено"
        if (!$num_works) {
            echo("<td><font color=#049E00>Не найдено</font></td>");
        } else {
            //вывод в виде маркированного списка
            echo("<td><ul align=left>");
            for ($i = 0; $i < $num_works; $i++) {
                echo("<li>" . mysql_result($works, $i) . "</li>");
            }
            echo("</ul></td>");
        }
        //вывод функционала
        $id_shop = $str[0];
        echo("<td>");
        echo("<a href=\"../add/?page=shop&event=edit&id=" . $id_shop
        . "\"><img src=\"../update.ico\" width=16 height=16
title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=shop&id_shop=" . $id_shop .
        "\"><img src=\"../delete.ico\" width=16 height=16
title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table><br><br>");
    return 0;
}

/* ----------------------Вывод записей таблицы Client(Клиенты)-
  -------------- */

function client_show($dbcnt, $param = true) {
//проверка соединения
    if (!$dbcnt) {
        echo("<table class=\"show\"><caption>КЛИЕНТЫ</caption>");
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Соединение с сервером отсутст-
вует</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>КЛИЕНТЫ</caption>");
//запрос на пролучение списка имен столбцов
    $query = "SHOW COLUMNS FROM Client";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
        //вывод
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    } else {
        //альтернативные имена
        $columns = array("№", "ФИО", "Водительское удостоверение",
            "Телефон-1", "Телефон-2");
        $num_columns = sizeof($columns);
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//вывод хранимой информации
//запрос на получение
    $query = "SELECT * FROM Client";
    $result = mysql_query($query, $dbcnt);
    $num_str = mysql_num_rows($result);
//если таблица не содержит никаких записей
    if (!$num_str) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод записей
    $n = 0; //номер записи
    while ($str = mysql_fetch_row($result)) {
        echo("<tr>");
        //вывод номера записи в зависимости от param
        if ($param) {
            echo("<td>" . $str[0] . "</td>");
        } else {
            echo("<td>" . ++$n . "</td>");
        }
        //вывод остальной информации
        for ($i = 1; $i < sizeof($str); $i++) {
            echo("<td>");
            //если поле "телефон-2" содержит информацию
//то выводим ее
            if ($i == sizeof($str) - 1) {
                if ($str[$i]) {
                    echo($str[$i]);
                }
            } else {
                //вывод всех остальных полей
                echo($str[$i]);
            }
            echo("</td>");
        }
        //вывод функционала
        $id_client = $str[0];
        echo("<td>");
        echo("<a href=\"../add/?page=client&event=edit&id=" .
        $id_client . "\"><img src=\"../update.ico\" width=16 height=16
title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=client&id_client=" . $id_client
        . "\"><img src=\"../delete.ico\" width=16 height=16
title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table><br><br>");
    return 0;
}

/* ------------------Вывод записей таблицы Auto(Автомобили)----
  -------------- */

function auto_show($dbcnt, $param = true) {
//проверка соединения
    if (!$dbcnt) {
        echo("<table class=\"show\"><caption>АВТОМОБИЛИ</caption>");
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Соединение с сервером отсутст-
вует</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>АВТОМОБИЛИ</caption>");
//запрос на пролучение списка имен столбцов
    $query = "SHOW COLUMNS FROM Auto";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
        //вывод
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    } else {
        //альтернативные имена
        $columns = array("№", "VIN", "Марка/Модель", "Гос.номер",
            "Владелец (ВУ)");
        $num_columns = sizeof($columns);
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//вывод хранимой информации
//запрос на получение
    $query = "SELECT * FROM Auto";
    $result = mysql_query($query, $dbcnt);
    $num_str = mysql_num_rows($result);
//если таблица не содержит никаких записей
    if (!$num_str) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод записей
    $n = 0; //номер записи
    while ($str = mysql_fetch_row($result)) {
//получение данных о владельце
        $id_client = $str[sizeof($str) - 1];
        $query = "SELECT fio, document FROM Client WHERE id_Client=" .
                $id_client;
        $client = mysql_query($query, $dbcnt);
        echo("<tr>");
        //вывод номера записи в зависимости от param
        if ($param) {
            echo("<td>" . $str[0] . "</td>");
        } else {
            echo("<td>" . ++$n . "</td>");
        }
        //вывод остальной информации
        for ($i = 1; $i < sizeof($str); $i++) {
            echo("<td>");
            if ($i == sizeof($str) - 1) {
//если владелец найден выводим ФИО (данные о документе)
//иначе "не найдено"
                if (!mysql_num_rows($client)) {
                    echo("<font color=#049E00>Не найден</font>");
                } else {
                    $fio = mysql_result($client, 0, 'fio');
                    $document = mysql_result($client, 0, 'document');
                    echo($fio . " (" . $document . ")");
                }
            } else {
                //вывод остальных полей
                echo($str[$i]);
            }
            echo("</td>");
        }
        //вывод функционала
        $id_auto = $str[0];
        echo("<td>");
        echo("<a href=\"../add/?page=auto&event=edit&id=" . $id_auto
        . "\"><img src=\"../update.ico\" width=16 height=16
title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=auto&id_auto=" . $id_auto .
        "\"><img src=\"../delete.ico\" width=16 height=16
title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table><br><br>");
    return 0;
}

/* ----------------------Вывод записей таблицы Master----------
  -------------- */

function master_show($dbcnt, $param = true) {
//проверка соединения
    if (!$dbcnt) {
        echo("<table class=\"show\"><caption>МАСТЕРА</caption>");
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Соединение с сервером отсутст-
вует</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>МАСТЕРА</caption>");
//запрос на пролучение списка имен столбцов
    $query = "SHOW COLUMNS FROM Master";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
        //вывод
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td>works</td>");
        echo("<td></td>");
        echo("</tr>");
    } else {
        //альтернативные имена
        $columns = array("№", "ФИО", "Табельный номер", "Цех (ад-
рес)", "Выполняемые работы");
        $num_columns = sizeof($columns);
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//вывод хранимой информации
//запрос на получение
    $query = "SELECT * FROM Master";
    $result = mysql_query($query, $dbcnt);
    $num_str = mysql_num_rows($result);
//если таблица не содержит никаких записей
    if (!$num_str) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод записей
    $n = 0; //номер записи
    while ($str = mysql_fetch_row($result)) {
//получение информации о цехе
        $id_shop = $str[sizeof($str) - 1];
        $query = "SELECT address FROM Shop WHERE id_Shop=" . $id_shop;
        $shop = mysql_query($query, $dbcnt);
//получение информации о выполняемых работах
        $id_master = $str[0];
        $query = "SELECT workname FROM Works, MasterWorks WHERE " .
                "MasterWorks.id_Master=" . $id_master . " AND " .
                "Works.id_Works=MasterWorks.id_Works";
        $works = mysql_query($query, $dbcnt);
        echo("<tr>");
        //вывод номера записи в зависимости от param
        if ($param) {
            echo("<td>" . $str[0] . "</td>");
        } else {
            echo("<td>" . ++$n . "</td>");
        }
        //вывод остальной информации
        for ($i = 1; $i < sizeof($str); $i++) {
            echo("<td>");
            if ($i == sizeof($str) - 1) {
                if (!mysql_num_rows($shop)) {
                    echo("<font color=#049E00>Не найден</font>");
                } else {
                    echo(mysql_result($shop, 0));
                }
            } else {
                echo($str[$i]);
            }
            echo("</td>");
        }
        //вывод информации о выполняемой работе
        echo("<td>");
        //количество выполняемых работ
        $num_works = mysql_num_rows($works);
        if (!$num_works) {
            echo("Не найдено");
        } else {
            echo("<ul align=left>");
            for ($i = 0; $i < $num_works; $i++) {
                echo("<li>" . mysql_result($works, $i)) . "</li>";
            }
            echo("</ul>");
        }
        echo("</td>");
        //вывод функционала
        echo("<td>");
        echo("<a href=\"../add/?page=master&event=edit&id=" .
        $id_master . "\"><img src=\"../update.ico\" width=16 height=16
title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=master&id_master=" . $id_master
        . "\"><img src=\"../delete.ico\" width=16 height=16
title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table><br><br>");
    return 0;
}

/* ---------------------Вывод записей таблицы Material---------
  -------------- */

function material_show($dbcnt, $param = true) {
//проверка соединения
    if (!$dbcnt) {
        echo("<table class=\"show\"><caption>МАТЕРИАЛЫ</caption>");
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Соединение с сервером отсутст-
вует</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>МАТЕРИАЛЫ</caption>");
//запрос на пролучение списка имен столбцов
    $query = "SHOW COLUMNS FROM Material";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
        //вывод
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td>works</td>");
        echo("<td></td>");
        echo("</tr>");
    } else {
//альтернативные имена
        $columns = array("№", "Название", "Описание", "Цена", "Приме-
нимо к работам");
        $num_columns = sizeof($columns);
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//вывод хранимой информации
//запрос на получение
    $query = "SELECT * FROM Material";
    $result = mysql_query($query, $dbcnt);
    $num_str = mysql_num_rows($result);
//если таблица не содержит никаких записей
    if (!$num_str) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод записей
    $n = 0; //номер записи
    while ($str = mysql_fetch_row($result)) {
        echo("<tr>");
        //вывод номера записи в зависимости от param
        if ($param) {
            echo("<td>" . $str[0] . "</td>");
        } else {
            echo("<td>" . ++$n . "</td>");
        }
        //вывод информации из таблицы Material
        for ($i = 1; $i < sizeof($str); $i++) {
            echo("<td>" . $str[$i] . "</td>");
        }
        //получение и вывод списка работ,
        //к которым применяется данный материал
        $query = "SELECTworknameFROM " .
                "Works, Material, MaterialWorks WHERE " .
                "MaterialWorks.id_Works = Works.id_Works AND " .
                "MaterialWorks.id_Material = Material.id_Material AND
" .
                "Material.id_Material = " . (int) $str[0];
        $works = mysql_query($query, $dbcnt);
        $num_works = mysql_num_rows($works);
        if (!$num_works) {
            echo("<td><font color=#049E00>Не найдено</font></td>");
        } else {
            //вывод в виде маркированного списка
            echo("<td><ul align=left>");
            for ($i = 0; $i < $num_works; $i++) {
                echo("<li>" . mysql_result($works, $i) . "</li>");
            }
            echo("</ul></td>");
        }
        //вывод функционала
        $id_material = $str[0];
        echo("<td>");
        echo("<a href=\"../add/?page=material&event=edit&id=" .
        $id_material . "\"><img src=\"../update.ico\" width=16
height=16 title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=material&id_material=" .
        $id_material . "\"><img src=\"../delete.ico\" width=16
height=16 title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table>");
}

/* ---------------------Вывод записей таблицы Works ---------
  -------------- */

function works_show($dbcnt, $param = true) {
//проверка соединения
    if (!$dbcnt) {
        echo("<table class=\"show\"><caption>РАБОТЫ</caption>");
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Соединение с сервером отсутст-
вует</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
    echo("<table class=\"show\"><caption>РАБОТЫ</caption>");
//запрос на пролучение списка имен столбцов
    $query = "SHOW COLUMNS FROM Works";
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<tr><td>");
        echo("<font color=#f00>Ошибка. Загрузка таблицы</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод имена столбцов
//если true, то как в таблице
//иначе альтернативные имена
    if ($param) {
//количество столбцов
        $num_columns = mysql_num_rows($result);
        //вывод
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . mysql_result($result, $i) . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    } else {
        //альтернативные имена
        $columns = array("№", "Название", "Описание", "Срок выполне-
ния", "Цена");
        $num_columns = sizeof($columns);
        echo("<tr>");
        for ($i = 0; $i < $num_columns; $i++) {
            echo("<td>" . $columns[$i] . "</td>");
        }
        echo("<td></td>");
        echo("</tr>");
    }
//вывод хранимой информации
//запрос на получение
    $query = "SELECT * FROM Works";
    $result = mysql_query($query, $dbcnt);
    $num_str = mysql_num_rows($result);
//если таблица не содержит никаких записей
    if (!$num_str) {
        echo("<tr><td colspan=" . ($num_columns + 1) . ">");
        echo("<font color=#049E00>Нет записей</font>");
        echo("</td></tr>");
        echo("</table><br><br>");
        return 1;
    }
//вывод записей
    $n = 0; //номер записи
    while ($str = mysql_fetch_row($result)) {
        echo("<tr>");
        //вывод номера записи в зависимости от param
        if ($param) {
            echo("<td>" . $str[0] . "</td>");
        } else {
            echo("<td>" . ++$n . "</td>");
        }
        if ($param) {
            for ($i = 1; $i < sizeof($str); $i++) {
                echo("<td>" . $str[$i] . "</td>");
            }
        } else {
            echo("<td>" . $str[1] . "</td>"); //название
            echo("<td>" . $str[2] . "</td>"); //описание
            $temp = "~ " . $str[3];
            switch ($str[4]) {
                case 'hours': $temp = $temp . " ч.";
                    break;
                case 'minutes': $temp = $temp . " мин.";
                    break;
                case 'days': $temp = $temp . " дн.";
                    break;
            }
            echo("<td>" . $temp . "</td>"); //срок выполнения
            echo("<td>" . $str[5] . " (руб.)</td>"); //цена
        }
        //вывод функционала
        $id_works = $str[0];
        echo("<td>");
        echo("<a href=\"../add/?page=works&event=edit&id=" .
        $id_works . "\"><img src=\"../update.ico\" width=16 height=16
title=\"Редактировать\" alt=\"Редактировать\"></a>");
        echo("<a href=\"../delete/?id=works&id_works=" . $id_works .
        "\"><img src=\"../delete.ico\" width=16 height=16
title=\"Удалить\" alt=\"Удалить\"></a>");
        echo("</td>");
        echo("</tr>");
    }
    echo("</table><br><br>");
    return 0;
}

?>
