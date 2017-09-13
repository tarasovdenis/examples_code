<html>
    <head>
        <title>Удаление</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    </head>
    <body>
        <?php
        //запоминаем предыдущую страницу
        $prev_page = $_SERVER['HTTP_REFERER'];
        require_once("../dbcnt.php");
        $p = ReadCnf("../cnf.ini");
        $cnt = Connect($p);
        SelectDB($p, $cnt);
        if (empty($_GET)) {
            Disconnect($cnt);
            exit();
        }
        $table = filter_input(INPUT_GET, 'id');
        switch ($table) {
            case 'auto':
                $id_auto = filter_input(INPUT_GET, 'id_auto');
                $r = auto_delete($cnt, $id_auto);
                break;
            case 'client':
                $id_client = filter_input(INPUT_GET, 'id_client');
                $r = client_delete($cnt, $id_client);
                break;
            case 'master':
                $id_master = filter_input(INPUT_GET, 'id_master');
                $r = master_delete($cnt, $id_master);
                break;
            case 'material':
                $id_material = filter_input(INPUT_GET, 'id_material');
                $r = material_delete($cnt, $id_material);
                break;
            case 'works':
                $id_works = filter_input(INPUT_GET, 'id_works');
                $r = works_delete($cnt, $id_works);
                break;
            case 'shop':
                $id_shop = filter_input(INPUT_GET, 'id_shop');
                $r = shop_delete($cnt, $id_shop);
                break;
            case 'order':
                $id_order = filter_input(INPUT_GET, 'id_order');
                $r = order_delete($cnt, $id_order);
                break;
        }
        Disconnect($cnt);
        if (!$r) {
            header("Location: $prev_page");
        }
        ?>
    </body>
</html>
<?php
/* -------------------Удаление записи о цехе (Shop)------------
  -------------- */

function shop_delete($dbcnt, $id_shop) {
//проверка соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования записи в БД
    $query = "SELECT id_Shop FROM Shop WHERE id_Shop=" . $id_shop;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<font color=#f00>Ошибка. Проверка существова-
ния</font>");
        return 1;
    }
//разрешить удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удаление данных о цехе
    $query = "DELETE FROM Shop WHERE id_Shop=" . $id_shop;
    if (!mysql_query($query, $dbcnt)) {
        echo("<fontcolor=#f00>Ошибка.Удаление данных о цехе</font>");
        return 1;
    }
//данные успешно удалены
    return 0;
}

/* -------------------Удаление записи о мастере (Master)-------
  -------------- */

function master_delete($dbcnt, $id_master) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования
    $query = "SELECT id_Master FROM Master WHERE id_Master=" .
            $id_master;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<font color=#f00>Ошибка. Проверка существова-
ния</font>");
        return 1;
    }
//разрешить удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удаление данных о мастере из БД
    $query = "DELETE FROM Master WHERE id_Master=" . $id_master;
    if (!mysql_query($query, $dbcnt)) {
        echo("<fontcolor=#f00>Ошибка.Удаление данных о масте-
ре</font>");
        return 1;
    }
//удаление мастера из таблицы соответствий MasterWorks
//проверка существования
    $query = "SELECT id_MasterWorks FROM MasterWorks WHERE
id_Master=" . $id_master;
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
//если данные найдены, то удаление
        $query = "DELETE FROM MasterWorks WHERE id_Master=" .
                $id_master;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Удаление информации о видах выполняе-
мых работ</font>");
            return 1;
        }
    }
//данные успешно удалены
    return 0;
}

/* --------------------Удаление записи из таблицы материалов
  (material)------ */

function material_delete($dbcnt, $id_material) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования
    $query = "SELECT id_Material FROM Material WHERE id_Material="
            . $id_material;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Проверка существования</font>");
        return 1;
    }
//разрешить удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удаление данных о материале из БД
    $query = "DELETE FROM Material WHERE id_Material=" .
            $id_material;
    if (!mysql_query($query, $dbcnt)) {
        echo("<fontcolor=#f00>Ошибка.Удаление данных о
материале</font>");
        return 1;
    }
//удаление данных из таблицы соответствий MaterialWorks
//проверка существования данных в MaterialWorks
    $query = "SELECT id_MaterialWorks FROM MaterialWorks WHERE
id_Material=" . $id_material;
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        $query = "DELETE FROM MaterialWorks WHERE id_Material=" .
                $id_material;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Удаление информации о видах применяе-
мых работ</font>");
            return 1;
        }
    }
//данные успешно удалены
    return 0;
}

/* --------------------Удаление записи о клиенте (Client)------
  -------------- */

function client_delete($dbcnt, $id_client) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка сущестования
    $query = "SELECT id_Client FROM Client WHERE id_Client=" .
            $id_client;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Проверка существования</font>");
        return 1;
    }
