<?php
/*
 * session_start() DEBE ir antes de cualquier salida HTML.
 * De lo contrario PHP lanza "headers already sent".
 */
session_start();

// Verificar que vengan datos válidos de la sesión; si no, redirigir
if (!isset($_SESSION['productos']) || empty($_SESSION['productos'])) {
    header('Location: index.php');
    exit;
}

// ── Recuperar datos de la sesión ──────────────────────────────
$productos    = $_SESSION['productos'];
$precios      = $_SESSION['precios'];
$total        = $_SESSION['total'];
$promedio     = $_SESSION['promedio'];
$precio_max   = $_SESSION['precio_max'];
$producto_max = $_SESSION['producto_max'];
$precio_min   = $_SESSION['precio_min'];
$producto_min = $_SESSION['producto_min'];

// Limpiar sesión para evitar recarga duplicada
unset($_SESSION['productos'], $_SESSION['precios'], $_SESSION['total'],
      $_SESSION['promedio'], $_SESSION['precio_max'], $_SESSION['producto_max'],
      $_SESSION['precio_min'], $_SESSION['producto_min']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Inventario - TiendaOnline</title>
    <style>
        /* ── Estilos generales ── */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            padding: 30px 20px;
            display: flex;
            justify-content: center;
        }

        .pagina {
            width: 100%;
            max-width: 850px;
        }

        /* ── Encabezado ── */
        .encabezado {
            background: linear-gradient(135deg, #e94560, #0f3460);
            color: white;
            border-radius: 16px 16px 0 0;
            padding: 28px 35px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .encabezado .icono { font-size: 2.8rem; }

        .encabezado h1 { font-size: 1.7rem; margin-bottom: 4px; }
        .encabezado p  { font-size: 0.9rem; opacity: 0.85; }

        /* ── Tarjetas de resumen ── */
        .tarjetas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 14px;
            background: #f7f9fc;
            padding: 24px 30px;
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
        }

        .tarjeta {
            background: white;
            border-radius: 12px;
            padding: 18px 16px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            border-top: 4px solid var(--color);
        }

        .tarjeta .icono-tarjeta { font-size: 1.8rem; margin-bottom: 6px; }
        .tarjeta .etiqueta { font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .tarjeta .valor { font-size: 1.35rem; font-weight: 700; color: var(--color); }
        .tarjeta .sub   { font-size: 0.78rem; color: #555; margin-top: 4px; }

        /* ── Sección de tabla ── */
        .seccion {
            background: white;
            padding: 28px 35px;
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
        }

        .seccion h2 {
            font-size: 1.05rem;
            color: #0f3460;
            margin-bottom: 16px;
            border-left: 4px solid #e94560;
            padding-left: 10px;
        }

        /* ── Tabla ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
        }

        thead tr {
            background: #0f3460;
            color: white;
        }

        thead th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        tbody tr {
            border-bottom: 1px solid #eef0f5;
            transition: background 0.15s;
        }

        tbody tr:hover { background: #f5f7ff; }

        tbody td {
            padding: 11px 16px;
            color: #333;
        }

        /* Columna de precio alineada a la derecha */
        td.precio, th.precio { text-align: right; }

        /* Badge especial para max/min */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            margin-left: 6px;
            vertical-align: middle;
        }

        .badge-max { background: #fff0f3; color: #e94560; border: 1px solid #e94560; }
        .badge-min { background: #f0fff4; color: #27ae60; border: 1px solid #27ae60; }

        /* Fila de totales */
        tfoot tr {
            background: #f0f4ff;
            font-weight: 700;
        }

        tfoot td {
            padding: 12px 16px;
            color: #0f3460;
            border-top: 2px solid #c5d3f5;
        }

        /* ── Sección de reflexión ── */
        .reflexion {
            background: white;
            padding: 28px 35px;
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            margin-top: 2px;
        }

        .reflexion h2 {
            font-size: 1.05rem;
            color: #0f3460;
            margin-bottom: 18px;
            border-left: 4px solid #e94560;
            padding-left: 10px;
        }

        .pregunta {
            background: #f7f9fc;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 14px;
            border-left: 3px solid #0f3460;
        }

        .pregunta p.q {
            font-weight: 700;
            color: #0f3460;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .pregunta p.r {
            color: #444;
            font-size: 0.88rem;
            line-height: 1.6;
        }

        /* ── Conclusiones ── */
        .conclusiones {
            background: white;
            padding: 28px 35px;
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            border-bottom: none;
            margin-top: 2px;
        }

        .conclusiones h2 {
            font-size: 1.05rem;
            color: #0f3460;
            margin-bottom: 16px;
            border-left: 4px solid #e94560;
            padding-left: 10px;
        }

        .conclusion-bloque {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
        }

        .c-card {
            background: #f7f9fc;
            border-radius: 10px;
            padding: 16px 18px;
        }

        .c-card .c-titulo {
            font-weight: 700;
            color: #e94560;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .c-card p {
            font-size: 0.85rem;
            color: #555;
            line-height: 1.55;
        }

        /* ── Pie de página ── */
        .pie {
            background: #0f3460;
            color: rgba(255,255,255,0.75);
            text-align: center;
            padding: 16px;
            border-radius: 0 0 16px 16px;
            font-size: 0.82rem;
        }

        .pie a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
        }

        .pie a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="pagina">

    <!-- ── Encabezado ── -->
    <div class="encabezado">
        <div class="icono">📦</div>
        <div>
            <h1>Resultados del Inventario</h1>
            <p>TiendaOnline &mdash; Análisis de productos registrados</p>
        </div>
    </div>

    <!-- ── Tarjetas de resumen ── -->
    <div class="tarjetas">

        <!-- Total -->
        <div class="tarjeta" style="--color: #0f3460;">
            <div class="icono-tarjeta">💰</div>
            <div class="etiqueta">Total Inventario</div>
            <div class="valor">$<?= number_format($total, 2) ?></div>
            <div class="sub"><?= count($productos) ?> productos registrados</div>
        </div>

        <!-- Promedio -->
        <div class="tarjeta" style="--color: #8e44ad;">
            <div class="icono-tarjeta">📊</div>
            <div class="etiqueta">Precio Promedio</div>
            <div class="valor">$<?= number_format($promedio, 2) ?></div>
            <div class="sub">Por producto</div>
        </div>

        <!-- Más caro -->
        <div class="tarjeta" style="--color: #e94560;">
            <div class="icono-tarjeta">⬆️</div>
            <div class="etiqueta">Más Caro</div>
            <div class="valor">$<?= number_format($precio_max, 2) ?></div>
            <div class="sub"><?= htmlspecialchars($producto_max) ?></div>
        </div>

        <!-- Más barato -->
        <div class="tarjeta" style="--color: #27ae60;">
            <div class="icono-tarjeta">⬇️</div>
            <div class="etiqueta">Más Barato</div>
            <div class="valor">$<?= number_format($precio_min, 2) ?></div>
            <div class="sub"><?= htmlspecialchars($producto_min) ?></div>
        </div>

    </div><!-- /.tarjetas -->

    <!-- ── Tabla de productos ── -->
    <div class="seccion">
        <h2>Lista de Productos</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th class="precio">Precio</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /*
                 * Recorremos los arreglos paralelos $productos y $precios
                 * con un bucle for. Ambos tienen la misma cantidad de
                 * elementos porque los validamos en procesar.php.
                 */
                $cantidad = count($productos);

                for ($i = 0; $i < $cantidad; $i++):
                    // Determinamos si este producto es el más caro o más barato
                    $es_max = ($precios[$i] === $precio_max);
                    $es_min = ($precios[$i] === $precio_min);
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?= htmlspecialchars($productos[$i]) ?>
                        <?php if ($es_max): ?>
                            <span class="badge badge-max">↑ Más caro</span>
                        <?php elseif ($es_min): ?>
                            <span class="badge badge-min">↓ Más barato</span>
                        <?php endif; ?>
                    </td>
                    <td class="precio">$<?= number_format($precios[$i], 2) ?></td>
                    <td>
                        <?php
                        // Indicador visual de precio relativo al promedio
                        if ($precios[$i] > $promedio) {
                            echo '🔴 Sobre promedio';
                        } elseif ($precios[$i] < $promedio) {
                            echo '🟢 Bajo promedio';
                        } else {
                            echo '🟡 En promedio';
                        }
                        ?>
                    </td>
                </tr>
                <?php endfor; ?>
            </tbody>

            <!-- Fila de totales -->
            <tfoot>
                <tr>
                    <td colspan="2">Totales</td>
                    <td class="precio">$<?= number_format($total, 2) ?></td>
                    <td>Promedio: $<?= number_format($promedio, 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </div><!-- /.seccion -->

    <!-- ── Preguntas de reflexión ── -->
    <div class="reflexion">
        <h2>Preguntas de Reflexión</h2>

        <div class="pregunta">
            <p class="q">a) ¿Por qué los arreglos unidimensionales son útiles para manejar colecciones de datos similares?</p>
            <p class="r">
                Los arreglos unidimensionales permiten agrupar múltiples valores del mismo tipo
                bajo un único nombre de variable, accediendo a cada elemento mediante su índice.
                Esto evita crear variables separadas (ej. $producto1, $producto2…) y facilita
                el recorrido con bucles, lo que hace el código más limpio, escalable y fácil
                de mantener. Aquí usamos <code>$productos[]</code> y <code>$precios[]</code>
                para manejar todos los artículos sin importar cuántos sean.
            </p>
        </div>

        <div class="pregunta">
            <p class="q">b) ¿Qué ventajas tiene utilizar <code>array_sum()</code>, <code>max()</code> o <code>min()</code> en lugar de iterar manualmente los arreglos?</p>
            <p class="r">
                Las funciones nativas de PHP están implementadas en C internamente, por lo que
                son más rápidas y eficientes que un bucle escrito en PHP. Además, reducen el
                código (1 línea vs. 4-5 líneas) y son menos propensas a errores de lógica
                (por ejemplo, olvidar inicializar el acumulador). Aumentan la legibilidad
                porque el nombre de la función describe exactamente lo que hace.
            </p>
        </div>

        <div class="pregunta">
            <p class="q">c) ¿Cómo podrías modificar el programa para agregar o eliminar productos dinámicamente?</p>
            <p class="r">
                Para <strong>agregar</strong>: en el formulario (index.php) se pueden añadir
                filas dinámicamente con JavaScript y el servidor simplemente recibirá más
                elementos en <code>$_POST['nombres'][]</code>. En procesar.php el bucle
                <code>for</code> ya maneja cualquier cantidad. Para <strong>eliminar</strong>:
                se puede usar <code>unset($productos[$i]); unset($precios[$i]);</code> seguido
                de <code>array_values()</code> para reindexar. Una alternativa más robusta
                sería usar una base de datos MySQL con operaciones INSERT/DELETE.
            </p>
        </div>

        <div class="pregunta">
            <p class="q">d) ¿Qué sucedería si los arreglos no tuvieran la misma cantidad de elementos?</p>
            <p class="r">
                Al ser arreglos paralelos, cada índice de <code>$productos[]</code> debe
                corresponder al mismo índice de <code>$precios[]</code>. Si no coinciden,
                al acceder a <code>$productos[$i]</code> cuando <code>$precios[$i]</code>
                no existe (o viceversa) se produce un error de tipo <em>Undefined offset</em>
                y los cálculos (promedio, total) serían incorrectos. Por eso en procesar.php
                validamos cada par y solo agregamos al arreglo si ambos datos son válidos.
            </p>
        </div>

    </div><!-- /.reflexion -->

    <!-- ── Conclusiones ── -->
    <div class="conclusiones">
        <h2>Conclusiones</h2>

        <div class="conclusion-bloque">

            <div class="c-card">
                <div class="c-titulo">¿Qué sabía?</div>
                <p>
                    Sabía que PHP es un lenguaje del lado del servidor y que permite
                    crear variables y estructuras de control básicas como bucles e
                    instrucciones condicionales. También conocía la sintaxis de formularios
                    HTML y el uso del atributo <code>method="POST"</code>.
                </p>
            </div>

            <div class="c-card">
                <div class="c-titulo">¿Qué aprendí?</div>
                <p>
                    Aprendí a declarar y recorrer arreglos unidimensionales paralelos en PHP,
                    y a usar funciones nativas como <code>array_sum()</code>,
                    <code>max()</code>, <code>min()</code> y <code>array_search()</code>
                    para analizar colecciones de datos de forma eficiente. También aprendí
                    a pasar información entre scripts usando sesiones de PHP.
                </p>
            </div>

            <div class="c-card">
                <div class="c-titulo">¿Qué podría hacer?</div>
                <p>
                    Con este conocimiento podría construir sistemas de inventario más completos:
                    agregar categorías, manejar stock y precios con descuento, conectar los
                    arreglos a una base de datos MySQL, o exportar los resultados a un archivo
                    CSV para análisis en hojas de cálculo. Los arreglos son la base de
                    estructuras de datos más avanzadas como las listas enlazadas y las pilas.
                </p>
            </div>

        </div><!-- /.conclusion-bloque -->
    </div><!-- /.conclusiones -->

    <!-- ── Pie de página ── -->
    <div class="pie">
        <a href="index.php">← Registrar nuevos productos</a>
        &nbsp;|&nbsp;
        Actividad Integradora – Arreglos Unidimensionales en PHP &mdash; Jesús Salas Marín
    </div>

</div><!-- /.pagina -->

</body>
</html>
