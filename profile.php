<?php
require 'db.php';
session_start();

$username = $_SESSION["email"];

$stmt = $pdo->prepare("
    SELECT nom, prenom, objectif_calorie_daily
    FROM Users
    WHERE email = :email
");
$stmt->execute(['email' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$nom_user = $user['nom'];
$prenom_user = $user['prenom'];
$calories_daily_user = $user['objectif_calorie_daily'];

$stmt_allergie = $pdo->prepare("
    SELECT Ingredient.nom, Ingredient.id_ingredient
    FROM Allergie
    JOIN Users 
        ON Allergie.id_user = Users.id_user
    JOIN Ingredient 
        ON Allergie.id_ingredient = Ingredient.id_ingredient
    WHERE Users.email = :email
");
$stmt_allergie->execute(['email' => $username]);
$allergies = $stmt_allergie->fetchAll(PDO::FETCH_ASSOC);

$stmtFav = $pdo->prepare("
    SELECT Recette.nom_recette, Recette.id_recette
    FROM Favoris
    JOIN Users
        ON Favoris.id_user = Users.id_user
    JOIN Recette
        ON Favoris.id_recette = Recette.id_recette
    WHERE Users.email = :email
");
$stmtFav->execute(['email' => $username]);
$favoris = $stmtFav->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile">
    <div class="me">

        <img class="avatar-img" src="./assets/avatar.png" alt="avatar">
        <h2 class="username"><?= $username ?></h2>
        <div class="info">
            <p class="label">Nom</p>
            <p class="value"><?= $nom_user ?></p>
        </div>

        <div class="info">
            <p class="label">Prénom</p>
            <p class="value"><?= $prenom_user ?></p>
        </div>

        <div class="info">
            <p class="label">Objectif calorique / jour</p>
            <p class="value"><?= $calories_daily_user ?> kcal</p>
        </div>

        <div class="section">
            <h3>Allergies</h3>
        <?php foreach($allergies as $allergie): ?>
        <div class="item action-item">
            <span>
                <?= $allergie['nom'] ?>
            </span>
            <a class="delete-btn"
            href="supprimer_allergie.php?id=<?= $allergie['id_ingredient'] ?>">
                Enlever
            </a>
        </div>
    <?php endforeach; ?>

        <div class="section">
            <h3>Favoris</h3>

            <?php foreach($favoris as $fav): ?>
            <div class="item action-item">
                <span>
                    <?= $fav['nom_recette'] ?>
                </span>
                <a class="delete-btn"
                href="supprimer_favori.php?id=<?= $fav['id_recette'] ?>">
                    Enlever
                </a>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="actions">
            <a class="edit-btn" href="modifier_profile.php">
                Modifier
            </a>

            <a class="logout-btn" href="logout.php">
                Déconnecter
            </a>
        </div>

    </div>
    <div class="btn-retour">
        <a href="index.php">Retour</a>
    </div>
</div>
</body>
</html>
