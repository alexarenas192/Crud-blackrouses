BlackRouses CRUD

BlackRouses es una aplicación CRUD (Create, Read, Update, Delete) desarrollada para gestionar los cócteles creados en el bar Black Rouse, un espacio dedicado a la coctelería elegante y de autor.
El sistema permite registrar, visualizar, editar y eliminar cócteles, guardando información clave como su nombre, ingredientes, preparación y una imagen representativa.

FUNCIONALIDADES PRINCIPALES

Crear cócteles: agregar un nuevo cóctel con su nombre, lista de ingredientes, método de preparación y una foto.
Leer cócteles: visualizar todos los cócteles registrados en una tabla dinámica o galería.
Actualizar cócteles: editar cualquier información del cóctel, incluyendo su imagen.
Eliminar cócteles: borrar registros fácilmente desde la interfaz.
Subida de imágenes: las fotos se almacenan en la carpeta uploads/ y se asocian al registro del cóctel.

ESTRUCTURA DEL PROYECTO 

La estructura principal del proyecto es la siguiente, ahora complementada con los archivos necesarios para la contenerización:
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
├── **init_db/** # **[NUEVA CARPETA]** Contiene el script SQL para la inicialización automática de la base de datos.
│   └── **coctel.sql** # **[NUEVO ARCHIVO]** Define la estructura de la tabla 'coctel' y se ejecuta al levantar el contenedor MySQL.
│
├── crud.php        # Lógica principal del CRUD (conexión, inserción, lectura, actualización, eliminación). **La conexión se modificó para apuntar al servicio Docker 'db'**.
│
├── index.php       # Página principal de la aplicación, muestra la interfaz del CRUD
│
├── **Dockerfile** # **[NUEVO ARCHIVO]** Contiene las instrucciones para construir la imagen del contenedor de la aplicación PHP (se instala PHP 8.2 y las extensiones necesarias como mysqli).
│
└── **docker-compose.yml** # **[NUEVO ARCHIVO]** Define los servicios de la aplicación (PHP/Apache) y la base de datos (MySQL 8.0), maneja la red de comunicación interna y el mapeo de puertos. Incluye un mecanismo de *healthcheck* para evitar el error de "Connection refused".

TECNOLOGIAS UTILIZADAS

HTML5 / CSS3 / JavaScript → Interfaz del usuario
PHP (versión 8+) → Lógica del servidor y conexión con base de datos
MySQL / MariaDB → Base de datos para almacenar los registros de cócteles
~~XAMPP / Apache~~ → **Reemplazado por Docker Compose y contenedores PHP-Apache/MySQL** (para un entorno reproducible).

ESTRUCTURA DE LA BASE DE DATOS


La base de datos se llama blackrouses_db, con una tabla coctel (modificada de 'cocteles' para coincidir con el código) estructurada así:
| Campo | Tipo | Descripción |
| :--- | :--- | :--- |
| id | INT (AUTO_INCREMENT) | Identificador único del cóctel |
| nombre | VARCHAR(100) | Nombre del cóctel |
| ingredientes | TEXT | Lista de ingredientes |
| preparacion | TEXT | Pasos de preparación |
| imagen | VARCHAR(255) | Nombre o ruta del archivo de imagen |

---

##  Guía de Despliegue con Docker Compose

La aplicación se despliega utilizando Docker Compose para garantizar un entorno consistente.

1. Instalar Docker: Se requiere tener instalado Docker Desktop.
2. Arranque: Desde la carpeta raíz del proyecto, se utiliza el comando para construir la aplicación y levantar los servicios:
    ```bash
    docker-compose up -d --build
    ```
3.  Acceso: Una vez iniciados los contenedores, la aplicación es accesible en el puerto mapeado: `http://localhost:8080`.