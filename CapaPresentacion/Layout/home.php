<?php
session_start();
if (isset($_SESSION['usuario'])) {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>TimeApp V1.0</title>
        <!-- <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico"> -->
        <link rel="stylesheet" href="../vendor/css/bootstrap.min.css">
        <link rel="stylesheet" href="../Datatables/datatables.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
        <script src="../vendor/js/fontawesome5.0.7.js"></script>
        <link rel="stylesheet" href="../vendor/css/style.css">
        <link rel="stylesheet" href="../vendor/css/sweetalert2.min.css">
        <script src="../vendor/js/sweetalert2.min.js"></script>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Time App V1.0</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="home.php?mod=actividades">
                                    <i class="fas fa-tasks"></i>
                                    Actividades</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="home.php?mod=tiempos">
                                    <i class="fas fa-clock"></i>
                                    Tiempo</a>
                            </li>
                            <li class="nav-item" <?php
                                                    $perfil = $_SESSION['perfil'];
                                                    if ($perfil == 'Empleado') {
                                                        echo "hidden";
                                                    }
                                                    ?>>
                                <a class="nav-link" href="home.php?mod=usuarios">
                                    <i class="fas fa-users"></i>
                                    Usuarios</a>
                            </li>
                            <li class="nav-item d-none d-sm-none d-md-block position-absolute top-0 end-0">
                                <div class="d-flex flex-row-reverse bd-highlight">
                                    <div class="p-1 bd-highlight">
                                        <a class="nav-link exit" href="../../CapaNegocio/cerrar_sesion.php">
                                            <i class="fas fa-window-close fa-2x btn-salir"></i>
                                        </a>
                                    </div>
                                    <div class="p-3 bd-highlight">
                                        <span class="text-white"><?php echo $_SESSION['perfil']; ?></span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item d-block d-sm-block d-md-none">
                                <div class="d-flex justify-content-center bd-highlight">
                                    <div class="p-2 bd-highlight">
                                        <a class="nav-link exit" href="../../CapaNegocio/cerrar_sesion.php">
                                            <i class="fas fa-window-close fa-1x btn-salir"></i>
                                        </a>
                                    </div>
                                    <div class="p-3 bd-highlight">
                                        <span class="text-white"><?php echo $_SESSION['perfil']; ?></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container">
            <section>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        <?php

                        switch (@$_GET['mod']) {

                            case "actividades":
                                require_once("../actividad/actividad.php");
                                break;
                            case "usuarios":
                                require_once("../usuario/usuario.php");
                                break;
                            case "tiempos":
                                require_once("../actividad/tiempo.php");
                                break;
                            default:
                                require_once("../actividad/actividad.php");
                                break;
                        }

                        ?>
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
        <script src="../vendor/js/jQuery.js"></script>
        <script src="../vendor/js/bootstrap.min.js"></script>
        <script src="../Datatables/datatables.min.js"></script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </body>

    </html>
<?php
} else {
    header('location: ../usuario/login.php');
}
?>