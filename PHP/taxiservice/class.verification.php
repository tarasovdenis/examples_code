<?php

require_once("interface.handing.php");
require_once("interface.returnmsg.php");

class Verification extends ConnectDB implements Handing, ReturnMsg{
    private $row;
    
    public function __constructor($host, $username, $passw, $dbname) {
        parent::__constructor($host, $username, $passw, $dbname);
    }
    
    function handing() {
        $id = $_POST['id'];
        
        $query = "SELECT status FROM orders WHERE id=".$id;
        $res = $this->query($query);
        $this->row = $res->fetch_assoc();
    }
    
    function returnMsg(){
        $arr = array('status'=>$this->row['status']);
        echo json_encode($arr);
    }
}

?>

