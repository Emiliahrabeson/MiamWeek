<?php
require 'db.php';
session_start();

$id_user = $_SESSION['id_user'] ?? 1;
$msg     = '';
$search  = trim($_GET['search'] ?? '');

// AJOUTER
if (($_POST['action'] ?? '') === 'ajouter') {
    $pdo->prepare(
        "INSERT INTO Recette (nom_recette, description, temps_preparation, temps_cuisson, categories, calories_total, image_url, id_user)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    )->execute([
        trim($_POST['nom_recette']),
        trim($_POST['description']),
        (int)$_POST['temps_preparation'],
        (int)$_POST['temps_cuisson'],
        $_POST['categories'],
        (int)$_POST['calories_total'],
        !empty($_POST['image_url']) ? trim($_POST['image_url']) : 'default.jpg',
        $id_user
    ]);
    $msg = alerte('Recette ajoutee avec succes.');
}

// MODIFIER
if (($_POST['action'] ?? '') === 'modifier') {
    $pdo->prepare(
        "UPDATE Recette SET nom_recette=?, description=?, temps_preparation=?, temps_cuisson=?,
         categories=?, calories_total=?, image_url=?
         WHERE id_recette=? AND id_user=?"
    )->execute([
        trim($_POST['nom_recette']),
        trim($_POST['description']),
        (int)$_POST['temps_preparation'],
        (int)$_POST['temps_cuisson'],
        $_POST['categories'],
        (int)$_POST['calories_total'],
        !empty($_POST['image_url']) ? trim($_POST['image_url']) : 'default.jpg',
        (int)$_POST['id_recette'],
        $id_user
    ]);
    $msg = alerte('Recette modifiee.');
}

// SUPPRIMER
if (isset($_GET['supprimer'])) {
    $pdo->prepare("DELETE FROM Recette WHERE id_recette=? AND id_user=?")
        ->execute([(int)$_GET['supprimer'], $id_user]);
    header("Location: recette.php?deleted=1");
    exit;
}
if (isset($_GET['deleted'])) $msg = alerte('Recette supprimee.');

// EDITER
$edit = null;
if (isset($_GET['editer'])) {
    $s = $pdo->prepare("SELECT * FROM Recette WHERE id_recette=? AND id_user=?");
    $s->execute([(int)$_GET['editer'], $id_user]);
    $edit = $s->fetch(PDO::FETCH_ASSOC);
}

// SUGGESTIONS
$suggestions = $pdo->query(
    "SELECT id_recette, nom_recette, categories, calories_total, image_url FROM Recette ORDER BY RAND() LIMIT 7"
)->fetchAll(PDO::FETCH_ASSOC);

// PAGINATION
$parPage      = 6;
$pageActuelle = max(1, (int)($_GET['p'] ?? 1));

$stmtTotal = $pdo->prepare($search
    ? "SELECT COUNT(*) FROM Recette WHERE id_user=? AND nom_recette LIKE ?"
    : "SELECT COUNT(*) FROM Recette WHERE id_user=?"
);
$stmtTotal->execute($search ? [$id_user, "%$search%"] : [$id_user]);
$total  = $stmtTotal->fetchColumn();
$pages  = max(1, ceil($total / $parPage));
$offset = ($pageActuelle - 1) * $parPage;

$stmtList = $pdo->prepare($search
    ? "SELECT * FROM Recette WHERE id_user=? AND nom_recette LIKE ? ORDER BY id_recette DESC LIMIT $parPage OFFSET $offset"
    : "SELECT * FROM Recette WHERE id_user=? ORDER BY id_recette DESC LIMIT $parPage OFFSET $offset"
);
$stmtList->execute($search ? [$id_user, "%$search%"] : [$id_user]);
$recettes = $stmtList->fetchAll(PDO::FETCH_ASSOC);

$toutesRecettes = $pdo->query("SELECT id_recette, nom_recette FROM Recette ORDER BY nom_recette")->fetchAll(PDO::FETCH_ASSOC);

$jours = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];
$cats  = ["Entree","Plat","Dessert","Petit-dejeuner","Collation"];

