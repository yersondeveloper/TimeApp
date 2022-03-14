<script src="../../CapaPresentacion/vendor/js/Jquery.js"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_SESSION['usuario'])) {
    include '../../CapaNegocio/actividadBL/actividadBL.php';
    include '../../CapaNegocio/actividadBL/tiempoBL.php';
    $activities = new ActividadBL();
    $id_user = $_SESSION['idUser'];
    $arr_actividad = $activities->selectAll($id_user);
    $time = new TiempoBL();
    $arr_times = $time->selectAll($id_user);

    if (isset($_POST['btnCrearTiempo'])) {
        $actividad = $_POST['cmbIdActividad'];
        $fecha = $_POST['txtfecha'];
        $horas = $_POST['cmbHoras'];
        $validacion = $time->sumaHoras($actividad);
        foreach ($validacion as $row){
            $sumHoras = $row['horas'];
        }
        if($sumHoras == 8){
            $time->validacion(1);
        }else{
            $totalHoras = ($sumHoras + $horas);
            if($totalHoras > 8){
                $time->validacion(2);
            }else{
                $res = $time->insert($actividad, $fecha, $horas);
                $time->result($res);
            }
        }
    }

    if (isset($_POST['btnModificarTiempo'])) {
        $id = $_POST['id_tiempo'];
        $actividad = $_POST['cmbIdActividad'];
        $fecha = $_POST['txtfecha'];
        $horas = $_POST['cmbHoras'];
        $validacion = $time->sumaHoras($actividad);
        foreach ($validacion as $row){
            $sumHoras = $row['horas'];
        }
        $arr_tiempo = $time->select($id);
        foreach ($arr_tiempo as $row2){
            $horaenBD = $row2['horas'];
        }
        $totalHoras = ($sumHoras - $horaenBD);
        $totalHoras = ($totalHoras + $horas);
        if($totalHoras > 8){
            $time->validacion(2);
        }else{
            $res = $time->update($id, $actividad, $fecha, $horas);
            $time->result($res);
        }
    }

    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $res = $time->delete($id);
        $time->result($res);
    }
?>
    <div class="col-12 col-xs-12 col-sm-12 col-md-12 pb-3">
        <form action="home.php?mod=tiempos" method="POST">
            <div class="container text-center pb-3 mt-3">
                <h3><i class="fas fa-clock"></i>&nbsp;GESTIÓN TIEMPOS</h3>
            </div>
            <?php
            if (isset($_POST['btnModificar'])) {
                $id = $_POST['id_tiempo'];
                $arr_time = $time->select($id);
                foreach ($arr_time as $item2) {
                    $cantidad = count($arr_time);
            ?>
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label for="Perfil" class="form-label">Actividad</label>
                                <select class="form-select" name="cmbIdActividad" required>
                                    <option value="">Seleccionar actividad</option>
                                    <?php foreach ($arr_actividad as $op) :
                                        if ($item2['id_actividad'] == $op['id']) {
                                            echo "<option value=" . $op['id'] . " selected>";
                                            echo $op['descripcion'];
                                            echo "</option>";
                                        } else {
                                            echo "<option value=" . $op['id'] . ">";
                                            echo $op['descripcion'];
                                            echo "</option>";
                                        }
                                    ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="txtfecha" value="<?php echo $item2['fecha']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label for="Perfil" class="form-label">Horas</label>
                                <select class="form-select" name="cmbHoras" required>
                                    <option value="">Seleccionar Actividad</option>
                                    <option value="1" <?php if ($item2['horas'] == "1") { echo 'selected="selected"';} ?>>1 hora</option>
                                    <option value="2" <?php if ($item2['horas'] == "2") { echo 'selected="selected"';} ?>>2 horas</option>
                                    <option value="3" <?php if ($item2['horas'] == "3") { echo 'selected="selected"';} ?>>3 horas</option>
                                    <option value="4" <?php if ($item2['horas'] == "4") { echo 'selected="selected"';} ?>>4 horas</option>
                                    <option value="5" <?php if ($item2['horas'] == "5") { echo 'selected="selected"';} ?>>5 horas</option>
                                    <option value="6" <?php if ($item2['horas'] == "6") { echo 'selected="selected"';} ?>>6 horas</option>
                                    <option value="7" <?php if ($item2['horas'] == "7") { echo 'selected="selected"';} ?>>7 horas</option>
                                    <option value="8" <?php if ($item2['horas'] == "8") { echo 'selected="selected"';} ?>>8 horas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                        <div class="mb-3">
                            <label for="Perfil" class="form-label">Actividad</label>
                            <select class="form-select" name="cmbIdActividad" required>
                                <option value="">Seleccionar actividad</option>
                                <?php foreach ($arr_actividad as $op) : ?>
                                    <option value="<?= $op['id'] ?>"><?= $op['descripcion']; ?></option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                        <div class="mb-3">
                            <label for="Fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="txtfecha" required>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                        <div class="mb-3">
                            <label for="Perfil" class="form-label">Perfil</label>
                            <select class="form-select" name="cmbHoras" required>
                                <option value="">Seleccionar Actividad</option>
                                <option value="1">1 hora</option>
                                <option value="2">2 horas</option>
                                <option value="3">3 horas</option>
                                <option value="4">4 horas</option>
                                <option value="5">5 horas</option>
                                <option value="6">6 horas</option>
                                <option value="7">7 horas</option>
                                <option value="8">8 horas</option>
                            </select>
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
                        <button type="submit" name="btnModificarTiempo" class="btn btn-outline-primary btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Modificar</button>
                        <input type="number" name="id_tiempo" value="<?php echo $item2['id']; ?>" hidden />
                    </div>
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" onclick="refresh()" class="btn btn-outline-danger btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Cancelar</button>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-end">
                        <button type="submit" name="btnCrearTiempo" class="btn btn-outline-primary btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Guardar</button>
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
                        <th scope="col">Fecha</th>
                        <th scope="col">Horas</th>
                        <th scope="col">Modificar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($arr_times as $item) {
                        $cantidad = count($arr_times);
                    ?>
                        <tr>
                            <td><?php echo $item['descripcion']; ?></td>
                            <td><?php echo $item['fecha']; ?></td>
                            <td><?php echo $item['horas']; ?></td>
                            <td>
                                <form action="home.php?mod=tiempos" method="post">
                                    <input type="number" name="id_tiempo" value="<?php echo $item['id']; ?>" hidden />
                                    <button type="submit" class="btn btn-primary" name="btnModificar"><i class="fas fa-edit"></i></button>
                                </form>
                            </td>
                            <td>
                                <input type="number" id="eliminar" name="id_tiempo" value="<?php echo $item['id']; ?>" hidden />
                                <button type="button" class="btn btn-danger eliminarTiempo"><i class="fas fa-trash-alt"></i></button>
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