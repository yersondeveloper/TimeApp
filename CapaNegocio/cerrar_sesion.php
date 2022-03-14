<?php
    //Cerrar la sesion del usuario
    session_start();
    session_destroy();
    header('Location: ../capaPresentacion/usuario/login.php');
?>