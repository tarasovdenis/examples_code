<?php

require_once("class.workdb.php");
require_once("class.add.php");

//соединение с БД
$mysqli = new AddData("localhost", "root", "", "taxiservice");
$mysqli->set_charset("utf8");
$mysqli->handing();
$mysqli->returnMsg();

//закрытие соединения
$mysqli->close();
?>

