<?php
    session_start();
    require 'db.php';
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        if (!empty($username) && !empty($password)) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(["email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password_hash"])) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["email"] = $user["email"];
                header("Location: index.php");
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — MiamWeek</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login-card">

    <div class="brand">
        <div class="brand-icon">&#9963;</div>
        <div>
            <div class="brand-name">MiamWeek</div>
            <div class="brand-tagline">Plan de repas</div>
        </div>
    </div>

    <div class="divider"></div>

    <h1 class="login-title">Bon retour,<br><em>bon appétit.</em></h1>
    <p class="login-sub">Connectez-vous pour voir votre semaine.</p>

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
            <label for="email">Nom d'utilisateur</label>
            <input type="text" id="email" name="email"
                   placeholder="votre email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   autocomplete="zmail">
        </div>

        <div class="field">
            <div class="field-row">
                <label for="password">Mot de passe</label>
                <a href="forgot_password.php" class="forgot">Oublié ?</a>
            </div>
            <input type="password" id="password" name="password"
                   placeholder="••••••••" autocomplete="current-password">
        </div>

        <button type="submit" class="btn-submit">Se connecter &rarr;</button>
    </form>

    <div class="register-link">
        Pas encore de compte ? <a href="register.php">Créer un compte</a>
    </div>

</div>
</body>
</html>