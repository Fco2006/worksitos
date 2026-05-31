#  Analizador de Consumo Energético en Servidores (PHP)

## . Nombre del Proyecto
**Monitor de Energía — DataCenter** — Herramienta web profesional que calcula la energía total consumida por un servidor a partir de una función de potencia, usando integración numérica por la Regla del Trapecio.

---

## . Objetivo del Proyecto
Crear una herramienta web que permita a administradores de sistemas ingresar parámetros de tiempo y calcular la **Energía Total Consumida (en Joules)** de un servidor, aplicando conceptos de Programación Orientada a Objetos: **encapsulamiento**, **namespaces**, **manejo de excepciones** y **métodos de cálculo**.

---

## . Problema que Resuelve
En un Data Center, el consumo energético de un servidor varía según la carga de la CPU. Para facturar a clientes o calcular la huella de carbono, se necesita calcular:

$$Energía = \int_{a}^{b} P(t)\, dt$$

El sistema resuelve esto numéricamente con la **Regla del Trapecio**, aproximando la integral definida de la función de potencia `P(t) = t² + 2t` en un intervalo `[a, b]`.

---

## . Tecnologías Utilizadas
| Tecnología | Uso |
|------------|-----|
| PHP 8.x | Lógica de cálculo con POO |
| Namespaces PHP | Organización profesional del código (`App\Calculo`) |
| HTML5 | Formulario de entrada de parámetros |
| CSS3 | Diseño de la interfaz del monitor |
| XAMPP / Apache | Servidor local de desarrollo |
| Composer (opcional) | Gestión de dependencias/autoload |

---

## . Conceptos Aplicados
- **Namespaces** (`namespace App\Calculo`) para evitar colisiones de nombres
- **Encapsulamiento:** propiedades `private` (`$inicio`, `$fin`, `$pasos`)
- **Manejo de excepciones** con `try-catch` y `throw new Exception()`
- **Métodos públicos y privados** (`calcularEnergiaTotal()`, `funcionPotencia()`)
- **Integración numérica** con la Regla del Trapecio
- **Casting de tipos** en PHP (`(float)`, `(int)`)
- **Abstracción:** `index.php` no conoce la lógica de cálculo, solo usa la clase
- `require_once` y `use` para importar la clase con namespace



## . Instrucciones de Ejecución

1. Instalar **XAMPP** y activar **Apache**.
2. Copiar la carpeta del proyecto en:
   ```
   C:/xampp/htdocs/monitor_energetico/
   ```
3. Abrir el navegador y acceder a:
   ```
   http://localhost/monitor_energetico/index.php
   ```
4. Ingresar los parámetros en el formulario:
   - **Tiempo Inicial (s):** por ejemplo `0`
   - **Tiempo Final (s):** por ejemplo `10`
   - **Precisión (n):** por ejemplo `1000`
5. Presionar **"Calcular Joules Consumidos"**.
6. El resultado aparecerá en pantalla. El valor exacto para `[0, 10]` es **433.33 Joules**.

### Estructura de archivos
```
monitor_energetico/
├── index.php                          ← Formulario + resultado HTML
├── css/
│   └── style.css                      ← Estilos de la interfaz
└── src/
    └── Calculo/
        └── IntegradorNumerico.php     ← Clase con lógica de integración
```

---

## . Reflexión Personal

### ¿Qué aprendí?
Aprendí cómo los **namespaces** en PHP permiten organizar el código de forma profesional, similar a los paquetes en Java o los módulos en Python. También comprendí el poder del **encapsulamiento**: el archivo `index.php` no necesita saber cómo funciona la integral, solo instancia la clase y obtiene el resultado. Además, practicar el manejo de excepciones con `try-catch` me ayudó a crear un sistema más robusto que no "truena" con entradas inválidas.

### ¿Qué fue difícil?
Lo más difícil fue entender la **Regla del Trapecio** y traducirla correctamente en el bucle `for` de PHP. También me costó configurar correctamente el `namespace` y el `use` para que PHP encontrara la clase sin errores. Al principio confundía `require_once` con la declaración `use`, que son cosas distintas.

### ¿Qué mejoraría?
- Implementar los **3 perfiles de consumo** del desafío: IDLE, AVERAGE y STRESS, permitiendo al usuario elegir entre ellos.
- Agregar la conversión a **kWh** directamente en la interfaz.
- Usar **Chart.js** para graficar la función `P(t)` junto al área bajo la curva.
- Implementar **Composer** con autoload PSR-4 para una gestión de clases más profesional.
- Agregar pruebas unitarias con **PHPUnit** para validar la exactitud del cálculo.

---

*Proyecto desarrollado como Actividad de Evaluación ABPj Corte 2 — Programación Orientada a Objetos | Ingeniería Informática | ITSL*
