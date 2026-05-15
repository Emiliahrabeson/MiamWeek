<?php
require 'db.php';
session_start();

$email = $_SESSION['email'];

$id_ingredient = $_GET['id'];

$stmtUser = $pdo->prepare("
    SELECT id_user
    FROM Users
    WHERE email = :email
");

$stmtUser->execute(['email' => $email]);

$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

$id_user = $user['id_user'];

$delete = $pdo->prepare("
    DELETE FROM Allergie
    WHERE id_user = :id_user
    AND id_ingredient = :id_ingredient
");

$delete->execute([
    'id_user' => $id_user,
    'id_ingredient' => $id_ingredient
]);

header("Location: profile.php");
exit();
?>
