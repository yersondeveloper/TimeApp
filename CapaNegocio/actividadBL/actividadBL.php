<?php
include '../../CapaDatos/Conexion.php';

class ActividadBL extends Conexion {
    public function selectAll($id)
    {   
        $conn = new Conexion();
        $id_user = $conn->sanitize($id);
        $stmt = $this->conexion->prepare("CALL sp_Activity_SelectAll(?)");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $res = $stmt->get_result();
        $actividades = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $actividades;
    }

    public function select($var)
    {   
        $conn = new Conexion();
        $id = $conn->sanitize($var);
        $stmt = $this->conexion->prepare("CALL sp_Activity_Select(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $actividad = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $actividad;
    }

    public function insert($descripcion, $idUser)
    {
        $conn = new Conexion();
        $var_descripcion = $conn->sanitize($descripcion);
        $var_idUser = $conn->sanitize($idUser);
        $stmt = $this->conexion->prepare("CALL sp_Activity_Insert(?,?)");
        $stmt->bind_param("si", $var_descripcion, $var_idUser);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
    }

    public function update($descripcion,$id)
    {
        $conn = new Conexion();
        $var_descripcion = $conn->sanitize($descripcion);
        $var_id = $conn->sanitize($id);
        $stmt = $this->conexion->prepare("CALL sp_Activity_Update(?,?)");
        $stmt->bind_param("si", $var_descripcion, $var_id);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
    }

    public function delete($id)
    {
        $conn = new Conexion();
        $var_id = $conn->sanitize($id);
        $stmt = $this->conexion->prepare("CALL sp_Activity_Delete(?)");
        $stmt->bind_param("i", $var_id);
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
            window.location.href = 'home.php?mod=actividades';
        }, 1000); 
        });
        </script>";
    }
}
