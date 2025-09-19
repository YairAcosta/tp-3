<?php

function leerAlumnos() {
    $ruta = __DIR__ . '/../files/alumnos.txt';
    $alumnos = [];

    if (!file_exists($ruta)) {
        return $alumnos;
    }

    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        // Se espera formato: Apellido,Nombre
        $partes = explode(',', $linea);
        if (count($partes) === 2) {
            $alumnos[] = [
                'apellido' => trim($partes[0]),
                'nombre' => trim($partes[1])
            ];
        }
    }

    return $alumnos;
}

function guardarAsistencia($fecha, $asistieron) {
    $ruta = __DIR__ . '/../files/asistencia.txt';

    // Formato a guardar:
    // Fecha: YYYY-MM-DD
    // Alumno1, Alumno2, ...
    $linea = "Fecha: $fecha\n";
    $linea .= "Presentes:\n";

    foreach ($asistieron as $alumno) {
        $linea .= " - $alumno\n";
    }

    $linea .= "------------------------\n";

    // Guardar en modo append
    file_put_contents($ruta, $linea, FILE_APPEND);
}

function borrarAsistencia() {
    $ruta = __DIR__ . '/../files/asistencia.txt';
    // Vaciar archivo
    file_put_contents($ruta, '');
}
