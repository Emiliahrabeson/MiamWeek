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
    SELECT Ingredient.nom
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
    SELECT Recette.nom_recette
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
            <p>Nom : <?= $nom_user ?></p>
            <p>Prénom : <?= $prenom_user ?></p>
            <p>Objectif calorique / jour : <?= $calories_daily_user ?></p>

            <p>Allergies :</p>
            <?php foreach($allergies as $allergie): ?>
                <p><?= $allergie['nom'] ?></p>
            <?php endforeach; ?>

            <p>Favoris :</p>
            <?php foreach($favoris as $fav): ?>
                <p><?= $fav['nom_recette'] ?></p>
            <?php endforeach; ?>

            <a href="modifier_profile.php">Modifier le profile</a>
        </div>
    </div>
</body>
</html>