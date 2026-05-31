# Gestión de Bitácoras en Archivos de Texto (PHP)

## . Nombre del Proyecto
**Sistema de Bitácora Digital** — Módulo de registro de actividades en archivos de texto plano con PHP.

---

## . Objetivo del Proyecto
Desarrollar un módulo prototipo en PHP que permita a una empresa de seguridad llevar un registro digital de sus actividades diarias (revisiones, incidentes, tareas) sin necesidad de una base de datos, utilizando archivos de texto plano como almacenamiento.

---

## . Problema que Resuelve
Una empresa de seguridad llevaba su registro de actividades en papel. Se necesitaba una solución ligera y digital que permitiera:
- Registrar actividades con fecha, descripción y responsable.
- Consultar el historial completo de la bitácora.
- Agregar nuevas entradas **sin borrar** las anteriores.
- Validar que no se envíen campos vacíos.

---

## . Tecnologías Utilizadas
| Tecnología | Uso |
|------------|-----|
| PHP 8.x | Lógica del servidor, manejo de archivos |
| HTML5 | Formulario de captura de datos |
| XAMPP / Apache | Servidor local de desarrollo |
| Archivo `.txt` | Almacenamiento de la bitácora |

---

## . Conceptos Aplicados
- Manejo de archivos en PHP (`file_put_contents`, `file_get_contents`)
- Modo **append** (`FILE_APPEND`) para no sobreescribir datos
- Formularios HTML con método `POST`
- Validación de campos vacíos en PHP
- Presentación de contenido con `<pre>` y `<ol>`
- Mensajes de éxito y error al usuario


---

## . Instrucciones de Ejecución

1. Instalar **XAMPP** y asegurarse de que **Apache** esté activo.
2. Copiar la carpeta `bitacora/` dentro de:
   ```
   C:/xampp/htdocs/bitacora/
   ```
3. Abrir el navegador y acceder a:
   ```
   http://localhost/bitacora/index.php
   ```
4. Llenar el formulario con los datos de la actividad y presionar **Enviar**.
5. El archivo `bitacora.txt` se crea automáticamente en la misma carpeta.
6. Las actividades registradas aparecerán listadas en la parte inferior de la página.

### Estructura de archivos
```
bitacora/
├── index.php       ← Formulario + lógica + visualización
└── bitacora.txt    ← Se genera automáticamente al guardar
```

---

## . Reflexión Personal

### ¿Qué aprendí?
Aprendí a manipular archivos de texto desde PHP usando `file_put_contents` con la bandera `FILE_APPEND`, lo que me permite guardar información de forma persistente sin depender de una base de datos. También aprendí la importancia de validar los datos antes de escribirlos en el archivo.

### ¿Qué fue difícil?
Lo más difícil fue entender la diferencia entre el modo `append` y el modo de escritura normal, ya que al principio sobreescribía el archivo completo cada vez. También me costó un poco formatear la salida del archivo para que se viera ordenada en pantalla.

### ¿Qué mejoraría?
- Agregar la posibilidad de **eliminar o editar** una entrada específica.
- Implementar un sistema de **búsqueda por fecha o responsable**.
- Usar `flock()` para evitar problemas si varios usuarios escriben al mismo tiempo.
- Añelar una capa de seguridad con `htmlspecialchars()` para evitar inyección de código.

---

*Proyecto desarrollado como actividad de evaluación — Programación Orientada a Objetos | Ingeniería Informática | ITSL*
