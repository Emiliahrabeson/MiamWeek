<?php
    session_start();
    require 'db.php';
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        if (!empty($email) && !empty($password)) {
            $sql = "SELECT * FROM Users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(["email" => $email]);

            $user = $stmt-> fetch();

                if ($user && password_verify($password, $user["password"])){
                $_SESSION["id_user"] = $user["id_user"];
                $_SESSION["email"] = $user["email"];

                header("Location: index.php");
                exit();
            }
            else {
                $error = "email ou mot de passe incorrect";
            }

        }
        else {
            $error = "veuillez remplir tous les champs";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="login_card">

        <div class="brand">
            <div class="brand-name">MiamWeek</div>
            <div class="brand-tagline">Plan de repas</div>
        </div>

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
            <input type="text" id="email" name="email" placeholder="Votre email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email">
        </div>

         <div class="field">
            <div class="field-row">
                <label for="password">Mot de passe</label>
                <a href="forgot_password.php" class="forgot">Oublié ?</a>
            </div>
            <input type="password" id="password" name="password"
                   placeholder="votre mot de passe" >
        </div>

        <button type="submit" class="btn-submit">Se connecter </button>


    </form>

    <div class="register-link">
        Pas encore de compte ? <a href="register.php">Créer un compte</a>
    </div>

    </div>
</body>
</html>
