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
        Disconnect();
        exit("<fontcolor=#f00>Ошибка.Не выбрана запись для редактирова-
ния</font>");
    }
    $id = (int) filter_input(INPUT_GET, 'id');
//запрос на получение
    $query = "SELECT * FROM Auto WHERE id_Auto=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//получение данных о автомобиле
    $auto = mysql_fetch_assoc($result);
//получение данных о владельце
    $query = "SELECT document FROM Client WHERE id_Client=" . $auto['id_Client'];
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        $client = "Не найдено";
    } else {
        $client = mysql_result($result, 0);
    }
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=auto&event=add\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=auto&event=edit&id=" . $id .
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
        <td>VIN*</td>
        <td><input name="vin" type="text"></td>
    </tr>
    <tr>
        <td>Марка/Модель*</td>
        <td><input name="model" type="text"></td>
    </tr>
    <tr>
        <td>Государственный номер*</td>
        <td><input name="number" type="text"></td>
    </tr>
    <tr>
        <td>Серия и номер<br>водительского удостоверения владель-
            ца*</td>
        <td><input name="document" type="text"></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if ($event == "add") {
                echo("<button name=\"func\" value=\"auto_add\"
type=\"submit\">Добавить</button>");
            } else {
                echo("<button name=\"func\" value=\"auto_edit\"
type=\"submit\">Изменить</button>");
            }
            ?>
        </td>
    </tr>
</table>
</form>
<script type="text/javascript">
    function read(vvin, vmodel, vnumber, vdoc) {
        var vin, model, number, doc;
        vin = document.getElementsByName("vin")[0];
        model = document.getElementsByName("model")[0];
        number = document.getElementsByName("number")[0];
        doc = document.getElementsByName("document")[0];
        vin.value = vvin;
        model.value = vmodel;
        number.value = vnumber;
        doc.value = vdoc;
        return 0;
    }
</script>
<?php
if ($event == "edit") {
    $vin = $auto['VIN'];
    $model = $auto['model'];
    $number = $auto['st_num'];
//+$client
    echo("<script type=\"text/javascript\">");
    echo("read(\"$vin\", \"$model\", \"$number\", \"$client\")");
    echo("</script>");
}
?>
