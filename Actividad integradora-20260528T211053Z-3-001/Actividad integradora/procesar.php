<?php
/*
 * ============================================================
 *  procesar.php
 *  Actividad Integradora – Arreglos Unidimensionales en PHP
 *  Alumno : Jesús Salas Marín
 * ============================================================
 *  Responsabilidad de este archivo:
 *   1. Recibir los datos enviados por el formulario (index.php)
 *   2. Validar que los datos sean correctos
 *   3. Almacenar los nombres y precios en arreglos paralelos
 *   4. Realizar los cálculos requeridos (total, promedio, max, min)
 *   5. Pasar los resultados a resultados.php para su presentación
 * ============================================================
 */

// ── 1. Verificar que la petición sea POST ──────────────────────────────────
/*
 * Solo procesamos si el formulario fue enviado correctamente.
 * Si alguien accede directamente a este archivo por URL, lo
 * redirigimos al formulario.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ── 2. Recibir datos crudos del formulario ─────────────────────────────────
/*
 * $_POST['nombres'] y $_POST['precios'] llegan como arreglos porque
 * en el formulario usamos name="nombres[]" y name="precios[]".
 * filter_input_array() los sanea antes de usarlos.
 */
$nombres_raw = isset($_POST['nombres']) ? $_POST['nombres'] : [];
$precios_raw = isset($_POST['precios']) ? $_POST['precios'] : [];

// ── 3. Validación y construcción de los arreglos paralelos ─────────────────
/*
 * $productos[] → arreglo con los nombres de los productos
 * $precios[]   → arreglo con los precios (floats) correspondientes
 * Ambos arreglos son paralelos: el índice 0 de $productos corresponde
 * al índice 0 de $precios, y así sucesivamente.
 */
$productos = []; // Arreglo de nombres
$precios   = []; // Arreglo de precios (numéricos)
$errores   = []; // Acumulamos mensajes de error de validación

$total_recibidos = count($nombres_raw);

for ($i = 0; $i < $total_recibidos; $i++) {

    // Limpiar espacios extra del nombre
    $nombre = trim($nombres_raw[$i]);

    // Convertir precio a float; si no es numérico quedará en 0
    $precio = isset($precios_raw[$i]) ? floatval($precios_raw[$i]) : 0;

    // Validar nombre: no vacío
    if ($nombre === '') {
        $errores[] = "El producto #" . ($i + 1) . " no tiene nombre.";
        continue; // saltar este producto
    }

    // Validar precio: debe ser positivo
    if ($precio <= 0) {
        $errores[] = "El precio del producto \"$nombre\" debe ser mayor a cero.";
        continue;
    }

    // Agregar al arreglo solo si pasa las validaciones
    $productos[] = $nombre; // nombre → arreglo de productos
    $precios[]   = $precio; // precio → arreglo de precios
}

// Verificar que tengamos al menos 5 productos válidos
if (count($productos) < 5) {
    $errores[] = "Se necesitan al menos 5 productos válidos. Solo se recibieron " . count($productos) . ".";
}

// Si hay errores, redirigir con mensaje (en producción se usaría sesión o POST/PRG)
if (!empty($errores)) {
    // Guardamos errores en sesión para mostrarlos en el formulario
    session_start();
    $_SESSION['errores'] = $errores;
    header('Location: index.php');
    exit;
}

// ── 4. Cálculos sobre los arreglos ────────────────────────────────────────

/*
 * array_sum($precios)
 * Suma todos los elementos del arreglo $precios en una sola instrucción.
 * Equivale a hacer un bucle for sumando cada precio, pero más conciso
 * y optimizado internamente por PHP.
 */
$total = array_sum($precios);

/*
 * Promedio = suma total / cantidad de productos
 * count() devuelve el número de elementos en el arreglo.
 */
$cantidad = count($precios);
$promedio = $total / $cantidad;

/*
 * max($precios) → devuelve el valor más alto del arreglo.
 * Para saber QUÉ producto tiene ese precio, buscamos su índice
 * con array_search() y lo usamos en $productos[].
 */
$precio_max   = max($precios);
$indice_max   = array_search($precio_max, $precios);
$producto_max = $productos[$indice_max];

/*
 * min($precios) → devuelve el valor más bajo del arreglo.
 * Mismo procedimiento que con max().
 */
$precio_min   = min($precios);
$indice_min   = array_search($precio_min, $precios);
$producto_min = $productos[$indice_min];

// ── 5. Pasar datos a resultados.php ──────────────────────────────────────
/*
 * Usamos sesiones para transferir los datos al siguiente script
 * sin exponerlos en la URL (más seguro que GET).
 */
session_start();

$_SESSION['productos']    = $productos;
$_SESSION['precios']      = $precios;
$_SESSION['total']        = $total;
$_SESSION['promedio']     = $promedio;
$_SESSION['precio_max']   = $precio_max;
$_SESSION['producto_max'] = $producto_max;
$_SESSION['precio_min']   = $precio_min;
$_SESSION['producto_min'] = $producto_min;

// Redirigir a la página de resultados
header('Location: resultados.php');
exit;
