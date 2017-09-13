<?php
//проверка сущестования события
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
    $id = (int) filter_input(INPUT_GET, 'id');
//запрос на получение
    $query = "SELECT * FROM Shop WHERE id_Shop=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//данные из таблицы Shop
    $shop = mysql_fetch_assoc($result);
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=shop&event=add\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=shop&event=edit&id=" . $id .
    "\" method=\"POST\">");
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
        <td>Описание</td>
        <td><input name="description" type="text"></td>
    </tr>
    <tr>
        <td>Адрес*</td>
        <td><input name="address" type="text"></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if ($event == "add") {
                echo("<button name=\"func\" value=\"shop_add\"
type=\"submit\">Добавить</button>");
            } else {
                echo("<button name=\"func\" value=\"shop_edit\"
type=\"submit\">Изменить</button>");
            }
            ?>
        </td>
    </tr>
</table>
</form>
<script type="text/javascript">
    //запись входных данных в поля ввода
    function read(vdescription, vaddress) {
        var description, address;
        description = document.getElementsByName("description")[0];
        address = document.getElementsByName("address")[0];
        description.value = vdescription;
        address.value = vaddress;
        return 0;
    }
</script>
<?php
if ($event == "edit") {
//запись данных в поля ввода
    $description = $shop['description'];
    $address = $shop['address'];
    echo("<script type=\"text/javascript\">");
    echo("read(\"$description\", \"$address\");");
    echo("</script>");
}
?>
