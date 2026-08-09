<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — MiamWeek</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="navbar">
  <h1 class="titre">MiamWeek</h1>
  <div class="link">
    <ul>
      <li><a href="index.php?page=home">Home</a></li>
      <li><a href="index.php?page=recette">Recettes</a></li>
      <li><a href="index.php?page=ingredient">Ingredient</a></li>
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

    <h2 class="page-title">Dashboard</h2>

    <div class="info">
        <p class="label">Objectif calorique / jour</p>
        <p class="value"><?= $objectif ?> kcal</p>
    </div>

    <div class="sections-row">

        <div class="section">
            <h3>Allergies</h3>
            <?php foreach ($allergies as $allergie): ?>
                <div class="item">
                    <span><?= htmlspecialchars($allergie['nom']) ?></span>
                </div>
            <?php endforeach; ?>
            <?php if (empty($allergies)): ?>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Aucune allergie enregistrée.</p>
            <?php endif; ?>
        </div>

        <div class="section">
            <h3>Favoris</h3>
            <?php foreach ($favoris as $fav): ?>
                <div class="item">
                    <span><?= htmlspecialchars($fav['nom_recette']) ?></span>
                </div>
            <?php endforeach; ?>
            <?php if (empty($favoris)): ?>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Aucun favori enregistré.</p>
            <?php endif; ?>
        </div>

    </div>

    <div class="chart-card">
        <h2>Calories de la semaine</h2>
        <canvas id="caloriesChart"
            data-jours="<?= htmlspecialchars(json_encode(array_keys($caloriesSemaine))) ?>"
            data-calories="<?= htmlspecialchars(json_encode(array_values($caloriesSemaine))) ?>"
            data-objectif="<?= (int) $objectif ?>">
        </canvas>
    </div>

</div>

<script src="/javascript/dashboard.js"></script>

</body>
</html>
