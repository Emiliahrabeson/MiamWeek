<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="/css/notification.css">
</head>
<body>

<div class="navbar">
    <h1 class="titre">MiamWeek</h1>
    <div class="link">
        <ul>
            <li><a href="index.php?page=home">Home</a></li>
            <li><a href="index.php?page=recette">Recettes</a></li>
            <li><a href="index.php?page=ingredient">Ingrédient</a></li>
            <li><a href="index.php?page=dashboard">Dashboard</a></li>
        </ul>
    </div>
    <div class="avatar">
        <ul>
            <li class="up"><a href="index.php?page=profile"><?= $prenom_user ?></a></li>
        </ul>
    </div>
</div>

<div class="wrap">
    <h2 class="page-title">Notifications</h2>

    <?php if (empty($notifications)): ?>
        <div class="aucune">Aucune notification pour le moment.</div>

    <?php else: ?>
        <?php foreach ($notifications as $notification): ?>
            <div class="notification">
                <strong><?= htmlspecialchars($notification['type_notification']) ?></strong>
                <p><?= htmlspecialchars($notification['message']) ?></p>
                <div class="date"><?= htmlspecialchars($notification['date_creation']) ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>

