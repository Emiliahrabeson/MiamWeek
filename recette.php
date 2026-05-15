<?php
require 'db.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nom_user = $_SESSION["email"];

$suggestions = $pdo->query(
    "SELECT id_recette, nom_recette, categories, calories_total, image_url FROM Recette ORDER BY RAND() LIMIT 10"
)->fetchAll(PDO::FETCH_ASSOC);

$res = [];
if (isset($_POST['search'])) {
  $search = trim($_POST['search']);

  if (!empty($search)) {
    $sql = "SELECT * FROM Recette WHERE nom_recette LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%".$search."%"]);

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

  }
}
$stmt = $pdo->prepare("SELECT * FROM Recette");
$stmt->execute();
$recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['favori'])) {
  if (isset($_GET['favori'])) {
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit();
    }
    $id_recette = $_GET['favori'];

    // si déjà en favoris
    $check = $pdo->prepare("
        SELECT *
        FROM Favoris
        WHERE id_user = :id_user
        AND id_recette = :id_recette
    ");
    $check->execute([
        'id_user' => $id_user,
        'id_recette' => $id_recette
    ]);

    $exist = $check->fetch();
    // ajouter si pas déjà présent
    if (!$exist) {

        $insert = $pdo->prepare("
            INSERT INTO Favoris(id_user, id_recette)
            VALUES(:id_user, :id_recette)
        ");

        $insert->execute([
            'id_user' => $id_user,
            'id_recette' => $id_recette
        ]);
    }

    header("Location: recette.php");
    exit();
  }
}
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
          <li class="up"><a href="profile.php"><?=$nom_user?></a></li>
      </ul>
  </div>
</div>

<div class="wrap">

<div class="panel">
    <div class="search-bar">
    <form method="POST" action="">
        <input type="text" class="search-input" name="search" placeholder="Rechercher des recettes">
        <input type="submit" value="rechercher" class="submit">
    </form>
  </div>
  
    <div class="panel-titre">Suggestions du moment</div>
    <div class="sug-grid">
      <?php $data = empty($res) ? $suggestions : $res;
      foreach ($data as $s): ?>
      <div class="sug-card">
        <img src="<?= htmlspecialchars($s['image_url']) ?>"
             alt="<?= htmlspecialchars($s['nom_recette']) ?>"
        >
        <div class="sug-card-body">
          <h4><?= htmlspecialchars($s['nom_recette']) ?></h4>
          <p><?= htmlspecialchars($s['categories']) ?> : <span class="kcal"><?= (int)$s['calories_total'] ?> kcal</span></p>
           <a class="fav-btn"
            href="recette.php?favori=<?= $s['id_recette'] ?>">
              Ajouter aux favoris
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>
</body>
</html>

