<?php
require_once __DIR__ . '/../core/Model.php';

class PlanRepas extends Model {
    public function createNotification($id_user, $type_notification, $message){
        $stmt = $this->pdo->prepare(" INSERT INTO Notification (id_user,type_notification,message) VALUES (?,?,?);
        ");

        $stmt->execute([$id_user, $type_notification, $message]);
    }

    public function getPlanSemaine($id_user) {  // un plan chaque semaine 
        $lundi = date('Y-m-d', strtotime('monday this week'));
        $dimanche = date('Y-m-d', strtotime('sunday this week'));
        $jours_ordre = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $types_repas = ['Petit-déjeuner','Déjeuner','Dîner'];

        $cal = $this->pdo->prepare(
            "SELECT objectif_calorie_daily FROM Users WHERE id_user = :id_user;"
        );
        $cal->execute(['id_user' => $id_user]);
        $objectifRow = $cal->fetch();
        
        $objectif_cal = $objectifRow['objectif_calorie_daily'] ?? null;     // valeur numérique

        $stmt = $this->pdo->prepare(
            "SELECT id_plan
             FROM Plan_de_repas
             WHERE id_user = ? AND date_debut = ?"
        );

        $stmt->execute([$id_user, $lundi]);
        $plan = $stmt->fetch();

        if (!$plan) {       // si n'existe pas encore
            $stmt = $this->pdo->prepare(    // creer plan
                "INSERT INTO Plan_de_repas
                (date_debut, date_fin, id_user)
                VALUES (?, ?, ?)
                RETURNING id_plan"
            );
            $stmt->execute([$lundi, $dimanche, $id_user]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_plan = $result['id_plan'];

            for ($i = 0; $i < 7; $i++) {        // creer 7 jours de la sem sur le plan
                $date_jour = date('Y-m-d', strtotime("$lundi +$i days"));

                $stmtJour = $this->pdo->prepare(    // ajouter les 7 jours dans la table Jour avec id_plan
                    "INSERT INTO Jour
                    (nom_jour, date_jour, id_plan)
                    VALUES (?, ?, ?)
                    RETURNING id_jour"
                );
                $stmtJour->execute([$jours_ordre[$i], $date_jour, $id_plan]);
                
                $resultJour = $stmtJour->fetch(PDO::FETCH_ASSOC);
                $id_jour = $resultJour['id_jour'];

                foreach ($types_repas as $type) {       // ajouter type repas
                    $this->pdo->prepare(
                        "INSERT INTO Repas
                        (nom_repas, type_repas, calories, id_jour)
                        VALUES (?, ?, 0, ?)"
                    )->execute([$type, $type, $id_jour]);
                    
                }
            }
        } 
        else {
            $id_plan = $plan['id_plan'];
        }

        $stmt = $this->pdo->prepare(    // affichage des elts de calendrier
            "SELECT
                id_jour,
                nom_jour,
                date_jour,
                id_repas,
                type_repas,
                id_recette,
                nom_recette,
                calories_par_centG
            FROM vue_planning_repas         
            WHERE id_plan = ?
            ORDER BY date_jour, type_repas"
        );  // vue_planning_repas

        $stmt->execute([$id_plan]);

        $planData = [];
        $notifie = []; 

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

                $planData[$jour][$type]['total_calories'] += (int) $row['calories_par_centG'];
// si objectif atteint
                if ( $objectif_cal !== null && $planData[$jour][$type]['total_calories'] >= $objectif_cal && empty($notifie[$jour])) {  
                    $this->createNotification(
                        $id_user,
                        'OBJECTIF_ATTEINT',
                        'Félicitations, Vous avez atteint votre objectif calorique du jour.'
                    );
                    $notifie[$jour] = true;
                }
            }
        }

        return $planData;
    }
}
