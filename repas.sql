INSERT INTO Users
(nom, prenom, email, password, objectif_calorie_daily, date_inscription)
VALUES
(
    'Rabeson',
    'keirah',
    'keirah@gmail.com',
    '123456',
    2500,
    CURDATE()
);


INSERT INTO Plan_de_repas
(date_debut, date_fin, id_user)
VALUES
(
    '2026-05-06',
    '2026-05-12',
    1
);


INSERT INTO Jour
(nom_jour, date_jour, id_plan)
VALUES
('Lundi', '2026-05-06', 1),
('Mardi', '2026-05-07', 1),
('Mercredi', '2026-05-08', 1);
('Jeudi', '2026-05-09', 1);
('Vendredi', '2026-05-10', 1);
('Samedi', '2026-05-11', 1);
('Dimanche', '2026-05-12', 1);

INSERT INTO Repas
(nom_repas, type_repas, calories, id_jour)
VALUES
('Petit déjeuner', 'Matin', 500, 1),
('Déjeuner', 'Midi', 800, 1),
('Dîner', 'Soir', 700, 2);

-- INSERT INTO Recette
-- (
--     nom_recette,
--     description,
--     temps_preparation,
--     temps_cuisson,
--     categories,
--     calories_total,
--     image_url,
--     date_creation,
--     id_user
-- )
-- VALUES
-- (
--     'Omelette',
--     'Omelette aux légumes',
--     10,
--     5,
--     'Petit déjeuner',
--     400,
--     'omelette.jpg',
--     CURDATE(),
--     1
-- ),

-- (
--     'Riz Poulet',
--     'Riz avec poulet grillé',
--     20,
--     30,
--     'Déjeuner',
--     800,
--     'riz.jpg',
--     CURDATE(),
--     1
-- );


-- relier repas recette
INSERT INTO Repas_Recette
(id_repas, id_recette)

VALUES
(1, 1),
(2, 2);


-- SELECT 
--     u.id_user,
--     u.nom,
--     u.prenom,

--     p.id_plan,
--     p.date_debut,
--     p.date_fin,

--     j.nom_jour,
--     j.date_jour,

--     r.id_repas,
--     r.nom_repas,
--     r.type_repas,
--     r.calories,

--     rec.id_recette,
--     rec.nom_recette,
--     rec.calories_total

-- FROM Users u

-- JOIN Plan_de_repas p
--     ON u.id_user = p.id_user

-- JOIN Jour j
--     ON p.id_plan = j.id_plan

-- JOIN Repas r
--     ON j.id_jour = r.id_jour

-- JOIN Repas_Recette rr
--     ON r.id_repas = rr.id_repas

-- JOIN Recette rec
--     ON rr.id_recette = rec.id_recette

-- WHERE u.id_user = 1

-- ORDER BY j.date_jour;