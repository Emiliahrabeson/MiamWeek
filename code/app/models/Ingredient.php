<?php
require_once __DIR__ . '/../core/Model.php';

class Ingredient extends Model {

    public function search($search) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Ingredient WHERE nom LIKE :search"
        );

        $stmt->execute(['search' => "%".$search."%"]);
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($ingredients)) {
            return [
                'ingredients' => $ingredients,
                'erreur_api' => ''
            ];
        }

        $url = "https://world.openfoodfacts.org/cgi/search.pl?search_terms=" . urlencode($search). "&json=1&page_size=50";
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'header'  => "User-Agent: MiamWeek/1.0\r\n"
            ]
        ]);

        $raw = file_get_contents($url, false, $context);
        if ($raw === false) {
            return [
                'ingredients' => [],
                'erreur_api' => "Service OpenFoodFacts indisponible."
            ];
        }

        $data = json_decode($raw, true);

        if (!empty($data['products'])) {
            foreach ($data['products'] as $p) {
                $nom = trim($p['product_name_fr'] ?? $p['product_name'] ?? '');
                $nom = ucfirst(strtolower($nom));

                if (empty($nom)) {
                    continue;
                }

                $check = $this->pdo->prepare(
                    "SELECT id_ingredient FROM Ingredient WHERE nom = :nom"
                );

                $check->execute([
                    'nom' => $nom
                ]);

                if ($check->fetch()) {
                    continue;
                }

                $calories = round($p['nutriments']['energy-kcal_100g'] ?? 0 );
                $categorie = trim (str_replace(['en:', 'fr:'],'',$p['categories_tags'][0] ?? 'autre'));
                $insert = $this->pdo->prepare(
                    "INSERT INTO Ingredient (nom, unite_par_def, calories_par_centG, categories) VALUES (:nom, 'g', :calories, :categories)"
                );

                $insert->execute([
                    'nom' => $nom,
                    'calories' => $calories,
                    'categories' => $categorie
                ]);

                break;
            }
        }

        $stmt = $this->pdo->prepare(
            "SELECT * FROM Ingredient WHERE nom LIKE :search"
        );

        $stmt->execute([
            'search' => "%".$search."%"
        ]);

        return [
            'ingredients' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'erreur_api' => ''
        ];
    }

    public function getAll() {
        $stmt = $this->pdo->query(
            "SELECT * FROM Ingredient"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

