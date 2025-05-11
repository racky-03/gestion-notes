
-- Créer la base de données
CREATE DATABASE IF NOT EXISTS gestion_notes CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestion_notes;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin', 'etudiant') NOT NULL
);

-- Ajout d’un utilisateur admin avec login = admin et mot de passe = admin (haché)
INSERT INTO utilisateur (login, mot_de_passe, role) VALUES
('admin', '$2y$10$2MPSebhm1LMZPRtF5LKFqusrBBtv7BFYhB3z5Ig9fZCOOv2t1p/ym', 'admin');

-- Table des formations
CREATE TABLE IF NOT EXISTS formation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

-- Table des étudiants
CREATE TABLE IF NOT EXISTS etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    id_utilisateur INT NOT NULL,
    id_formation INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (id_formation) REFERENCES formation(id) ON DELETE CASCADE
);

-- Table des matières
CREATE TABLE IF NOT EXISTS matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- Table des notes
CREATE TABLE IF NOT EXISTS note (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT NOT NULL,
    id_matiere INT NOT NULL,
    valeur FLOAT NOT NULL CHECK (valeur >= 0 AND valeur <= 20),
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matiere) REFERENCES matiere(id) ON DELETE CASCADE
);