//разрешить удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удаление данных о клиенте из БД
    $query = "DELETE FROM Client WHERE id_Client=" . $id_client;
    if (!mysql_query($query, $dbcnt)) {
        echo("<fontcolor=#f00>Ошибка.Удаление данных о клиен-
те</font>");
        return 1;
    }
//данные успешно удалены
    return 0;
}

/* --------------------Удаление записи о автомобиле (Auto)-----
  - ------------ */

function auto_delete($dbcnt, $id_auto) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка зущестования записи
    $query = "SELECT id_Auto FROM Auto WHERE id_Auto=" . $id_auto;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Проверка существования</font>");
        return 1;
    }
//разрешение удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удадение данных о автомобиле из БД
    $query = "DELETE FROM Auto WHERE id_Auto=" . $id_auto;
    if (!mysql_query($query, $dbcnt)) {
        echo("<fontcolor=#f00>Ошибка.Удаление данных о
автомобиле</font>");
        return 1;
    }
//существуют ли заказы для этого автомобиля?
    $query = "SELECT id_Orders FROM Orders WHERE id_Auto=" .
            $id_auto;
    $result = mysql_query($query, $dbcnt);
//если не существуют, то выход
    if (!mysql_num_rows($result)) {
        return 0;
    }
//если существуют, то удаляем их
    while ($order = mysql_fetch_assoc($result)) {
        $id_order = $order['id_Orders'];
        //уделение заказа
        $query = "DELETE FROM Orders WHERE id_Orders=" . $id_order;
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Удаление заказов на автомо-
биль</font>");
            return 1;
        }
        //удаление списка работ для заказа
        $query = "DELETE FROM WorksOrders WHERE id_Orders=" .
                $id_order;
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Удаление списка работа в за-
казе на автомобиль</font>");
            return 1;
        }
    }
//данные успешно удалены
    return 0;
}

/* ---------------------Удаление записи о работе---------------
  ---------------- */

function works_delete($dbcnt, $id_works) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования данных
    $query = "SELECT id_Works FROM Works WHERE id_Works=" .
            $id_works;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Проверка существования</font>");
        return 1;
    }
//разрешение удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удаление данных из БД
    $query = "DELETE FROM Works WHERE id_Works=" . $id_works;
    if (!mysql_query($query, $dbcnt)) {
        echo("<fontcolor=#f00>Ошибка.Удаление данных о виде
работы</font>");
        return 1;
    }
//удаление данных из таблиц сопоставлений MasterWorks, MaterialWorks
//удаление данных из MasterWorks
//проверка существования
    $query = "SELECT id_MasterWorks FROM MasterWorks WHERE
id_Works=" . $id_works;
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        //если данные найдены, то удаление
        $query = "DELETE FROM MasterWorks WHERE id_Works=" .
                $id_works;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Удаление сопоставления с масте-
рами</font>");
            return 1;
        }
    }
//удаление данных из MaterialWorks
    $query = "SELECT id_MaterialWorks FROM MaterialWorks WHERE
id_Works=" . $id_works;
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        //если данные найдены, то удаление
        $query = "DELETE FROM MaterialWorks WHERE id_Works=" .
                $id_works;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Удаление сопоставления с мате-
риалами</font>");
            return 1;
        }
    }
//удаление данных из WorksOrders
    $query = "SELECT id_WorksOrders FROM WorksOrders WHERE
id_Works=" . $id_works;
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        //если данные найдены, то удаление
        $query = "DELETE FROM WorksOrders WHERE id_Works=" .
                $id_works;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Удаление сопоставления с зака-
зами</font>");
            return 1;
        }
    }
//данные успешно удалены
    return 0;
}

/* --------------------Удаление записи о заказе----------------
  -------------- */

function order_delete($dbcnt, $id_order) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования данных
    $query = "SELECT id_Orders FROM ORDERS WHERE id_Orders=" .
            $id_order;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Проверка существования</font>");
        return 1;
    }
//разрешение удалять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//удаление данных из БД
    $query = "DELETE FROM Orders WHERE id_Orders=" . $id_order;
    if (!mysql_query($query, $dbcnt)) {
        echo("<font color=#f00>Ошибка.Удаление данных</font>");
        return 1;
    }
//удаление сопоставления с видами работ
//удаление данных из WorksOrders
    $query = "SELECT id_WorksOrders FROM WorksOrders WHERE
id_Orders=" . $id_order;
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        //если данные найдены, то удаление
        $query = "DELETE FROM WorksOrders WHERE id_Orders=" .
                $id_order;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Удаление сопоставления с зака-
зами</font>");
            return 1;
        }
    }
//данные успешно удалены
    return 0;
}
?>

