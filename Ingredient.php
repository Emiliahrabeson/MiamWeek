<?php
require 'db.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$nom_user = $_SESSION["email"];
$ingredients = [];

if (isset($_POST['search'])) {
    $search = trim($_POST['search']);

    $stmt = $pdo->prepare("SELECT * FROM Ingredient WHERE nom LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ingredients)) {
        $url = "https://world.openfoodfacts.org/cgi/search.pl?search_terms=" . urlencode($search) . "&json=1&page_size=50";

        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'header'  => "User-Agent: MiamWeek/1.0 (contact@miamweek.fr)\r\n"
            ]
        ]);

        $raw  = file_get_contents($url, false, $context);
        $data = json_decode($raw, true);

        if (!empty($data['products'])) {
            foreach ($data['products'] as $p) {

                $nom = trim($p['product_name_fr'] ?? $p['product_name'] ?? '');
                $nom = ucfirst(strtolower($nom));

                if (empty($nom)) continue;

                // Ignorer si déjà en BDD
                $check = $pdo->prepare("SELECT id_ingredient FROM Ingredient WHERE nom = :nom");
                $check->execute(['nom' => $nom]);
                $exists = $check->fetchColumn();
            if ($exists) continue;

                $calories  = round($p['nutriments']['energy-kcal_100g'] ?? 0);
                $categorie = trim(str_replace(['en:', 'fr:'], '', $p['categories_tags'][0] ?? 'autre'));

                $pdo->prepare("INSERT INTO Ingredient (nom, unite_par_def, calories_par_centG, categories)
                               VALUES (:nom, 'g', :calories, :categories)")
                    ->execute(['nom' => $nom, 'calories' => $calories, 'categories' => $categorie]);

                break;
            }

            $stmt = $pdo->prepare("SELECT * FROM Ingredient WHERE nom LIKE :search");
            $stmt->execute(['search' => "%$search%"]);
            $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

} else {
    $stmt = $pdo->prepare("SELECT * FROM Ingredient");
    $stmt->execute();
    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingrédients</title>
  <link rel="stylesheet" href="./style/Ingredient.css">
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
      <li class="up"><a href="profile.php"><?= htmlspecialchars($nom_user) ?></a></li>
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

    <div class="sug-grid">
      <?php if (!empty($ingredients)): ?>
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
