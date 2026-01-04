create DATABASE digitalGarden;
DROP DATABASE digitalGarden;
USE digitalGarden;

-- TABLE USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(50) NOT NULL ,
    username VARCHAR(50) NOT NULL UNIQUE ,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
alter table users add COLUMN status enum ("pending","active","blocked");
alter table users MODIFY status enum ("active","blocked") DEFAULT "active";
DROP TABLE users;

-- TABLE THEMES
CREATE TABLE themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(7) NOT NULL,
    tags TEXT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- Insertion pour l'utilisateur ID 1 (admin)
INSERT INTO themes (user_id, name, color, tags) VALUES
(1, 'Jardin Méditerranéen', '#4CAF50', 'méditerranée,soleil,aromatiques'),
(1, 'Potager Urbain', '#8BC34A', 'potager,urbain,légumes,bio'),
(1, 'Japonais Zen', '#009688', 'japonais,zen,minimaliste,bambou');

-- Insertion pour l'utilisateur ID 2
INSERT INTO themes (user_id, name, color, tags) VALUES
(2, 'Roses Anglaises', '#E91E63', 'roses,anglais,romantique,fleurs'),
(2, 'Herbes Culinaires', '#795548', 'herbes,cuisine,aromates,épices');

-- Insertion pour l'utilisateur ID 3
INSERT INTO themes (user_id, name, color, tags) VALUES
(3, 'Cactus & Succulentes', '#8BC34A', 'cactus,succulentes,désert,xérophile'),
(3, 'Jardin de Pluie', '#2196F3', 'pluie,écologie,eau,humidité');

-- Insertion pour l'utilisateur ID 4
INSERT INTO themes (user_id, name, color, tags) VALUES
(4, 'Forêt Comestible', '#4CAF50', 'forêt,comestible,permaculture,arbre');
DROP TABLE themes;
-- TABLE NOTES
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    theme_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    importance INT NOT NULL CHECK(importance BETWEEN 1 AND 5),
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
);
-- Insertion des notes

-- Note 1 : Pour le thème "Jardin Méditerranéen" (ID 1, utilisateur 1)
INSERT INTO notes (theme_id, title, importance, content) VALUES
(1, 'Plantes aromatiques essentielles', 4, 'Liste des plantes aromatiques pour un jardin méditerranéen : romarin, thym, lavande, sauge. Elles résistent bien à la sécheresse et embaument le jardin.');

-- Note 2 : Pour le thème "Potager Urbain" (ID 2, utilisateur 1)
INSERT INTO notes (theme_id, title, importance, content) VALUES
(2, 'Optimisation espace balcon', 5, 'Techniques pour maximiser la production sur un petit balcon : jardinières verticales, pots empilables, treillis pour tomates et concombres.');

-- Note 3 : Pour le thème "Roses Anglaises" (ID 4, utilisateur 2)
INSERT INTO notes (theme_id, title, importance, content) VALUES
(4, 'Calendrier de taille des roses', 3, 'Taille principale en mars après les gelées. Taille légère en été pour encourager la floraison. Supprimer les fleurs fanées régulièrement.');

-- Note 4 : Pour le thème "Cactus & Succulentes" (ID 6, utilisateur 3)
INSERT INTO notes (theme_id, title, importance, content) VALUES
(6, 'Arrosage en hiver', 4, 'Réduire l\'arrosage à une fois par mois en hiver. Les cactus entrent en dormance. Éviter l\'eau stagnante dans les soucoupes.');

-- Note 5 : Pour le thème "Forêt Comestible" (ID 8, utilisateur 4)
INSERT INTO notes (theme_id, title, importance, content) VALUES
(8, 'Stratification verticale', 5, 'Organiser la forêt comestible en 7 étages : grands arbres, petits arbres, arbustes, herbacées, couvre-sol, racines, grimpantes.');
CREATE TABLE role (
    id INT PRIMARY KEY,
    userRole varchar(10) DEFAULT 'user',  
    Foreign Key (id) REFERENCES users(id) ON DELETE CASCADE 
);

INSERT INTO users (fName, username, password) VALUES
('Alice', 'admin_alice', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW'),
('Bob', 'user_bob', '$2y$10$X9z6L5k8sQ7r2tY1vBw3cD4eF5gH6j7K8L9M0N1O2P3Q4R5S6T7U8V'),
('Charlie', 'user_charlie', '$2y$10$A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6'),
('Diana', 'user_diana', '$2y$10$M1N2O3P4Q5R6S7T8U9V0W1X2Y3Z4A5B6C7D8E9F0G1H2I3J4K5L6');


INSERT INTO role (id, userRole) VALUES
(1, 'admin');  