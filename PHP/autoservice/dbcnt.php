<?php

/* -------------Чтение параметров из конфигурационного файла--- */
function ReadCnf($inifile) {
    $param = parse_ini_file($inifile, true);
    return $param;
}

/* -------------Соедиение с сервером MySQL--------------------- */
function Connect($param) {
    $dblocation = $param['mysql']['dblocation'];
    $dbuser = $param['mysql']['dbuser'];
    $dbpassw = $param['mysql']['dbpassw'];
    $dbcnt = mysql_connect($dblocation, $dbuser, $dbpassw);
    if (!$dbcnt) {
        exit("<font color=#f00>Ошибка. Подключение к серверу
БД.</font>");
    }
    return $dbcnt;
}

/* ------------------Выбор базы данных------------------------- */
function SelectDB($param, $dbcnt) {
    $dbname = $param['mysql']['dbname'];
    mysql_select_db($dbname, $dbcnt)
            or die("<font color=#f00>Ошибка. Выбор БД.</font>");
    mysql_query("SET NAMES 'utf8'")
            or die("<font color=#f00>Ошибка. Кодировка
БД.</font>");
}

/* ----------------------Закрытиесоединения-------------------- */
function Disconnect($dbcnt) {
    mysql_close($dbcnt)
            or die("<font color=#f00>Ошибка. Закрытие соедине-
ния.</font>");
}

/* -------------------Загрузка списка цехов (Shop)------------- */
function LoadShop($dbcnt) {
//если соединение отсутствует
    if (!$dbcnt) {
        echo("<fontcolor=#f00>Ошибка.Соединение с сервером отсутству-
ет</font>");
        return 1;
    }

//отправка запроса на получение информации
    $query = "SELECT * FROM Shop";
    $result = mysql_query($query, $dbcnt);
    $num_shop = mysql_num_rows($result);
//если нет результата
    if (!$num_shop) {
        echo("<fontcolor=#f00>Ошибка.Список цехов отсутствует</font>");
        return 1;
    }

//формируем и выводим список
    echo("<select onchange=\"change(this)\" class=\"shop_list\"
name=\"shop_list\">");
    $i = 0;
    while ($shop = mysql_fetch_assoc($result)) {
        ++$i;
        echo("<option value=" . $shop['id_Shop'] . ">" . $i . "." .
        $shop['address'] . "</option>");
    }
    echo("</select>");
    return 0;
}

?>
