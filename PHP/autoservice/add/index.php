<!DOCTYPE HTML>
<html>
    <head>
        <title>Добавление/Изменение</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <?php
        //получение адреса начальной страницы
        $firstpage = parse_ini_file("../cnf.ini", true);
        $firstpage = $firstpage['server']['first'];
        //соединение с БД
        require_once("../dbcnt.php"); //функции соединения с БД
        $p = ReadCnf("../cnf.ini"); //чтение параметров из ini-файла
        $cnt = Connect($p); //соединение с сервером БД
        SelectDB($p, $cnt); //выбор БД
        //загружаемая страница
        if (!filter_has_var(INPUT_GET, 'page')) {
            Disconnect($cnt);
            exit("not page");
        }
        //выбор страницы указанной в запросе
        $page = filter_input(INPUT_GET, 'page');
        switch ($page) {
            case 'shop': require_once("shop.php");
                break;
            case 'client':require_once("client.php");
                break;
            case 'auto': require_once("auto.php");
                break;
            case 'works': require_once("works.php");
                break;
            case 'master':require_once("master.php");
                break;
            case 'material':require_once("material.php");
                break;
            case 'orders':require_once("orders.php");
                break;
        }
        //проверка поступивших данных
        if (empty($_POST)) {
            Disconnect($cnt);
            exit();
        }
        //если запрос на добавление
        if (filter_has_var(INPUT_POST, 'func')) {
            $func = filter_input(INPUT_POST, 'func');
            require_once("func.php"); //функции добавления в таблицы
        } else {
            Disconnect($cnt);
            exit();
        }
        //вызов функции указанной в запросе
        switch ($func) {
            case 'shop_add':
                $r = func_shop($cnt, "add");
                break;
            case 'shop_edit':
                $r = func_shop($cnt, "edit");
                break;
            case 'client_add':
                $r = func_client($cnt, "add");
                break;
            case 'client_edit':
                $r = func_client($cnt, "edit");
                break;
            case 'auto_add':
                $r = func_auto($cnt, "add");
                break;
            case 'auto_edit':
                $r = func_auto($cnt, "edit");
                break;
            case 'works_add':
                $r = func_works($cnt, "add");
                break;
            case 'works_edit':
                $r = func_works($cnt, "edit");
                break;
            case 'master_add':
                $r = func_master($cnt, "add");
                break;
            case 'master_edit':
                $r = func_master($cnt, "edit");
                break;
            case 'material_add':
                $r = func_material($cnt, "add");
                break;
            case 'material_edit':
                $r = func_material($cnt, "edit");
                break;
            case 'orders_add':
                $r = func_orders($cnt, "add");
                break;
            case 'orders_edit':
                $r = func_orders($cnt, "edit");
                break;
        }
        Disconnect($cnt);
        //если данные успешно добалвены/изменены, то переход на начальную страницу
        if (!$r) {
            header("Location: $firstpage");
        }
        ?>
    </body>
</html>

