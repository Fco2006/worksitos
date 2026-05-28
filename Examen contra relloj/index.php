<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Logistica/Paquete.php';
require_once __DIR__ . '/src/Logistica/Sensor.php';

use Logistica\Paquete;
use Logistica\Sensor;

// Instanciar dos objetos Paquete
$paqueteA = new Paquete();
$paqueteB = new Paquete();

// Asignar valores a propiedades públicas
$paqueteA->codigoSeguimiento = "FDX12345";
$paqueteA->pesoKilogramos = 5.75;
$paqueteA->esFragil = true;

// Intentar asignar valor a propiedad privada
// $paqueteA->costoInterno = 150.00;
// Esta línea generaría un ERROR FATAL porque costoInterno es una propiedad privada
// y no puede ser accedida desde fuera de la clase.

// Instanciar objeto Sensor
$sensor1 = new Sensor();
$sensor1->id = 101;
$sensor1->marca = "Bosch";
$sensor1->ultimaLectura = new DateTime();
$sensor1->rangoMaximo = 75.5;