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
    $query = "SELECT * FROM Master WHERE id_Master=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//данные из таблицы Master
    $master = mysql_fetch_assoc($result);
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=master&event=add\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=master&event=edit&id=" . $id
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
        <td>Табельный номер (до 7 цифр)*</td>
        <td><input name="document" type="text"></td>
    </tr>
    }
    <tr>
        <td>Выбрать цех*</td>
        <td>
            <?php
            //получение и вывод списка цехов
            $query = "SELECT id_shop, address FROM Shop"; //запрос
            $result = mysql_query($query, $cnt); //выполнение запроса
//проверка результатов
            if (mysql_num_rows($result)) {
                //если данные существуют, то
                //вывод списка
                $i = 0;
                echo "<select name=\"id_shop\">";
                echo "<option value=\"0\">Выбрать...</option>";
                while ($option = mysql_fetch_assoc($result)) {
                    ++$i;
                    echo "<option value=" . $option['id_shop'] . ">" . $i . ".
" . $option['address'] . "</option>";
                }
                echo "</select>";
            } else {
                //если проверка завершилась неудачей
                echo "<fontcolor=#00f>Данные о цехах отсутствуют</font>";
            }
            ?>
        </td>
    </tr>
    <tr>
    <tdvalign="top">Список выполняемых работ</td>
        <td>
            <?php
            //если выбрана операция редактирования,то
            //получение списка выполняемых мастером работ
            if ($event == "edit") {
                $query = "SELECT id_Works FROM MasterWorks WHERE id_Master=" .
                        $id;
                $result = mysql_query($query, $cnt);
                if (!$result || !mysql_num_rows($result)) {
                    echo("<fontcolor=#f00>Ошибка.Загрузка информации о выпол-
няемых работах</font>");
                } else {
                    //массив значений id_Works для id_Master из MasterWorks
                    for ($i = 0; $i < mysql_num_rows($result); $i++) {
                        $works[$i] = mysql_result($result, $i);
                    }
                }
            }
            ?>
            <?php
            //получение и вывод списка выполняемых работ
            $query = "SELECT id_Works, workname FROM Works"; //запрос
            $result = mysql_query($query, $cnt); //выполнение запроса
            if (mysql_num_rows($result)) {
//если данные существуют, то
                //вывод списка видов работ
                $i = 0;
                while ($option = mysql_fetch_assoc($result)) {
                    ++$i;
                    //если выполняется редактирование, то вывод списка
                    //в зависимости от выбранных элементов
                    if ($event == "edit") {
                        //если элемент найден в массиве выбранных, то отмечаем его
                        if (!empty($works) && in_array($option['id_Works'], $works)) {
                            echo "<input name=\"w$i\" value=\"" . $option['id_Works']
                            . "\" type=\"checkbox\" checked>" . $option['workname']
                            . "<br>";
                        } else {
                            echo "<input name=\"w$i\" value=\"" . $option['id_Works']
                            . "\" type=\"checkbox\">" . $option['workname']
                            . "<br>";
                        }
                    } else {
                        echo "<input name=\"w$i\" value=\"" . $option['id_Works']
                        . "\" type=\"checkbox\">" . $option['workname'] . "<br>";
                    }
                }
                //общее количество работ (для обработки данных)
                echo "<input type=\"hidden\" name=\"num_work\" value=\"$i\">";
            } else {
                //если проверка завершилась неудачей
                echo "<fontcolor=#00f>Список работ отсутствует</font>";
            }
            ?>
        </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                if ($event == "add") {
                    echo("<button name=\"func\" value=\"master_add\"
type=\"submit\">Добавить</button>");
                } else {
                    echo("<button name=\"func\" value=\"master_edit\"
type=\"submit\">Изменить</button>");
                }
                ?>
            </td>
        </tr>
</table>
</form>
<script type="text/javascript">
    function read(vfio, vdoc, vshop) {
        document.getElementsByName("fio")[0].value = vfio;
        document.getElementsByName("document")[0].value = vdoc;
        document.getElementsByName("id_shop")[0].value = vshop;
        return 0;
    }
</script>
<?php
if ($event == "edit") {
    $fio = $master['fio'];
    $document = $master['document'];
    $id_shop = $master['id_Shop'];
    echo("<script type=\"text/javascript\">");
    echo("read(\"$fio\", \"$document\", \"$id_shop\");");
    echo("</script>");
}
?>