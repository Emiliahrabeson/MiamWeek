<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="/css/modifier_profile.css">
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

                    <a href="index.php?page=deleteFavori&id=<?= $fav['id_recette'] ?>">
                        Supprimer
                    </a>
                </p>
            <?php endforeach; ?>
        </div>
        <div class="back">
            <a href="index.php?page=profile">Retour</a>
        </div>

</div>
</body>
</html>
