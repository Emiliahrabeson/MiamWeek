-- PostgreSQL version of the MySQL schema
-- Optional: create and connect to the database before running this file.
-- CREATE DATABASE nutrition;
-- \c nutrition

CREATE TABLE IF NOT EXISTS users (
    id_user SERIAL PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    objectif_calorie_daily INTEGER,
    date_inscription DATE,
    verification_token VARCHAR(255),
    is_verified BOOLEAN NOT NULL DEFAULT FALSE,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS plan_de_repas (
    id_plan SERIAL PRIMARY KEY,
    date_debut DATE,
    date_fin DATE,
    id_user INTEGER,
    CONSTRAINT fk_plan_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS jour (
    id_jour SERIAL PRIMARY KEY,
    nom_jour VARCHAR(20),
    date_jour DATE,
    id_plan INTEGER,
    CONSTRAINT fk_jour_plan FOREIGN KEY (id_plan)
        REFERENCES plan_de_repas(id_plan)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS repas (
    id_repas SERIAL PRIMARY KEY,
    nom_repas VARCHAR(100),
    type_repas VARCHAR(50),
    calories INTEGER,
    id_jour INTEGER,
    CONSTRAINT fk_repas_jour FOREIGN KEY (id_jour)
        REFERENCES jour(id_jour)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS recette (
    id_recette SERIAL PRIMARY KEY,
    nom_recette VARCHAR(150),
    description TEXT,
    preparation TEXT,
    temps_preparation INTEGER,
    temps_cuisson INTEGER,
    categories VARCHAR(100),
    calories_par_centg INTEGER,
    image_url TEXT,
    date_creation DATE,
    id_user INTEGER,
    CONSTRAINT fk_recette_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS repas_recette (
    id_repas INTEGER,
    id_recette INTEGER,
    PRIMARY KEY (id_repas, id_recette),
    CONSTRAINT fk_repas_recette_repas FOREIGN KEY (id_repas)
        REFERENCES repas(id_repas)
        ON DELETE CASCADE,
    CONSTRAINT fk_repas_recette_recette FOREIGN KEY (id_recette)
        REFERENCES recette(id_recette)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ingredient (
    id_ingredient SERIAL PRIMARY KEY,
    nom VARCHAR(100),
    unite_par_def VARCHAR(50),
    calories_par_unite INTEGER,
    categories VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS recette_ingredient (
    id_recette INTEGER,
    id_ingredient INTEGER,
    quantite REAL,
    PRIMARY KEY (id_recette, id_ingredient),
    CONSTRAINT fk_recette_ingredient_recette FOREIGN KEY (id_recette)
        REFERENCES recette(id_recette)
        ON DELETE CASCADE,
    CONSTRAINT fk_recette_ingredient_ingredient FOREIGN KEY (id_ingredient)
        REFERENCES ingredient(id_ingredient)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS liste_course (
    id_liste SERIAL PRIMARY KEY,
    nom_liste VARCHAR(100),
    date_liste DATE,
    terminee BOOLEAN,
    id_user INTEGER,
    id_plan INTEGER,
    CONSTRAINT fk_liste_course_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE,
    CONSTRAINT fk_liste_course_plan FOREIGN KEY (id_plan)
        REFERENCES plan_de_repas(id_plan)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS liste_ingredient (
    id_liste INTEGER,
    id_ingredient INTEGER,
    quantite REAL,
    achete BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id_liste, id_ingredient),
    CONSTRAINT fk_liste_ingredient_liste FOREIGN KEY (id_liste)
        REFERENCES liste_course(id_liste)
        ON DELETE CASCADE,
    CONSTRAINT fk_liste_ingredient_ingredient FOREIGN KEY (id_ingredient)
        REFERENCES ingredient(id_ingredient)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS allergie (
    id_user INTEGER,
    id_ingredient INTEGER,
    PRIMARY KEY (id_user, id_ingredient),
    CONSTRAINT fk_allergie_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE,
    CONSTRAINT fk_allergie_ingredient FOREIGN KEY (id_ingredient)
        REFERENCES ingredient(id_ingredient)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS notification (
    id_notification SERIAL PRIMARY KEY,
    message TEXT,
    id_user INTEGER,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lu BOOLEAN DEFAULT FALSE,
    type_notification VARCHAR(50) NOT NULL,
    date_envoi TIMESTAMP,
    envoyee BOOLEAN DEFAULT FALSE,
    CONSTRAINT fk_notification_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS favoris (
    id_user INTEGER,
    id_recette INTEGER,
    date_ajout DATE,
    PRIMARY KEY (id_user, id_recette),
    CONSTRAINT fk_favoris_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE,
    CONSTRAINT fk_favoris_recette FOREIGN KEY (id_recette)
        REFERENCES recette(id_recette)
        ON DELETE CASCADE
);

CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER users_updated_at
BEFORE UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();

DROP VIEW IF EXISTS vue_ingredients_plan CASCADE;
CREATE VIEW vue_ingredients_plan AS
SELECT
    j.id_plan,
    i.id_ingredient,
    i.nom,
    i.unite_par_def,
    SUM(ri.quantite) AS quantite_totale
FROM jour j
JOIN repas r
    ON j.id_jour = r.id_jour
JOIN repas_recette rr
    ON r.id_repas = rr.id_repas
JOIN recette_ingredient ri
    ON rr.id_recette = ri.id_recette
JOIN ingredient i
    ON ri.id_ingredient = i.id_ingredient
GROUP BY
    j.id_plan,
    i.id_ingredient,
    i.nom,
    i.unite_par_def;

DROP VIEW IF EXISTS vue_planning_repas CASCADE;
CREATE VIEW vue_planning_repas AS
SELECT
    j.id_plan,
    j.id_jour,
    j.nom_jour,
    j.date_jour,
    r.id_repas,
    r.type_repas,
    rec.id_recette,
    rec.nom_recette,
    rec.calories_par_centg
FROM jour j
JOIN repas r
    ON j.id_jour = r.id_jour
LEFT JOIN repas_recette rr
    ON r.id_repas = rr.id_repas
LEFT JOIN recette rec
    ON rr.id_recette = rec.id_recette;

CREATE INDEX IF NOT EXISTS idx_jour_id_plan
ON jour(id_plan);
