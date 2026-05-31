<?php
require 'db.php';
session_start();

$nom_user = $_SESSION["email"];

$id_repas = (int)($_GET['id_repas'] ?? 0);
if (!$id_repas) {
     header('Location: index.php');
    exit;
 }

$repas = $pdo->prepare(
    "SELECT r.*, j.nom_jour, j.date_jour
     FROM Repas r JOIN Jour j ON r.id_jour = j.id_jour
     WHERE r.id_repas = ?"
);
$repas->execute([$id_repas]);
$repas = $repas->fetch();


$recettes_liees = $pdo->prepare(
    "SELECT rec.* FROM Recette rec
     JOIN Repas_Recette rr ON rec.id_recette = rr.id_recette
     WHERE rr.id_repas = ?"
);
$recettes_liees->execute([$id_repas]);
$recettes_liees = $recettes_liees->fetchAll();

$toutes = $pdo->query("SELECT id_recette, nom_recette, calories_total FROM Recette ORDER BY nom_recette")->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'ajouter' && isset($_POST['id_recette'])) {
        $id_rec = (int)$_POST['id_recette'];
        $pdo->prepare(
            "INSERT IGNORE INTO Repas_Recette (id_repas, id_recette) VALUES (?, ?)"
        )->execute([$id_repas, $id_rec]);
        // maj calories du repas
        $pdo->prepare(
            "UPDATE Repas SET calories = (
                SELECT COALESCE(SUM(rec.calories_total),0)
                FROM Repas_Recette rr JOIN Recette rec ON rr.id_recette = rec.id_recette
                WHERE rr.id_repas = ?
             ) WHERE id_repas = ?"
        )->execute([$id_repas, $id_repas]);
    }

    if ($action === 'supprimer' && isset($_POST['id_recette'])) {
        $id_rec = (int)$_POST['id_recette'];
        $pdo->prepare(
            "DELETE FROM Repas_Recette WHERE id_repas = ? AND id_recette = ?"
        )->execute([$id_repas, $id_rec]);
    }

    header("Location: modifier_repas.php?id_repas=$id_repas");
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier  <?= htmlspecialchars($repas['type_repas']) ?></title>
  <link rel="stylesheet" href="./style/index.css">
  <link rel="stylesheet" href="./style/modifier_repas.css">   
</head>
<body>

<div class="navbar">
  <h1 class="titre">MiamWeek</h1>
  <div class="link"><ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="Recette.php">Recettes</a></li>
    <li><a href="Ingredient.php">Ingrédient</a></li>
    <li><a href="dashboard.php">Dashboard</a></li>
  </ul>
</div>

  <div class="avatar">
        <ul>
            <li class="up"><a href="profile.php"><?=$nom_user?></a></li>
        </ul>
    </div>
</div>

<div class="modifier-wrapper">
  <h2><?= $repas['type_repas'] ?></h2>
  <p class="sub">
    <?= htmlspecialchars($repas['nom_jour']) ?>  <?= date('d/m/Y', strtotime($repas['date_jour'])) ?>
  </p>

  <p class="section-title">Recettes dans ce repas</p>
  <?php if (empty($recettes_liees)): ?>
    <p>Aucune recette pour l'instant</p>
  <?php else: ?>
    <ul class="recettes-liees">
      <?php foreach ($recettes_liees as $rec): ?>
        <li>
          <span>
            <?= htmlspecialchars($rec['nom_recette']) ?>
            <span class="kcal"><?= $rec['calories_total'] ?> kcal</span>
          </span>
          <form method="POST">
            <input type="hidden" name="action" value="supprimer">
            <input type="hidden" name="id_recette" value="<?= $rec['id_recette'] ?>">
            <button class="btn-sup" type="submit"> Retirer</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <hr class="divider">


  <p class="section-title">Ajouter une recette</p>
  <form method="POST" class="ajouter-form">
    <input type="hidden" name="action" value="ajouter">
    <select name="id_recette" required>
      <option value=""> Choisir une recette </option>
      <?php foreach ($toutes as $rec): ?>
        <option value="<?= $rec['id_recette'] ?>">
          <?= htmlspecialchars($rec['nom_recette']) ?>
          (<?= $rec['calories_total'] ?> kcal)
        </option>
      <?php endforeach; ?>
    </select>
    <button class="btn-add" type="submit"> Ajouter</button>
  </form>

  <a class="btn-retour" href="index.php"> Retour au calendrier</a>
</div>

</body>
</html>
