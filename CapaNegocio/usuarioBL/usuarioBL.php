<?php
include_once '../../CapaDatos/Conexion.php';

class UsuarioBL extends Conexion {
    public function selectAll()
    {
        $stmt = $this->conexion->prepare("CALL sp_User_SelectAll()");
        $stmt->execute();
        $res = $stmt->get_result();
        $usuarios = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $usuarios;
    }

    public function select($var)
    {   
        $conn = new Conexion();
        $id = $conn->sanitize($var);
        $stmt = $this->conexion->prepare("CALL sp_User_Select(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $usuarios = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $usuarios;
    }

    public function insert($nombre, $identificacion, $perfil, $pass)
    {
        $conn = new Conexion();
        $var_nombre = $conn->sanitize($nombre);
        $var_identificacion = $conn->sanitize($identificacion);
        $var_perfil = $conn->sanitize($perfil);
        $var_pass = $conn->sanitize($pass);
        $fecha_crea = date('Y-m-d');
        $estado = 1;
        $stmt = $this->conexion->prepare("CALL sp_User_Insert(?,?,?,?,?,?)");
        $stmt->bind_param("sssisi", $var_nombre, $var_identificacion, $var_pass, $var_perfil, $fecha_crea, $estado);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
    }

    public function update($id, $nombre, $identificacion, $perfil, $pass, $estado)
    {
        $conn = new Conexion();
        $var_id = $conn->sanitize($id);
        $var_nombre = $conn->sanitize($nombre);
        $var_identificacion = $conn->sanitize($identificacion);
        $var_perfil = $conn->sanitize($perfil);
        $var_pass = $conn->sanitize($pass);
        $var_estado = $conn->sanitize($estado);
        $fecha_mod = date('Y-m-d');
        $stmt = $this->conexion->prepare("CALL sp_User_Update(?,?,?,?,?,?,?)");
        $stmt->bind_param("sssisii", $var_nombre, $var_identificacion, sha1($var_pass), $var_perfil, $fecha_mod, $var_estado, $var_id);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
    }

    public function result($res){
        if($res){     
            echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong> Ejecutando... Datos Actualizados con éxito</strong>
            </button>
            </div>';           
        }else{   
            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>No se actualizaron los datos</strong>
            </button>
            </div>';   
        }
        echo "<script>
        $(document).ready(function() {
        setTimeout(function() {
            $('.alert').alert('close');
        }, 1000);
         
        setTimeout(function() {
            window.location.href = 'home.php?mod=usuarios';
        }, 1000); 
        });
        </script>";
    }
}
