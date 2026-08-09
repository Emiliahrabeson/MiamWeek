<?php
require_once __DIR__ . '/../core/Model.php';

class Course extends Model {
    public function getPlanSemaine($id_user){   // retourne le id_plan
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
    
    public function getIngredientsPlan($id_plan) {      // vue course
        $stmt = $this->pdo->prepare("
            SELECT
                id_ingredient,
                nom,
                unite_par_def,
                quantite_totale
            FROM vue_ingredients_plan
            WHERE id_plan = ?
            ORDER BY nom
        ");

        $stmt->execute([$id_plan]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createListe($id_plan, $id_user) {       // creer liste de courses
        $stmt = $this->pdo->prepare("
            INSERT INTO Liste_course
            (nom_liste, date_liste, terminee, id_user, id_plan)
            VALUES (?, CURRENT_DATE, 0, ?, ?)
            RETURNING id_liste
        ");

        $stmt->execute([
            "Liste du plan ".$id_plan,
            $id_user,
            $id_plan
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_liste = $result['id_liste'];
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

    public function getListe($id_liste) {           // recuperer la liste des courses 
        $stmt = $this->pdo->prepare("
            SELECT
                li.id_liste,
                i.id_ingredient,
                i.nom,
                li.quantite,
                i.unite_par_def,
                li.achete
            FROM Liste_ingredient li
            JOIN Ingredient i
                ON li.id_ingredient = i.id_ingredient
            WHERE li.id_liste = ?
            ORDER BY i.nom
        ");

        $stmt->execute([$id_liste]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleAchete($id_liste, $id_ingredient) {      // coche et décoche un ingrédient
        $stmt = $this->pdo->prepare("
            UPDATE Liste_ingredient
            SET achete = NOT achete
            WHERE id_liste = ? AND id_ingredient = ?
        ");

        return $stmt->execute([$id_liste, $id_ingredient]);
    }
    
    public function getListeByPlan($id_plan) {      // retourne l'id_liste existante pour ce plan, ou null
        $stmt = $this->pdo->prepare("
            SELECT id_liste
            FROM Liste_course
            WHERE id_plan = ?
            ORDER BY id_liste DESC
            LIMIT 1
        ");
        $stmt->execute([$id_plan]);
        $id = $stmt->fetchColumn();
        return $id ?: null;
    }
        

}
