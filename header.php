<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MiamWeek <?= htmlspecialchars($titre ?? 'Gestion') ?></title>
<link rel="stylesheet" href="header.css">   
</head>

<body>

<div class="topbar">
  <a href="index.php" class="brand-name">Accueil</a>
  <div class="avatar">RA</div>
</div>

<div class="navbar">
  <a href="recette.php"    class="nav-item <?= ($page ?? '') === 'recettes' ? 'active' : '' ?>">Recettes</a>
  <a href="repas.php"       class="nav-item <?= ($page ?? '') === 'repas' ? 'active' : '' ?>">Repas</a>
  <a href="ingredients.php" class="nav-item <?= ($page ?? '') === 'ingredients' ? 'active' : '' ?>">Ingrédients</a>
  <a href="index.php"       class="nav-item <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
</div>

<div class="content">