function alerte($t) { return "<div class='alerte'>$t</div>"; }
function catTag($c)  { return "<span class='tag'>".htmlspecialchars($c)."</span>"; }
function lienPage($p, $s) {
    return "recette.php?p=$p" . ($s ? "&search=".urlencode($s) : '');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Recettes</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="recette.css">
</head>
<body>

<div class="topbar">
  <a href="index.php" class="brand-name">MiamWeek</a>
  <div class="avatar">RA</div>
</div>

<div class="navbar">
  <a href="recette.php"    class="nav-item active">Recettes</a>
  <a href="repas.php"      class="nav-item">Repas</a>
  <a href="ingredient.php" class="nav-item">Ingredients</a>
  <a href="index.php"      class="nav-item">Dashboard</a>
</div>

<div class="wrap">

<?= $msg ?>

<!-- RECHERCHE -->
<form method="GET" class="search-bar">
  <input type="text" name="search" placeholder="Rechercher une recette..." value="<?= htmlspecialchars($search) ?>">
  <button type="submit" class="btn btn-primary">Rechercher</button>
  <?php if ($search): ?>
    <a href="recette.php" class="btn btn-ghost">Effacer</a>
  <?php endif; ?>
</form>

<?php if (!$search): ?>

<!-- SUGGESTIONS -->
<div class="panel">
  <div class="panel-titre">Suggestions du moment</div>
  <div class="sug-grid">
    <?php foreach ($suggestions as $s): ?>
    <div class="sug-card" title="<?= htmlspecialchars($s['nom_recette']) ?>">
      <img src="<?= htmlspecialchars($s['image_url'] ?? 'default.jpg') ?>"
           alt="<?= htmlspecialchars($s['nom_recette']) ?>"
           onerror="this.src='./assets/fond.webp' ">
      <div class="sug-card-body">
        <h4><?= htmlspecialchars($s['nom_recette']) ?></h4>
        <p><?= htmlspecialchars($s['categories']) ?> &middot; <span class="kcal"><?= (int)$s['calories_total'] ?> kcal</span></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- PLAN DE LA SEMAINE -->
<div class="panel">
  <div class="panel-titre">Plan de la semaine <small>— modifiez selon vos envies</small></div>
  <form method="POST" action="plan_semaine.php">
    <div class="week-grid">
      <?php foreach ($jours as $i => $jour):
            $sug = $suggestions[$i] ?? null; ?>
      <div class="day-col">
        <h4><?= $jour ?></h4>
        <select name="repas[<?= $i ?>]">
          <option value="">Aucun</option>
          <?php foreach ($toutesRecettes as $r):
                $sel = ($sug && $sug['id_recette'] == $r['id_recette']) ? 'selected' : ''; ?>
            <option value="<?= $r['id_recette'] ?>" <?= $sel ?>>
              <?= htmlspecialchars($r['nom_recette']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="submit" class="save-plan">Enregistrer le plan</button>
  </form>
</div>

<?php endif; ?>

<!-- FORMULAIRE AJOUT et EDIT -->
<div class="panel">
  <div class="panel-titre"><?= $edit ? 'Modifier la recette' : 'Nouvelle recette' ?></div>
  <form method="POST">
    <input type="hidden" name="action" value="<?= $edit ? 'modifier' : 'ajouter' ?>">
    <?php if ($edit): ?>
      <input type="hidden" name="id_recette" value="<?= $edit['id_recette'] ?>">
    <?php endif; ?>

    <div class="form-row">
      <div class="form-group">
        <label>Nom de la recette *</label>
        <input type="text" name="nom_recette" required
               value="<?= htmlspecialchars($edit['nom_recette'] ?? '') ?>"
               placeholder="Ex : Salade nicoise">
      </div>
      <div class="form-group">
        <label>Categorie</label>
        <select name="categories">
          <?php foreach ($cats as $c): ?>
            <option <?= ($edit['categories'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Temps de preparation (min)</label>
        <input type="number" name="temps_preparation" min="0" value="<?= $edit['temps_preparation'] ?? 10 ?>">
      </div>
      <div class="form-group">
        <label>Temps de cuisson (min)</label>
        <input type="number" name="temps_cuisson" min="0" value="<?= $edit['temps_cuisson'] ?? 0 ?>">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Calories totales (kcal)</label>
        <input type="number" name="calories_total" min="0" step="0.1" value="<?= $edit['calories_total'] ?? 400 ?>">
      </div>
      <div class="form-group">
        <label>URL de l'image</label>
        <input type="text" name="image_url"
               value="<?= htmlspecialchars($edit['image_url'] ?? '') ?>"
               placeholder="https://... ou laisser vide">
      </div>
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" placeholder="Decrivez la recette..."><?= htmlspecialchars($edit['description'] ?? '') ?></textarea>
    </div>

    <div class="btn-row">
      <button type="submit" class="btn btn-primary">
        <?= $edit ? 'Enregistrer' : 'Ajouter la recette' ?>
      </button>
      <?php if ($edit): ?>
        <a href="recette.php" class="btn btn-ghost">Annuler</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<!-- LISTE DES RECETTES -->
<div class="panel">
  <div class="panel-titre">
    Mes recettes
  </div>

  <?php if (empty($recettes)): ?>
    <div class="vide">Aucune recette trouvee<?= $search ? ' pour "'.htmlspecialchars($search).'"' : '' ?>.</div>
  <?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Categorie</th>
        <th>Preparation</th>
        <th>Calories</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recettes as $r): ?>
      <tr>
        <td>
          <strong><?= htmlspecialchars($r['nom_recette']) ?></strong><br>
          <span style="color:var(--muted);font-size:12px;">
            <?= htmlspecialchars(mb_substr($r['description'] ?? '', 0, 55)) ?><?= mb_strlen($r['description'] ?? '') > 55 ? '...' : '' ?>
          </span>
        </td>
        <td><?= catTag($r['categories']) ?></td>
        <td><?= $r['temps_preparation'] ?> min</td>
        <td class="kcal"><?= (int)$r['calories_total'] ?> kcal</td>
        <td>
          <div class="actions">
            <a href="recette.php?editer=<?= $r['id_recette'] ?>" class="btn btn-ghost btn-sm">Editer</a>
            <a href="recette.php?supprimer=<?= $r['id_recette'] ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Supprimer cette recette ?')">Supprimer</a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php if ($pages > 1): ?>
  <div class="pagination">
    <?php if ($pageActuelle > 1): ?>
      <a href="<?= lienPage($pageActuelle - 1, $search) ?>">Prec</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <?php if ($i === $pageActuelle): ?>
        <span class="current"><?= $i ?></span>
      <?php else: ?>
        <a href="<?= lienPage($i, $search) ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($pageActuelle < $pages): ?>
      <a href="<?= lienPage($pageActuelle + 1, $search) ?>">Suiv</a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <?php endif; ?>
</div>

</div>
</body>
</html>