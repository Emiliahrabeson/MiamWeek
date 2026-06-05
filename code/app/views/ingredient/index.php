 <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingrédients</title>
  <link rel="stylesheet" href="/css/ingredient.css">
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
      <li class="up"><a href="index.php?page=profile"><?= htmlspecialchars($nom_user) ?></a></li>
    </ul>
  </div>
</div>

<div class="wrap">
  <div class="panel">

    <div class="search-bar">
      <form method="POST" action="">
        <input type="text" class="search-input" name="search"
               placeholder="Rechercher un ingrédient"
               value="<?= htmlspecialchars($_POST['search'] ?? '') ?>">
        <input type="submit" value="Rechercher" class="submit">
      </form>
    </div>

    <?php if (!empty($erreur_api)): ?>
    <p class="erreur"><?= $erreur_api ?></p>
    <?php elseif (!empty($ingredients)): ?>
        <?php foreach ($ingredients as $s): ?>
             <div class="sug-card">
            <div class="sug-card-body">
              <h4><?= htmlspecialchars($s['nom']) ?></h4>
              <p>
                <?= htmlspecialchars($s['categories']) ?> :
                <span class="kcal">
                  <?= (int)$s['calories_par_centG'] ?> kcal / 100g
                </span>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun ingrédient trouvé.</p>
    <?php endif; ?>

    </div>

  </div>
</div>

</body>
</html>
