<?php
require 'db.php';
session_start();

$email = $_SESSION['email'];

$id_recette = $_GET['id'];

$stmtUser = $pdo->prepare("
    SELECT id_user
    FROM Users
    WHERE email = :email
");

$stmtUser->execute(['email' => $email]);

$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

$id_user = $user['id_user'];

$delete = $pdo->prepare("
    DELETE FROM Favoris
    WHERE id_user = :id_user
    AND id_recette = :id_recette
");

$delete->execute([
    'id_user' => $id_user,
    'id_recette' => $id_recette
]);

header("Location: profile.php");
exit();
?>
