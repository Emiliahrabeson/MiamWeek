<?php
require_once __DIR__ . '/../core/Model.php';

class Profile extends Model {

    public function getObjectifCalories ($email) {
        $stmt = $this->pdo->prepare("
            SELECT nom, prenom, objectif_calorie_daily
            FROM Users
            WHERE email = :email
        ");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getAllergies ($email) {
           $stmt_allergie = $this->pdo->prepare("
                SELECT Ingredient.nom, Ingredient.id_ingredient
                FROM Allergie
                JOIN Users 
                    ON Allergie.id_user = Users.id_user
                JOIN Ingredient 
                    ON Allergie.id_ingredient = Ingredient.id_ingredient
                WHERE Users.email = :email
            ");
            $stmt_allergie->execute(['email' => $email]);

        return $stmt_allergie->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavoris ($email) {
        $stmtFav = $this->pdo->prepare("
            SELECT Recette.nom_recette, Recette.id_recette
            FROM Favoris
            JOIN Users
                ON Favoris.id_user = Users.id_user
            JOIN Recette
                ON Favoris.id_recette = Recette.id_recette
            WHERE Users.email = :email
        ");
        $stmtFav->execute(['email' => $email]);

        return $stmtFav->fetchAll(PDO::FETCH_ASSOC);
    }


}
