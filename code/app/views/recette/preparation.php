<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recette['nom_recette']) ?> MiamWeek</title>
    <link rel="stylesheet" href="/css/preparation.css">
</head>
<body>

<div class="navbar">
    <h1 class="titre">MiamWeek</h1>
    <div class="link">
        <ul>
            <li><a href="index.php?page=home">Home</a></li>
            <li><a href="index.php?page=recette">Recettes</a></li>
            <li><a href="index.php?page=ingredient">Ingrédient</a></li>
            <li><a href="index.php?page=dashboard">Dashboard</a></li>
        </ul>
    </div>
    <div class="avatar">
        <ul>
            <li class="up"><a href="index.php?page=profile"><?= $prenom_user ?></a></li>
        </ul>
    </div>
</div>

<div class="wrap">
    <a href="index.php?page=recette" class="retour"> Retour aux recettes</a>

    <h2 class="page-title"><?= htmlspecialchars($recette['nom_recette']) ?></h2>

    <div class="prep-hero">
        <img src="<?= htmlspecialchars($recette['image_url']) ?>" alt="<?= htmlspecialchars($recette['nom_recette']) ?>" class="prep-image">

        <div class="prep-hero-info">
            <span class="badge-categorie"><?= htmlspecialchars($recette['categories']) ?></span>
            <p class="prep-description"><?= htmlspecialchars($recette['description']) ?></p>

            <div class="prep-stats">
                <div class="stat">
                    <span class="stat-valeur"><?= (int)$recette['temps_preparation'] ?> min</span>
                    <span class="stat-label">Préparation</span>
                </div>
                <div class="stat">
                    <span class="stat-valeur"><?= (int)$recette['temps_cuisson'] ?> min</span>
                    <span class="stat-label">Cuisson</span>
                </div>
                <div class="stat">
                    <span class="stat-valeur"><?= (int)$recette['calories_par_centG'] ?> kcal</span>
                    <span class="stat-label">/ 100 g</span>
                </div>
            </div>

            <a class="favori-btn" href="index.php?page=recette&favori=<?= $recette['id_recette'] ?>">
                Ajouter aux favoris
            </a>
        </div>
    </div>

    <div class="prep-steps-panel">
        <div class="prep-ingredients-panel">
            <h3 class="steps-titre">Ingrédients</h3>
            <div class="ingredients-list">
                <?php foreach ($ingredients as $ing): ?>
                    <div class="ingredient-item">
                        <span class="ingredient-nom"><?= htmlspecialchars($ing['nom']) ?></span>
                        <span class="ingredient-qte">
                            <?= (float)$ing['quantite'] ?> <?= htmlspecialchars($ing['unite_par_def']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <h3 class="steps-titre">Préparation</h3>
        <div class="steps-list">
            <?php foreach (explode("\n", $recette['preparation']) as $etape): ?>
                <?php $etape = trim($etape); ?>
                <?php if ($etape !== ''): ?>
                    <div class="step"><?= htmlspecialchars($etape) ?></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

</div>

</body>
</html>

