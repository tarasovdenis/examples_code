<?php

/* ---------------------Добавление/Изменение в Shop (Цех)------
  -------------- */

function func_shop($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Отсутствует соединение с серве-
ром</font>");
        return 1;
    }
//проверка существования данных в запросе
    if (!filter_has_var(INPUT_POST, 'address')) {
        echo("<fontcolor=#f00>Ошибка.Данные отсутствуют</font>");
        return 0;
    }
//чтение и фильтрация данных
    $description = filter_input(INPUT_POST, 'description');
    $address = filter_input(INPUT_POST, 'address');
    $description = trim(htmlspecialchars(addslashes($description)));
    $address = trim(htmlspecialchars(addslashes($address)));
    if (!strlen($address)) {
        echo("<font color=#f00>Ошибка. Заполните обязательные поля
*</font>");
        return 1;
    }
    $description = "'$description'";
    $address = "'$address'";
//проверка существования данных в БД
    if ($event == "add") {
        $query = "SELECT id_Shop FROM Shop WHERE address=" . $address;
    } else {
        $query = "SELECT id_Shop FROM Shop WHERE address=" . $address
                . " AND id_Shop<>" . $_GET['id'];
    }
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Такой адрес уже указан в одной
из записей</font>");
        return 1;
    }
    if ($event == "add") {
//запись данных в БД
        $query = "INSERT INTO Shop VALUES(0," . $description . "," .
                $address . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Запись данных</font>");
            return 1;
        }
    } else {
//разрешить изменять данные с вторичными ключами
        $query = "SET FOREIGN_KEY_CHECKS=0";
        mysql_query($query, $dbcnt);
//изменение данных
        $query = "REPLACE INTO Shop VALUES(" . $_GET['id'] . "," . $description
                . "," . $address . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Изменение данных</font>");
            return 1;
        }
    }
    return 0;
}

/* ---------------------Добавление/Изменение в Client (Клиент)-
  -------------- */

