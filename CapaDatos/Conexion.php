<?php

require_once('config.php');

class Conexion{
    protected $conexion;
    //declaro el constructor
    public function __construct()
    {
        //Realizo conexion a la base de datos
        $this->conexion = new mysqli(DB_PASS,DB_USER,DB_PASS,DB_NAME);

        if($this->conexion->connect_errno){
            echo "Fallo la conexión a la base de datos";
            exit();
        }
        $this->conexion->set_charset('DB_CHARSET');
    }

    public function sanitize($var){
        $return = mysqli_real_escape_string($this->conexion, $var);
        return $return;
    }
}

?>