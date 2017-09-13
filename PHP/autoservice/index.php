<!DOCTYPEHTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Автосервис</title>
    </head>
    <body>
        <?php
        //подключение к MySQL
        require_once("dbcnt.php");
        $p = ReadCnf("cnf.ini");
        $cnt = Connect($p);
        SelectDB($p, $cnt);
        ?>
        <div class="panel">
            <table class="search">
                <caption>ПОИСК</caption>
                <tr>
                    <td>
                        <form action="search/" method="POST">
                            <input type="text" name="search">
                            <select name="criterion" size="1">
                                <option value="order">Заказ</option>
                                <option value="client">Клиент</option>
                                <option value="master">Мастер</option>
                            </select>
                            <button type="submit" name="query" value="1">Найти</button>
                        </form>
                    </td>
                </tr>
            </table>
            <table class="order">
                <caption>ЗАКАЗЫ</caption>
                <tr>
                    <td rowspan="2" valign="top"><?php LoadShop($cnt); ?></td>
                    <td><a name="id_shop" href="add/">Добавить заказ</a></td>
                </tr>
                <tr>
                    <td><a name="id_shop" href="show/">Посмотреть заказы</a></td>
                </tr>
            </table>
            <table class="shop left">
                <caption>Цехи</caption>
                <tr><td><a href = "show/?id=shop">Просмотр</a></td><tr>
                <tr><td><a href =
                           "add/?page=shop&event=add">Добавить</a></td></tr>
            </table>
            <table class="works left">
                <caption>Работы</caption>
                <tr><td><a href = "show/?id=works">Просмотр</a></td></tr>
                <tr><td><a
                            href="add/?page=works&event=add">Добавить</a></td></tr>
            </table>
            <table class="master right">
                <caption>Мастера</caption>
                <tr><td><a href = "show/?id=master">Просмотр</a></td></tr>
                <tr><td><a href =
                           "add/?page=master&event=add">Добавить</a></td></tr>
            </table>
            <table class="material left">
                <caption>Материалы</caption>
                <tr><td><a href = "show/?id=material">Просмотр</a></td></tr>
                <tr><td><a
                            href="add/?page=material&event=add">Добавить</a></td></tr>
            </table>
            <table class="client left">
                <caption>Клиенты</caption>
                <tr><td><a href = "show/?id=client">Просмотр</a></td></tr>
                <tr><td><a
                            href="add/?page=client&event=add">Добавить</a></td></tr>
            </table>
            <table class="auto right">
                <caption>Автомобили</caption>
                <tr><td><a href = "show/?id=auto">Просмотр</a></td></tr>
                <tr><td><a
                            href="add/?page=auto&event=add">Добавить</a></td></tr>
            </table>
            <table class="view">
                <tr>
                    <td>
                <a href="show/">Посмотреть все таблицы</a>
                    </td>
                    </tr>
            </table>
        </div>
        <?php
        Disconnect($cnt);
        ?>
    </body>
</html>
<script type="text/javascript">
    /*-----Функция для формирования GET-запроса со значением id_shop---*/
    function change() {
        //link - ссылка
        //list - список цехов
        var link_add, link_show, list;
        //получаем элементы элементы
        list = document.getElementsByName("shop_list")[0];
        link_add = document.getElementsByName("id_shop")[0];
        link_show = document.getElementsByName("id_shop")[1];
//при выборе элемента из спискаid_shop =
//значение $_GET(id_shop) = Shop(id_shop)
        if (list != undefined) {
            link_add.href = "add/?page=orders&event=add&id_shop=" +
                    list.value;
            link_show.href = "show/?id=order&id_shop=" + list.value;
        } else
        {
            link_add.href = "add/?id=order";
            link_show.href = "show/?id=order";
        }
        return 0;
    }
//при загрузке страницы устанавливаем
//в качестве id_shop первый элемент из списка
    change();
</script>

