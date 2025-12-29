create DATABASE digitalGarden;
DROP DATABASE digitalGarden;
USE digitalGarden;

-- TABLE USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL ,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
DROP TABLE users;
alter table users add COLUMN  fName VARCHAR(50) NOT NULL ;
alter table users MODIFY COLUMN  username VARCHAR(50) NOT NULL UNIQUE;

-- TABLE THEMES
CREATE TABLE themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(7) NOT NULL,
    tags TEXT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
DROP TABLE themes;
-- TABLE NOTES
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    theme_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    importance INT NOT NULL CHECK(importance BETWEEN 1 AND 5),
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
);