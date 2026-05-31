
<?php
session_start();
require 'db.php';
$id_user = $_SESSION["id_user"];
$nom_user = $_SESSION["email"];


$lundi    = date('Y-m-d', strtotime('monday this week'));
$dimanche = date('Y-m-d', strtotime('sunday this week'));

$stmt = $pdo->prepare(
    "SELECT id_plan FROM Plan_de_repas WHERE id_user = ? AND date_debut = ?"
);
$stmt->execute([$id_user, $lundi]);
$plan = $stmt->fetch();

if (!$plan) {
    $pdo->prepare(
        "INSERT INTO Plan_de_repas (date_debut, date_fin, id_user) VALUES (?, ?, ?)"
    )->execute([$lundi, $dimanche, $id_user]);
    $id_plan = $pdo->lastInsertId();

    $jours_labels = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    $types_repas  = ['Petit-déjeuner','Déjeuner','Dîner'];

    for ($i = 0; $i < 7; $i++) {
        $date_jour = date('Y-m-d', strtotime("$lundi +$i days"));

        $pdo->prepare(
            "INSERT INTO Jour (nom_jour, date_jour, id_plan) VALUES (?, ?, ?)"
        )->execute([$jours_labels[$i], $date_jour, $id_plan]);
        $id_jour = $pdo->lastInsertId();

        foreach ($types_repas as $type) {
            $pdo->prepare(
                "INSERT INTO Repas (nom_repas, type_repas, calories, id_jour)
                 VALUES (?, ?, 0, ?)"
            )->execute([$type, $type, $id_jour]);
        }
    }
} else {
    $id_plan = $plan['id_plan'];
}

$stmt = $pdo->prepare("
    SELECT
        j.id_jour,
        j.nom_jour,
        j.date_jour,
        r.id_repas,
        r.type_repas,
        rec.id_recette,
        rec.nom_recette,
        rec.calories_par_centG
    FROM Jour j
    JOIN Repas r ON j.id_jour = r.id_jour
    LEFT JOIN Repas_Recette rr ON r.id_repas = rr.id_repas
    LEFT JOIN Recette rec ON rr.id_recette = rec.id_recette
    WHERE j.id_plan = ?
    ORDER BY j.date_jour, r.type_repas
");
$stmt->execute([$id_plan]);

$planData = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $jour = $row['nom_jour'];
    $type = $row['type_repas'];

    if (!isset($planData[$jour][$type])) {
        $planData[$jour][$type] = [
            'id_repas' => $row['id_repas'],
            'recettes' => []
        ];
    }
    if ($row['id_recette']) {
        $planData[$jour][$type]['recettes'][] = [
            'id'       => $row['id_recette'],
            'nom'      => $row['nom_recette'],
            'calories' => $row['calories_total']
        ];
    }
}

$nb_recettes    = $pdo->query("SELECT COUNT(*) FROM Recette")->fetchColumn();
$nb_ingredients = $pdo->query("SELECT COUNT(*) FROM Ingredient")->fetchColumn();
$nb_repas       = $pdo->query("SELECT COUNT(*) FROM Repas")->fetchColumn();
$nb_plans       = $pdo->query("SELECT COUNT(*) FROM Plan_de_repas")->fetchColumn();

$jours_ordre = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
$types_repas = ['Petit-déjeuner','Déjeuner','Dîner'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiamWeek</title>
    <link rel="stylesheet" href="./style/index.css">   
</head>
<body>
<div class="navbar">
  <h1 class="titre">MiamWeek</h1>

  <div class="link">
      <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="recette.php">Recettes</a></li>
          <li><a href="Ingredient.php">Ingredient</a></li>
          <li><a href="dashboard.php">Dashboard</a></li>
      </ul>
  </div>
  <div class="avatar">
      <ul>
          <li class="up"><a href="profile.php"><?=$nom_user?></a></li>
      </ul>
  </div>

</div>


<div class="titre">
    <h1>Bienvenue sur MiamWeek</h1>

<div class="statistique">

  <div class="stat-card">
    <h3>Recettes</h3>
    <p><?= $nb_recettes ?></p>
  </div>

  <div class="stat-card">
    <h3>Ingrédients</h3>
    <p><?= $nb_ingredients ?></p>
  </div>

  <div class="stat-card">
    <h3>Repas</h3>
    <p><?= $nb_repas ?></p>
  </div>

  <div class="stat-card">
    <h3>Plans</h3>
    <p><?= $nb_plans ?></p>
  </div>

</div>


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
            $slot   = $planData[$jour][$type] ?? null;
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
                <a href="modifier_repas.php?id_repas=<?= $id_rep ?>"
                   class="btn-modifier"> Modifier</a>
              <?php else: ?>
                <span class="vide-icon">+</span>
                <a href="modifier_repas.php?id_repas=<?= $id_rep ?>"
                   class="btn-ajouter">Ajouter</a>
              <?php endif; ?>
            </td>
          <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>

