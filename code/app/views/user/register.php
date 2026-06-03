<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — MiamWeek</title>
    <link rel="stylesheet" href="./styleregister.css">
    <style>
        
    </style>
</head>
<body>
<div class="login-card">

    <div class="brand">
        <div>
            <div class="brand-name">MiamWeek</div>
            <div class="brand-tagline">Plan de repas</div>
        </div>
    </div>

    <div class="divider"></div>

    <h1 class="login-title">Bienvenue,<br><em>bon appétit.</em></h1>
    <p class="login-sub">Inscrivez-vous pour voir votre semaine.</p>

    <div class="week-pills">
        <span class="pill">Lundi</span>
        <span class="pill">Mardi</span>
        <span class="pill">Mercredi</span>
        <span class="pill">Jeudi</span>
        <span class="pill">Vendredi</span>
        <span class="pill">Weekend</span>
    </div>

    <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="field">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name"
                placeholder="votre nom"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="field">
            <label for="name">Prénom</label>
            <input type="text" id="prenom" name="prenom"
                placeholder="votre prénom"
                value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
        </div>
        <div class="field">
            <label for="email">Nom d'utilisateur</label>
            <input type="text" id="email" name="email"
                   placeholder="votre email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   autocomplete="email">
        </div>

        <div class="field">
            <div class="field-row">
                <label for="password">Mot de passe</label>
                <a href="forgot_password.php" class="forgot">Oublié ?</a>
            </div>
            <input type="password" id="password" name="password"
                   placeholder="••••••••" autocomplete="current-password">
        </div>

        <div class="field">
            <div class="field-row">
                <label for="confirm_password">confirmation</label>
            </div>
            <input type="password" id="confirm_password" name="confirm_password"
                placeholder="••••••••">
        </div>

        <button type="submit" class="btn-submit">S'inscrire ;</button>
    </form>

    <div class="register-link">
        J'ai déja un compte ? <a href="index.php?page=login">Se connecter</a>
    </div>

</div>
</body>
</html>
