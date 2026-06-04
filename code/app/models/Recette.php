<?php
require_once __DIR__ . '/../core/Model.php';

class Recette extends Model {
    public function getSuggestions() {
        $stmt = $this->pdo->query(
            "SELECT id_recette,
                    nom_recette,
                    categories,
                    calories_par_centG,
                    image_url
             FROM Recette
             ORDER BY RAND()
             LIMIT 10"
        );

        return $stmt->fetchAll();
    }

    public function getAll() {
        $stmt = $this->pdo->query(
            "SELECT * FROM Recette"
        );

        return $stmt->fetchAll();
    }

    public function search($search) {
        $stmt = $this->pdo->prepare(
            "SELECT *
             FROM Recette
             WHERE nom_recette LIKE :search"
        );

        $stmt->execute([
            'search' => "%".$search."%"
        ]);

        return $stmt->fetchAll();
    }

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
}

