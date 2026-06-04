<?php
require_once __DIR__ . '/../core/Model.php';

class ModifierProfile extends Model {

    public function getUser($email) {
        $stmt = $this->pdo->prepare("
            SELECT id_user, objectif_calorie_daily
            FROM Users
            WHERE email = :email
        ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }

    public function updateCalories($id_user, $calories) {
        $stmt = $this->pdo->prepare("
            UPDATE Users
            SET objectif_calorie_daily = :calories
            WHERE id_user = :id_user
        ");

        return $stmt->execute([
            'calories' => $calories,
            'id_user' => $id_user
        ]);
    }

    public function addAllergie($id_user, $nomIngredient) {
        $stmt = $this->pdo->prepare("
            SELECT id_ingredient
            FROM Ingredient
            WHERE nom = :nom
        ");

        $stmt->execute([
            'nom' => $nomIngredient
        ]);

        $ingredient = $stmt->fetch();

        if (!$ingredient) {
            return false;
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO Allergie(id_user,id_ingredient)
            VALUES(:id_user,:id_ingredient)
        ");

        return $stmt->execute([
            'id_user' => $id_user,
            'id_ingredient' => $ingredient['id_ingredient']
        ]);
    }

    public function getFavoris($email) {
        $stmt = $this->pdo->prepare("
            SELECT Recette.id_recette,
                   Recette.nom_recette
            FROM Favoris
            JOIN Users
                ON Favoris.id_user = Users.id_user
            JOIN Recette
                ON Favoris.id_recette = Recette.id_recette
            WHERE Users.email = :email
        ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetchAll();
    }
}
