<?php
require 'db.php';

$page  = 'recettes';
$titre = 'Recettes';
$msg   = '';

$id_user_connecte = $_SESSION['id_user'] ?? 1;

  //  AJOUTER

if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {

    $image = !empty($_POST['image_url']) ? trim($_POST['image_url']) : 'default.jpg';

    $stmt = $pdo->prepare(
        "INSERT INTO Recette 
        (nom_recette, description, temps_preparation, temps_cuisson, categorie, calories_totales, image_url, id_user)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->execute([
        trim($_POST['nom_recette']),
        trim($_POST['description']),
        (int) $_POST['temps_preparation'],
        (int) $_POST['temps_cuisson'],
        $_POST['categorie'],
        $_POST['calories_totales'],
        $image,
        $id_user_connecte,
    ]);

    $msg = '<div class="alert alert-success">Recette ajoutée !</div>';
}

  //  MODIFIER
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {

    $image = !empty($_POST['image_url']) ? trim($_POST['image_url']) : 'default.jpg';

    $stmt = $pdo->prepare(
        "UPDATE Recette
         SET nom_recette=?, description=?, temps_preparation=?, temps_cuisson=?,
             categorie=?, calories_totales=?, image_url=?
         WHERE id_recette=? AND id_user=?"
    );

    $stmt->execute([
        trim($_POST['nom_recette']),
        trim($_POST['description']),
        (int) $_POST['temps_preparation'],
        (int) $_POST['temps_cuisson'],
        $_POST['categorie'],
        $_POST['calories_totales'],
        $image,
        (int) $_POST['id_recette'],
        $id_user_connecte,
    ]);

    $msg = '<div class="alert alert-success">Recette modifiée !</div>';
}

  //  SUPPRIMER
if (isset($_GET['supprimer'])) {
    $stmt = $pdo->prepare("DELETE FROM Recette WHERE id_recette=? AND id_user=?");
    $stmt->execute([(int)$_GET['supprimer'], $id_user_connecte]);
    $msg = '<div class="alert alert-success">Recette supprimée</div>';
}

  //  EDIT
$edit = null;
if (isset($_GET['editer'])) {
    $stmt = $pdo->prepare("SELECT * FROM Recette WHERE id_recette=? AND id_user=?");
    $stmt->execute([(int)$_GET['editer'], $id_user_connecte]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

  //  SUGGESTIONS
$stmtSug = $pdo->query("SELECT * FROM Recette ORDER BY RAND() LIMIT 4");
$suggestions = $stmtSug->fetchAll(PDO::FETCH_ASSOC);

  //  PAGINATION
$parPage = 5;
$pageActuelle = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;

$stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM Recette WHERE id_user=?");
$stmtTotal->execute([$id_user_connecte]);
$total = $stmtTotal->fetchColumn();

$pages = ceil($total / $parPage);
$offset = ($pageActuelle - 1) * $parPage;

$stmt = $pdo->prepare("SELECT * FROM Recette WHERE id_user=? ORDER BY id_recette DESC LIMIT $parPage OFFSET $offset");
$stmt->execute([$id_user_connecte]);
$recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<div class="page-title">Recettes</div>
<div class="page-sub">Gérer les recettes</div>

<?= $msg ?>

<!-- SUGGESTIONS -->
<div class="panel">
  <div class="panel-title"> Suggestions</div>

  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:15px;">
    <?php foreach ($suggestions as $s): ?>
      <div style="border:1px solid #eee;padding:10px;border-radius:10px;">
        <img src="<?= htmlspecialchars($s['image_url']) ?>"
             style="width:100%;height:120px;object-fit:cover;border-radius:8px;">
        <h4><?= htmlspecialchars($s['nom_recette']) ?></h4>
        <small><?= htmlspecialchars($s['categorie']) ?></small>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- FORM -->
<div class="panel">
  <div class="panel-title">
    <?= $edit ? 'Modifier' : 'Nouvelle recette' ?>
  </div>

  <form method="POST">
    <input type="hidden" name="action" value="<?= $edit ? 'modifier' : 'ajouter' ?>">

    <?php if ($edit): ?>
      <input type="hidden" name="id_recette" value="<?= $edit['id_recette'] ?>">
    <?php endif; ?>

    <input type="text" name="nom_recette" required placeholder="Nom"
           value="<?= htmlspecialchars($edit['nom_recette'] ?? '') ?>">

    <textarea name="description"><?= htmlspecialchars($edit['description'] ?? '') ?></textarea>

    <input type="number" name="temps_preparation" placeholder="Préparation"
           value="<?= $edit['temps_preparation'] ?? 10 ?>">

    <input type="number" name="temps_cuisson" placeholder="Cuisson"
           value="<?= $edit['temps_cuisson'] ?? 0 ?>">

    <input type="number" name="calories_totales" placeholder="Calories"
           value="<?= $edit['calories_totales'] ?? 400 ?>">

    <input type="url" name="image_url" placeholder="Image URL"
           value="<?= htmlspecialchars($edit['image_url'] ?? '') ?>">

    <button class="btn btn-primary">
      <?= $edit ? 'Modifier' : 'Ajouter' ?>
    </button>
  </form>
</div>

<!-- TABLE -->
<div class="panel">
  <div class="panel-title">Liste</div>

  <table>
    <tr><th>#</th><th>Nom</th><th>Actions</th></tr>

    <?php foreach ($recettes as $r): ?>
    <tr>
      <td><?= $r['id_recette'] ?></td>
      <td><?= htmlspecialchars($r['nom_recette']) ?></td>
      <td>
        <a href="?editer=<?= $r['id_recette'] ?>">Edit</a>
        <a href="?supprimer=<?= $r['id_recette'] ?>">X</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>

  <!-- PAGINATION -->
  <div style="margin-top:10px;">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <a href="?p=<?= $i ?>" class="btn"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</div>

</div>

</div>
</body>

</html>