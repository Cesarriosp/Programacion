DROP DATABASE IF EXISTS streamweb_cesar;
CREATE DATABASE streamweb_cesar;
USE streamweb_cesar;

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    edad INT NOT NULL
);

-- Tabla de Planes de suscripción
CREATE TABLE planes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre ENUM('Básico', 'Estándar', 'Premium') NOT NULL,
    precio DECIMAL(5,2) NOT NULL
);

-- Insertar datos de planes
INSERT INTO planes (nombre, precio) VALUES
('Básico', 9.99),
('Estándar', 13.99),
('Premium', 17.99);

-- Tabla de Paquetes Adicionales
CREATE TABLE paquetes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre ENUM('Deporte', 'Cine', 'Infantil') NOT NULL,
    precio DECIMAL(5,2) NOT NULL
);

-- Insertar datos de paquetes
INSERT INTO paquetes (nombre, precio) VALUES
('Deporte', 6.99),  -- Solo anual
('Cine', 7.99),
('Infantil', 4.99);  -- Solo para menores

-- Tabla de Suscripciones
CREATE TABLE suscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    plan_id INT,
    duracion ENUM('Mensual', 'Anual') NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES planes(id) ON DELETE CASCADE
);

-- Tabla intermedia para relacionar usuarios con paquetes adicionales
CREATE TABLE usuario_paquetes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    paquete_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (paquete_id) REFERENCES paquetes(id) ON DELETE CASCADE
);


-- Insertar usuarios de prueba
INSERT INTO usuarios (nombre, email, edad) VALUES
('Carlos Pérez', 'carlos.perez@email.com', 25),
('Ana Martínez', 'ana.martinez@email.com', 17), -- Menor de edad
('Luis Gómez', 'luis.gomez@email.com', 30);

-- Insertar suscripciones de prueba
INSERT INTO suscripciones (usuario_id, plan_id, duracion) VALUES
(1, 2, 'Mensual'),  -- Carlos tiene Plan Estándar mensual
(2, 1, 'Mensual'),  -- Ana tiene Plan Básico mensual (solo puede contratar Infantil)
(3, 3, 'Anual');    -- Luis tiene Plan Premium anual

-- Insertar paquetes contratados por los usuarios
INSERT INTO usuario_paquetes (usuario_id, paquete_id) VALUES
(1, 2),  -- Carlos ha contratado el Pack Cine
(2, 3),  -- Ana ha contratado el Pack Infantil (única opción posible)
(3, 1),  -- Luis ha contratado el Pack Deporte (porque su suscripción es Anual)
(3, 2);  -- Luis también ha contratado el Pack Cine
