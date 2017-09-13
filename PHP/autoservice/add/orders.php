<?php
//проверка существования события
if (!filter_has_var(INPUT_GET, 'event')) {
    Disconnect($cnt);
    exit();
}
//получение имени события
$event = filter_input(INPUT_GET, 'event');
//получение редактируемых данных
if ($event == "edit") {
    if (!filter_has_var(INPUT_GET, 'id')) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Не выбрана запись для
редактирования</font>");
    }
    $id = filter_input(INPUT_GET, 'id');
//запрос на получение
    $query = "SELECT * FROM Orders WHERE id_Orders=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//данные из таблицы Orders
    $orders = mysql_fetch_assoc($result);
//проверка существования цеха
    $query = "SELECT id_Shop FROM Shop WHERE id_Shop=" . $orders['id_Shop'];
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        $id_shop = 0;
    } else {
        $id_shop = $orders['id_Shop'];
    }
//получение данных о клиенте по id_Client
    $query = "SELECT document FROM Client WHERE id_Client=" . $orders['id_Client'];
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        $client = "Не найдено";
    } else {
        $client = mysql_result($result, 0);
    }
//получение данных о автомобиле по id_Auto
    $query = "SELECT VIN FROM Auto WHERE id_Auto=" . $orders['id_Auto'];
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        $auto = "Не найдено";
    } else {
        $auto = mysql_result($result, 0);
    }
//форматирование даты
    $dat = $orders['dat'];
    $format = 'Y-m-d H:i:s';
    $t = date_parse_from_format($format, $dat);
    $dat = $t['day'] . "." . $t['month'] . "." . $t['year'] . ",
";
    $dat = $dat . $t['hour'] . ":" . $t['minute'] . ":" .
            $t['second'];
//состояние заказа
    $status = $orders['status'];
} else {
//проверка массива GET
    if (!filter_has_var(INPUT_GET, 'id_shop')) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Для добавления заказа
необходимо выбрать цех</font>");
    }
//проверка GET-параметра на пустоту
    $id_shop = filter_input(INPUT_GET, 'id_shop');
    if (!$id_shop) {
        Disconnect($cnt);
        exit("<fontcolor=#f00>Ошибка.Для добавления заказа необходимо
выбрать цех</font>");
    }
//проверка существования выбранного цеха
    $query = "SELECT id_Shop FROM Shop WHERE id_Shop=" . $id_shop;
    $result = mysql_query($query, $cnt);
    if (!mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Указанный цех не
найден</font>");
    }
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=orders&event=add&id_shop=" .
    $id_shop . "\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=orders&id_shop=" . $id_shop
    . "&event=edit&id=" . $id . "\" method=\"POST\">");
}
?>
<table class="add">
    <caption>
        <?php
        $event == "add" ? $caption = "Добавить новую запись" : $caption = "Изменить данные";
        echo($caption);
        ?>
    </caption>
    <tr>
        <td>Клиент<br>Водительское удостоверение(серия,номер)*</td>
        <td><input name="document" type="text"></td>
    </tr>
    <tr>
        <td>Автомобиль (VIN)*</td>
        <td><input name="vin" type="text"></td>
    </tr>
    <tr>
        <td>Работы*</td>
        <td>
            <?php
//если выбрана операция редактирования,то
            //получение списка выполняемых в заказе работ
            if ($event == "edit") {
                $query = "SELECT id_Works FROM WorksOrders WHERE
id_Orders=" . $id;
                $result = mysql_query($query, $cnt);
                if (!$result || !mysql_num_rows($result)) {
                    echo("<fontcolor=#f00>Ошибка.Загрузка информации о выпол-
няемых работах</font>");
                } else {
                    //массив значений id_Works для id_Orders из WorksOrders
                    for ($i = 0; $i < mysql_num_rows($result); $i++) {
                        $works[$i] = mysql_result($result, $i);
                    }
                }
            }
            ?>
            <?php
            //поиск видов работ для указанного цеха id_shop
            $query = "SELECT DISTINCT Works.id_Works, workname FROM " .
                    "Works, Master, MasterWorks, Shop WHERE " .
                    "MasterWorks.id_Works = Works.id_Works AND " .
                    "MasterWorks.id_Master = Master.id_Master AND " .
                    "Master.id_Shop = " . $id_shop;
            $workslist = mysql_query($query, $cnt);
//вывод списка работ
            $n = 0; //количество видов работ
            while ($str = mysql_fetch_assoc($workslist)) {
                ++$n;
                //если выполняется редактирование, то вывод списка
                //в зависимости от выбранных элементов
                if ($event == "edit") {
                    //если элемент найден в массиве выбранных, то отмечаем его
                    if (!empty($works) && in_array($str['id_Works'], $works)) {
                        echo("<input name=\"w$n\" value=" . $str['id_Works'] . "
type=\"checkbox\" checked>" . $str['workname'] . "<br>");
                    } else {
                        echo("<input name=\"w$n\" value=" . $str['id_Works'] . "
type=\"checkbox\">" . $str['workname'] . "<br>");
                    }
                } else {
                    echo("<input name=\"w$n\" value=" . $str['id_Works'] . "
type=\"checkbox\">" . $str['workname'] . "<br>");
                }
            }
            echo "<input type=\"hidden\" name=\"num_work\" value=\"$n\">";
            ?>
        </td>
    </tr>
    <tr>
        <td>Статус</td>
        <td>
            <input name="status" type="radio" value="0">Не готов
            <input name="status" type="radio" value="1">Готов
        </td>
    </tr>
    <tr>
        <td>Дата оформления</td>
        <td><input name="dat" type="text"></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if ($event == "add") {
                echo("<button name=\"func\" value=\"orders_add\"
type=\"submit\">Добавить</button>");
            } else {
                echo("<button name=\"func\" value=\"orders_edit\"
type=\"submit\">Изменить</button>");
            }
            ?>
        </td>
    </tr>
</table>
</form>
<script type="text/javascript">
    function read(vclient, vauto, vstatus, vdat) {
        document.getElementsByName("document")[0].value = vclient;
        document.getElementsByName("vin")[0].value = vauto;
        if (vstatus == 0)
            document.getElementsByName("status")[0].checked = true;
        else
            document.getElementsByName("status")[1].checked = true;
        document.getElementsByName("dat")[0].value = vdat;
        return 0;
    }
    functionshow_date() { //установка текущей даты и времени в "дата оформления";
        var temp, str;
        temp = new Date();
        str = temp.toLocaleString();
        document.getElementsByName("dat")[0].value = str;
    }
</script>
<?php
echo("<script type=\"text/javascript\">");
if ($event == "edit") {
    echo("read(\"$client\", \"$auto\", $status, \"$dat\");");
} else {
    echo("show_date();");
}
echo("</script>");
?>