function func_client($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка сущестования входных данных
    if (!filter_has_var(INPUT_POST, 'fio') ||
            !filter_has_var(INPUT_POST, 'document') ||
            !filter_has_var(INPUT_POST, 'phone1')) {
        echo("<font color=#f00>Ошибка.Данные отстутствуют</font>");
        return 1;
    }
//чтение, проверка данных
    $fio = filter_input(INPUT_POST, 'fio');
    $document = filter_input(INPUT_POST, 'document');
    $phone1 = filter_input(INPUT_POST, 'phone1');
    $phone2 = filter_input(INPUT_POST, 'phone2');
//проверка обязательных строк на пустоту
    if (!strlen($fio) || !strlen($document) || !strlen($phone1)) {
        echo("<font color=#f00>Ошибка. Заполните обязательные поля
*</font>");
        return 1;
    }
//проверка корректности поля fio
    $pattern = "|^[A-Za-zА-Яа-яѐЁ\s]+$|u";
    if (!preg_match($pattern, $fio)) {
        echo("<font color=#f00>Ошибка. ФИО должен содержать кириллицу
и латиницу</font>");
        return 1;
    }
//проверка формата поля документы
    $pattern = "|^[\d]{4}\s[\d]{6}$|";
    if (!preg_match($pattern, $document)) {
        echo("<fontcolor=#f00>Ошибка.Ошибка ввода серии и номера во-
дительского удостоверения</font>");
        return 1;
    }
//проверка формата телефонных номеров
    $pattern = "|^\+[7]\([\d]{3}\)[\d]{7}$|";
    if (!preg_match($pattern, $phone1)) {
        echo("<font color=#f00>Ошибка.Ошибка ввода Телефон
1</font>");
        return 1;
    }
    if (!empty($phone2)) {
        if (!preg_match($pattern, $phone2)) {
            echo("<font color=#f00>Ошибка.Ошибка ввода Телефон
2</font>");
            return 1;
        }
    }
    $fio = trim($fio);
    $document = trim($document);
    $phone1 = trim($phone1);
    $phone2 = trim($phone2);
    $fio = "'$fio'";
    $document = "'$document'";
    $phone1 = "'$phone1'";
    if (!empty($phone2)) {
        $phone2 = "'$phone2'";
    } else {
        unset($phone2);
    }
//проверка введенных данных на существование в БД
    if ($event == "add") {
        $query = "SELECT id_Client FROM Client WHERE document=" .
                $document;
    } else {
        
    }
    $query = "SELECT id_Client FROM Client WHERE document=" .
            $document . " AND id_Client<>" . $_GET['id'];
}

$result = mysql_query($query, $dbcnt);
if (mysql_num_rows($result)) {
    echo("<fontcolor=#f00>Ошибка.Запись с такими данными уже су-
ществует</font>");
    return 1;
}
//поверка номеров телефонов на существование
//проверка телефон 1
if ($event == "add") {
    $query = "SELECT id_Client FROM Client WHERE phone1=" . $phone1
            . " OR phone2=" . $phone1;
} else {
    $query = "SELECT id_Client FROM Client WHERE id_Client<>" .
            $_GET['id'] . " AND (phone1=" . $phone1 . " OR phone2=" .
            $phone1 . ")";
}
$result = mysql_query($query, $dbcnt);
if (mysql_num_rows($result)) {
    echo("<fontcolor=#f00>Телефон 1 принадлежит другому
клиенту</font>");
    return 1;
}
//проверка телефон 2(если указан)
if (isset($phone2)) {
    if ($event == "add") {
        $query = "SELECT id_Client FROM Client WHERE phone1=" .
                $phone2 . " OR phone2=" . $phone2;
    } else {
        $query = "SELECT id_Client FROM Client WHERE id_Client<>" .
                $_GET['id'] . " AND (phone1=" . $phone2 . " OR phone2=" .
                $phone2 . ")";
    }
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Телефон 2 принадлежит другому клиен-
ту</font>");
        return 1;
    }
}
if ($event == "add") {
//запис данных в БД
    if (isset($phone2)) {
        $query = "INSERT INTO Client VALUES(0," . $fio . "," . $document
                . "," . $phone1 . "," . $phone2 . ")";
    } else {
        $query = "INSERT INTO Client VALUES(0," . $fio . "," . $document
                . "," . $phone1 . ",0)";
    }
    if (!mysql_query($query, $dbcnt)) {
        echo("<font color=#f00>Ошибка.Запись данных</font>");
        return 1;
    }
} else {
//разрешить изменять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//изменение данных
    if (isset($phone2)) {
        $query = "REPLACE INTO Client VALUES(" . $_GET['id'] . "," .
                $fio . "," . $document . "," . $phone1 . "," . $phone2 . ")";
    } else {
        $query = "REPLACE INTO Client VALUES(" . $_GET['id'] . "," .
                $fio . "," . $document . "," . $phone1 . ",0)";
    }
    if (!mysql_query($query, $dbcnt)) {
        echo("<font color=#f00>Ошибка.Запись данных</font>");
        return 1;
    }
    return 0;
}
/* ---------------------Добавление/Изменение в Auto (Автомо-
  биль)------------- */

function func_auto($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 0;
    }
//проверка существования входных данных
    if (!filter_has_var(INPUT_POST, 'vin') ||
            !filter_has_var(INPUT_POST, 'model') ||
            !filter_has_var(INPUT_POST, 'document') ||
            !filter_has_var(INPUT_POST, 'number')) {
        echo("<font color=#f00>Ошибка.Данные отстутствуют</font>");
    }
    return 1;
}

//чтение, проверка входных данных
$vin = filter_input(INPUT_POST, 'vin');
$model = filter_input(INPUT_POST, 'model');
$number = filter_input(INPUT_POST, 'number');
$document = filter_input(INPUT_POST, 'document');
//проверка обязательных строк на пустоту
if (!strlen($vin) || !strlen($model) || !strlen($document) ||
        !strlen($number)) {
    echo("<font color=#f00>Ошибка. Заполните обязательные поля
*</font>");
    return 1;
}
//проверка формата VIN
$pattern = "|^[A-z0-9]{17}$|u";
if (!preg_match($pattern, $vin)) {
    echo("<font color=#f00>Ошибка. VIN должен состоять из 17 цифр
(латиница, цифры)</font>");
    return 1;
}
//проверка формата гос.номера
$pattern = "|^[A-zА-яѐЁ0-9]+$|u";
if (!preg_match($pattern, $number)) {
    echo("Ошибка. Ошибка ввода государственного номера");
    return 1;
}
//проверка формата поля документы
$pattern = "|^[\d]{4}\s[\d]{6}$|";
if (!preg_match($pattern, $document)) {
    echo("<fontcolor=#f00>Ошибка.Ошибка ввода серии и номера во-
дительского удостоверения</font>");
    return 1;
}
$vin = trim($vin);
$model = trim(htmlspecialchars($model));
$number = trim($number);
$document = trim($document);
$vin = "'$vin'";
$model = "'$model'";
$number = "'$number'";
$document = "'$document'";
//проверка существования владельца в БД
$query = "SELECT id_Client FROM Client WHERE document=" .
        $document;
$result = mysql_query($query, $dbcnt);
if (!mysql_num_rows($result)) {
    echo("<fontcolor=#f00>Ошибка.Вледелец автомобиля не
найден</font>");
    return 1;
}
//получение id владельца
$id_Client = mysql_result($result, 0, 'id_Client');
$id_Client = (int) $id_Client;
//проверка введенных данных на существование в таблице
//проверка vin
if ($event == "add") {
    $query = "SELECT id_Auto FROM Auto WHERE vin=" . $vin;
} else {
    $query = "SELECT id_Auto FROM Auto WHERE vin=" . $vin . " AND
id_Auto<>" . $_GET['id'];
}
$result = mysql_query($query);
if (mysql_num_rows($result)) {
    echo("<fontcolor=#f00>Автомобиль с таким VIN уже зарегистри-
рован</font>");
    return 1;
}
//проверка гос.номера
if ($event == "add") {
    $query = "SELECT id_Auto FROM Auto WHERE st_num=" . $number;
} else {
    $query = "SELECT id_Auto FROM Auto WHERE st_num=" . $number .
            " AND id_Auto<>" . $_GET['id'];
}
$result = mysql_query($query, $dbcnt);
if (mysql_num_rows($result)) {
    echo("<fontcolor=#f00>Автомобиль с таким гос.номером уже за-
регистрирован</font>");
    return 1;
}
if ($event == "add") {
//запись данных в таблицу
    $query = "INSERT INTO Auto VALUES(0," . $vin . "," . $model .
            "," . $number . "," . $id_Client . ")";
    if (!mysql_query($query, $dbcnt)) {
        echo("<font>Ошибка. Запись данных</font>");
        return 1;
    }
} else {
//разрешить изменять данные с вторичными ключами
    $query = "SET FOREIGN_KEY_CHECKS=0";
    mysql_query($query, $dbcnt);
//изменение данных
    $query = "REPLACE INTO Auto VALUES(" . $_GET['id'] . "," . $vin
            . "," . $model . "," . $number . "," . $id_Client . ")";
    if (!mysql_query($query, $dbcnt)) {
        echo("<font>Ошибка. Запись данных</font>");
        return 1;
    }
    return 0;
}
/* ---------------------Добавление/Изменение в Works (Работы)--
  -------------- */

function func_works($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования данных в запросе
    if (!filter_has_var(INPUT_POST, 'name') ||
            !filter_has_var(INPUT_POST, 'dat') ||
            !filter_has_var(INPUT_POST, 'type_dat') ||
            !filter_has_var(INPUT_POST, 'price')) {
        echo("<font color=#f00>Ошибка.Данные отстутствуют</font>");
        return 1;
    }
//чтение и фильтрация данных
    $name = filter_input(INPUT_POST, 'name');
//название
    $description = filter_input(INPUT_POST, 'description');
//описание
    $dat = filter_input(INPUT_POST, 'dat');
//срок выполнения
    $type_dat = filter_input(INPUT_POST, 'type_dat');
//размерность срока выполнения
    $price = filter_input(INPUT_POST, 'price');
//цена
    if (!strlen($name) || !strlen($dat) || !strlen($price)) {
        echo("<font color=#f00>Ошибка. Заполните обязательные поля
*</font>");
        return 1;
    }
//проверка значения поля срок выполнения
    $pattern = "|^[\d]{1,3}$|";
    if (!preg_match($pattern, $dat)) {
        echo("<font color=#f00>Ошибка. Проверьте корректность данных
в поле Срок выполнения</font>");
        return 1;
    }
//проверка значения поля цена
    $pattern = "|^[\d]+\.{0,1}[\d]{0,2}$|";
    if (!preg_match($pattern, $price)) {
        echo("<font color=#f00>Ошибка. Проверьте корректность данных
в поле Цена</font>");
        return 1;
    }
    $name = trim(htmlspecialchars(addslashes($name)));
    $description = trim(htmlspecialchars($description));
    $name = "'$name'";
    $description = "'$description'";
    $dat = (int) $dat;
    $type_dat = (int) $type_dat;
    $price = (float) $price;
//проверка на существование данных в таблице
    if ($event == "add") {
        $query = "SELECT id_Works FROM Works WHERE workname = " .
                $name;
    } else {
        $query = "SELECT id_Works FROM Works WHERE workname = " .
                $name . " AND id_Works<>" . $_GET['id'];
    }
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Такое название уже указано в од-
ной из записей</font>");
        return 1;
    }
    if ($event == "add") {
//запись данных в таблицу
        $query = "INSERT INTO Works VALUES(0," . $name . "," . $description
                . "," . $dat . "," . $type_dat . "," . $price . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Запись данных</font>");
            return 1;
        } else {
            return 0;
        }
    } else {
//разрешить изменять данные с вторичными ключами
        $query = "SET FOREIGN_KEY_CHECKS=0";
        mysql_query($query, $dbcnt);
//изменение данных
        $query = "REPLACE INTO Works VALUES(" . $_GET['id'] . "," .
                $name . "," . $description . "," . $dat . "," . $type_dat . ","
                . $price . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Запись данных</font>");
            return 1;
        }
    }
    return 0;
}

/* ---------------------Добавление/Изменение в Master (Мастер)-
  -------------- */

function func_master($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существоания входных данных
    if (!filter_has_var(INPUT_POST, 'fio') ||
            !filter_has_var(INPUT_POST, 'document') ||
            !filter_has_var(INPUT_POST, 'id_shop')) {
        echo("<font color=#f00>Ошибка.Данные отстутствуют</font>");
        return 1;
    }
//чтение, проверка данных
    $fio = filter_input(INPUT_POST, 'fio'); //ФИО
    $document = filter_input(INPUT_POST, 'document');
//табельный номер
    $id_shop = (int) filter_input(INPUT_POST, 'id_shop');
//Shop(id_Shop)
//проверка обязательных строк на пустоту
    if (!strlen($fio) || !strlen($document)) {
        echo("<font color=#f00>Ошибка. Заполните обязательные поля
*</font>");
        return 1;
    }
//если цех не указан
    if (!$id_shop) {
        echo("<fontcolor=#f00>Ошибка.Выберите цех</font>");
        return 1;
    }
//проверка корректности поля fio
    $pattern = "|^[A-Za-zА-Яа-яѐЁ\s]+$|u";
    if (!preg_match($pattern, $fio)) {
        echo("<font color=#f00>Ошибка. ФИО должен содержать кириллицу
и латиницу</font>");
        return 1;
    }
//проверка табельного номера
    $pattern = "|^[0-9]{1,7}$|";
    if (!preg_match($pattern, $document)) {
        echo("<fontcolor=#f00>Табельный номер не соответствует форма-
ту (до 7 цифр)</font>");
        return 1;
    }
    $fio = trim($fio);
    $document = trim($document);
    $fio = "'$fio'";
    $document = (int) $document;
//проверка выбранного списка работ
    if (!filter_has_var(INPUT_POST, 'num_work')) {
        echo("<font color=#f00>Ошибка.Список выполняемых работ
отсутствует</font>");
        return 1;
    }
//получение количества выбранных видов работ
    $num_work = (int) filter_input(INPUT_POST, 'num_work');
//если список работ пуст, запись данных невозможна
    if (!$num_work) {
        echo("<fontcolor=#f00>Ошибка.Список выполняемых работ отсутст-
вует.Необходимо внести в базу список работ</font>");
        return 1;
    }
//проверка выбора из списка работ
    $flag = false;
//цикл до первого нахождения выделенного элемента из списка работ
    for ($i = 1; $i <= $num_work; $i++) {
        if (filter_has_var(INPUT_POST, "w$i")) {
            $flag = true;
            break;
        }
    }
//если не выделено ни одного элемента, то запись данных невозможна
    if (!$flag) {
        echo("<fontcolor=#f00>Ошибка.Необходимо выбрать вид
работы</font>");
        return 1;
    }
//проверка введенных данных на существование в БД
    if ($event == "add") {
        $query = "SELECT id_Master FROM Master WHERE document=" .
                $document;
    } else {
        $query = "SELECT id_Master FROM Master WHERE document=" .
                $document . " AND id_Master<>" . $_GET['id'];
    }
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Табельный номер уже использует-
ся</font>");
        return 1;
    }
    if ($event == "add") {
//запись данных в таблицу master
        $query = "INSERT INTO Master VALUES(0," . $fio . "," . $document
                . "," . $id_shop . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Запись данных в табли-
цу</font>");
            return 1;
        }
    } else {
//разрешить изменять данные с вторичными ключами
        $query = "SET FOREIGN_KEY_CHECKS=0";
        mysql_query($query, $dbcnt);
//изменение данных в Master
        $query = "REPLACE INTO Master VALUES(" . $_GET['id'] . "," .
                $fio . "," . $document . "," . $id_shop . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка.Запись данных в
таблицу</font>");
            return 1;
        }
    }
//сопоставление мастера со списком работ
//получение id_master для вышедобавленного мастера
    if ($event == "add") {
        $query = "SELECT id_Master FROM Master WHERE fio=" . $fio . "
AND document=" . $document;
        $result = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($result)) {
            echo("<font color=#f00>Ошибка.Получение id мастера</font>");
            return 1;
        }
        $id_master = mysql_result($result, 0, 'id_master');
    } else {
        $id_master = $_GET['id'];
    }
//если выполняется редактирование данных
//то удаление старого списка из MasterWorks
    if ($event == "edit") {
        $query = "DELETE FROM MasterWorks WHERE id_Master=" .
                $id_master;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Изменение списка ра-
бот</font>");
            return 1;
        }
    }
//запись данных в таблицу соответствий (MasterWorks)
    for ($i = 1; $i <= $num_work; $i++) {
        if (filter_has_var(INPUT_POST, "w$i")) {
            $w = filter_input(INPUT_POST, "w$i");
            $w = (int) $w;
            $query = "INSERT INTO MasterWorks VALUES(0," . $id_master .
                    "," . $w . ")";
            if (!mysql_query($query, $dbcnt)) {
                echo("<fontcolor=#f00>Ошибка при сопостовлении работ с мас-
тером");
                return 1;
            }
        }
    }
    return 0;
}

/* ---------------------Добавление/Изменение в Material (Мате-
  риал)----------- */

function func_material($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка сущестования входных данных
    if (!filter_has_var(INPUT_POST, 'name') ||
            !filter_has_var(INPUT_POST, 'description') ||
            !filter_has_var(INPUT_POST, 'price')) {
        echo("<font color=#f00>Ошибка.Данные отстутствуют</font>");
        return 1;
    }
//чтение, проверка данных
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    $price = filter_input(INPUT_POST, 'price');
    $name = trim(htmlspecialchars($name));
    $description = trim(htmlspecialchars($description));
    $price = trim($price);
//проверка обязательных строк на пустоту
    if (!strlen($name) || !strlen($price) || !strlen($description)) {
        echo("<font color=#f00>Ошибка. Заполните обязательные поля
*</font>");
        return 1;
    }
//проверка формата числа в поле цена
    $pattern = "|^[\d]{1,10}\.{0,1}[\d]{0,2}$|";
    if (!preg_match($pattern, $price)) {
        echo("<font color=#f00>Ошибка. Проверьте корректность данных
в поле Цена</font>");
        return 1;
    }
//преобразование переменных в удобный формат
    $name = "'$name'";
    $description = "'$description'";
    $price = (float) $price;
//проверка введенных данных на существование в БД
    if ($event == "add") {
        $query = "SELECT id_Material FROM Material WHERE name=" .
                $name . " AND description=" . $description;
    } else {
        $query = "SELECT id_Material FROM Material WHERE name=" .
                $name . " AND description=" . $description . " AND
id_Material<>" . $_GET['id'];
    }
    $result = mysql_query($query, $dbcnt);
    if (mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Запись с такими данными уже су-
ществует</font>");
        return 1;
    }
    if ($event == "add") {
//запись данных в БД
        $query = "INSERT INTO Material VALUES(0," . $name . "," .
                $description . "," . $price . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Запись данных в табли-
цу</font>");
            return 1;
        }
    } else {
//разрешить изменять данные с вторичными ключами
        $query = "SET FOREIGN_KEY_CHECKS=0";
        mysql_query($query, $dbcnt);
//Изменение данных
        $query = "REPLACE INTO Material VALUES(" . $_GET['id'] . "," .
                $name . "," . $description . "," . $price . ")";
        if (!mysql_query($query, $dbcnt)) {
            echo("<font color=#f00>Ошибка. Запись данных в табли-
цу</font>");
            return 1;
        }
    }
//сопоставление материала с видами работ
    if (!filter_has_var(INPUT_POST, 'num_work')) {
        echo("Данные успешно записаны без списка работ<br>");
        return 0;
    }
//получение количества имеющихся видов работ
    $num_work = filter_input(INPUT_POST, 'num_work');
    if (!$num_work) {
        echo("Данные успешно записаны без списка работ");
        return 0;
    }
    if ($event == "add") {
//получение id_Material вышедобавленной записи
        $query = "SELECT id_Material FROM Material WHERE name=" . $name
                . " AND description=" . $description;
        $result = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($result)) {
            echo("Данные успешно записаны без списка работ");
            return 0;
        }
        $id_material = mysql_result($result, 0, 'id_Material');
    } else {
        $id_material = $_GET['id'];
    }
//если выполняется редактирование данных
//то удаление старого списка из MasterWorks
    if ($event == "edit") {
        $query = "DELETE FROM MaterialWorks WHERE id_Material=" .
                $id_material;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Изменение списка ра-
бот</font>");
            return 1;
        }
    }
//сопоставление id_Material с id_Works в таблице MaterialWorks
    $flag = false; //флаг обнаружения вида работы
    for ($i = 1; $i <= $num_work; $i++) {
        if (filter_has_var(INPUT_POST, "w$i")) {
            $w = filter_input(INPUT_POST, "w$i");
            $w = (int) $w;
            $query = "INSERT INTO MaterialWorks VALUES(0," . $w . "," .
                    $id_material . ")";
            if (mysql_query($query, $dbcnt)) {
                $flag = true;
            }
        }
    }
    if (!$flag) {
        echo("Данные успешно записаны без списка работ");
        return 0;
    }
//данные успешно записаны и сопоставленны с видами работ
    return 0;
}

/* ---------------------Добавление/Изменение в Orders (Заказы)-
  -------------- */

function func_orders($dbcnt, $event) {
//проверка существования соединения
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }
//проверка существования входных данных
    if (!filter_has_var(INPUT_POST, 'document') ||
            !filter_has_var(INPUT_POST, 'vin')) {
        echo("<font color=#f00>Ошибка. Данные отсутстуют</font>");
        return 0;
    }
//чтение входных данных
    $document = filter_input(INPUT_POST, 'document');
    $vin = filter_input(INPUT_POST, 'vin');
    $id_shop = filter_input(INPUT_GET, 'id_shop');
    $status = (int) filter_input(INPUT_POST, 'status');
    $dat = filter_input(INPUT_POST, 'dat');
//проверка обязательных строк на пустоту
    if (!strlen($document) || !strlen($vin)) {
        echo("<fontcolor=#f00>Ошибка.Заполните обязательные поля
*</font>");
        return 1;
    }
//проверка формата VIN
    $pattern = "|^[A-z0-9]{17}$|u";
    if (!preg_match($pattern, $vin)) {
        echo("<font color=#f00>Ошибка. VIN должен состоять из 17 цифр
(латиница, цифры)</font>");
        return 1;
    }
//проверка формата поля документы
    $pattern = "|^[\d]{4}\s[\d]{6}$|";
    if (!preg_match($pattern, $document)) {
        echo("<fontcolor=#f00>Ошибка.Ошибка ввода серии и номера во-
дительского удостоверения</font>");
        return 1;
    }
//проверка формата даты оформления
    $pattern = "|^[\d]{1,2}\.[\d]{1,2}\.[\d]{4},\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2
}$|";
    if (!preg_match($pattern, $dat)) {
        echo("<fontcolor=#f00>Ошибка.Дата оформления не соответствует
формату</font>");
        return 1;
    }
//разбор строки дата оформления
    $format = "d.n.Y, G:i:s"; //формат строки
//разбиение строки в ассоциативный массив
    $temp = date_parse_from_format($format, $dat);
//формирование даты в формате mysql
    $dat = $temp['year'] . "-" . $temp['month'] . "-" .
            $temp['day'] . " " .
            $temp['hour'] . ":" . $temp['minute'] . ":" .
            $temp['second'];
    $dat = "'$dat'";
//проверка выбранного списка работ
//проверка существования списка работ
    if (!filter_has_var(INPUT_POST, 'num_work')) {
        echo("<fontcolor=#f00>Ошибка.Список выполняемых работ отсут-
ствует</font>");
        return 1;
    }
    $num_work = (int) filter_input(INPUT_POST, 'num_work');
    if (!$num_work) {
        echo("<fontcolor=#f00>Ошибка.Список выполняемых работ отсутст-
вует.Необходимо внести в базу список работ</font>");
        return 1;
    }
//проверка выбора из списка работ
    $flag = false;
//цикл до первого нахождения выделенного элемента из списка работ
    for ($i = 1; $i <= $num_work; $i++) {
        if (filter_has_var(INPUT_POST, "w$i")) {
            $flag = true;
            break;
        }
    }
//если ни один элемент из списка работ не выбран, то запись данных не возможна
    if (!$flag) {
        echo("<fontcolor=#f00>Ошибка.Необходимо выбрать виды
работ</font>");
        return 1;
    }
    $document = trim($document);
    $vin = trim($vin);
    $document = "'$document'";
    $vin = "'$vin'";
//получение Client(id_Client) по документам
    $query = "SELECT id_Client FROM Client WHERE document=" . $document;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Клиент не найден в базе
данных</font>");
        return 1;
    }
    $id_client = (int) mysql_result($result, 0, 'id_Client');
//получение Auto(id_Auto) по VIN
    $query = "SELECT id_Auto FROM Auto WHERE vin=" . $vin;
    $result = mysql_query($query, $dbcnt);
    if (!mysql_num_rows($result)) {
        echo("<fontcolor=#f00>Ошибка.Автомобиль не найден в базе дан-
ных</font>");
        return 1;
    }
    $id_auto = (int) mysql_result($result, 0, 'id_Auto');
    if ($event == "add") {
//запись данных в таблицу Orders
        $query = "INSERT INTO Orders VALUES(0," . $id_client . "," .
                $id_auto . "," . $status . "," .
                $dat . "," . $id_shop . ")";
    } else {
//разрешить изменять данные с вторичными ключами
        $query = "SET FOREIGN_KEY_CHECKS=0";
        mysql_query($query, $dbcnt);
//изменение данных
        $query = "REPLACE INTO Orders VALUES(" . $_GET['id'] . "," .
                $id_client . "," . $id_auto . "," . $status . "," .
                $dat . "," . $id_shop . ")";
    }
    if (!mysql_query($query, $dbcnt)) {
        echo("<font color=#f00>Ошибка.Запись данных</font>");
        return 1;
    }
    if ($event == "add") {
//получение Orders(id_Orders) для добавленной записи
        $query = "SELECT id_Orders FROM Orders WHERE id_Client=" .
                $id_client . " AND " .
                "id_Auto=" . $id_auto . " AND " . "dat=" . $dat;
        $result = mysql_query($query, $dbcnt);
        if (!mysql_num_rows($result)) {
            echo("<fontcolor=#f00>Ошибка.Получение номера зака-
за</font>");
            return 1;
        }
        $id_orders = (int) mysql_result($result, 0, 'id_Orders');
    } else {
        $id_orders = $_GET['id'];
    }
//если выполняется редактирование данных
//то удаление старого списка из WorksOrders
    if ($event == "edit") {
        $query = "DELETE FROM WorksOrders WHERE id_Orders=" .
                $id_orders;
        if (!mysql_query($query, $dbcnt)) {
            echo("<fontcolor=#f00>Ошибка.Изменение списка ра-
бот</font>");
            return 1;
        }
    }
//запись данных в таблицу соответствий
    for ($i = 1; $i <= $num_work; $i++) {
        if (filter_has_var(INPUT_POST, "w$i")) {
            $w = filter_input(INPUT_POST, "w$i");
            $w = (int) $w;
            $query = "INSERT INTO WorksOrders VALUES(0," . $w . "," .
                    $id_orders . ")";
            if (!mysql_query($query, $dbcnt)) {
                echo("<fontcolor=#f00>Ошибка.Соспоставление видов работ с
заказом</font>");
                return 1;
            }
        }
    }
    return 0;
}

?>
