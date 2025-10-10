<?php
class ListeModel {
    public function getElements($filtre) {
        // Données complètes avec détails pour les modals
        $elements = [
            [
                'id' => 1,
                'titre' => 'Vikings',
                'description' => 'Spectacle épique sur les guerriers nordiques',
                'categorie' => 'spectacles',
                'image' => 'vikings1.jpg',
                'duree' => '1h30',
                'horaires' => ['14:00', '17:00', '20:00'],
                'emplacement' => 'Grand Théâtre Nordique',
                'details' => 'Plongez au cœur de l\'âge viking avec ce spectacle époustouflant mettant en scène des combats réels, des effets spéciaux à couper le souffle et une histoire captivante.',
                'prix' => '25€'
            ],
            [
                'id' => 2,
                'titre' => 'Vikings',
                'description' => 'Restaurant proposant une cuisine scandinave authentique',
                'categorie' => 'restaurants',
                'image' => 'vikings2.jpg',
                'horaires' => '11:00 - 23:00',
                'specialites' => ['Saumon fumé', 'Viande de renne', 'Soupe de poisson'],
                'emplacement' => 'Place du Festin',
                'details' => 'Dégustez une cuisine nordique authentique dans une ambiance de grande salle viking. Notre chef vous propose des plats traditionnels revisités.',
                'prix_moyen' => '35€'
            ],
            [
                'id' => 3,
                'titre' => 'Vikings',
                'description' => 'Sanitaires décorés sur le thème viking',
                'categorie' => 'chiottes',
                'image' => 'vikings3.jpg',
                'emplacement' => 'Près de la Grande Halle',
                'details' => 'Des sanitaires propres et décorés dans le plus pur style viking. Profitez de notre espace raffiné pour une pause bien méritée.',
                'services' => ['Toilettes', 'Points d\'eau', 'Espace bébé']
            ],
            [
                'id' => 4,
                'titre' => 'Vikings',
                'description' => 'Exposition interactive sur la vie des Vikings',
                'categorie' => 'spectacles',
                'image' => 'vikings4.jpg',
                'duree' => '45min',
                'horaires' => ['10:00', '13:00', '15:00', '18:00'],
                'emplacement' => 'Hall des Découvertes',
                'details' => 'Découvrez la vie quotidienne des Vikings à travers cette exposition interactive. Manipulez des reproductions d\'objets, essayez des costumes et participez à des ateliers.',
                'prix' => '12€'
            ],
            [
                'id' => 5,
                'titre' => 'Vikings',
                'description' => 'Bar à hydromel et spécialités nordiques',
                'categorie' => 'restaurants',
                'image' => 'vikings5.jpg',
                'horaires' => '16:00 - 02:00',
                'specialites' => ['Hydromel maison', 'Bières artisanales', 'Tapas nordiques'],
                'emplacement' => 'Quartier des Brasseurs',
                'details' => 'Venez déguster notre sélection de boissons nordiques dans une ambiance chaleureuse. Notre hydromel est préparé selon une recette ancestrale.',
                'prix_moyen' => '18€'
            ],
            [
                'id' => 6,
                'titre' => 'Vikings',
                'description' => 'Toilettes publiques au design scandinave',
                'categorie' => 'chiottes',
                'image' => 'vikings6.jpg',
                'emplacement' => 'Entrée principale',
                'details' => 'Des installations modernes dans un décor inspiré de l\'artisanat viking. Accessibles aux personnes à mobilité réduite.',
                'services' => ['Toilettes', 'Distributeurs', 'Espace détente']
            ],
            [
                'id' => 7,
                'titre' => 'Vikings',
                'description' => 'Reconstitution historique de batailles vikings',
                'categorie' => 'spectacles',
                'image' => 'vikings7.jpg',
                'duree' => '1h15',
                'horaires' => ['11:30', '15:30', '19:00'],
                'emplacement' => 'Arène Centrale',
                'details' => 'Assistez à une reconstitution fidèle de combats vikings avec des cascades impressionnantes et des effets pyrotechniques. Nos guerriers vous feront revivre l\'histoire.',
                'prix' => '20€'
            ]
        ];
        
        // Filtrer par catégorie si spécifiée
        if ($filtre !== 'tous') {
            $elements = array_filter($elements, function($element) use ($filtre) {
                return $element['categorie'] === $filtre;
            });
        }
        
        return $elements;
    }
    
    public function getElementById($id) {
        $elements = $this->getElements('tous');
        foreach ($elements as $element) {
            if ($element['id'] == $id) {
                return $element;
            }
        }
        return null;
    }
}
?>