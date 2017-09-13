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
    $query = "SELECT * FROM Works WHERE id_Works=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//данные из таблицы Works
    $works = mysql_fetch_assoc($result);
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=works&event=add\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=works&event=edit&id=" . $id
    . "\" method=\"POST\">");
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
        <td>Название*</td>
        <td><input name="name" type="text"></td>
    </tr>
    <tr>
        <td>Описание</td>
        <td><textarea name="description" cols="50"
                      rows="8"></textarea></td>
    </tr>
    <tr>
        <td>Срок выполнения*</td>
        <td><input name="dat" type="text">
            <select name="type_dat">
                <option value="1">Минут</option>
                <option value="2">Час</option>
                <option value="3">День</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Цена(руб.)*</td>
        <td><input name="price" type="text"></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if ($event == "add") {
                echo("<button name=\"func\" value=\"works_add\"
type=\"submit\">Добавить</button>");
            } else {
                echo("<button name=\"func\" value=\"works_edit\"
type=\"submit\">Изменить</button>");
            }
            ?>
        </td>
    </tr>
</table>
</form>
<script type="text/javascript">
    function read(vname, vdescription, vdat, vdattype, vprice) {
        n = document.getElementsByName("name")[0];
        description = document.getElementsByName("description")[0];
        dat = document.getElementsByName("dat")[0];
        dattype = document.getElementsByName("type_dat")[0];
        price = document.getElementsByName("price")[0];
        n.value = vname;
        description.value = vdescription;
        dat.value = vdat;
        price.value = vprice;
        switch (vdattype) {
            case 'minutes':
                dattype.value = 1;
                break;
            case 'hours':
                dattype.value = 2;
                break;
            case 'days':
                dattype.value = 3;
                break;
        }
        return 0;
    }
</script>
<?php
if ($event == "edit") {
    $n = $works['workname'];
    $description = $works['description'];
    $dat = $works['dat'];
    $dattype = $works['type_dat'];
    $price = $works['price'];
    echo("<script type=\"text/javascript\">");
    echo("read(\"$n\", \"$description\", \"$dat\", \"$dattype\",
\"$price\")");
    echo("</script>");
}
?>