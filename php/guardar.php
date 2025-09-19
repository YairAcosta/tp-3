<?php
require_once('funciones.php');

if (!isset($_POST['accion'])) {
    header("Location: ../index.php");
    exit;
}

$accion = $_POST['accion'];

if ($accion === 'borrar') {
    borrarAsistencia();
    header("Location: ../index.php");
    exit;
}

if ($accion === 'registrar') {
    if (!isset($_POST['fecha']) || empty($_POST['fecha'])) {
        header("Location: ../index.php");
        exit;
    }
    if (!isset($_POST['asistencia']) || empty($_POST['asistencia'])) {
        header("Location: ../index.php");
        exit;
    }

    $fecha = $_POST['fecha'];
    $asistieron = $_POST['asistencia'];

    guardarAsistencia($fecha, $asistieron);

    header("Location: historial.php");
    exit;
}

header("Location: ../index.php");
exit;
