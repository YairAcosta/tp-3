<?php
require_once('php/funciones.php');

$alumnos = leerAlumnos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Toma de Asistencia</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');

    /* Reset */
    *, *::before, *::after {
        box-sizing: border-box;
    }
    body {
        background: #eef2f7;
        font-family: 'Open Sans', sans-serif;
        margin: 0; padding: 40px 15px;
        color: #2c3e50;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }
    h1 {
        font-weight: 700;
        font-size: 2.3rem;
        margin-bottom: 30px;
        color: #34495e;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.05);
    }
    form {
        background: #fff;
        border-radius: 14px;
        padding: 30px 40px;
        box-shadow: 0 8px 20px rgba(52, 73, 94, 0.12);
        max-width: 720px;
        width: 100%;
        transition: box-shadow 0.3s ease;
    }
    form:hover {
        box-shadow: 0 12px 30px rgba(52, 73, 94, 0.18);
    }
    .fecha {
        display: flex;
        align-items: center;
        margin-bottom: 28px;
    }
    label[for="fecha"] {
        font-weight: 700;
        font-size: 1.15rem;
        margin-right: 18px;
        color: #2c3e50;
    }
    input[type="date"] {
        padding: 10px 14px;
        font-size: 1rem;
        border: 2px solid #3498db;
        border-radius: 8px;
        outline: none;
        color: #2c3e50;
        transition: border-color 0.3s ease;
    }
    input[type="date"]:focus {
        border-color: #2980b9;
        box-shadow: 0 0 8px rgba(41, 128, 185, 0.35);
    }
    .alumnos-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 18px;
        max-height: 390px;
        overflow-y: auto;
        padding-right: 8px;
        margin-bottom: 30px;
    }
    .alumnos-container::-webkit-scrollbar {
        width: 7px;
    }
    .alumnos-container::-webkit-scrollbar-thumb {
        background-color: #7f8c8d;
        border-radius: 6px;
    }
    .alumno {
        background: #f7fbff;
        border: 1.8px solid #3498db;
        border-radius: 12px;
        padding: 16px 12px;
        text-align: center;
        user-select: none;
        transition: background-color 0.3s ease, border-color 0.3s ease;
        cursor: default;
    }
    .alumno strong {
        display: block;
        margin-bottom: 12px;
        font-size: 1.05rem;
        color: #2c3e50;
    }
    label.checkbox-label {
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        font-size: 1rem;
        color: #34495e;
        cursor: pointer;
        user-select: none;
        gap: 7px;
        transition: color 0.25s ease;
    }
    label.checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #2980b9;
    }
    label.checkbox-label:hover {
        color: #1f3f6e;
    }
    .botones {
        display: flex;
        justify-content: center;
        gap: 22px;
        flex-wrap: wrap;
    }
    button {
        background-color: #2980b9;
        border: none;
        padding: 14px 32px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(41, 128, 185, 0.5);
        transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.15s ease;
        user-select: none;
    }
    button:hover {
        background-color: #1f6394;
        box-shadow: 0 6px 20px rgba(31, 99, 148, 0.7);
        transform: translateY(-2px);
    }
    button.delete-btn {
        background-color: #c0392b;
        box-shadow: 0 4px 14px rgba(192, 57, 43, 0.5);
    }
    button.delete-btn:hover {
        background-color: #90261b;
        box-shadow: 0 6px 20px rgba(144, 38, 27, 0.7);
    }
    .link-historial {
        margin-top: 38px;
        font-size: 1.05rem;
        font-weight: 600;
        color: #2980b9;
        text-align: center;
        text-decoration: none;
        transition: color 0.3s ease;
        user-select: none;
        display: inline-block;
    }
    .link-historial:hover {
        color: #1f6394;
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 600px) {
        form {
            padding: 24px 24px 32px;
        }
        h1 {
            font-size: 2rem;
        }
        .botones {
            flex-direction: column;
        }
        button {
            width: 100%;
            margin-bottom: 15px;
        }
    }
</style>
</head>
<body>

<?php if (empty($alumnos)): ?>
    <p style="text-align:center; font-weight:bold; color: #e74c3c; font-size:1.15rem;">
        No hay alumnos cargados en 'files/alumnos.txt'.
    </p>
<?php endif; ?>

<h1>Toma de Asistencia</h1>

<form action="php/guardar.php" method="post" autocomplete="off">
    <div class="fecha">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required value="<?= date('Y-m-d') ?>" />
    </div>

    <div class="alumnos-container">
        <?php foreach ($alumnos as $alumno): ?>
            <div class="alumno">
                <strong><?= htmlspecialchars($alumno['apellido']) ?>, <?= htmlspecialchars($alumno['nombre']) ?></strong>
                <label class="checkbox-label">
                    <input type="checkbox" name="asistencia[]" value="<?= htmlspecialchars($alumno['apellido'] . ',' . $alumno['nombre']) ?>" />
                    Presente
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="botones">
        <button type="submit" name="accion" value="registrar">Registrar Asistencia</button>
        <button type="submit" class="delete-btn" name="accion" value="borrar" onclick="return confirm('¿Seguro que querés borrar todas las asistencias?');">Borrar Asistencias</button>
    </div>
</form>

<a class="link-historial" href="php/historial.php" target="_blank" rel="noopener">Ver Historial de Asistencias</a>

</body>
</html>
