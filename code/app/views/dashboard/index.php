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
            <li class="up"><a href="index.php?page=profile"><?= $nom_user ?></a></li>
        </ul>
    </div>
</div>

<div class="dashboard-wrapper">

    <h1>Dashboard</h1>
    <div class="info">
        <p class="label">Objectif calorique / jour</p>
        <p class="value"><?= $user['objectif_calorie_daily'] ?> kcal</p>
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
        <canvas id="caloriesChart"></canvas>
    </div>

</div>

<script>
const jours = <?= json_encode(array_keys($caloriesSemaine)) ?>;
const calories = <?= json_encode(array_values($caloriesSemaine)) ?>;
const objectif = <?= (int) $objectif ?>;

new Chart(document.getElementById('caloriesChart'), {
    type: 'line',
    data: {
        labels: jours,
        datasets: [
            {
                label: 'Calories consommées',
                data: calories,
                borderColor: '#e8a020',
                backgroundColor: 'rgba(232,160,32,0.12)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#e8a020',
                pointBorderColor: '#0e0e0e',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
            },
            {
                label: 'Objectif calorique',
                data: Array(7).fill(objectif),
                borderColor: 'rgba(240,236,228,0.25)',
                borderDash: [6, 4],
                pointRadius: 0,
                tension: 0,
                fill: false,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'rgba(240,236,228,0.7)',
                    font: { family: 'Outfit', size: 13 },
                    boxWidth: 12,
                    padding: 20,
                }
            },
            tooltip: {
                backgroundColor: 'rgba(14,14,14,0.92)',
                borderColor: 'rgba(232,160,32,0.4)',
                borderWidth: 1,
                titleColor: '#e8a020',
                bodyColor: '#f0ece4',
                padding: 12,
                titleFont: { family: 'Outfit', weight: '600' },
                bodyFont:  { family: 'Outfit' },
                callbacks: {
                    label: ctx => ` ${ctx.parsed.y} kcal`
                }
            }
        },
        scales: {
            x: {
                grid:  { color: 'rgba(255,255,255,0.05)' },
                ticks: { color: 'rgba(240,236,228,0.55)', font: { family: 'Outfit' } }
            },
            y: {
                grid:  { color: 'rgba(255,255,255,0.05)' },
                ticks: {
                    color: 'rgba(240,236,228,0.55)',
                    font:  { family: 'Outfit' },
                    callback: v => v + ' kcal'
                }
            }
        }
    }
});
</script>

</body>
</html>
