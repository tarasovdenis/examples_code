<?php

require_once("interface.returnmsg.php");
require_once("interface.handing.php");

class AddData extends ConnectDB implements Handing, ReturnMsg {

    private $fio,
            $email,
            $departure,
            $destination,
            $car,
            $status,
            $id;

    public function __constructor($host, $username, $passw, $dbname) {
        parent::__constructor($host, $username, $passw, $dbname);
    }

    function handing() {
        //получение данных из $_POST
        $this->fio = $_POST['fio'];
        $this->email = $_POST['email'];
        $this->departure = $_POST['departure'];
        $this->destination = $_POST['destination'];
        $this->car = $_POST['car'];
        $this->status = 'false';

        $query = "INSERT INTO orders VALUE(" .
                "0,'" . $this->fio . "','" . $this->email . "','" . $this->departure . "','" . $this->destination .
                "','" . $this->car . "'," . $this->status . ")";

        //выполнение запроса
        $this->query($query);
        //получение id записи
        $this->id = $this->insert_id;
    }

    function returnMsg() {
        $arr = array('fio'=>$this->fio, 'email'=>$this->email, 
            'departure'=>$this->departure, 'destination'=>$this->destination, 
            'car'=>$this->car, 'status'=> $this->status, 'id'=>$this->id);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

}
