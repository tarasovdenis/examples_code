<?php

require_once("../interface.handing.php");
require_once("../interface.returnmsg.php");
require_once("../class.workdb.php");

class Confirm extends ConnectDB implements Handing, ReturnMsg {

    private $status;

    function __constructor($host, $username, $passw, $dbname) {
        parent::__constructor($host, $username, $passw, $dbname);
    }

    function handing() {
        $id = $_POST['id'];
        
        $query = "SELECT status FROM orders WHERE id=" . $id;
        $result_query = $this->query($query);
        if ($result_query->num_rows) {
            $row = $result_query->fetch_assoc();
            if ($row['status'] == '0') {
                $query = "UPDATE orders SET status=1 WHERE id=" . $id;
                if ($this->query($query)) {
                    $this->status = true;
                }
            } else if ($row['status'] == '1') {
                $query = "UPDATE orders SET status=0 WHERE id=" . $id;
                if ($this->query($query)) {
                    $this->status = false;
                }
            }
        }
    }

    function returnMsg() {
        if ($this->status) {
            echo "1";
        } else {
            echo "0";
        }
    }

}

?>