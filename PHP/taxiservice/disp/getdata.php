<?php
    require_once("class.loadtable.php");
    
    $mysqli = new LoadTable("localhost", "root", "", "taxiservice");
    $mysqli->set_charset("utf8");
    $mysqli->handing();
    $mysqli->returnMsg();
    
    $mysqli->close();
?>
