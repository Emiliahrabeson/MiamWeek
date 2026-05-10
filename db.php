<?php
$host = "localhost";
$db_name = "Nutrition";
$db_user = "emiliah_nutrition";
$db_password = "Emi1234@";

try {
    $pdo = new PDO ("mysql:host=$host;dbname=$db_name;charset=utf8",$db_user,$db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}

?>


