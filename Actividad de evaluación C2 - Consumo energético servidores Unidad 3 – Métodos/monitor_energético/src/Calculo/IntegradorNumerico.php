<?php
namespace App\Calculo;

class IntegradorNumerico {
    private float $tiempoInicial;
    private float $tiempoFinal;
    private int $numeroSubintervalos;
    private string $perfil;
    private string $formato;

    public function __construct(float $a, float $b, int $n = 1000, ?string $perfil = null, ?string $formato = null) {
        if ($a >= $b) {
            throw new \Exception("El tiempo inicial debe ser menor al final.");
        }

        if ($n <= 0) {
            throw new \Exception("La precisión (n) debe ser un número positivo.");
        }

        $this->tiempoInicial = $a;
        $this->tiempoFinal = $b;
        $this->numeroSubintervalos = $n;
        $this->perfil = $perfil;
        $this->formato = $formato;
    }

    private function funcionPotencia(float $tiempoActual): float {
        switch($this->perfil){
            case 'IDLE':
                return 5;

            case 'AVERAGE':
                return $tiempoActual*2 + 5;

            case 'STRESS':
                return pow($tiempoActual, 2);

            default:
                return pow($tiempoActual, 2) + (2 * $tiempoActual);
        }
    }

    public function calcularEnergiaTotal(): float {

        $anchoPaso = ($this->tiempoFinal - $this->tiempoInicial) / $this->numeroSubintervalos;

        $sumaAcumulada = ($this->funcionPotencia($this->tiempoInicial) + $this->funcionPotencia($this->tiempoFinal)) / 2;

        for ($indicePaso = 1; $indicePaso < $this->numeroSubintervalos; $indicePaso++) {
            $tiempoPuntoMedio = $this->tiempoInicial + $indicePaso * $anchoPaso;
            $sumaAcumulada += $this->funcionPotencia($tiempoPuntoMedio);
        }

        $resultado = $sumaAcumulada * $anchoPaso;

        // Esto simplemente ayuda a cambiar el resultado dependiendo de la unidad elegida por el usuario.
        switch($this->formato){
            case 'KWH':
                return $resultado * ( 2.7778 * ( pow(10,-7) ) );
            default:
                return $resultado;
        }
    }

    /*
    Función hecha para sacar el nombre de la unidad del resultado.
    Esto es útil para manejar el nombre de las unidades, y manejar todo sobre
    las unidades dentro de la clase IntegradorNumerico.
    */
    public function conseguirUnidad(): string {
        switch($this->formato){
            case 'KWH':
                return " Kilovatio-hora";
            default:
                return " Joules";
        }
    }


}