<?php
require_once __DIR__ . '/../core/Model.php';

class ModifierRepas extends Model {

    public function getRepas($id_repas) {
        $stmt = $this->pdo->prepare(
            "SELECT r.*, j.nom_jour, j.date_jour
             FROM Repas r
             JOIN Jour j ON r.id_jour = j.id_jour
             WHERE r.id_repas = ?"
        );

        $stmt->execute([$id_repas]);

        return $stmt->fetch();
    }

    public function getRecettesLiees($id_repas) {
        $stmt = $this->pdo->prepare(
            "SELECT rec.*
             FROM Recette rec
             JOIN Repas_Recette rr
                ON rec.id_recette = rr.id_recette
             WHERE rr.id_repas = ?"
        );
        $stmt->execute([$id_repas]);

        return $stmt->fetchAll();
    }

    public function getToutesRecettes() {
        $stmt = $this->pdo->query(
            "SELECT id_recette,
                    nom_recette,
                    calories_par_centG
             FROM Recette
             ORDER BY nom_recette"
        );

        return $stmt->fetchAll();
    }

    public function ajouterRecette($id_repas, $id_recette) {
        $stmt = $this->pdo->prepare(
            "INSERT IGNORE INTO Repas_Recette
             (id_repas,id_recette)
             VALUES (?,?)"
        );

        $stmt->execute([
            $id_repas,
            $id_recette
        ]);

        $this->updateCalories($id_repas);
    }

    public function supprimerRecette($id_repas, $id_recette) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Repas_Recette
             WHERE id_repas = ?
             AND id_recette = ?"
        );

        $stmt->execute([
            $id_repas,
            $id_recette
        ]);

        $this->updateCalories($id_repas);
    }

    private function updateCalories($id_repas) {
        $stmt = $this->pdo->prepare(
            "UPDATE Repas
             SET calories = (
                SELECT COALESCE(
                    SUM(rec.calories_par_centG),
                    0
                )
                FROM Repas_Recette rr
                JOIN Recette rec
                    ON rr.id_recette = rec.id_recette
                WHERE rr.id_repas = ?
             )
             WHERE id_repas = ?"
        );

        $stmt->execute([$id_repas,$id_repas]);
    }
}
