/* ================================
   DATABASE
================================ */
DROP DATABASE IF EXISTS digitalGarden;
CREATE DATABASE digitalGarden;
USE digitalGarden;

/* ================================
   TABLE USERS
================================ */
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status ENUM('active','blocked') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

/* ================================
   TABLE ROLES
================================ */
CREATE TABLE roles (
    user_id INT PRIMARY KEY,
    role ENUM('user','admin','moderator') DEFAULT 'user',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

/* ================================
   TABLE THEMES
================================ */
CREATE TABLE themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(7) NOT NULL,
    tags TEXT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

/* ================================
   TABLE NOTES
   (SOFT DELETE + FAVORIS)
================================ */
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    theme_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    importance INT NOT NULL CHECK (importance BETWEEN 1 AND 5),
    content TEXT NOT NULL,
    status ENUM('active','archived') DEFAULT 'active',
    is_favorite BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
);

/* ================================
   TABLE REPORTS (SIGNALEMENTS)
================================ */
CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('note','theme') NOT NULL,
    element_id INT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending','ignored','processed') DEFAULT 'pending',
    reported_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reported_by) REFERENCES users(id) ON DELETE CASCADE
);

/* ================================
   DONNÉES DE TEST
================================ */

/* USERS */
INSERT INTO users (fName, username, password) VALUES
('Alice', 'admin_alice', '$2y$10$XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
('Bob', 'user_bob', '$2y$10$XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
('Charlie', 'user_charlie', '$2y$10$XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
('Diana', 'user_diana', '$2y$10$XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

/* ROLES */
INSERT INTO roles (user_id, role) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'moderator'),
(4, 'user');

/* THEMES */
INSERT INTO themes (user_id, name, color, tags, is_public) VALUES
(1, 'Jardin Méditerranéen', '#4CAF50', 'méditerranée,soleil,aromatiques', TRUE),
(1, 'Potager Urbain', '#8BC34A', 'potager,urbain,légumes,bio', TRUE),
(2, 'Roses Anglaises', '#E91E63', 'roses,anglais,romantique', FALSE),
(3, 'Cactus & Succulentes', '#009688', 'cactus,succulentes,désert', TRUE),
(4, 'Forêt Comestible', '#795548', 'permaculture,arbres', FALSE);

/* NOTES */
INSERT INTO notes (theme_id, title, importance, content, is_favorite) VALUES
(1, 'Plantes aromatiques', 4, 'Romarin, thym, lavande.', TRUE),
(2, 'Potager sur balcon', 5, 'Optimisation espace réduit.', FALSE),
(3, 'Taille des roses', 3, 'Taille en mars.', FALSE),
(4, 'Arrosage cactus', 4, 'Très peu d’eau en hiver.', TRUE),
(5, 'Stratification forêt', 5, 'Organisation en étages.', FALSE);

/* REPORTS */
INSERT INTO reports (type, element_id, reason, reported_by) VALUES
('note', 1, 'Contenu inapproprié', 2),
('theme', 3, 'Thème offensant', 4);

SELECT n.title, count(theme_id)   FROM notes n group by id with rollup;
SELECT *
FROM notes
LIMIT 1 OFFSET 6;
SELECT importance FROM notes where importance >3
INTERSECT;
SELECT CONCAT(importance,' ',title)  FROM notes where importance <5;
select * from themes where EXISTS (select * from notes );
SELECT *
FROM notes
WHERE importance > ALL (
    SELECT importance
    FROM notes
    WHERE title = "Taille des roses"
);
