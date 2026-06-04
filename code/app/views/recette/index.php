
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recettes</title>
  <link rel="stylesheet" href="/css/recette.css">
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
          <li class="up"><a href="index.php?page=profile"><?=$nom_user?></a></li>
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
            <a class="sug-card-body" href="index.php?page=recette&favori=<?= $s['id_recette'] ?>">
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

