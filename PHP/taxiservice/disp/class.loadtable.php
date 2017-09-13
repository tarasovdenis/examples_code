<?php

require_once("../class.workdb.php");
require_once("../interface.returnmsg.php");
require_once("../interface.handing.php");

class LoadTable extends ConnectDB implements Handing, ReturnMsg {

    private $rows = array();
    private $flag = false;

    function __constructor($host, $username, $passw, $dbname) {
        parent::__constructor($host, $username, $passw, $dbname);
    }

    function handing() {
        $num_row = $_POST['num_row'];

        $query = "SELECT * FROM orders";
        $result_query = $this->query($query);

        if ($result_query->num_rows) {
            if ($result_query->num_rows > $num_row) {
                $result_query->data_seek($num_row);
                $this->flag = true;
                while ($row = $result_query->fetch_assoc()) {
                    array_push($this->rows, $row);
                }
                $this->flag = true;
            } else {
                $this->flag = false;
            }
        }
    }

    function returnMsg() {
        if ($this->flag) {
            echo json_encode($this->rows, JSON_UNESCAPED_UNICODE);
        } else {
            echo "not";
        }
    }

}
?>

