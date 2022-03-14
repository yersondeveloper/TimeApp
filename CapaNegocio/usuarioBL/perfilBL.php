<?php
include_once '../../CapaDatos/Conexion.php';

class PerfilBL extends Conexion {
    public function selectAll()
    {
        $stmt = $this->conexion->prepare("CALL sp_Perfil_SelectAll()");
        $stmt->execute();
        $res = $stmt->get_result();
        $perfiles = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->fetch();
        $stmt->close();

        return $perfiles;
    }
}
?>