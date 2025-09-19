<?php
require_once('funciones.php');

// Leer el contenido del archivo de asistencia
$archivo = __DIR__ . '/../files/asistencia.txt';
$asistencias = [];

if (file_exists($archivo)) {
    $contenido = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Parsear líneas agrupándolas por bloques separados por "------------------------"
    $bloque = [];
    foreach ($contenido as $linea) {
        if (trim($linea) === '------------------------') {
            if (!empty($bloque)) {
                $asistencias[] = $bloque;
                $bloque = [];
            }
        } else {
            $bloque[] = $linea;
        }
    }
    // Último bloque
    if (!empty($bloque)) {
        $asistencias[] = $bloque;
    }
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Historial de Asistencias</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');

    body {
        background: #eef2f7;
        font-family: 'Open Sans', sans-serif;
        margin: 0; padding: 40px 15px;
        color: #2c3e50;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    h1 {
        font-weight: 700;
        font-size: 2.3rem;
        margin-bottom: 30px;
        color: #34495e;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.05);
    }
    .container {
        background: #fff;
        border-radius: 14px;
        padding: 30px 40px;
        box-shadow: 0 8px 20px rgba(52, 73, 94, 0.12);
        max-width: 720px;
        width: 100%;
        transition: box-shadow 0.3s ease;
        overflow-y: auto;
        max-height: 650px;
    }
    .container:hover {
        box-shadow: 0 12px 30px rgba(52, 73, 94, 0.18);
    }
    .bloque-asistencia {
        border-bottom: 2px solid #3498db;
        padding-bottom: 18px;
        margin-bottom: 24px;
    }
    .fecha {
        font-weight: 700;
        font-size: 1.25rem;
        color: #2980b9;
        margin-bottom: 10px;
        user-select: none;
    }
    ul.asistencia-lista {
        list-style: inside disc;
        margin: 0;
        padding-left: 18px;
        color: #34495e;
        font-size: 1.05rem;
        max-height: 200px;
        overflow-y: auto;
    }
    ul.asistencia-lista::-webkit-scrollbar {
        width: 7px;
    }
    ul.asistencia-lista::-webkit-scrollbar-thumb {
        background-color: #7f8c8d;
        border-radius: 6px;
    }
    .no-data {
        text-align: center;
        font-size: 1.25rem;
        color: #e74c3c;
        font-weight: 600;
        margin-top: 100px;
        user-select: none;
    }
    a.back-link {
        display: inline-block;
        margin-top: 30px;
        font-weight: 700;
        font-size: 1.1rem;
        color: #2980b9;
        text-decoration: none;
        transition: color 0.3s ease;
        user-select: none;
    }
    a.back-link:hover {
        color: #1f6394;
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 600px) {
        .container {
            padding: 24px 24px 32px;
            max-height: none;
        }
        h1 {
            font-size: 2rem;
        }
    }
</style>
</head>
<body>

<h1>Historial de Asistencias</h1>

<div class="container">
    <?php if (empty($asistencias)): ?>
        <p class="no-data">No hay registros de asistencia disponibles.</p>
    <?php else: ?>
        <?php foreach ($asistencias as $bloque): ?>
            <?php 
                // Buscamos la línea que empieza con "Fecha: " para mostrarla
                $fecha = 'Fecha no disponible';
                $presentes = [];
                foreach ($bloque as $linea) {
                    if (str_starts_with($linea, 'Fecha: ')) {
                        $fecha = substr($linea, 7);
                    } elseif (trim($linea) !== '' && strpos($linea, 'Presentes:') === false && strpos($linea, '-') === 0) {
                        // Líneas de alumnos empiezan con " - "
                        $presentes[] = trim(substr($linea, 2));
                    }
                }
            ?>
            <div class="bloque-asistencia">
                <div class="fecha"><?= htmlspecialchars($fecha) ?></div>
                <?php if (count($presentes) > 0): ?>
                    <ul class="asistencia-lista">
                        <?php foreach ($presentes as $presente): ?>
                            <li><?= htmlspecialchars($presente) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p><em>No se registraron alumnos presentes en esta fecha.</em></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<a href="../index.php" class="back-link">&larr; Volver a la toma de asistencia</a>

</body>
</html>
