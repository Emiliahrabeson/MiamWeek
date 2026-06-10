<?php
require_once __DIR__ . '/../core/Model.php';

class Course extends Model {
    public function getPlanSemaine($id_user){
        $stmt = $this->pdo->prepare("
            SELECT id_plan
            FROM Plan_de_repas
            WHERE id_user = ?
            ORDER BY date_debut DESC
            LIMIT 1
        ");

        $stmt->execute([$id_user]);

        return $stmt->fetchColumn();
    }
    
    public function getIngredientsPlan($id_plan) {
        $stmt = $this->pdo->prepare("
            SELECT
                i.id_ingredient,
                i.nom,
                i.unite_par_def,
                SUM(ri.quantite) AS quantite_totale
            FROM Jour j
            JOIN Repas r
                ON j.id_jour = r.id_jour
            JOIN Repas_Recette rr
                ON r.id_repas = rr.id_repas
            JOIN Recette_ingredient ri
                ON rr.id_recette = ri.id_recette
            JOIN Ingredient i
                ON ri.id_ingredient = i.id_ingredient
            WHERE j.id_plan = ?
            GROUP BY i.id_ingredient
            ORDER BY i.nom
        ");

        $stmt->execute([$id_plan]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createListe($id_plan, $id_user) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Liste_course
            (nom_liste, date_liste, terminee, id_user, id_plan)
            VALUES (?, CURDATE(), 0, ?, ?)
        ");

        $stmt->execute([
            "Liste du plan ".$id_plan,
            $id_user,
            $id_plan
        ]);

        $id_liste = $this->pdo->lastInsertId();
        $ingredients = $this->getIngredientsPlan($id_plan);

        $insert = $this->pdo->prepare("
            INSERT INTO Liste_ingredient
            (id_liste, id_ingredient, quantite)
            VALUES (?, ?, ?)
        ");

        foreach ($ingredients as $ingredient) {
            $insert->execute([
                $id_liste,
                $ingredient['id_ingredient'],
                $ingredient['quantite_totale']
            ]);
        }

        return $id_liste;
    }

    public function getListe($id_liste) {
        $stmt = $this->pdo->prepare("
            SELECT
                i.nom,
                li.quantite,
                i.unite_par_def
            FROM Liste_ingredient li
            JOIN Ingredient i
                ON li.id_ingredient = i.id_ingredient
            WHERE li.id_liste = ?
            ORDER BY i.nom
        ");

        $stmt->execute([$id_liste]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

}
