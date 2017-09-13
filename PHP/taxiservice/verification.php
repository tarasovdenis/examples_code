<?php

require_once("class.workdb.php");
require_once("class.verification.php");

//соединение с БД
$mysqli = new Verification("localhost", "root", "", "taxiservice");
$mysqli->set_charset("utf8");
$mysqli->handing();
$mysqli->returnMsg();

//закрытие соединения
$mysqli->close();
?>

