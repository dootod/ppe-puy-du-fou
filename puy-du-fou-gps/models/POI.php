<?php
class POI {
    private $pois = [];

    public function __construct() {
        // Initialisation des points d'intérêt
        $this->pois = [
            [
                'id' => 1,
                'name' => 'Le Signe du Triomphe',
                'lat' => 46.8901,
                'lng' => -0.9345,
                'category' => 'Spectacle',
                'description' => 'Spectacle de gladiateurs',
                'duration' => '40 min',
                'capacity' => 3500
            ],
            [
                'id' => 2,
                'name' => 'Les Vikings',
                'lat' => 46.8915,
                'lng' => -0.9320,
                'category' => 'Spectacle',
                'description' => 'Drakkar et batailles vikings',
                'duration' => '35 min',
                'capacity' => 3000
            ],
            [
                'id' => 3,
                'name' => 'Le Bal des Oiseaux Fantômes',
                'lat' => 46.8895,
                'lng' => -0.9310,
                'category' => 'Spectacle',
                'description' => 'Spectacle de rapaces',
                'duration' => '25 min',
                'capacity' => 2500
            ],
            [
                'id' => 4,
                'name' => 'Mousquetaire de Richelieu',
                'lat' => 46.8880,
                'lng' => -0.9355,
                'category' => 'Spectacle',
                'description' => 'Cascades équestres',
                'duration' => '30 min',
                'capacity' => 2000
            ],
            [
                'id' => 5,
                'name' => 'Le Dernier Panache',
                'lat' => 46.8920,
                'lng' => -0.9340,
                'category' => 'Spectacle',
                'description' => 'Épopée vendéenne',
                'duration' => '45 min',
                'capacity' => 4000
            ],
            [
                'id' => 6,
                'name' => 'Les Amoureux de Verdun',
                'lat' => 46.8910,
                'lng' => -0.9365,
                'category' => 'Spectacle',
                'description' => 'Première Guerre mondiale',
                'duration' => '35 min',
                'capacity' => 2800
            ],
            [
                'id' => 7,
                'name' => 'Restaurant La Table des Mousquetaires',
                'lat' => 46.8905,
                'lng' => -0.9330,
                'category' => 'Restaurant',
                'description' => 'Cuisine française',
                'duration' => null,
                'capacity' => 200
            ],
            [
                'id' => 8,
                'name' => 'Crêperie Bretonne',
                'lat' => 46.8888,
                'lng' => -0.9325,
                'category' => 'Restaurant',
                'description' => 'Crêpes et galettes',
                'duration' => null,
                'capacity' => 100
            ],
            [
                'id' => 9,
                'name' => 'Boutique Souvenirs Principale',
                'lat' => 46.8898,
                'lng' => -0.9348,
                'category' => 'Boutique',
                'description' => 'Souvenirs du parc',
                'duration' => null,
                'capacity' => null
            ],
            [
                'id' => 10,
                'name' => 'Toilettes Nord',
                'lat' => 46.8892,
                'lng' => -0.9338,
                'category' => 'Services',
                'description' => 'Sanitaires',
                'duration' => null,
                'capacity' => null
            ],
            [
                'id' => 11,
                'name' => 'Point Information',
                'lat' => 46.8900,
                'lng' => -0.9342,
                'category' => 'Services',
                'description' => 'Accueil et renseignements',
                'duration' => null,
                'capacity' => null
            ],
            [
                'id' => 12,
                'name' => 'Toilettes Sud',
                'lat' => 46.8885,
                'lng' => -0.9350,
                'category' => 'Services',
                'description' => 'Sanitaires',
                'duration' => null,
                'capacity' => null
            ]
        ];
    }

    // Récupérer tous les POIs
    public function getAllPOIs() {
        return $this->pois;
    }

    // Récupérer un POI par ID
    public function getPOIById($id) {
        foreach ($this->pois as $poi) {
            if ($poi['id'] == $id) {
                return $poi;
            }
        }
        return null;
    }

    // Rechercher des POIs
    public function searchPOIs($query) {
        $query = strtolower($query);
        $results = [];

        foreach ($this->pois as $poi) {
            if (
                stripos($poi['name'], $query) !== false ||
                stripos($poi['category'], $query) !== false ||
                stripos($poi['description'], $query) !== false
            ) {
                $results[] = $poi;
            }
        }

        return $results;
    }

    // Filtrer par catégorie
    public function getPOIsByCategory($category) {
        $results = [];
        foreach ($this->pois as $poi) {
            if ($poi['category'] === $category) {
                $results[] = $poi;
            }
        }
        return $results;
    }

    // Récupérer toutes les catégories uniques
    public function getCategories() {
        $categories = [];
        foreach ($this->pois as $poi) {
            if (!in_array($poi['category'], $categories)) {
                $categories[] = $poi['category'];
            }
        }
        return $categories;
    }
}
?>
