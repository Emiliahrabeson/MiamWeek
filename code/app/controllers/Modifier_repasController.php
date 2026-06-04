<?php
require_once __DIR__ . '/../models/ModifierRepas.php';

class Modifier_repasController {

    public function index() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $nom_user = $_SESSION['email'];
        $id_repas = (int)($_GET['id_repas'] ?? 0);

        if (!$id_repas) {
            header("Location: index.php?page=home");
            exit();
        }

        $model = new ModifierRepas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'ajouter' && isset($_POST['id_recette'])) {
                $model->ajouterRecette(
                    $id_repas,
                    $_POST['id_recette']
                );
            }

            if ($action === 'supprimer' && isset($_POST['id_recette'])) {
                $model->supprimerRecette(
                    $id_repas,
                    $_POST['id_recette']
                );
            }

            header(
                "Location: index.php?page=modifier_repas&id_repas=".$id_repas
            );
            exit();
        }

        $repas = $model->getRepas($id_repas);
        $recettes_liees = $model->getRecettesLiees($id_repas);
        $toutes = $model->getToutesRecettes();

        require __DIR__ . '/../views/modifier_repas/index.php';
    }
}
