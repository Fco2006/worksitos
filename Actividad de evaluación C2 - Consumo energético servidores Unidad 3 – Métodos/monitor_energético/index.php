<?php
require_once 'src/Calculo/IntegradorNumerico.php';
use App\Calculo\IntegradorNumerico;

$resultado = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $integrador = new IntegradorNumerico(
            (float)$_POST['t_inicio'],
            (float)$_POST['t_fin'],
            (int)$_POST['precision'],
            (string)$_POST['perfil_consumo'],
            (string)$_POST['unidad']
        );


        $resultado = $integrador->calcularEnergiaTotal();
        $unidad = $integrador->conseguirUnidad();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cloud Energy Monitor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1>Monitor de Energía (DataCenter)</h1>
        <form method="POST">
            <label>Tiempo Inicial (s):</label>
            <input type="number" name="t_inicio" step="0.1" required>

            <label>Tiempo Final (s):</label>
            <input type="number" name="t_fin" step="0.1" required>

            <label>Precisión (n subintervalos):</label>
            <input type="number" name="precision" value="1000">

            <label for="perfiles-consumo">Perfil de Consumo:</label>
            <select id="perfiles-consumo" name="perfil_consumo">
                <option value="">DEFAULT</option>
                <option value="IDLE">IDLE</option>
                <option value="AVERAGE">AVERAGE</option>
                <option value="STRESS">STRESS</option>
            </select>

            <label for="unidad">Unidad:</label>
            <select id="unidad" name="unidad">
                <option value="">Joules</option>
                <option value="KWH">Kilovatios-hora</option>
            </select>

            <button type="submit">Calcular</button>
        </form>

    <h2>Tabla de Ejemplo</h2>

    <?php
    $valoresN = [10, 100, 1000];
    $valorExacto = 433.33;
    ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>n (subintervalos)</th>
            <th>Resultado Aproximado</th>
            <th>Error Absoluto</th>
        </tr>

        <?php foreach ($valoresN as $n): ?>
            <?php
            $integrador = new IntegradorNumerico(0, 10, $n, '', '');
            $aprox = $integrador->calcularEnergiaTotal();
            $error = abs($valorExacto - $aprox);
            ?>

            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo number_format($aprox, 4); ?></td>
                <td><?php echo number_format($error, 4); ?></td>
            </tr>

        <?php endforeach; ?>
    </table>

        <?php if ($resultado !== null): ?>
            <div class="result">
                <h3>Consumo Total: <?php echo number_format($resultado, 4); echo $unidad?> </h3>
                <p>Cálculo basado en la integral definida de la carga del servidor.</p>
            </div>

        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"> Error: <?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>