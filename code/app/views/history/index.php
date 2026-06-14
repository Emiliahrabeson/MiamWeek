<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiamWeek</title>
    <link rel="stylesheet" href="/css/index.css">   
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
  <a href="index.php?page=notification"><img class="bell_img"src="/images/notification.png" alt="bell"></a>
  <div class="avatar">
      <ul>
          <li class="up"><a href="index.php?page=profile"><?=$nom_user?></a></li>
      </ul>
  </div>

</div>

    <h1>Historique</h1>

<div class="plan">
    <h2 class="plan-titre"> Plan de repas de la semaine</h2>

  <div class="tableau-plan">
    <table class="calendrier">
      <thead>
        <tr>
          <th class="col-type"></th>
          <?php foreach ($jours_ordre as $i => $jour): 
            $date = date('d/m', strtotime("$lundi +$i days"));
          ?>
            <th class="today">
              <span class="jour-nom"><?= $jour ?></span>
              <span class="jour-date"><?= $date ?></span>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($types_repas as $type): ?>

        <tr>
          <td class="label-repas">
            <span class="repas-nom"><?= $type ?></span>
          </td>
          <?php foreach ($jours_ordre as $jour): 
            $slot   = $planDataHistory[$jour][$type] ?? null;
            $repas  = $slot['recettes'] ?? [];
            $id_rep = $slot['id_repas'] ?? null;
          ?>
            <td class="cell-repas <?= !empty($repas) ? 'cell-filled' : 'cell-empty' ?>">
              <?php if (!empty($repas)): ?>
                <?php foreach ($repas as $rec): ?>
                  <span class="nom-recette"><?= htmlspecialchars($rec['nom']) ?></span>
                  <?php if ($rec['calories']): ?>
                    <span class="cal-badge"><?= $rec['calories'] ?> kcal</span>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </td>
          <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>

        <tr>
          <td class="label-repas">
              <span class="repas-nom">Calories</span>
          </td>
          <?php foreach ($jours_ordre as $jour): ?>
              <?php
              $totalJour = 0;

              foreach ($types_repas as $type) {
                  $totalJour += $planDataHistory[$jour][$type]['total_calories'] ?? 0;
              }
              ?>

              <td class="calories">
                  <?= $totalJour ?> kcal
              </td>

          <?php endforeach; ?>

      </tr>
        
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
