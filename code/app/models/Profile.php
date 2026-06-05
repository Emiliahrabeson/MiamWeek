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

    public function deleteAllergie($id_user, $id_ingredient) {
        $stmt = $this->pdo->prepare("
            DELETE FROM Allergie
            WHERE id_user = :id_user
            AND id_ingredient = :id_ingredient
        ");

        return $stmt->execute([
            'id_user' => $id_user,
            'id_ingredient' => $id_ingredient
        ]);
    }

    public function deleteFavori ($email, $id_recette) {    
        $stmtUser = $this->pdo->prepare("
            SELECT id_user
            FROM Users
            WHERE email = :email
        ");
        $stmtUser->execute(['email' => $email]);

        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        $id_user = $user['id_user'];

        $delete = $this->pdo->prepare("
            DELETE FROM Favoris
            WHERE id_user = :id_user
            AND id_recette = :id_recette
        ");

        return $delete->execute([
                    'id_user' => $id_user,
                    'id_recette' => $id_recette
                ]);


    }

}
