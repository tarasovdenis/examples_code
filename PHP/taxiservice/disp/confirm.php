<?php
    require_once("class.confirm.php");
    
    $mysqli = new Confirm("localhost", "root", "", "taxiservice");
    $mysqli->set_charset("utf8");
    $mysqli->handing();
    $mysqli->returnMsg();
    
    $mysqli->close();
?>

