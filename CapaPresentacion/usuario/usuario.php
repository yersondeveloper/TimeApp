<script src="../../CapaPresentacion/vendor/js/jQuery.js"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_SESSION['usuario'])) {
    include_once '../../CapaNegocio/usuarioBL/usuarioBL.php';
    include_once '../../CapaNegocio/usuarioBL/perfilBL.php';
    $users = new UsuarioBL();
    $arr_users = $users->selectAll();
    $perfiles = new PerfilBL();
    $arr_perfiles = $perfiles->selectAll();

    if (isset($_POST['btnCrearUsuario'])) {
        $nombre = $_POST['txtnombre'];
        $identificacion = $_POST['txtidentificacion'];
        $perfil = $_POST['cmbIdPerfil'];
        $pass = $_POST['txtpassword'];
        $estado = $_POST['cmbEstado'];
        $res = $users->insert($nombre, $identificacion, $perfil, $pass, $estado);
        $users->result($res);
    }

    if (isset($_POST['btnModificarUsuario'])) {
        $id = $_POST['id_usuario'];
        $nombre = $_POST['txtnombre'];
        $identificacion = $_POST['txtidentificacion'];
        $perfil = $_POST['cmbIdPerfil'];
        $pass = $_POST['txtpassword'];
        $estado = $_POST['cmbEstado'];
        $res = $users->update($id, $nombre, $identificacion, $perfil, $pass, $estado);
        $users->result($res);
    }
?>
    <div class="col-12 col-xs-12 col-sm-12 col-md-12 pb-3">
        <form action="home.php?mod=usuarios" method="POST">
            <div class="container text-center pb-3 mt-3">
                <h3><i class="fas fa-users"></i>&nbsp;GESTIÓN USUARIOS</h3>
            </div>
            <?php
            if (isset($_POST['btnModificar'])) {
                $id = $_POST['id_usuario'];
                $arr_user = $users->select($id);
                foreach ($arr_user as $item2) {
                    $cantidad = count($arr_user);
            ?>
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="txtnombre" value="<?php echo $item2['nombre']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="Identificación" class="form-label">Identificación</label>
                                <input type="text" class="form-control" name="txtidentificacion" value="<?php echo $item2['identificacion']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label for="Perfil" class="form-label">Perfil</label>
                                <select class="form-select" name="cmbIdPerfil" required>
                                    <option value="">Seleccionar Perfil</option>
                                    <?php foreach ($arr_perfiles as $op) :
                                        if ($item2['id_perfil'] == $op['id']) {
                                            echo "<option value=" . $op['id'] . " selected>";
                                            echo $op['nombre'];
                                            echo "</option>";
                                        } else {
                                            echo "<option value=" . $op['id'] . ">";
                                            echo $op['nombre'];
                                            echo "</option>";
                                        }
                                    ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label for="Contraseña" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="txtpassword" value="<?php echo $item2['password']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label for="Estado" class="form-label">Estado</label>
                                <select class="form-select" name="cmbEstado" required>
                                    <option value="">Seleccionar Perfil</option>
                                    <option value="1" <?php if ($item2['estado'] == "1") { echo 'selected="selected"';} ?>>Activo</option>
                                    <option value="0" <?php if ($item2['estado'] == "0") { echo 'selected="selected"';} ?>>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="txtnombre" required>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="Identificación" class="form-label">Identificación</label>
                            <input type="text" class="form-control" name="txtidentificacion" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                        <div class="mb-3">
                            <label for="Perfil" class="form-label">Perfil</label>
                            <select class="form-select" name="cmbIdPerfil" required>
                                <option value="">Seleccionar Perfil</option>
                                <?php foreach ($arr_perfiles as $op) : ?>
                                    <option value="<?= $op['id'] ?>"><?= $op['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                        <div class="mb-3">
                            <label for="Contraseña" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="txtpassword" required>
                                <div class="input-group-append">
                                    <button onclick="mostrarContrasena()" class="btn btn-outline-dark" type="button"><span class="fa fa-eye-slash icon"></span> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4">
                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado</label>
                            <select class="form-select" name="cmbEstado" required>
                                <option value="">Seleccionar Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
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
                        <button type="submit" name="btnModificarUsuario" class="btn btn-outline-primary btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Modificar</button>
                        <input type="number" name="id_usuario" value="<?php echo $item2['id']; ?>" hidden />
                    </div>
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" onclick="refresh()" class="btn btn-outline-danger btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Cancelar</button>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-end">
                        <button type="submit" name="btnCrearUsuario" class="btn btn-outline-primary btn-lg col-12 col-xs-12 col-sm-12 col-md-4">Guardar</button>
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
        <div class="table-responsive-md col-md-12">
            <table class="table table-sm table-bordered table-striped text-center" id="usuarios" data-page-length='5' style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Identificación</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($arr_users as $item) {
                        $cantidad = count($arr_users);
                    ?>
                        <tr>
                            <td><?php echo $item['nombre']; ?></td>
                            <td><?php echo $item['identificacion']; ?></td>
                            <td><?php echo $item['perfil']; ?></td>
                            <td><?php
                                if ($item['estado'] == '1') {
                                    echo 'Activo';
                                }
                                ?>
                                <?php
                                if ($item['estado'] == '0') {
                                    echo 'Inactivo';
                                }
                                ?>
                            </td>
                            <td>
                                <form action="home.php?mod=usuarios" method="post">
                                    <input type="number" name="id_usuario" value="<?php echo $item['id']; ?>" hidden />
                                    <button class="navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" type="submit" name="btnModificar">
                                        <i class="fas fa-edit"></i>&nbsp;
                                    </button>
                                </form>
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