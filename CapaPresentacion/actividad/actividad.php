<script src="../../CapaPresentacion/vendor/js/Jquery.js"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_SESSION['usuario'])) {
    include '../../CapaNegocio/actividadBL/actividadBL.php';
    $activities = new ActividadBL();
    $id_user = $_SESSION['idUser'];
    $arr_activities = $activities->selectAll($id_user);

    if(isset($_POST['btnCrearActividad'])){
        $descripcion = $_POST['txtdescripcion'];
        $id_user = $_SESSION['idUser'];
        $res = $activities->insert($descripcion, $id_user);
        $activities->result($res);
    }

    if(isset($_POST['btnModificarActividad'])){
        $descripcion = $_POST['txtdescripcion'];
        $id = $_POST['id_actividad'];
        $res = $activities->update($descripcion, $id);
        $activities->result($res);
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $res = $activities->delete($id);
        $activities->result($res);
    }
?>
    <div class="col-12 col-xs-12 col-sm-12 col-md-12 pb-3">
        <form action="home.php?mod=actividades" method="POST">
            <div class="container text-center pb-3 mt-3">
                <h3><i class="fas fa-users"></i>&nbsp;GESTIÓN ACTIVIDAD</h3>
            </div>
            <?php
            if (isset($_POST['btnModificar'])) {
                $id = $_POST['id_actividad'];
                $arr_activity = $activities->select($id);
                foreach ($arr_activity as $item2) {
                    $cantidad = count($arr_activity);
            ?>
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12">
                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="txtdescripcion" value="<?php echo $item2['descripcion']; ?>" required>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12">
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Descripción</label>
                            <input type="text" class="form-control" name="txtdescripcion" required>
                        </div>
                    </div>
                </div>
                <?php
            }
                ?>
                <div class="row justify-content-center align-items-center">
                    <?php
                    if (isset($_POST['btnModificar'])) {
                    ?>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-end">
                            <button type="submit" name="btnModificarActividad" class="btn btn-outline-primary btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Modificar</button>
                            <input type="number" name="id_actividad" value="<?php echo $item2['id']; ?>" hidden />
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" onclick="refresh()" class="btn btn-outline-danger btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Cancelar</button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-end">
                            <button type="submit" name="btnCrearActividad" class="btn btn-outline-primary btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Guardar</button>
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button type="reset" class="btn btn-outline-danger btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Cancelar</button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
        </form>
        <br>
        <div class="table-responsive-md col-md-12 mt-3">
            <table class="table table-sm table-bordered table-striped text-center" id="actividad" data-page-length='5' style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Actividad</th>
                        <th scope="col">Modificar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($arr_activities as $item) {
                        $cantidad = count($arr_activities);
                    ?>
                        <tr>
                            <td><?php echo $item['descripcion']; ?></td>
                            <td>
                                <form action="home.php?mod=actividades" method="post">
                                    <input type="number" name="id_actividad" value="<?php echo $item['id']; ?>" hidden />
                                    <button type="submit" class="btn btn-primary" name="btnModificar"><i class="fas fa-edit"></i></button>
                                </form>
                            </td>
                            <td>
                                <input type="number" id="eliminaract" name="id_actividad" value="<?php echo $item['id']; ?>" hidden />
                                <button type="button" class="btn btn-danger eliminarActividad"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../vendor/js/script.js"></script>
<?php
} else {
    header('location: ../usuario/login.php');
}
?>