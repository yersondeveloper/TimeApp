<?php

class TiempoBL extends Conexion {
    public function selectAll($id)
    {   
        $conn = new Conexion();
        $id_user = $conn->sanitize($id);
        $stmt = $this->conexion->prepare("CALL sp_ActivityTime_SelectAll(?)");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $res = $stmt->get_result();
        $tiempos = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $tiempos;
    }

    public function select($var)
    {   
        $conn = new Conexion();
        $id = $conn->sanitize($var);
        $stmt = $this->conexion->prepare("CALL sp_ActivityTime_Select(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $tiempo = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $tiempo;
    }

    public function insert($id_actividad, $fecha, $horas)
    {
        $conn = new Conexion();
        $var_actividad = $conn->sanitize($id_actividad);
        $var_fecha = $conn->sanitize($fecha);
        $var_horas = $conn->sanitize($horas);
        $estado = 1;
        $stmt = $this->conexion->prepare("CALL sp_ActivityTime_Insert(?,?,?,?)");
        $stmt->bind_param("isii", $var_actividad, $var_fecha, $var_horas, $estado);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
    }

    public function sumaHoras($act){
        $conn = new Conexion();
        $var_actividad = $conn->sanitize($act);
        $stmt = $this->conexion->prepare("CALL sp_ActivityTime(?)");
        $stmt->bind_param("i", $var_actividad);
        $stmt->execute();
        $res = $stmt->get_result();
        $tiempo = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $tiempo;
    }

    public function update($id, $actividad, $fecha, $horas)
    {
        $conn = new Conexion();
        $var_actividad = $conn->sanitize($actividad);
        $var_fecha = $conn->sanitize($fecha);
        $var_horas = $conn->sanitize($horas);
        $var_id = $conn->sanitize($id);
        $stmt = $this->conexion->prepare("CALL sp_ActivityTime_Update(?,?,?,?)");
        $stmt->bind_param("isii", $var_actividad, $var_fecha, $var_horas, $var_id);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
    }

    public function delete($id)
    {
        $conn = new Conexion();
        $var_id = $conn->sanitize($id);
        $stmt = $this->conexion->prepare("CALL sp_ActivityTime_Delete(?)");
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
            window.location.href = 'home.php?mod=tiempos';
        }, 1000); 
        });
        </script>";
    }

    public function validacion($num){
        switch ($num) {
            case 1 :
                echo'<script type="text/javascript">Swal.fire({
                    title: "La actividad ya completó las 8 horas",
                    text: "Por favor verifique la información.",
                    type: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar",
                    allowOutsideClick: false,
                    }).then((result) => {
                    if (result.value) {
                    window.location="home.php?mod=tiempos";
                    }
                    });</script>';
                break;
            
            case 2 :
                echo'<script type="text/javascript">Swal.fire({
                    title: "El tiempo ingresado sobrepasa las 8 horas.",
                    text: "Por favor verifique la información.",
                    type: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar",
                    allowOutsideClick: false,
                    }).then((result) => {
                    if (result.value) {
                    window.location="home.php?mod=tiempos";
                    }
                    });</script>';
                break;
        }
    }
}
