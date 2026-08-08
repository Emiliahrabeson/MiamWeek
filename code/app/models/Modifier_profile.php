<?php
require_once __DIR__ . '/../core/Model.php';

class ModifierProfile extends Model {

    public function getUser($email) {
        $stmt = $this->pdo->prepare("
            SELECT id_user, email, password, objectif_calorie_daily
            FROM Users
            WHERE email = :email
        ");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function addAllergie_by_igId($id_user, $id_ingredient) {     // pour le gestion d'erreur 
    $check = $this->pdo->prepare(
        "SELECT *
         FROM Allergie
         WHERE id_user = :id_user
         AND id_ingredient = :id_ingredient"
    );

    $check->execute([
        'id_user' => $id_user,
        'id_ingredient' => $id_ingredient
    ]);

    if (!$check->fetch()) {
        $insert = $this->pdo->prepare(
            "INSERT INTO Allergie(id_user, id_ingredient)
             VALUES(:id_user, :id_ingredient)"
        );

        $insert->execute([
            'id_user' => $id_user,
            'id_ingredient' => $id_ingredient
        ]);
    }
}

    public function addAllergie($id_user, $nomIngredient) {     // simple add
        $stmt = $this->pdo->prepare("
            SELECT id_ingredient
            FROM Ingredient
            WHERE nom = :nom
        ");

        $stmt->execute(['nom' => $nomIngredient]);
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

        $stmt->execute(['email' => $email]);

        return $stmt->fetchAll();
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
 
    public function deleteFavori($id_user, $id_recette) {
        $stmt = $this->pdo->prepare("
            DELETE FROM Favoris
            WHERE id_user = :id_user
            AND id_recette = :id_recette
        ");

        return $stmt->execute([
            'id_user' => $id_user,
            'id_recette' => $id_recette
        ]);
    }

    public function modify_password ($email, $password) {
        $stmt = $this->pdo->prepare("
            UPDATE Users
            SET password = :password
            WHERE email = :email;
        ");
        
        return $stmt->execute(
            ['password' => $password,
             'email' => $email
            ]);
        
    }
}
