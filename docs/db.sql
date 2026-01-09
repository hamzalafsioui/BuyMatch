/* =========================== DATABASE =========================== */

DROP DATABASE IF EXISTS buyMatch_db;
CREATE DATABASE buyMatch_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE buyMatch_db;


/* =========================== ROLES =========================== */

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO roles (name) VALUES
('USER'),
('ORGANIZER'),
('ADMIN');


/* =========================== USERS =========================== */

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    img_path VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);


/* =========================== ORGANIZERS =========================== */

CREATE TABLE organizers (
    user_id INT PRIMARY KEY,
    company_name VARCHAR(150),
    logo VARCHAR(255),
    bio TEXT,
    is_acceptable BOOLEAN DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);


/* =========================== TEAMS =========================== */

CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255)
);


/* =========================== VENUES =========================== */

CREATE TABLE venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    city VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    capacity INT 
);


/* =========================== MATCHES =========================== */

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organizer_id INT NOT NULL,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    venue_id INT NOT NULL,
    match_datetime DATETIME NOT NULL,
    duration_min INT DEFAULT 90,
    total_seats INT,
    ticket_price DECIMAL(8,2) NOT NULL,
    status ENUM('DRAFT','PUBLISHED','FINISHED') DEFAULT 'DRAFT',
    request_status ENUM('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING',
    avg_rating FLOAT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id),
    FOREIGN KEY (home_team_id) REFERENCES teams(id),
    FOREIGN KEY (away_team_id) REFERENCES teams(id),
    FOREIGN KEY (venue_id) REFERENCES venues(id)
);


/* =========================== SEAT CATEGORIES =========================== */

CREATE TABLE seat_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (match_id) REFERENCES matches(id)
    ON DELETE CASCADE
);


/* =========================== SEATS =========================== */

CREATE TABLE seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    category_id INT NOT NULL,
    seat_number VARCHAR(10) NOT NULL,
    FOREIGN KEY (match_id) REFERENCES matches(id),
    FOREIGN KEY (category_id) REFERENCES seat_categories(id),
    UNIQUE (match_id, seat_number)
);


/* =========================== TICKETS =========================== */

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    seat_id INT UNIQUE,
    price_paid DECIMAL(10,2) NOT NULL,
    qr_code VARCHAR(255),
    status ENUM('VALID','USED','CANCELLED') DEFAULT 'VALID',
    purchase_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (match_id) REFERENCES matches(id),
    FOREIGN KEY (seat_id) REFERENCES seats(id)
);


/* =========================== REVIEWS =========================== */

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (match_id) REFERENCES matches(id),
    UNIQUE (user_id, match_id)
);

/* =========================== EVENT update_finished_matches =========================== */

CREATE EVENT IF NOT EXISTS update_finished_matches
ON SCHEDULE EVERY 2 MINUTE
ON COMPLETION PRESERVE
DO
UPDATE matches
SET status = 'FINISHED'
WHERE status = 'PUBLISHED'
  AND ADDTIME(match_datetime, SEC_TO_TIME(duration_min * 60)) < NOW();