
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier  <?= htmlspecialchars($repas['type_repas']) ?></title>
  <link rel="stylesheet" href="/css/index.css">
  <link rel="stylesheet" href="/css/modifier_repas.css">   
</head>
<body>

    <div class="navbar">
    <h1 class="titre">MiamWeek</h1>
    <div class="link"><ul>
        <li><a href="index.php?page=home">Home</a></li>
        <li><a href="index.php?page=recette">Recettes</a></li>
        <li><a href="index.php?page=ingredient">Ingrédient</a></li>
        <li><a href="index.php?page=dashboard">Dashboard</a></li>
    </ul>
    </div>

    <div class="avatar">
            <ul>
                <li class="up"><a href="index.php?page=profile"><?=$nom_user?></a></li>
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
                <span class="kcal"><?= $rec['calories_par_centG'] ?> kcal</span>
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
            (<?= $rec['calories_par_centG'] ?> kcal)
            </option>
        <?php endforeach; ?>
        </select>
        <button class="btn-add" type="submit"> Ajouter</button>
    </form>

    <a class="btn-retour" href="index.php?page=home"> Retour au calendrier</a>
    </div>

</body>
</html>
