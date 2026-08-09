<?php
require_once __DIR__ . '/../core/Model.php';

class Recette extends Model {
    // public function getSuggestions() {
    //     $stmt = $this->pdo->query(
    //         "SELECT id_recette,
    //                 nom_recette,
    //                 categories,
    //                 calories_par_centG,
    //                 preparation,
    //                 image_url
    //          FROM Recette
    //          ORDER BY RAND()
    //          LIMIT 10"
    //     );

    //     return $stmt->fetchAll();
    // }


    // suggestion avec filtrage
    public function getSuggestions($id_user) {
    $stmt = $this->pdo->prepare(
        "SELECT id_recette, nom_recette, categories, calories_par_centG, preparation, image_url
         FROM Recette r
         WHERE NOT EXISTS (
             SELECT 1
             FROM Recette_ingredient ri
             JOIN Ingredient ing ON ing.id_ingredient = ri.id_ingredient
             JOIN Allergie a ON a.id_user = :id_user
             JOIN Ingredient ai ON ai.id_ingredient = a.id_ingredient
             WHERE ri.id_recette = r.id_recette
               AND ing.nom LIKE '%' || ai.nom || '%'
         )
         ORDER BY RANDOM()
         LIMIT 10"
    );
    $stmt->execute(['id_user' => $id_user]);
    return $stmt->fetchAll();
}

    public function getAll() {
        $stmt = $this->pdo->query(
            "SELECT * FROM Recette"
        );

        return $stmt->fetchAll();
    }

    public function getById($id_recette) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Recette WHERE id_recette = :id_recette"
        );

        $stmt->execute(['id_recette' => $id_recette]);

        return $stmt->fetch();
    }
 
    public function search($search) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Recette WHERE nom_recette LIKE :search"
        );

        $stmt->execute([
            'search' => "%".$search."%"
        ]);

        return $stmt->fetchAll();
    }

    // ajouter recette favoris
    public function addFavori($id_user, $id_recette) {
        $check = $this->pdo->prepare(
            "SELECT *
             FROM Favoris
             WHERE id_user = :id_user
             AND id_recette = :id_recette"
        );

        $check->execute([
            'id_user' => $id_user,
            'id_recette' => $id_recette
        ]);

        if (!$check->fetch()) {

            $insert = $this->pdo->prepare(
                "INSERT INTO Favoris(id_user,id_recette)
                 VALUES(:id_user,:id_recette)"
            );

            $insert->execute([
                'id_user' => $id_user,
                'id_recette' => $id_recette
            ]);
        }
    }

    //  prendre les ingredients d'une recette
    public function getIngredients($id_recette) {
        $stmt = $this->pdo->prepare("
            SELECT i.nom, i.unite_par_def, ri.quantite
            FROM Recette_ingredient ri
            JOIN Ingredient i ON i.id_ingredient = ri.id_ingredient
            WHERE ri.id_recette = :id_recette
            ORDER BY i.nom
        ");
        $stmt->execute(['id_recette' => $id_recette]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

