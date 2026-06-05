<?php
require_once __DIR__ . '/../core/Model.php';

class Dashboard extends Model {
    public function getStats() {
        $nb_recettes = $this->pdo->query("SELECT COUNT(*) FROM Recette")->fetchColumn();
        $nb_ingredients = $this->pdo->query("SELECT COUNT(*) FROM Ingredient")->fetchColumn();
        $nb_repas = $this->pdo->query("SELECT COUNT(*) FROM Repas")->fetchColumn();
        $nb_plans = $this->pdo->query("SELECT COUNT(*) FROM Plan_de_repas")->fetchColumn();

        return [$nb_recettes,$nb_ingredients,$nb_repas,$nb_plans];
    }
}
