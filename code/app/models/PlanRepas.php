<?php
require_once __DIR__ . '/../core/Model.php';

class PlanRepas extends Model {
    public function getPlanSemaine($id_user)
    {
        $lundi = date('Y-m-d', strtotime('monday this week'));
        $dimanche = date('Y-m-d', strtotime('sunday this week'));

        $jours_ordre = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

        $types_repas = ['Petit-déjeuner','Déjeuner','Dîner'];

        $stmt = $this->pdo->prepare(
            "SELECT id_plan
             FROM Plan_de_repas
             WHERE id_user = ? AND date_debut = ?"
        );

        $stmt->execute([$id_user, $lundi]);
        $plan = $stmt->fetch();

        if (!$plan) {
            $this->pdo->prepare(
                "INSERT INTO Plan_de_repas
                (date_debut, date_fin, id_user)
                VALUES (?, ?, ?)"
            )->execute([$lundi, $dimanche, $id_user]);

            $id_plan = $this->pdo->lastInsertId();

            for ($i = 0; $i < 7; $i++) {
                $date_jour = date(
                    'Y-m-d',
                    strtotime("$lundi +$i days")
                );

                $this->pdo->prepare(
                    "INSERT INTO Jour
                    (nom_jour, date_jour, id_plan)
                    VALUES (?, ?, ?)"
                )->execute([
                    $jours_ordre[$i],
                    $date_jour,
                    $id_plan
                ]);

                $id_jour = $this->pdo->lastInsertId();

                foreach ($types_repas as $type) {
                    $this->pdo->prepare(
                        "INSERT INTO Repas
                        (nom_repas, type_repas, calories, id_jour)
                        VALUES (?, ?, 0, ?)"
                    )->execute([
                        $type,
                        $type,
                        $id_jour
                    ]);
                }
            }
        }
        else {
            $id_plan = $plan['id_plan'];
        }

        $stmt = $this->pdo->prepare(
            "SELECT
                j.id_jour,
                j.nom_jour,
                j.date_jour,
                r.id_repas,
                r.type_repas,
                rec.id_recette,
                rec.nom_recette,
                rec.calories_par_centG
            FROM Jour j
            JOIN Repas r ON j.id_jour = r.id_jour
            LEFT JOIN Repas_Recette rr
                ON r.id_repas = rr.id_repas
            LEFT JOIN Recette rec
                ON rr.id_recette = rec.id_recette
            WHERE j.id_plan = ?
            ORDER BY j.date_jour, r.type_repas"
        );

        $stmt->execute([$id_plan]);

        $planData = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $jour = $row['nom_jour'];
            $type = $row['type_repas'];

            if (!isset($planData[$jour][$type])) {
                $planData[$jour][$type] = [
                    'id_repas' => $row['id_repas'],
                    'recettes' => [],
                    'total_calories' => 0
                ];
            }

            if ($row['id_recette']) {

                $planData[$jour][$type]['recettes'][] = [
                    'id' => $row['id_recette'],
                    'nom' => $row['nom_recette'],
                    'calories' => $row['calories_par_centG']
                ];

                $planData[$jour][$type]['total_calories']
                    += $row['calories_par_centG'];
            }
        }

        return $planData;
    }
}
