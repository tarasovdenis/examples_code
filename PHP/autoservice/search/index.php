<html>
    <head>
        <title>Поиск</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <?php
        require_once("../dbcnt.php");
        $p = ReadCnf("cnf.ini");
        $cnt = Connect($p);
        SelectDB($p, $cnt);
        if (empty($_POST) || !filter_has_var(INPUT_POST, 'query') ||
                !filter_has_var(INPUT_POST, 'search')) {
            Disconnect($cnt);
            exit("Ошибка.Отсутствует запрос");
        }
        //чтение поискового запроса
        $search = filter_input(INPUT_POST, 'search'); //строка запроса
        $criterion = filter_input(INPUT_POST, 'criterion'); //критерий запроса
        switch ($criterion) {
            case 'master': master_search($cnt, $search);
                break;
            case 'client': client_search($cnt, $search);
                break;
            case 'order': order_search($cnt, $search);
                break;
        }
        Disconnect($cnt);
        ?>
    </body>
</html>
<?php
/* ----------------------Поиск мастера (Master)----------------
  -------------- */

function master_search($dbcnt, $search) {
//проверка соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
    $flag = true; //допустим, поиск будет успешным
//ищем по табельному номеру
    $query = "SELECT * FROM Master WHERE document=" . $search;
    $result = mysql_query($query, $dbcnt);
    if (!$result || !mysql_num_rows($result)) {
        $flag = false; //поиск завершился неудачей
    }
//если поиск по таб.номеру завершился неудачей
//ищем по fio (ФИО)
    if (!$flag) {
        $flag = true; // допустим, поиск будет успешным
        $query = "SELECT * FROM Master WHERE fio=" . "'$search'";
        $result = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($result)) {
            $flag = false;
        }
    }
//если поиск завершился неудачей, то вывод
    if (!$flag) {
        echo("Результаты поиска: не найдено");
        return 0;
    }
//если найдено, то выводим информацию
    echo("<table class=\"result\"><caption>Результаты
поска</caption>");
    $n = 0; //номер записи
    while ($master = mysql_fetch_assoc($result)) {
        $fio = $master['fio'];
        $document = $master['document'];
        $id_shop = $master['id_Shop'];
//получение информации о цехе, к которому он относится
        $query = "SELECT description, address FROM Shop WHERE id_Shop="
                . $id_shop;
        $res = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($res)) {
            $shop = "Не найдено";
        } else {
            $temp = mysql_fetch_assoc($res);
            $shop = $temp['description'] . ", " . $temp['address'];
        }
        //вывод
        echo("<tr bgcolor=#aaa>");
        echo("<td>Результат-" . ++$n . "</td>");
        echo("</tr>");
        echo("<tr>");
        echo("<td>");
        echo("<b>ФИО: </b>" . $fio . "<br>");
        echo("<b>Табельный номер: </b>" . $document . "<br>");
        echo("<b>Цех: </b>" . $shop . "<br>");
        //получение и вывод выполняемых работ
        $query = "SELECT workname FROM Works, MasterWorks WHERE " .
                "Works.id_Works = MasterWorks.id_Works AND " .
                "MasterWorks.id_Master=" . $master['id_Master'];
        $res = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($res)) {
            echo("<b>Выполняемые работы:</b> не найдено");
        } else {
            echo("<b>Выполняемые работы:</b><br>");
            echo("<ol>");
            for ($i = 0; $i < mysql_num_rows($res); $i++) {
                echo("<li>" . mysql_result($res, $i) . "</li>");
            }
            echo("</ol>");
        }
        echo("<br><br></td>");
        echo("</tr>");
    }
    echo("</table>");
    return 0;
}

/* ----------------------Поиск клиента (Client)----------------
  -------------- */

