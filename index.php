<?php
require 'db.php';

$page  = 'dashboard';
$titre = 'Tableau de bord';

$nb_recettes    = $pdo->query("SELECT COUNT(*) FROM Recette")->fetchColumn();
$nb_ingredients = $pdo->query("SELECT COUNT(*) FROM Ingredient")->fetchColumn();
$nb_repas       = $pdo->query("SELECT COUNT(*) FROM Repas")->fetchColumn();
$nb_plans       = $pdo->query("SELECT COUNT(*) FROM Plan_de_repas")->fetchColumn();

require 'header.php';
?>

<div class="index">
<h1 class="Bienvenue">Bienvenue sur MiamWeek</h1>

<div class="Grand_cadre">
  <div class="onglet_item">
    <img src="" alt="">
    <h2>Recettes</h2>
  </div>

  <div class="onglet_item">
    <img src="" alt="">
    <h2>Ingrédients</h2>
  </div>

  <div class="onglet_item">
    <img src="" alt="">
    <h2>Repas</h2>
  </div>

  <div class="onglet_item">
    <img src="" alt="">
    <h2>Plan de repas</h2>
  </div>

</div>
</div>


  </div>
</div>
</body>
</html>

