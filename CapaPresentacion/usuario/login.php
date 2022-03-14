<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once '../../CapaNegocio/usuarioBL/loginBL.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>TimeApp V1.0</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="../vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="../vendor/js/fontawesome5.0.7.js"></script>
    <link rel="stylesheet" href="../vendor/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">TimeApp V1.0</a>
            </div>
        </nav>
    </header>
    <main class="container m-auto align-items-center">
        <section>
            <div class="col-12">
                <div class="container col-sm-8 my-3">
                    <div class="row justify-content-center align-items-center">
                        <div class="form col-md-6 login-content">
                            <form action="login.php" method="post" class="p-3">
                                <div class="form-group mb-3 text-center">
                                    <i class="fas fa-user-circle fa-5x"></i>
                                    <h3>Inicio de Sesión</h3>
                                </div>
                                <?php
                                if (isset($_POST['btnIngresar']) && ((!empty($_POST['txtUsuario']) && !empty($_POST['txtPassword'])))) {
                                    $user = new GetUser();
                                    $array_user = $user->Get();
                                    if (empty($array_user)) {
                                        echo "<font color='red'><center><b>Usuario o contraseña incorrectos.</b></center></font><br>";
                                    } else {
                                        foreach ($array_user as $elemento) {
                                            $cantidad = count($array_user);
                                            if ($cantidad == 1) {
                                                session_start();
                                                $_SESSION['usuario'] = $elemento['identificacion'];
                                                $_SESSION['nombre'] = $elemento['nombre'];
                                                $_SESSION['perfil'] = $elemento['perfil'];
                                                $_SESSION['idUser'] = $elemento['id'];
                                                if ($elemento['estado'] == 0) {
                                                    echo "<font color='red'><center><b>El Usuario con el que intenta ingresar se encuentra Inactivo.</b></center></font><br>";
                                                    session_destroy();
                                                } else {
                                                    header('Location: ../Layout/home.php');
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                                <div class="form-group mb-3">
                                    <i class="fas fa-user"></i>
                                    <label for="usuario">Usuario</label>
                                    <input type="number" class="form-control" placeholder="Número de Identificación" name="txtUsuario" pattern="[0-9]" title="Ingrese Números." required>
                                </div>
                                <div class="form-group mb-3">
                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                    <label for="contraseña">Contraseña</label>
                                    <input type="password" class="form-control" placeholder="Ingrese su contraseña" name="txtPassword" pattern="[A-Za-z0-9]{8,25}" title="Ingrese solo Letras y Números. Tamaño mínimo: 8" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Ingresar" name="btnIngresar" class="btn btn-outline-primary col-12 col-xs-12 col-sm-12 col-md-12 btn-lg">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="container-fluid bg-dark">
        <div class="row">
            <div class="color1 col-12"></div>
            <div class="col-sm-12 col-md-12 pr-0">
                <p class="text-center pr-0">&copy; <?php echo date('Y'); ?>. Todos los derechos reservados. Programador: Yerson Silva</p>
            </div>
        </div>
    </footer>
    <script src="../vendor/js/bootstrap.min.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>