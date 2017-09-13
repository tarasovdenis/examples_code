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
    $query = "SELECT * FROM Client WHERE id_Client=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//данные из таблиц Client
    $client = mysql_fetch_assoc($result);
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=client&event=add\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=client&event=edit&id=" . $id
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
        <td>ФИО*</td>
        <td><input name="fio" type="text"></td>
    </tr>
    <tr>
        <td>Серия и номер водительского удостоверения*</td>
        <td><input name="document" type="text" placeholder="9876
                   543210"></td>
    </tr>
    <tr>
        <td>Телефон 1*</td>
        <td><input name="phone1" type="text" placeholder="+7(987)6543210"></td>
    </tr>
    <tr>
        <td>Телефон 2</td>
        <td><input name="phone2" type="text" placeholder="+7(987)6543210"></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if ($event == "add") {
                echo("<button name=\"func\" value=\"client_add\"
type=\"submit\">Добавить</button>");
            } else {
                echo("<button name=\"func\" value=\"client_edit\"
type=\"submit\">Изменить</button>");
            }
            ?>
        </td>
    </tr>
</table>
}
</form>
<script type="text/javascript">
    function read(vfio, vdoc, vphone1, vphone2) {
        var fio, doc, phone1, phone2;
        fio = document.getElementsByName("fio")[0];
        doc = document.getElementsByName("document")[0];
        phone1 = document.getElementsByName("phone1")[0];
        phone2 = document.getElementsByName("phone2")[0];
        fio.value = vfio;
        doc.value = vdoc;
        phone1.value = vphone1;
        phone2.value = vphone2;
        return 0;
    }
</script>
<?php
if ($event == "edit") {
    $fio = $client['fio'];
    $doc = $client['document'];
    $phone1 = $client['phone1'];
    if ($client['phone2'] == '0') {
        $phone2 = "";
    } else {
        $phone2 = $client['phone2'];
    }
    echo("<script type=\"text/javascript\">");
    echo("read(\"$fio\", \"$doc\", \"$phone1\", \"$phone2\");");
    echo("</script>");
}
?>