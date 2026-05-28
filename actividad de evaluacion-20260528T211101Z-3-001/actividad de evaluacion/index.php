<?php
// ============================================================
// BLOQUE 1: Procesamiento del formulario (escritura en archivo)
// ============================================================

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $actividad    = trim($_POST["actividad"] ?? "");
    $responsable  = trim($_POST["responsable"] ?? "");
    $fecha        = trim($_POST["fecha"] ?? "");

    // Validación: campos vacíos
    if (empty($actividad) || empty($responsable) || empty($fecha)) {
        $mensaje     = "❌ Error: Todos los campos son obligatorios. Por favor, completa el formulario.";
        $tipoMensaje = "error";
    } else {
        // Formato del registro
        $registro  = "Fecha: " . htmlspecialchars($fecha) . "\n";
        $registro .= "Actividad: " . htmlspecialchars($actividad) . "\n";
        $registro .= "Responsable: " . htmlspecialchars($responsable) . "\n";
        $registro .= "-------------------------------\n";

        // Escritura en archivo con FILE_APPEND (no borra contenido previo)
        $archivo = "bitacora.txt";
        $resultado = file_put_contents($archivo, $registro, FILE_APPEND | LOCK_EX);

        if ($resultado !== false) {
            $mensaje     = "✅ Actividad registrada correctamente en la bitácora.";
            $tipoMensaje = "exito";
        } else {
            $mensaje     = "❌ Error: No se pudo escribir en el archivo. Verifica los permisos.";
            $tipoMensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Actividades</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            padding: 30px 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3rem;
            border-left: 4px solid #3498db;
            padding-left: 10px;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            margin-bottom: 18px;
            transition: border 0.2s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 11px 28px;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .mensaje {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .mensaje.exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Bitácora */
        ol {
            padding-left: 20px;
        }

        ol li {
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 12px;
            line-height: 1.7;
            white-space: pre-wrap;
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.92rem;
        }

        .vacia {
            color: #888;
            font-style: italic;
        }

        footer {
            text-align: center;
            color: #aaa;
            font-size: 0.85rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>📋 Bitácora de Actividades</h1>

    <!-- ===================== FORMULARIO ===================== -->
    <div class="card">
        <h2>Registrar nueva actividad</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?= $tipoMensaje ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php">

            <label for="fecha">📅 Fecha</label>
            <input
                type="date"
                id="fecha"
                name="fecha"
                value="<?= isset($_POST['fecha']) && $tipoMensaje === 'error' ? htmlspecialchars($_POST['fecha']) : '' ?>"
            >

            <label for="actividad">📝 Descripción de la actividad</label>
            <input
                type="text"
                id="actividad"
                name="actividad"
                placeholder="Ej. Revisión de cámaras perimetrales"
                value="<?= isset($_POST['actividad']) && $tipoMensaje === 'error' ? htmlspecialchars($_POST['actividad']) : '' ?>"
            >

            <label for="responsable">👤 Responsable</label>
            <input
                type="text"
                id="responsable"
                name="responsable"
                placeholder="Ej. Carlos Mendoza"
                value="<?= isset($_POST['responsable']) && $tipoMensaje === 'error' ? htmlspecialchars($_POST['responsable']) : '' ?>"
            >

            <button type="submit">Guardar en bitácora</button>
        </form>
    </div>

    <!-- ===================== LECTURA DEL ARCHIVO ===================== -->
    <?php
    // ============================================================
    // BLOQUE 2: Lectura y despliegue del archivo bitacora.txt
    // ============================================================
    $archivo = "bitacora.txt";
    ?>

    <div class="card">
        <h2>📂 Registros en la bitácora</h2>

        <?php if (file_exists($archivo) && filesize($archivo) > 0): ?>
            <?php
                $contenido = file_get_contents($archivo);
                // Separar cada entrada por el separador
                $entradas = explode("-------------------------------\n", $contenido);
                // Filtrar entradas vacías
                $entradas = array_filter($entradas, fn($e) => trim($e) !== "");
                $entradas = array_values($entradas);
            ?>
            <ol>
                <?php foreach ($entradas as $entrada): ?>
                    <li><?= htmlspecialchars(trim($entrada)) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php else: ?>
            <p class="vacia">Aún no hay actividades registradas en la bitácora.</p>
        <?php endif; ?>
    </div>

</div>

<footer>
    Bitácora Digital &mdash; Gestión de Archivos en PHP
</footer>

</body>
</html>
