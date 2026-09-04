CREATE DATABASE IF NOT EXISTS comunication_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE comunication_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    departamento VARCHAR(50) NOT NULL,
    torre VARCHAR(20) NOT NULL,
    telefono VARCHAR(20),
    rol ENUM('Residente', 'Administrador') DEFAULT 'Residente',
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertar usuario de prueba (Contraseña: Carlos2026!)
INSERT INTO usuarios (nombre, email, password_hash, departamento, torre, telefono, rol) 
VALUES (
    'Carlos Mendoza', 
    'carlos.mendoza@email.com', 
    '$2y$10$w0uO4hR2I5J1XmPzL8G.eOqX.aE3eQ0Y6k7F9K0L1M2N3O4P5Q6R7S8T9U0V', 
    'Apto 402', 
    'Torre A', 
    '555-1234', 
    'Residente'
);