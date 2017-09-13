<?php
    //создание соединения с БД
    class ConnectDB extends mysqli{
        public function __constructor($host, $username, $passw, $dbname){
            parent::__construct($host, $username, $passw, $dbname);
            
            if(mysqli_connect_error()){
                exit("Ошибка подключения 'mysqli_connect_error()': " . mysqli_connect_error());
            }
        }
    }
    
    
?>

