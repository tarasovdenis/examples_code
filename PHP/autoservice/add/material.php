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
    $query = "SELECT * FROM Material WHERE id_Material=" . $id;
    $result = mysql_query($query, $cnt);
    if (!$result || !mysql_num_rows($result)) {
        Disconnect($cnt);
        exit("<font color=#f00>Ошибка.Получение редактируемых
данных</font>");
    }
//данные из таблицы Material
    $material = mysql_fetch_assoc($result);
}
?>
<?php
if ($event == "add") {
    echo("<form action=\"../add/?page=material&event=add\" method=\"POST\">");
} else {
    echo("<form action=\"../add/?page=material&event=edit&id=" .
    $id . "\" method=\"POST\">");
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
        <td>Описание*</td>
        <td><input name="description" type="text"></td>
    </tr>
    <tr>
        <td>Цена(руб.)*</td>
        <td><input name="price" type="text"></td>
    </tr>
    <tr>
    <tdvalign="top">Применение (виды работ)*</td>
        <td>
            <?php
            //если выбрана операция редактирования,то
            //получение списка применяемых работ
            if ($event == "edit") {
                $query = "SELECT id_Works FROM MaterialWorks WHERE
id_Material=" . $id;
                $result = mysql_query($query, $cnt);
                if (!$result || !mysql_num_rows($result)) {
                    echo("<fontcolor=#0f0>Отсутствует информации о выполняемых
работах<br></font>");
                } else {
                    //массив значений id_Works для id_Material из MaterialWorks
                    for ($i = 0; $i < mysql_num_rows($result); $i++) {
                        $works[$i] = mysql_result($result, $i);
                    }
                }
            }
            ?>
            <?php
            //получение списка применяемых видов работ
            $query = "SELECT id_Works, workname FROM Works"; //запрос
            $result = mysql_query($query, $cnt); //выполнение запроса
            if (mysql_num_rows($result)) {
//если данные существуют, то
                //вывод списка
                $i = 0;
                while ($option = mysql_fetch_assoc($result)) {
                    ++$i;
                    //если выполняется редактирование, то вывод списка
                    //в зависимости от выбранных элементов
                    if ($event == "edit") {
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
                    echo("<button name=\"func\" value=\"material_add\"
type=\"submit\">Добавить</button>");
                } else {
                    echo("<button name=\"func\" value=\"material_edit\"
type=\"submit\">Изменить</button>");
                }
                ?>
            </td>
        </tr>
</table>
</form>
<script type="text/javascript">
    function read(vname, vdescription, vprice) {
        document.getElementsByName("name")[0].value = vname;
        document.getElementsByName("description")[0].value = vdescription;
        document.getElementsByName("price")[0].value = vprice;
        return 0;
    }
</script>
<?php
if ($event == "edit") {
    $name = $material['name'];
    $description = $material['description'];
    $price = $material['price'];
    echo("<script type=\"text/javascript\">");
    echo("read(\"$name\", \"$description\", \"$price\");");
    echo("</script>");
}
?>