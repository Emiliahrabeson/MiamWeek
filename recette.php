<?php
require 'db.php';
session_start();

$id_user = $_SESSION['id_user'];
$nom_user = $_SESSION["email"];

$suggestions = $pdo->query(
    "SELECT id_recette, nom_recette, categories, calories_total, image_url FROM Recette ORDER BY RAND() LIMIT 10"
)->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM Recette");
$stmt->execute();
$recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recettes</title>
  <link rel="stylesheet" href="recette.css">
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
      <li class="up"><a href="profile.php"><?= $nom_user ?></a></li>
    </ul>
  </div>
</div>

<div class="wrap">

<div class="panel">
    <div class="panel-titre">Suggestions du moment</div>
    <div class="sug-grid">
      <?php foreach ($suggestions as $s): ?>
      <div class="sug-card" title="<?= htmlspecialchars($s['nom_recette']) ?>">
        <img src="<?= htmlspecialchars($s['image_url']) ?>"
             alt="<?= htmlspecialchars($s['nom_recette']) ?>"
        >
        <div class="sug-card-body">
          <h4><?= htmlspecialchars($s['nom_recette']) ?></h4>
          <p><?= htmlspecialchars($s['categories']) ?> : <span class="kcal"><?= (int)$s['calories_total'] ?> kcal</span></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="panel">
    <div class="panel-titre">Tous les recettes :</div>

    <?php if (empty($recettes)): ?>
      <div class="vide">Aucune recette trouvee</div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Categorie</th>
          <th>Preparation</th>
          <th>Calories</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recettes as $r): ?>
        <tr>
          <td>
            <strong><?= htmlspecialchars($r['nom_recette']) ?></strong><br>
            <span>
              <?= htmlspecialchars($r['description'])?>
            </span>
          </td>
          <td><span class="tag"><?= htmlspecialchars($r['categories']) ?></span></td>
          <td><?= $r['temps_preparation'] ?> min</td>
          <td class="kcal"><?= (int)$r['calories_total'] ?> kcal</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>

</div>
</body>
</html>

