CREATE DATABASE IF NOT EXISTS gamespark
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gamespark;

CREATE TABLE IF NOT EXISTS games (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    game_name VARCHAR(100) NOT NULL,
    platform ENUM('pc','playstation','xbox','nintendo') NOT NULL,
    genre ENUM('action','adventure','rpg','strategy','sports') NOT NULL,
    release_date DATE NULL,
    rating TINYINT UNSIGNED NOT NULL DEFAULT 3,
    status ENUM('wishlist','inbezit','speeltnu','uitgespeeld') NOT NULL DEFAULT 'wishlist',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_rating CHECK (rating BETWEEN 1 AND 5)
);

INSERT INTO games (game_name, platform, genre, release_date, rating, status) VALUES
    ('Elden Ring', 'pc', 'rpg', '2022-02-25', 5, 'uitgespeeld'),
    ('FC 25', 'playstation', 'sports', '2024-09-27', 3, 'speeltnu'),
    ('Civilization VI', 'pc', 'strategy', '2016-10-21', 4, 'inbezit'),
    ('Zelda: Tears of the Kingdom', 'nintendo', 'adventure', '2023-05-12', 5, 'wishlist');