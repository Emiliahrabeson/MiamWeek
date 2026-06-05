<?php
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/PlanRepas.php';

class Dashboard extends Model {
    public function getStats() {
        $nb_recettes = $this->pdo->query("SELECT COUNT(*) FROM Recette")->fetchColumn();
        $nb_ingredients = $this->pdo->query("SELECT COUNT(*) FROM Ingredient")->fetchColumn();
        $nb_repas = $this->pdo->query("SELECT COUNT(*) FROM Repas")->fetchColumn();
        $nb_plans = $this->pdo->query("SELECT COUNT(*) FROM Plan_de_repas")->fetchColumn();

        return [$nb_recettes,$nb_ingredients,$nb_repas,$nb_plans];
    }

    public function getCaloriesSemaine($id_user) {
        $planRepas = new PlanRepas();
        $plan = $planRepas->getPlanSemaine($id_user);

        $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $resultat = [];

        foreach ($jours as $jour) {
            $resultat[$jour] = 0;
            if(isset($plan[$jour])) {
                foreach ($plan[$jour] as $repas) {
                    $resultat[$jour] += $repas['total_calories'];
                }
            }
        }

        return $resultat;
    }

    public function getObjectifCalorique($id_user) {
        $stmt = $this->pdo->prepare(
            "SELECT objectif_calorie_daily
             FROM Users
             WHERE id_user = ?"
        );

        $stmt->execute([$id_user]);

        return $stmt->fetchColumn();
    }

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