function client_search($dbcnt, $search) {
//проверка соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//ищем по документам
//допустим поиск будет успешным
    $flag = true;
    $query = "SELECT * FROM Client WHERE document=" . "'$search'";
    $result = mysql_query($query, $dbcnt);
    if (!$result || !mysql_num_rows($result)) {
        $flag = false; //поиск завершился неудачей
    }
//если поиск по документам завершился неудачей,
//то ищем по fio (ФИО)
    if (!$flag) {
        $flag = true; //допустим поиск будет успешным
        $query = "SELECT * FROM Client WHERE fio=" . "'$search'";
        $result = mysql_query($query, $dbcnt);
        if (!$result || !mysql_num_rows($result)) {
            $flag = false; //поиск завершился неудачей
        }
    }
//если поиск по документам и фио неудачен,
//то ищем по телефону
    if (!$flag) {
        $flag = true;
        $query = "SELECT * FROM Client WHERE phone1=" . "'$search'" .
                " OR " .
                "phone2=" . "'$search'";
        $result = mysql_query($query, $dbcnt);
        if (!$result || !mysql_num_rows($result)) {
            $flag = false; //поиск завершился неудачей
        }
    }
//если поиск завершился неудачей, то вывод
    if (!$flag) {
        echo("Результаты поиска: не найдено");
        return 0;
    }
//если найдено, то выводим информацию
    echo("<table class=\"result\"><caption>РЕЗУЛЬТАТЫ
ПОИСКА</caption>");
    $n = 0; //номер результата
    while ($client = mysql_fetch_assoc($result)) {
        $fio = $client['fio'];
        $document = $client['document'];
        $phone1 = $client['phone1'];
        $client['phone2'] == '0' ? $phone2 = "отсутствует" : $phone2 = $client['phone2'];
        //вывод
        echo("<tr bgcolor=#aaa>");
        echo("<td>Результат - " . ++$n . "</td>");
        echo("</tr>");
        echo("<tr><td>");
        echo("<b>ФИО: </b>" . $fio . "<br>");
        echo("<b>Водительское удостоверение: </b>" . $document .
        "<br>");
        echo("<b>Телефон-1: </b>" . $phone1 . "<br>");
        echo("<b>Телефон-2: </b>" . $phone2 . "<br>");
        //получение списка автомобилей, которыми владеет клиент
        $query = "SELECT * FROM Auto WHERE id_Client=" .
                $client['id_Client'];
        $res = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($res)) {
            echo("<b>Автомобили: </b>отсутствуют");
        } else {
            echo("<b>Автомобили: </b><br>");
            echo("<ol>");
            while ($auto = mysql_fetch_assoc($res)) {
                $model = $auto['model'];
                $vin = $auto['VIN'];
                $st_num = $auto['st_num'];
                echo("<li>");
                echo("<b>Марка: </b>" . $model . "<br>");
                echo("<b>VIN: </b>" . $vin . "<br>");
                echo("<b>Гос.номер: </b>" . $st_num);
                echo("</li>");
            }
            echo("</ol>");
        }
        echo("<br><br></td>");
        echo("</tr></td>");
    }
    echo("</table>");
    return 0;
}

/* ----------------------Поиск заказа (Order)------------------
  -------------- */

function order_search($dbcnt, $search) {
//проверка соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//допустим поиск будет успешным
    $flag = true;
//поиск по номеру заказа
    $query = "SELECT * FROM Orders WHERE id_Orders=" . $search;
    $result = mysql_query($query, $dbcnt);
    if (!$result || !mysql_num_rows($result)) {
        $flag = false; //поиск завершился неудачей
    }
//если поиск по номеру заказа неудачен,
//то поиск по документам клиента
    if (!$flag) {
        $flag = true; //допустим поиск будет успешным
//получение id_Client
        $query = "SELECT id_Client FROM Client WHERE document=" .
                "'$search'";
        $result = mysql_query($query, $dbcnt);
        if (!$result || !mysql_num_rows($result)) {
            $flag = false; //поиск клиента завершился неудачей
        } else {
            $id_client = mysql_result($result, 0);
            //поиск заказа по id_Client
            $query = "SELECT * FROM Orders WHERE id_Client=" .
                    $id_client;
            $result = mysql_query($query, $dbcnt);
            if (!$result || !mysql_num_rows($result)) {
                $flag = false; //поиск завершился неудачей
            }
        }
    }
//если поиск по номеру заказа и по клиенту завершился неудачей,
//то поиск по VIN автомобиля
    if (!$flag) {
        $flag = true; //допустим поиск будет успешным
//получение id_Auto
        $query = "SELECT id_Auto FROM Auto WHERE VIN=" . "'$search'";
        $result = mysql_query($query, $dbcnt);
        if (!$result || !mysql_num_rows($result)) {
            $flag = false; //поиск автомобиля завершился неудачей
        } else {
            $id_auto = mysql_result($result, 0);
            //поиск заказа по id_auto
            $query = "SELECT * FROM Orders WHERE id_Auto=" . $id_auto;
            $result = mysql_query($query, $dbcnt);
            if (!$result || !mysql_num_rows($result)) {
                $flag = false; //поиск завершился неудачей
            }
        }
    }
//если поиск завершился неудачей, то вывод
    if (!$flag) {
        echo("Результаты поиска: не найдено");
        return 0;
    }
//если найдена информация, то вывод
//подключение библиотеки для использования
//функции order_detail(...)
    require_once("../show/show.php");
    echo("<table class=\"result\">");
    echo("<caption>РЕЗУЛЬТАТЫ ПОИСКА</caption>");
    $n = 0; //номер записи
    while ($order = mysql_fetch_assoc($result)) {
        echo("<tr bgcolor=#aaa><td>РЕЗУЛЬТАТ-" . ++$n .
        "</td></tr>");
        echo("<tr><td>");
        order_detail($dbcnt, $order['id_Orders']);
        echo("</td></tr>");
    }
    echo("</table>");
    return 0;
}
?>
