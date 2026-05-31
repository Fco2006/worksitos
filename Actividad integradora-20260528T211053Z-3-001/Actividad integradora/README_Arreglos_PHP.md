# Gestión de Inventario con Arreglos Unidimensionales (PHP)

## . Nombre del Proyecto
**Sistema de Inventario con Arreglos** — Módulo de gestión de productos para una tienda en línea, desarrollado en PHP con arreglos unidimensionales paralelos.

---

## . Objetivo del Proyecto
Desarrollar un script en PHP que permita registrar nombres y precios de productos en arreglos unidimensionales, y calcular automáticamente el total de ventas, el promedio de precios, y los productos más caro y más barato, presentando los resultados en una tabla HTML.

---

## . Problema que Resuelve
Una tienda en línea necesitaba un prototipo para gestionar su inventario de productos de forma estructurada. El sistema resuelve:
- Captura de datos de al menos 5 productos desde un formulario.
- Almacenamiento en arreglos `$productos[]` y `$precios[]`.
- Cálculo de: total, promedio, producto más caro y más barato.
- Presentación clara y ordenada de resultados en HTML.

---

## . Tecnologías Utilizadas
| Tecnología | Uso |
|------------|-----|
| PHP 8.x | Procesamiento de arreglos y cálculos |
| HTML5 | Formulario de captura y tabla de resultados |
| XAMPP / Apache | Servidor local de desarrollo |
| CSS básico | Estilizado de la tabla de resultados |

---

## . Conceptos Aplicados
- **Arreglos unidimensionales** (`$productos[]`, `$precios[]`)
- **Arreglos paralelos** para relacionar nombre con precio
- Funciones nativas: `array_sum()`, `max()`, `min()`, `count()`
- Formularios HTML con método `POST`
- Validación básica desde HTML (`required`)
- Procesamiento en archivo separado (`procesar.php`)
- Presentación en **tabla HTML** estructurada



## . Instrucciones de Ejecución

1. Instalar **XAMPP** y activar el módulo **Apache**.
2. Copiar la carpeta del proyecto dentro de:
   ```
   C:/xampp/htdocs/tienda/
   ```
3. Abrir el navegador y acceder a:
   ```
   http://localhost/tienda/index.php
   ```
4. Ingresar los nombres y precios de al menos **5 productos** en el formulario.
5. Presionar **Enviar** para procesar los datos.
6. Los resultados (total, promedio, máximo, mínimo) se mostrarán en una tabla.

### Estructura de archivos
```
tienda/
├── index.php        ← Formulario de captura de productos
├── procesar.php     ← Lógica con arreglos y cálculos
└── resultados.php   ← (Opcional) Tabla de resultados
```

---

## . Reflexión Personal

### ¿Qué aprendí?
Aprendí cómo los arreglos unidimensionales son una herramienta eficiente para manejar colecciones de datos del mismo tipo. El uso de funciones nativas como `array_sum()`, `max()` y `min()` simplifica enormemente operaciones que de otra forma requerirían bucles manuales. También practiqué cómo separar la lógica del formulario en archivos distintos.

### ¿Qué fue difícil?
Lo más complicado fue manejar los **arreglos paralelos** y asegurarme de que los índices de `$productos` y `$precios` estuvieran siempre alineados. También me costó encontrar el índice del producto más caro usando `array_search(max($precios), $precios)`.

### ¿Qué mejoraría?
- Usar un **arreglo asociativo** o un array de objetos en lugar de dos arreglos paralelos, para evitar desincronización de índices.
- Añadir la opción de **agregar y eliminar productos dinámicamente** con JavaScript.
- Implementar **persistencia** guardando el inventario en un archivo o base de datos.
- Mejorar el diseño visual con un framework CSS como Bootstrap.

---

*Proyecto desarrollado como Actividad Integradora — Programación Orientada a Objetos | Ingeniería Informática | ITSL*
