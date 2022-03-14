<?php
require_once "../../CapaDatos/Conexion.php";

class GetUser extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }
    //consulto el usario en la bd
    public function Get()
    {   
        $conn = new Conexion();
        $user = $conn->sanitize($_POST['txtUsuario']);
        $pass = $conn->sanitize($_POST['txtPassword']);
        $stmt = $this->conexion->prepare("CALL sp_GetUser(?,?)");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $res = $stmt->get_result();
        $usuario = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->fetch();
        $stmt->close();
        
        return $usuario;
    }
}
