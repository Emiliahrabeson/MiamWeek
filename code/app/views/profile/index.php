<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
    <div class="profile">
    <div class="me">

        <img class="avatar-img" src="/images/avatar.png" alt="avatar">
        <h2 class="username"><?= $username ?></h2>
        <div class="info">
            <p class="label">Nom</p>
            <p class="value"><?= $user['nom'] ?></p>
        </div>

        <div class="info">
            <p class="label">Prénom</p>
            <p class="value"><?= $user['prenom'] ?></p>
        </div>

        <div class="info">
            <p class="label">Objectif calorique / jour</p>
            <p class="value"><?= $user['objectif_calorie_daily'] ?> kcal</p>
        </div>

        <div class="section">
            <h3>Allergies</h3>
        <?php foreach($allergies as $allergie): ?>
        <div class="item action-item">
            <span>
                <?= $allergie['nom'] ?>
            </span>
            <a class="delete-btn"
            href="index.php?page=deleteAllergie&id=<?= $allergie['id_ingredient'] ?>">
                Enlever
            </a>
        </div>
    <?php endforeach; ?>

        <div class="section">
            <h3>Favoris</h3>

            <?php foreach($favoris as $fav): ?>
            <div class="item action-item">
                <span>
                    <?= $fav['nom_recette'] ?>
                </span>
                <a class="delete-btn"
                href="index.php?page=deleteFavori&id=<?= $fav['id_recette'] ?>">
                    Enlever
                </a>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="actions">
            <a class="edit-btn" href="index.php?page=modifier_profile">
                Modifier
            </a>

            <a class="logout-btn" href="index.php?page=logout">
                Déconnecter
            </a>
        </div>

    </div>
    <div class="btn-retour">
        <a href="index.php?page=home">Retour</a>
    </div>
</div>
</body>
</html>

