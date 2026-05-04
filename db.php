<?php

$host = "localhost";
$db_name = "Nutrition";
$username = "emiliah_nutrition";
$password = "Emi1234@";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}

?>