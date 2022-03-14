
$('.exit').on('click', function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Estás Seguro(a) de cerrar la sesión?',
        text: "Está a punto de cerrar la sesión y salir del sistema.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Salir!',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.value) {
            window.location="../../CapaNegocio/cerrar_sesion.php";
        }
    });
});

$('.eliminarTiempo').on('click', function(e){
    e.preventDefault();
    id = document.getElementById('eliminar').value
    Swal.fire({
        title: 'Estás Seguro(a) de eliminar el registro?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.value) {
            window.location="home.php?mod=tiempos&del=" + id;
        }
    });
});

$('.eliminarActividad').on('click', function(e){
    e.preventDefault();
    id2 = document.getElementById('eliminaract').value
    Swal.fire({
        title: 'Estás Seguro(a) de eliminar el registro?',
        text: "Si elimina el registro tambien se eliminará el seguimiento de los tiempos",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.value) {
            window.location="home.php?mod=actividades&delete=" + id2;
        }
    });
});

function refresh() {
    window.location.reload();
};

function mostrarContrasena() {
    var tipo = document.getElementById("password");
    if (tipo.type == "password") {
        tipo.type = "text";
    } else {
        tipo.type = "password";
    }
};

$(document).ready(function () {
    $('#actividad').DataTable({
        searching: true,
        responsive: true,
        "lengthChange": false,
        "language": {
            "decimal": ".",
            "emptyTable": "No hay datos para mostrar",
            "info": "Mostrando del _START_ al _END_ un total de _TOTAL_ registros",
            "infoEmpty": "No se encontraron registros",
            "infoFiltered": "(filtrado de todas las _MAX_ entradas)",
            "infoPostFix": "",
            "thousands": "'",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": ordenar de manera Ascendente",
                "sortDescending": ": ordenar de manera Descendente ",
            }
        }
    });

    $('#usuarios').DataTable({
        searching: true,
        responsive: true,
        "lengthChange": false,
        "language": {
            "decimal": ".",
            "emptyTable": "No hay datos para mostrar",
            "info": "Mostrando del _START_ al _END_ un total de _TOTAL_ registros",
            "infoEmpty": "No se encontraron registros",
            "infoFiltered": "(filtrado de todas las _MAX_ entradas)",
            "infoPostFix": "",
            "thousands": "'",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": ordenar de manera Ascendente",
                "sortDescending": ": ordenar de manera Descendente ",
            }
        }
    });
});

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
