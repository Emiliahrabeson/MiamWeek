<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes courses</title>
    <link rel="stylesheet" href="/css/courses.css">
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
            <li class="up"><a href="index.php?page=profile"><?= htmlspecialchars($prenom_user) ?></a></li>
        </ul>
    </div>
</div>

<div class="page-wrapper">
    <h2 class="page-title">Liste de courses</h2>

    <div class="course-panel">
        <ul class="course-list">
        <?php foreach ($liste as $ingredient): ?>
            <li class="course-item <?= $ingredient['achete'] ? 'done' : '' ?>">
                <a class="check-toggle" href="index.php?page=course&toggle=<?= $ingredient['id_ingredient'] ?>&liste=<?= $ingredient['id_liste'] ?>">
                    <span class="checkbox"></span>
                    <span class="item-nom"><?= htmlspecialchars($ingredient['nom']) ?></span>
                    <span class="item-qte"><?= htmlspecialchars($ingredient['quantite']) ?> <?= htmlspecialchars($ingredient['unite_par_def']) ?></span>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>
