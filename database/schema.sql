CREATE DATABASE IF NOT EXISTS yakrostyle
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE yakrostyle;

-- Catégories (basées sur le sondage : Hommes, Femmes, Enfants)
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Produits (avec style, tissu, genre)
CREATE TABLE produits (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categorie_id INT UNSIGNED NOT NULL,
    genre ENUM('homme','femme','enfant','mixte') DEFAULT 'mixte',
    nom VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    image VARCHAR(300) DEFAULT 'default.jpg',
    style VARCHAR(50) DEFAULT NULL,      -- simple, chic, fashion, sportswear, traditionnel
    tissu VARCHAR(50) DEFAULT NULL,      -- coton, jean, bazin, wax, lin
    actif TINYINT(1) DEFAULT 1,
    promo TINYINT(1) DEFAULT 0,          -- pour mettre en avant les promotions
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

-- Utilisateurs (avec role admin/client)
CREATE TABLE utilisateurs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('client','admin') DEFAULT 'client',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Commandes
CREATE TABLE commandes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    statut ENUM('en_attente','confirmee','expediee','livree','annulee') DEFAULT 'en_attente',
    total DECIMAL(10,2) NOT NULL,
    adresse TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id)
);

-- Lignes de commande
CREATE TABLE commande_lignes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    commande_id INT UNSIGNED NOT NULL,
    produit_id INT UNSIGNED NOT NULL,
    quantite INT UNSIGNED NOT NULL,
    prix_unit DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id)
);

-- =====================================================
-- DONNÉES INITIALES (inspirées du sondage)
-- =====================================================
INSERT INTO categories (nom, slug) VALUES
('Hommes', 'hommes'),
('Femmes', 'femmes'),
('Enfants', 'enfants');

-- Produits homme (prix adaptés : 5k-10k FCFA)
INSERT INTO produits (categorie_id, genre, nom, slug, description, prix, stock, image, style, tissu) VALUES
(1, 'homme', 'T-shirt Classic Blanc', 'tshirt-classic-blanc', 'Coton bio, coupe confortable, idéal pour le quotidien', 3500, 50, 'tshirt_blanc.jpg', 'simple', 'coton'),
(1, 'homme', 'Jean Slim Bleu', 'jean-slim-bleu', 'Tissu stretch, longueur 32, pour un look moderne', 8500, 30, 'jean_bleu.jpg', 'chic', 'jean'),
(1, 'homme', 'Chemise Chic', 'chemise-chic', 'Chemise en coton, coupe ajustée, parfaite pour le bureau', 7500, 25, 'chemise_chic.jpg', 'chic', 'coton');

-- Produits femme (robe wax, ensemble bazin)
INSERT INTO produits (categorie_id, genre, nom, slug, description, prix, stock, image, style, tissu) VALUES
(2, 'femme', 'Robe Wax Africaine', 'robe-wax', 'Pagne wax haute qualité, motifs colorés', 12500, 20, 'robe_wax.jpg', 'traditionnel', 'wax'),
(2, 'femme', 'Ensemble Bazin Brodé', 'ensemble-bazin', 'Bazin riche, 2 pièces (top + jupe), broderie fine', 22500, 15, 'ensemble_bazin.jpg', 'chic', 'bazin'),
(2, 'femme', 'T-shirt Femme Coton', 'tshirt-femme-coton', 'T-shirt basique doux, plusieurs couleurs', 3500, 40, 'tshirt_femme.jpg', 'simple', 'coton');

-- Produits enfant (tenue scolaire, tenue de fête)
INSERT INTO produits (categorie_id, genre, nom, slug, description, prix, stock, image, style, tissu) VALUES
(3, 'enfant', 'Tenue Scolaire Garçon', 'tenue-scolaire-garcon', 'Polo + short kaki, résistant', 4500, 40, 'scolaire_garcon.jpg', 'simple', 'coton'),
(3, 'enfant', 'Robe Fête Fille', 'robe-fete-fille', 'Robe en wax, pour cérémonies', 5500, 25, 'robe_fete_fille.jpg', 'chic', 'wax');

-- Utilisateurs (mot de passe = "password" hashé)
INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES
('Admin Yakro', 'admin@yakrostyle.ci', '$2y$10$92IXUNpkj00rQ05byMi.Ye4oKeAa3R0911C/.og/at2.uheWG/igi', 'admin'),
('Client Test', 'client@test.ci', '$2y$10$92IXUNpkj00rQ05byMi.Ye4oKeAa3R0911C/.og/at2.uheWG/igi', 'client');