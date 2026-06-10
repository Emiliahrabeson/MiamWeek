<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes courses</title>
    <link rel="stylesheet" href="/css/ingredient.css">
</head>
<body>

<div class="navbar">
    <h1 class="titre">MiamWeek</h1>

    <div class="link">
        <ul>
            <li><a href="index.php?page=home">Home</a></li>
            <li><a href="index.php?page=recette">Recettes</a></li>
            <li><a href="index.php?page=ingredient">Ingredient</a></li>
            <li><a href="index.php?page=course">Mes courses</a></li>
            <li><a href="index.php?page=dashboard">Dashboard</a></li>
        </ul>
    </div>

    <div class="avatar">
        <ul>
            <li class="up">
                <a href="index.php?page=profile">
                    <?= htmlspecialchars($nom_user) ?>
                </a>
            </li>
        </ul>
    </div>
</div>

<h2>Liste de courses</h2>

<ul>
<?php foreach($liste as $ingredient): ?>
    <li>
        <?= htmlspecialchars($ingredient['nom']) ?>
        :
        <?= htmlspecialchars($ingredient['quantite']) ?>
        <?= htmlspecialchars($ingredient['unite_par_def']) ?>
    </li>
<?php endforeach; ?>
</ul>

</body>
</html>
