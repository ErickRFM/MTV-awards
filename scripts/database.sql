CREATE DATABASE IF NOT EXISTS `DataMTVAwards` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `DataMTVAwards`;

CREATE TABLE IF NOT EXISTS roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  display_name VARCHAR(150) DEFAULT NULL,
  role_id INT NOT NULL DEFAULT 3,
  avatar VARCHAR(255) DEFAULT NULL,
  status TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS genres (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS artists (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  pseudonym VARCHAR(150) DEFAULT NULL,
  sex VARCHAR(20) DEFAULT NULL,
  nationality VARCHAR(100) DEFAULT NULL,
  biography TEXT DEFAULT NULL,
  photo VARCHAR(255) DEFAULT NULL,
  status TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS albums (
  id INT AUTO_INCREMENT PRIMARY KEY,
  artist_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  release_date DATE DEFAULT NULL,
  description TEXT DEFAULT NULL,
  cover VARCHAR(255) DEFAULT NULL,
  genre_id INT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_albums_artist FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE,
  CONSTRAINT fk_albums_genre FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS songs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  album_id INT DEFAULT NULL,
  title VARCHAR(255) NOT NULL,
  cover VARCHAR(255) DEFAULT NULL,
  release_date DATE DEFAULT NULL,
  genre_id INT DEFAULT NULL,
  mp3_url VARCHAR(500) DEFAULT NULL,
  video_url VARCHAR(500) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_songs_album FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE SET NULL,
  CONSTRAINT fk_songs_genre FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS nominations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  type ENUM('artist', 'album') NOT NULL,
  category VARCHAR(150) DEFAULT NULL,
  start_date DATETIME DEFAULT NULL,
  end_date DATETIME DEFAULT NULL,
  status ENUM('active', 'closed', 'finished') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS nomination_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nomination_id INT NOT NULL,
  artist_id INT DEFAULT NULL,
  album_id INT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_nomination_items_nomination FOREIGN KEY (nomination_id) REFERENCES nominations(id) ON DELETE CASCADE,
  CONSTRAINT fk_nomination_items_artist FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE SET NULL,
  CONSTRAINT fk_nomination_items_album FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  nomination_id INT NOT NULL,
  nomination_item_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_votes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_votes_nomination FOREIGN KEY (nomination_id) REFERENCES nominations(id) ON DELETE CASCADE,
  CONSTRAINT fk_votes_nomination_item FOREIGN KEY (nomination_item_id) REFERENCES nomination_items(id) ON DELETE CASCADE,
  UNIQUE KEY unique_vote (user_id, nomination_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles (id, name) VALUES
(1, 'Administrator'),
(2, 'Manager'),
(3, 'Audience')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO genres (id, name) VALUES
(1, 'Pop'),
(2, 'Rock'),
(3, 'Hip Hop'),
(4, 'Electronic'),
(5, 'Regional Mexicano'),
(6, 'Latin')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO users (username, email, password, display_name, role_id, avatar, status)
VALUES (
  'adminmtv',
  'usermtv@awards.com',
  '$2y$10$HA2E/t7Omu.sReO5i1Ok8OiDA9jV3aDUOOJGTrledc4X8VdD88OJ.',
  'Administrador MTV Awards',
  1,
  'uploads/users/man.png',
  1
)
ON DUPLICATE KEY UPDATE
  password = VALUES(password),
  display_name = VALUES(display_name),
  role_id = VALUES(role_id),
  avatar = VALUES(avatar),
  status = VALUES(status);
