-- Script para crear la tabla 'coctel'
CREATE TABLE IF NOT EXISTS coctel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    ingredientes TEXT,
    preparacion TEXT,
    imagen VARCHAR(255)
);

-- Opcional: Insertar un cóctel de ejemplo para verificar
INSERT INTO coctel (nombre, ingredientes, preparacion, imagen) VALUES 
('Mojito Clásico', 'Ron blanco, Azúcar, Menta, Lima, Soda', 'Machacar menta y azúcar, agregar ron, hielo y soda.', 'images/default.png');