BlackRouses CRUD
BlackRouses es una aplicación CRUD (Create, Read, Update, Delete) desarrollada para gestionar los cócteles creados en el bar Black Rouse, un espacio dedicado a la coctelería elegante y de autor.
El sistema permite registrar, visualizar, editar y eliminar cócteles, guardando información clave como su nombre, ingredientes, preparación y una imagen representativa.

Funcionalidades principales
Crear cócteles: agregar un nuevo cóctel con su nombre, lista de ingredientes, método de preparación y una foto.
Leer cócteles: visualizar todos los cócteles registrados en una tabla dinámica o galería.
Actualizar cócteles: editar cualquier información del cóctel, incluyendo su imagen.
Eliminar cócteles: borrar registros fácilmente desde la interfaz.
Subida de imágenes: las fotos se almacenan en la carpeta uploads/ y se asocian al registro del cóctel.
Estructura del proyecto
La estructura principal del proyecto es la siguiente:

ACOCOTEL/
│
├── css/            # Contiene los estilos CSS del CRUD y del diseño general de la aplicación
│
├── images/         # Carpeta con imágenes estáticas o decorativas utilizadas en la interfaz
│
├── js/             # Archivos JavaScript para funcionalidades dinámicas o validaciones
│
├── uploads/        # Carpeta donde se almacenan las fotos de los cócteles subidas por el usuario
│
├── crud.php        # Lógica principal del CRUD (conexión, inserción, lectura, actualización, eliminación)
│
└── index.php       # Página principal de la aplicación, muestra la interfaz del CRUD
Tecnologías utilizadas
HTML5 / CSS3 / JavaScript → Interfaz del usuario
PHP (versión 8+) → Lógica del servidor y conexión con base de datos
MySQL / MariaDB → Base de datos para almacenar los registros de cócteles
XAMPP / Apache → Entorno local de desarrollo
Estructura de la base de datos
La base de datos puede llamarse blackrouses_db, con una tabla cocteles estructurada así:

Campo	Tipo	Descripción
id	INT (AUTO_INCREMENT)	Identificador único del cóctel
nombre	VARCHAR(100)	Nombre del cóctel
ingredientes	TEXT	Lista de ingredientes
preparacion	TEXT	Pasos de preparación
imagen	VARCHAR(255)	Nombre o ruta del archivo de imagen


----------------------------------------------------------

## 1. Archivos Nuevos Agregados al Proyecto para la utilizacion de docker

Se agregaron tres archivos/carpetas en la raíz del proyecto para la implementación de Docker Compose:

### A. `Dockerfile`
Este archivo es la **receta** que Docker utiliza para construir la imagen del servicio **`app`** (la  aplicación PHP). Contiene las instrucciones exactas para:
* Usar una imagen base de PHP con Apache (ej: `php:8.2-apache`).
* Instalar las extensiones necesarias de PHP, como `mysqli` y `pdo_mysql`, que permiten a tu código conectarse con la base de datos MySQL.
* Establecer permisos de usuario y grupo (como `www-data`) dentro del contenedor.

### B. `docker-compose.yml`
Este es el archivo de **orquestación**. Le dice a Docker cómo deben trabajar juntos los diferentes servicios de la aplicación (la DB y la App).
* **Define dos servicios:** `app` ( código PHP) y `db` (MySQL 8.0).
* **Configura la red:** Permite que la aplicación se conecte a la base de datos usando el nombre de host `db`.
* **Mapea puertos:** Hace que la aplicación sea accesible en `http://localhost:8080`.
* **Define el volumen de datos (`dbdata`):** Asegura que los datos de la base de datos persistan incluso si eliminas los contenedores.
* **Añade el `healthcheck`:** Resuelve el error de "Connection refused" asegurando que la aplicación espere a que MySQL esté listo antes de iniciar.

### C. Carpeta `init_db/` con `coctel.sql`
Esta carpeta es crucial par ala base de datos .
* **`init_db/`:** Es el directorio especial que el contenedor de MySQL revisa en el inicio.
* **`coctel.sql`:** Contiene el código SQL (`CREATE TABLE IF NOT EXISTS coctel...`) necesario para crear la base de datos y la tabla la primera vez que se inicia el contenedor. Esto garantiza que la estructura de la base de datos esté lista antes de que PHP intente usarla.

---

## 2. Modificación Clave en el Código (Para la Conexión)

Además de los archivos de Docker, se hizo una modificación crucial en el archivo de código existente:

### `crud.php` (Línea de Conexión)
La línea de conexión a la base de datos tuvo que cambiar para apuntar al **nombre del servicio Docker** en lugar de una dirección local:

* **Original (XAMPP):** `$mysqli = new mysqli("localhost", "user", "password", "blackroses_db");`
* **Modificada (Docker):** `$mysqli = new mysqli("db", "user", "password", "blackroses_db");`

El host **`db`** es el nombre del servicio que se define en el archivo `docker-compose.yml`.