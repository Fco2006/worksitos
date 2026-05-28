<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - TiendaOnline</title>
    <style>
        /* ── Estilos generales ── */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .contenedor {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 750px;
            overflow: hidden;
        }

        /* ── Encabezado ── */
        .encabezado {
            background: linear-gradient(135deg, #e94560, #0f3460);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .encabezado h1 {
            font-size: 1.8rem;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .encabezado p {
            font-size: 0.95rem;
            opacity: 0.85;
        }

        /* ── Cuerpo del formulario ── */
        .cuerpo {
            padding: 35px 40px;
        }

        .cuerpo h2 {
            font-size: 1.1rem;
            color: #0f3460;
            margin-bottom: 20px;
            border-left: 4px solid #e94560;
            padding-left: 10px;
        }

        /* ── Fila de producto ── */
        .fila-producto {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            align-items: center;
        }

        .fila-producto label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            min-width: 80px;
        }

        .fila-producto input[type="text"],
        .fila-producto input[type="number"] {
            flex: 1;
            padding: 10px 14px;
            border: 2px solid #dde1e7;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.25s;
            outline: none;
        }

        .fila-producto input:focus {
            border-color: #e94560;
        }

        /* Número de producto */
        .num-producto {
            background: #0f3460;
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── Separador entre filas ── */
        .separador {
            border: none;
            border-top: 1px dashed #dde1e7;
            margin: 10px 0 16px 0;
        }

        /* ── Botón de envío ── */
        .btn-enviar {
            display: block;
            width: 100%;
            padding: 14px;
            margin-top: 24px;
            background: linear-gradient(135deg, #e94560, #c62a47);
            color: white;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn-enviar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 69, 96, 0.4);
        }

        /* ── Nota informativa ── */
        .nota {
            background: #f0f4ff;
            border: 1px solid #c5d3f5;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.83rem;
            color: #4a5a8a;
            margin-bottom: 24px;
        }

        .nota strong {
            color: #0f3460;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <!-- Encabezado -->
    <div class="encabezado">
        <h1>🛒 TiendaOnline</h1>
        <p>Módulo de Gestión de Inventario &mdash; Registro de Productos</p>
    </div>

    <!-- Cuerpo -->
    <div class="cuerpo">
        <h2>Captura de Productos</h2>

        <!-- Nota informativa -->
        <div class="nota">
            <strong>Instrucciones:</strong> Ingresa el nombre y precio de al menos
            5 productos. Todos los campos son obligatorios y el precio debe ser
            un valor positivo mayor a cero.
        </div>

        <!--
            FORMULARIO PRINCIPAL
            action  → procesar.php   (script que recibe y procesa los datos)
            method  → POST           (envía datos de forma segura, no visibles en la URL)
        -->
        <form action="procesar.php" method="POST">

            <?php
            /*
             * Generamos dinámicamente 5 filas de producto con PHP.
             * Cada par de campos comparte el mismo índice [i] en los
             * arreglos $_POST['nombres'] y $_POST['precios'].
             */
            for ($i = 1; $i <= 5; $i++):
            ?>

            <!-- Fila: Nombre del producto -->
            <div class="fila-producto">
                <div class="num-producto"><?= $i ?></div>
                <label for="nombre<?= $i ?>">Producto:</label>
                <!--
                    name="nombres[]"  → PHP lo recibirá como el arreglo $nombres
                    required          → validación HTML: campo obligatorio
                    maxlength         → límite de caracteres razonable
                -->
                <input
                    type="text"
                    id="nombre<?= $i ?>"
                    name="nombres[]"
                    placeholder="Ej. Laptop Lenovo"
                    required
                    maxlength="80">
            </div>

            <!-- Fila: Precio del producto -->
            <div class="fila-producto">
                <div style="width:28px; flex-shrink:0;"></div><!-- espaciador -->
                <label for="precio<?= $i ?>">Precio ($):</label>
                <!--
                    type="number"   → solo acepta valores numéricos
                    min="0.01"      → validación HTML: precio mínimo
                    step="0.01"     → permite decimales (centavos)
                    required        → campo obligatorio
                -->
                <input
                    type="number"
                    id="precio<?= $i ?>"
                    name="precios[]"
                    placeholder="0.00"
                    min="0.01"
                    step="0.01"
                    required>
            </div>

            <!-- Separador visual entre productos (excepto el último) -->
            <?php if ($i < 5): ?>
                <hr class="separador">
            <?php endif; ?>

            <?php endfor; ?>

            <!-- Botón de envío -->
            <button type="submit" class="btn-enviar">
                📊 Procesar Inventario
            </button>

        </form>
    </div><!-- /.cuerpo -->

</div><!-- /.contenedor -->

</body>
</html>
