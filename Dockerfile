# Usa la imagen base de PHP con Apache
FROM php:8.2-apache

# Instala extensiones de PHP necesarias para MySQL (mysqli, que usa tu código)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita el módulo de reescritura de Apache (por si usas URLs amigables)
RUN a2enmod rewrite

# Copia todo el código fuente del proyecto al servidor web del contenedor
COPY . /var/www/html/

# Establece los permisos correctos para que Apache pueda escribir en la carpeta uploads
RUN chown -R www-data:www-data /var/www/html