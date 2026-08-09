CREATE DATABASE if0_42614554;
USE Nutrition;

CREATE TABLE IF NOT EXISTS Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    objectif_calorie_daily INT,
    date_inscription DATE,
    verification_token VARCHAR(255),
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Plan_de_repas (
    id_plan INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE,
    date_fin DATE,
    id_user INT,
    FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Jour (
    id_jour INT AUTO_INCREMENT PRIMARY KEY,
    nom_jour VARCHAR(20),
    date_jour DATE,
    id_plan INT,
    FOREIGN KEY (id_plan)
        REFERENCES Plan_de_repas(id_plan)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Repas (
    id_repas INT AUTO_INCREMENT PRIMARY KEY,
    nom_repas VARCHAR(100),
    type_repas VARCHAR(50),
    calories INT,
    id_jour INT,
    FOREIGN KEY (id_jour)
        REFERENCES Jour(id_jour)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Recette (
    id_recette INT AUTO_INCREMENT PRIMARY KEY,
    nom_recette VARCHAR(150),
    description TEXT,
    preparation TEXT,
    temps_preparation INT,
    temps_cuisson INT,
    categories VARCHAR(100),
    calories_par_centG INT,
    image_url TEXT,
    date_creation DATE,
    id_user INT,
    FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Repas_Recette (
    id_repas INT,
    id_recette INT,
    PRIMARY KEY (id_repas, id_recette),
    FOREIGN KEY (id_repas)
        REFERENCES Repas(id_repas)
        ON DELETE CASCADE,
    FOREIGN KEY (id_recette)
        REFERENCES Recette(id_recette)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Ingredient (
    id_ingredient INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    unite_par_def VARCHAR(50),
    calories_par_unite INT,
    categories VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS Recette_ingredient (
    id_recette INT,
    id_ingredient INT,
    quantite FLOAT,
    PRIMARY KEY (id_recette, id_ingredient),
    FOREIGN KEY (id_recette)
        REFERENCES Recette(id_recette)
        ON DELETE CASCADE,
    FOREIGN KEY (id_ingredient)
        REFERENCES Ingredient(id_ingredient)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Liste_course (
    id_liste INT AUTO_INCREMENT PRIMARY KEY,
    nom_liste VARCHAR(100),
    date_liste DATE,
    terminee BOOLEAN,
    id_user INT,
    id_plan INT,
    FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
        ON DELETE CASCADE,
    FOREIGN KEY (id_plan)
        REFERENCES Plan_de_repas(id_plan)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Liste_ingredient (
    id_liste INT,
    id_ingredient INT,
    quantite FLOAT,
    PRIMARY KEY (id_liste, id_ingredient),
    FOREIGN KEY (id_liste)
        REFERENCES Liste_course(id_liste)
        ON DELETE CASCADE,
    FOREIGN KEY (id_ingredient)
        REFERENCES Ingredient(id_ingredient)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Allergie (
    id_user INT,
    id_ingredient INT,
    PRIMARY KEY (id_user, id_ingredient),
    FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
        ON DELETE CASCADE,
    FOREIGN KEY (id_ingredient)
        REFERENCES Ingredient(id_ingredient)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Notification (
    id_notification INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    id_user INT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    lu TINYINT(1) DEFAULT 0,
    type_notification VARCHAR(50) NOT NULL,
    date_envoi DATETIME,
    envoyee TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Favoris (
    id_user INT,
    id_recette INT,
    date_ajout DATE,
    PRIMARY KEY (id_user, id_recette),
    FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
        ON DELETE CASCADE,
    FOREIGN KEY (id_recette)
        REFERENCES Recette(id_recette)
        ON DELETE CASCADE
);


--    VUE : INGREDIENTS DU PLAN

CREATE VIEW IF NOT EXISTS vue_ingredients_plan AS
SELECT
    j.id_plan,
    i.id_ingredient,
    i.nom,
    i.unite_par_def,
    SUM(ri.quantite) AS quantite_totale
FROM Jour j
JOIN Repas r
    ON j.id_jour = r.id_jour
JOIN Repas_Recette rr
    ON r.id_repas = rr.id_repas
JOIN Recette_ingredient ri
    ON rr.id_recette = ri.id_recette
JOIN Ingredient i
    ON ri.id_ingredient = i.id_ingredient
GROUP BY
    j.id_plan,
    i.id_ingredient,
    i.nom,
    i.unite_par_def;


--    VUE : PLANNING DES REPAS

CREATE VIEW IF NOT EXISTS vue_planning_repas AS
SELECT 
    j.id_plan,
    j.id_jour,
    j.nom_jour,
    j.date_jour,
    r.id_repas,
    r.type_repas,
    rec.id_recette,
    rec.nom_recette,
    rec.calories_par_centG
FROM Jour j
JOIN Repas r 
    ON j.id_jour = r.id_jour
LEFT JOIN Repas_Recette rr
    ON r.id_repas = rr.id_repas
LEFT JOIN Recette rec
    ON rr.id_recette = rec.id_recette;

CREATE INDEX IF NOT EXISTS idx_jour_id_plan
ON Jour(id_plan);



ALTER TABLE Liste_ingredient
ADD COLUMN achete TINYINT(1) NOT NULL DEFAULT 0;