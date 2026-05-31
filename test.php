<?php
$search = "viande";
$url = "https://world.openfoodfacts.org/cgi/search.pl?search_terms=" . urlencode($search) . "&json=1&page_size=5";

// User-Agent obligatoire sinon OpenFoodFacts bloque avec 503
$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'header'  => "User-Agent: MiamWeek/1.0 (contact@miamweek.fr)\r\n"
    ]
]);

$raw = file_get_contents($url, false, $context);
$data = json_decode($raw, true);

foreach ($data['products'] as $p) {
    echo "<pre>";
    echo "product_name : "    . ($p['product_name'] ?? 'VIDE') . "\n";
    echo "product_name_fr : " . ($p['product_name_fr'] ?? 'VIDE') . "\n";
    echo "calories : "        . ($p['nutriments']['energy-kcal_100g'] ?? 'VIDE') . "\n";
    echo "categorie : "       . ($p['categories_tags'][0] ?? 'VIDE') . "\n";
    echo "</pre><hr>";
}
?>