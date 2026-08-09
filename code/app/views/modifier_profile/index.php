<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="/css/modifier_profile.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php?page=profile"><img class="retour" src="/images/retour.png" alt=""></a>
        <h1 class="titre">MiamWeek</h1>
    </div>
    
    <div class="modif">
        <h2 class="page-title">Paramètres</h2>
        <div class="fav">
            <!-- <p class="ti">Favoris :</p> -->
             <h3 style="color: #fff">Favoris</h3>
            <?php foreach($favoris as $fav): ?>
                <p>
                    <?= $fav['nom_recette'] ?>
                    <a href="index.php?page=deleteFavori&id=<?= $fav['id_recette'] ?>">
                        Enlever
                    </a>
                </p>
            <?php endforeach; ?>
        </div>

        <div class="fav">
            <!-- <p class="ti">Allergies :</p> -->
             <h3 style="color: #fff">Allergies</h3>
            <?php foreach($allergies as $all): ?>
                <p>
                    <?= $all['nom'] ?>

                    <a href="index.php?page=deleteAllergie&id=<?= $all['id_ingredient'] ?>">
                        Enlever
                    </a>
                </p>
            <?php endforeach; ?>
        </div>

        <h3 class="modif-titre">Modification</h3>
            <?php if (!empty($errorProfil)): ?>
                <p class="msg-error"><?= htmlspecialchars($errorProfil) ?></p>
            <?php elseif (!empty($successProfil)): ?>
                <p class="msg-success"><?= htmlspecialchars($successProfil) ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="action" value="update_profile">
                <input type="text" placeholder="Ajouter un objectif calorique" name="calories">
                <input type="text" placeholder="Ajouter une allergie" name="allergie">
                <input type="submit" value="Ajouter">
            </form>


       <h3 class="modif-titre">Sécurity</h3>
        <?php if (!empty($error)): ?>
            <p class="msg-error"><?= htmlspecialchars($error) ?></p>
        <?php elseif (!empty($success)): ?>
            <p class="msg-success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="action" value="change_password">
            <input type="password" placeholder="Ancien mot de passe" name="old_password">
            <input type="password" placeholder="Nouveau mot de passe" name="new_password">
            <input type="password" placeholder="Confirmer le nouveau mot de passe" name="confirm_password">
            <input type="submit" value="Modifier">
        </form>
        


    </div>

</div>
</body>
</html>
