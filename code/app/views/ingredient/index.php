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
      <li class="up"><a href="index.php?page=profile"><?= htmlspecialchars($prenom_user) ?></a></li>
    </ul>
  </div>
</div>

<div class="page-wrapper">
  <h2 class="page-title">Ingrédients</h2>

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
      <p class="aucun"><?= $erreur_api ?></p>

    <?php elseif (!empty($ingredients)): ?>

      <?php
        $par_page = 12;
        $page_courante = max(1, (int)($_GET['p'] ?? 1));
        $total = count($ingredients);
        $nb_pages = ceil($total / $par_page);
        $debut = ($page_courante - 1) * $par_page;
        $affichage = array_slice($ingredients, $debut, $par_page);
        $search_query = urlencode($_POST['search'] ?? '');
      ?>

      <div class="ing-grid">
        <?php foreach ($affichage as $s): ?>
          <div class="ing-card">
            <span class="ing-categorie"><?= htmlspecialchars($s['categories']) ?></span>
            <h4><?= htmlspecialchars($s['nom']) ?></h4>
            <p><span class="kcal"><?= (int)$s['calories_par_centG'] ?> kcal</span> / 100g</p>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($nb_pages > 1): ?>
      <div class="pagination">
        <?php if ($page_courante > 1): ?>
          <a href="?page=ingredient&p=<?= $page_courante - 1 ?>">← Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $nb_pages; $i++): ?>
          <?php if ($i == $page_courante): ?>
            <span class="active"><?= $i ?></span>
          <?php else: ?>
            <a href="?page=ingredient&p=<?= $i ?>"><?= $i ?></a>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page_courante < $nb_pages): ?>
          <a href="?page=ingredient&p=<?= $page_courante + 1 ?>">Suivant →</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>

    <?php else: ?>
      <p class="aucun">Aucun ingrédient trouvé.</p>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
