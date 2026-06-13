<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="/css/ingredient.css">
</head>
<body>

<h1> Mes notifications</h1>

<?php if (empty($notifications)): ?>

    <div class="aucune">
        Aucune notification.
    </div>

<?php else: ?>

    <?php foreach ($notifications as $notification): ?>

        <div class="notification">

            <strong>
                <?= htmlspecialchars($notification['type_notification']) ?>
            </strong>

            <p>
                <?= htmlspecialchars($notification['message']) ?>
            </p>

            <div class="date">
                <?= htmlspecialchars($notification['date_creation']) ?>
            </div>

        </div>

    <?php endforeach; ?>

<?php endif; ?>

</body>
</html>