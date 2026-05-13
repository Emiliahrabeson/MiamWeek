<?php
require 'db.php';
session_start();

$email = $_SESSION["email"];


$stmtUser = $pdo->prepare("
    SELECT id_user, objectif_calorie_daily
    FROM Users
    WHERE email = :email
");
$stmtUser->execute(['email' => $email]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);
$id_user = $user['id_user'];

//cal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST["calories"])) {
        $calories = $_POST["calories"];
    }
    $update = $pdo->prepare("
            UPDATE Users
            SET objectif_calorie_daily = :calories
            WHERE id_user = :id_user
    ");
    $update->execute([
        'calories' => $calories,
        'id_user' => $id_user
    ]);
}

//ajout fav
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["allergie"])) {
        $allergie = $_POST["allergie"];

        // chercher ingredient
        $stmtIng = $pdo->prepare("
            SELECT id_ingredient
            FROM Ingredient
            WHERE nom = :nom
        ");
        $stmtIng->execute(['nom' => $allergie]);
        $ingredient = $stmtIng->fetch(PDO::FETCH_ASSOC);

        if ($ingredient) {
            $id_ingredient = $ingredient['id_ingredient'];

            $insertAll = $pdo->prepare("
                INSERT INTO Allergie(id_user, id_ingredient)
                VALUES(:id_user, :id_ingredient)
            ");
            $insertAll->execute([
                'id_user' => $id_user,
                'id_ingredient' => $id_ingredient
            ]);
        }

    }
}


$stmtFav = $pdo->prepare("
    SELECT Recette.id_recette, Recette.nom_recette
    FROM Favoris
    JOIN Users
        ON Favoris.id_user = Users.id_user
    JOIN Recette
        ON Favoris.id_recette = Recette.id_recette
    WHERE Users.email = :email
");

$stmtFav->execute(['email' => $email]);

$favoris = $stmtFav->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
</head>
<body>
    <div class="modif">

    <form method="POST">

        <input type="text"
               placeholder="Ajouter un objectif calorique"
               name="calories">

        <input type="text"
               placeholder="Ajouter une allergie"
               name="allergie">

        <input type="submit" value="Ajouter">

    </form>


    <div class="fav">

        <p>Favoris :</p>

        <?php foreach($favoris as $fav): ?>
            <p>
                <?= $fav['nom_recette'] ?>

                <a href="supprimer_favori.php?id=<?= $fav['id_recette'] ?>">
                    Supprimer
                </a>
            </p>
        <?php endforeach; ?>

    </div>

    <a href="index.php">Retour</a>

</div>
</body>
</html>