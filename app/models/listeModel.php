<?php
class ListeModel {
    public function getElements($filtre) {
        $elements = [
            // SPECTACLES
            [
                'id' => 1,
                'titre' => 'Le Signe du Triomphe',
                'description' => 'Spectacle de gladiateurs dans les arènes gallo-romaines',
                'categorie' => 'spectacles',
                'image' => 'signe_triomphe.jpg',
                'duree' => '35min',
                'horaires' => ['11:30', '14:00', '16:30'],
                'emplacement' => 'Arènes Gallo-Romaines',
                'lat' => 46.8900,
                'lng' => -0.9300,
                'details' => 'Revivez l\'ambiance des grands jeux du cirque dans des arènes reconstituées. Gladiateurs, chars romains et effets spéciaux vous transportent au cœur de la Rome antique.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 2,
                'titre' => 'Les Vikings',
                'description' => 'Épopée maritime des guerriers nordiques',
                'categorie' => 'spectacles',
                'image' => 'vikings.jpg',
                'duree' => '30min',
                'horaires' => ['11:00', '13:30', '15:30', '17:30'],
                'emplacement' => 'Théâtre sur l\'Eau',
                'lat' => 46.8885,
                'lng' => -0.9285,
                'details' => 'Assistez au débarquement des drakkars vikings sur un lac de 4 hectares. Effets pyrotechniques et cascades spectaculaires vous plongent dans l\'univers des conquérants nordiques.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 3,
                'titre' => 'Le Secret de la Lance',
                'description' => 'Épopée médiévale avec cavaliers et effets spéciaux',
                'categorie' => 'spectacles',
                'image' => 'secret_lance.jpg',
                'duree' => '30min',
                'horaires' => ['12:00', '14:30', '16:00', '18:00'],
                'emplacement' => 'Château Fort',
                'lat' => 46.8915,
                'lng' => -0.9260,
                'details' => 'Plongez dans la Guerre de Cent Ans avec cette épopée mettant en scène des cavaliers acrobates, des combats à l\'épée et des effets spéciaux impressionnants.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 4,
                'titre' => 'Mousquetaire de Richelieu',
                'description' => 'Spectacle de cape et d\'épée au Grand Carrousel',
                'categorie' => 'spectacles',
                'image' => 'mousquetaire.jpg',
                'duree' => '40min',
                'horaires' => ['11:45', '14:15', '16:45'],
                'emplacement' => 'Grand Carrousel',
                'lat' => 46.8930,
                'lng' => -0.9295,
                'details' => 'Duel à l\'épée, voltige équestre et cascades dans la plus pure tradition des mousquetaires. Un spectacle rythmé par la musique baroque.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 5,
                'titre' => 'Les Amoureux de Verdun',
                'description' => 'Fresque historique sur la Première Guerre Mondiale',
                'categorie' => 'spectacles',
                'image' => 'verdun.jpg',
                'duree' => '30min',
                'horaires' => ['12:30', '15:00', '17:00'],
                'emplacement' => 'Théâtre des Tranchées',
                'lat' => 46.8870,
                'lng' => -0.9310,
                'details' => 'Une histoire d\'amour bouleversante au cœur des tranchées de 1916. Effets spéciaux, projections et décors réalistes vous immergent dans la Grande Guerre.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 6,
                'titre' => 'Le Dernier Panache',
                'description' => 'Spectacle scénique révolutionnaire',
                'categorie' => 'spectacles',
                'image' => 'dernier_panache.jpg',
                'duree' => '32min',
                'horaires' => ['11:15', '13:45', '16:15', '18:30'],
                'emplacement' => 'Salle du Dernier Panache',
                'lat' => 46.8920,
                'lng' => -0.9320,
                'details' => 'Vivez le destin tragique d\'un officier de marine durant la Révolution française. Scène rotative, effets d\'eau et mapping vidéo créent une expérience unique.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 7,
                'titre' => 'Le Bal des Oiseaux Fantômes',
                'description' => 'Volerie spectaculaire avec plus de 200 oiseaux',
                'categorie' => 'spectacles',
                'image' => 'oiseaux_fantomes.jpg',
                'duree' => '30min',
                'horaires' => ['11:00', '13:30', '15:30', '17:30'],
                'emplacement' => 'Théâtre des Oiseaux',
                'lat' => 46.8895,
                'lng' => -0.9250,
                'details' => 'Admirez le ballet aérien de rapaces en liberté. Aigles, faucons, vautours et cigognes évoluent au-dessus des spectateurs dans un spectacle poétique.',
                'prix' => 'Inclus dans le billet'
            ],
            [
                'id' => 8,
                'titre' => 'Les Noces de Feu',
                'description' => 'Spectacle nocturne sur le Grand Lac',
                'categorie' => 'spectacles',
                'image' => 'noces_feu.jpg',
                'duree' => '45min',
                'horaires' => ['22:00'],
                'emplacement' => 'Grand Lac',
                'lat' => 46.8865,
                'lng' => -0.9270,
                'details' => 'La Cinescénie revisitée en version nocturne. Jeux d\'eau, feux d\'artifice, projections géantes et 2000 acteurs pour un spectacle grandiose.',
                'prix' => 'Spectacle supplémentaire'
            ],

            // RESTAURANTS
            [
                'id' => 9,
                'titre' => 'La Mijoterie du Roy',
                'description' => 'Cuisine médiévale dans l\'ambiance d\'un banquet royal',
                'categorie' => 'restaurants',
                'image' => 'mijoterie_roy.jpg',
                'horaires' => '11:30 - 15:00',
                'emplacement' => 'Cité Médiévale',
                'lat' => 46.8910,
                'lng' => -0.9275,
                'details' => 'Savourez des plats inspirés de la cuisine médiévale dans une salle voûtée authentique. Spécialités : rôtis, pâtés en croûte et hydromel.',
                'prix_moyen' => '25€',
                'specialites' => ['Rôti de sanglier', 'Tourte médiévale', 'Hydromel maison']
            ],
            [
                'id' => 10,
                'titre' => 'L\'Auberge',
                'description' => 'Restaurant familial avec terrasse ombragée',
                'categorie' => 'restaurants',
                'image' => 'auberge.jpg',
                'horaires' => '11:00 - 18:00',
                'emplacement' => 'Village XVIIIème',
                'lat' => 46.8905,
                'lng' => -0.9290,
                'details' => 'Cadre champêtre et cuisine traditionnelle française. Parfait pour une pause déjeuner en famille.',
                'prix_moyen' => '18€',
                'specialites' => ['Poulet rôti', 'Quiche lorraine', 'Tarte aux pommes']
            ],
            [
                'id' => 11,
                'titre' => 'Le Café de la Madelon',
                'description' => 'Brasserie style 1900 avec spécialités régionales',
                'categorie' => 'restaurants',
                'image' => 'cafe_madelon.jpg',
                'horaires' => '10:00 - 19:00',
                'emplacement' => 'Place de la République',
                'lat' => 46.8880,
                'lng' => -0.9300,
                'details' => 'Ambiance Belle Époque et cuisine du terroir. Essayez notre célèbre galette saucisse !',
                'prix_moyen' => '22€',
                'specialites' => ['Galette saucisse', 'Rillettes du Mans', 'Fondant au chocolat']
            ],
            [
                'id' => 12,
                'titre' => 'Les Délices de la Forêt',
                'description' => 'Casse-croûte et snacks rapides',
                'categorie' => 'restaurants',
                'image' => 'delices_foret.jpg',
                'horaires' => '10:00 - 17:00',
                'emplacement' => 'Forêt Centrale',
                'lat' => 46.8890,
                'lng' => -0.9265,
                'details' => 'Pour une pause rapide entre deux spectacles. Sandwiches, salades et boissons fraîches.',
                'prix_moyen' => '12€',
                'specialites' => ['Sandwich jambon-beurre', 'Salade César', 'Cookie maison']
            ],

            // TOILETTES
            [
                'id' => 13,
                'titre' => 'Toilettes Principales',
                'description' => 'Sanitaires avec accès PMR et espace change bébé',
                'categorie' => 'chiottes',
                'image' => 'toilettes_principales.jpg',
                'emplacement' => 'Entrée Principale',
                'lat' => 46.8935,
                'lng' => -0.9315,
                'details' => 'Sanitaires spacieux et bien entretenus. Accès personnes à mobilité réduite et table à langer.',
                'services' => ['Toilettes', 'Points d\'eau', 'Espace bébé', 'Accès PMR']
            ],
            [
                'id' => 14,
                'titre' => 'Sanitaires Médiévaux',
                'description' => 'Toilettes thématisées Moyen-Âge',
                'categorie' => 'chiottes',
                'image' => 'toilettes_medievales.jpg',
                'emplacement' => 'Cité Médiévale',
                'lat' => 46.8912,
                'lng' => -0.9270,
                'details' => 'Sanitaires décorés dans le style médiéval. Propres et bien équipés.',
                'services' => ['Toilettes', 'Lavabos', 'Distributeur de serviettes']
            ],
            [
                'id' => 15,
                'titre' => 'Toilettes du Lac',
                'description' => 'Sanitaires près du théâtre sur l\'eau',
                'categorie' => 'chiottes',
                'image' => 'toilettes_lac.jpg',
                'emplacement' => 'Théâtre sur l\'Eau',
                'lat' => 46.8880,
                'lng' => -0.9280,
                'details' => 'Idéalement situées près du spectacle des Vikings. Nombreuses cabines.',
                'services' => ['Toilettes', 'Points d\'eau', 'Miroirs']
            ],
            [
                'id' => 16,
                'titre' => 'Sanitaires Arènes',
                'description' => 'Toilettes près des arènes gallo-romaines',
                'categorie' => 'chiottes',
                'image' => 'toilettes_arenes.jpg',
                'emplacement' => 'Arènes Gallo-Romaines',
                'lat' => 46.8898,
                'lng' => -0.9302,
                'details' => 'Sanitaires modernes à proximité immédiate des arènes. Très pratiques avant/après le spectacle.',
                'services' => ['Toilettes', 'Lavabos', 'Espace bébé', 'Sèche-mains']
            ]
        ];
        
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

    public function getAllPoints() {
        return $this->getElements('tous');
    }
}
?>