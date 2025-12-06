CREATE DATABASE prueba_ganbaru;
USE prueba_ganbaru;

CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE tareas_cat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tarea_id INT,
    categoria_id INT,
    FOREIGN KEY (tarea_id) REFERENCES tareas(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO categorias (nombre) VALUES ('PHP'), ('Javascript'), ('CSS');