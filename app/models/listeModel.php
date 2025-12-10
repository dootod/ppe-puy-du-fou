<?php
class ListeModel {
    
    public function getElements($filtre) {
        switch($filtre) {
            case 'spectacles':
                return $this->getSpectacles();
            case 'restaurants':
                return $this->getRestaurants();
            case 'toilettes':
                return $this->getToilettes();
            default:
                return $this->getSpectacles();
        }
    }
    
    private function getSpectacles() {
        try {
            $pdo = getPDO();
            
            $requete = $pdo->query("
                SELECT 
                    s.id_spectacle as id,
                    s.libelle as titre,
                    s.duree_spectacle,
                    s.duree_attente,
                    l.coordonnees_gps
                FROM spectacle s
                LEFT JOIN lieu l ON s.id_lieu = l.id_lieu
                ORDER BY s.id_spectacle
            ");
            
            $spectacles = [];
            while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                $horaires = $this->getHorairesSpectacle($row['id']);
                
                $coords = $this->parseCoordonneesGPS($row['coordonnees_gps']);
                $lat = $coords['lat'];
                $lng = $coords['lng'];
                
                $spectacles[] = [
                    'id' => $row['id'],
                    'titre' => $row['titre'],
                    'description' => $this->getDescriptionSpectacle($row['titre']),
                    'categorie' => 'spectacles',
                    'duree' => $this->formatDuree($row['duree_spectacle']),
                    'horaires' => $horaires,
                    'emplacement' => $this->getEmplacementSpectacle($row['titre']),
                    'lat' => $lat,
                    'lng' => $lng,
                    'details' => $this->getDetailsSpectacle($row['titre']),
                    'prix' => 'Inclus dans le billet'
                ];
            }
            
            return $spectacles;
            
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function parseCoordonneesGPS($coordonnees_gps) {
        if (empty($coordonnees_gps)) {
            return ['lat' => 46.8900, 'lng' => -0.9300];
        }
        
        if (strpos($coordonnees_gps, ',') !== false) {
            $coords = explode(',', $coordonnees_gps);
            $lat = floatval(trim($coords[0] ?? 46.8900));
            $lng = floatval(trim($coords[1] ?? -0.9300));
            
            return [
                'lat' => $lat,
                'lng' => $lng
            ];
        }
        
        return ['lat' => 46.8900, 'lng' => -0.9300];
    }
    
    private function getHorairesSpectacle($idSpectacle) {
        try {
            $pdo = getPDO();
            $requete = $pdo->prepare("
                SELECT heure_debut 
                FROM seance 
                WHERE id_spectacle = :id_spectacle 
                ORDER BY heure_debut
            ");
            $requete->execute(['id_spectacle' => $idSpectacle]);
            
            $horaires = [];
            while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                $horaires[] = substr($row['heure_debut'], 0, 5);
            }
            
            if (empty($horaires)) {
                $horaires = ['11:00', '14:00', '16:30'];
            }
            
            return $horaires;
            
        } catch (Exception $e) {
            return ['11:00', '14:00', '16:30'];
        }
    }
    
    private function getRestaurants() {
        return [
            [
                'id' => 12,
                'titre' => 'Les Deux Couronnes',
                'description' => 'Restaurant service rapide avec spécialité poulet rôti',
                'categorie' => 'restaurants',
                'horaires' => '11:30 - 15:00',
                'emplacement' => 'Entrée Principale',
                'lat' => 46.88646919206608,
                'lng' => -0.9214932405465168,
                'details' => 'Service rapide et efficace. Parfait pour un déjeuner entre deux spectacles. Spécialité de poulet rôti et frites maison.',
                'prix_moyen' => '18€',
                'specialites' => ['Poulet rôti', 'Frites maison', 'Salade bar']
            ],
            [
                'id' => 13,
                'titre' => 'L\'Auberge',
                'description' => 'Restaurant familial avec terrasse ombragée',
                'categorie' => 'restaurants',
                'horaires' => '11:00 - 18:00',
                'emplacement' => 'Village XVIIIème',
                'lat' => 46.887547107642796,
                'lng' => -0.9306913690442616,
                'details' => 'Cadre champêtre et cuisine traditionnelle française. Parfait pour une pause déjeuner en famille dans une ambiance conviviale.',
                'prix_moyen' => '22€',
                'specialites' => ['Pot-au-feu', 'Quiche lorraine', 'Tarte aux pommes']
            ],
            [
                'id' => 14,
                'titre' => 'La Mijoterie du Roy Henry',
                'description' => 'Cuisine médiévale dans l\'ambiance d\'un banquet royal',
                'categorie' => 'restaurants',
                'horaires' => '12:00 - 16:00',
                'emplacement' => 'Cité Médiévale',
                'lat' => 46.88957638791209,
                'lng' => -0.9311743283089507,
                'details' => 'Savourez des plats inspirés de la cuisine médiévale dans une salle voûtée authentique. Ambiance royale garantie.',
                'prix_moyen' => '28€',
                'specialites' => ['Rôti de sanglier', 'Tourte médiévale', 'Hydromel maison']
            ],
            [
                'id' => 15,
                'titre' => 'Le Café de la Madelon',
                'description' => 'Brasserie style 1900 avec spécialités régionales',
                'categorie' => 'restaurants',
                'horaires' => '10:00 - 19:00',
                'emplacement' => 'Place de la République',
                'lat' => 46.89177672558837,
                'lng' => -0.9339468711185384,
                'details' => 'Ambiance Belle Époque et cuisine du terroir. Essayez notre célèbre galette saucisse et nos bières artisanales !',
                'prix_moyen' => '20€',
                'specialites' => ['Galette saucisse', 'Rillettes du Mans', 'Fondant au chocolat']
            ],
            [
                'id' => 16,
                'titre' => 'L\'Orangerie',
                'description' => 'Restaurant gastronomique avec vue sur les jardins',
                'categorie' => 'restaurants',
                'horaires' => '12:00 - 15:30',
                'emplacement' => 'Jardins à la Française',
                'lat' => 46.89216247724903,
                'lng' => -0.9334460155100963,
                'details' => 'Expérience gastronomique raffinée dans un cadre élégant. Plats créatifs et vins sélectionnés.',
                'prix_moyen' => '35€',
                'specialites' => ['Menu dégustation', 'Poissons grillés', 'Desserts maison']
            ],
            [
                'id' => 17,
                'titre' => 'La Rôtissoire',
                'description' => 'Spécialités de viandes rôties à la broche',
                'categorie' => 'restaurants',
                'horaires' => '11:30 - 16:00',
                'emplacement' => 'Quartier Artisanal',
                'lat' => 46.88751175161544,
                'lng' => -0.931512156821394,
                'details' => 'Découvrez nos viandes rôties lentement à la broche selon les traditions culinaires françaises.',
                'prix_moyen' => '25€',
                'specialites' => ['Côte de bœuf', 'Poulet à la broche', 'Légumes rôtis']
            ],
            [
                'id' => 18,
                'titre' => 'La Taverne',
                'description' => 'Casse-croûte et snacks rapides',
                'categorie' => 'restaurants',
                'horaires' => '10:00 - 17:00',
                'emplacement' => 'Forêt Centrale',
                'lat' => 46.887506404978325,
                'lng' => -0.9270962110857249,
                'details' => 'Pour une pause rapide entre deux spectacles. Sandwiches, salades et boissons fraîches dans une ambiance de taverne.',
                'prix_moyen' => '12€',
                'specialites' => ['Sandwich jambon-beurre', 'Salade César', 'Cookie maison']
            ]
        ];
    }
    
    private function getToilettes() {
        return [
            [
                'id' => 19,
                'titre' => 'Toilettes Principales',
                'description' => 'Sanitaires avec accès PMR et espace change bébé',
                'categorie' => 'toilettes',
                'emplacement' => 'Entrée Principale',
                'lat' => 46.89189061974373,
                'lng' => -0.9321954678062714,
                'details' => 'Sanitaires spacieux et bien entretenus. Accès personnes à mobilité réduite et table à langer. Point d\'eau et distributeurs de serviettes.',
                'services' => ['Toilettes', 'Points d\'eau', 'Espace bébé', 'Accès PMR', 'Sèche-mains']
            ],
            [
                'id' => 20,
                'titre' => 'Toilettes Vikings',
                'description' => 'Sanitaires thématisés près du spectacle des Vikings',
                'categorie' => 'toilettes',
                'emplacement' => 'Théâtre sur l\'Eau',
                'lat' => 46.88759913402883,
                'lng' => -0.9287146907371377,
                'details' => 'Sanitaires modernes à proximité immédiate du spectacle des Vikings. Nombreuses cabines pour éviter l\'attente.',
                'services' => ['Toilettes', 'Lavabos', 'Distributeur de serviettes', 'Miroirs']
            ],
            [
                'id' => 21,
                'titre' => 'Toilettes Cité Médiévale',
                'description' => 'Toilettes thématisées Moyen-Âge',
                'categorie' => 'toilettes',
                'emplacement' => 'Cité Médiévale',
                'lat' => 46.88743377058037,
                'lng' => -0.927113080715879,
                'details' => 'Sanitaires décorés dans le style médiéval. Propres et bien équipés au cœur de la cité médiévale.',
                'services' => ['Toilettes', 'Lavabos', 'Distributeur de serviettes', 'Espace bébé']
            ],
            [
                'id' => 22,
                'titre' => 'Toilettes Stade Gallo-Romain',
                'description' => 'Sanitaires près des arènes gallo-romaines',
                'categorie' => 'toilettes',
                'emplacement' => 'Arènes Gallo-Romaines',
                'lat' => 46.8853878847044,
                'lng' => -0.927346847889757,
                'details' => 'Sanitaires modernes à proximité immédiate des arènes. Très pratiques avant/après le spectacle du Signe du Triomphe.',
                'services' => ['Toilettes', 'Lavabos', 'Espace bébé', 'Sèche-mains', 'Accès PMR']
            ]
        ];
    }
    
    private function getDescriptionSpectacle($titre) {
        $descriptions = [
            'Le Signe du Triomphe' => 'Spectacle de gladiateurs dans les arènes gallo-romaines',
            'Les Vikings' => 'Épopée maritime des guerriers nordiques',
            'Le Secret de la Lance' => 'Épopée médiévale avec cavaliers et effets spéciaux',
            'Mousquetaire de Richelieu' => 'Spectacle de cape et d\'épée au Grand Carrousel',
            'Le Bal des Oiseaux Fantômes' => 'Spectacle aviaire avec plus de 300 oiseaux',
            'Les Noces de Feu' => 'Spectacle nocturne sur le Grand Lac',
            'La Cinéscénie' => 'Le plus grand spectacle nocturne du monde',
            'Le Premier Royaume' => 'Épopée des premiers rois francs',
            'Le Dernier Panache' => 'Spectacle scénique historique',
            'Les Amoureux de Verdun' => 'Spectacle immersif Première Guerre mondiale',
            'Le Mystère de La Pérouse' => 'Expédition maritime du XVIIIe siècle'
        ];
        
        return $descriptions[$titre] ?? 'Spectacle grandiose au Puy du Fou';
    }
    
    private function getDetailsSpectacle($titre) {
        $details = [
            'Le Signe du Triomphe' => 'Revivez l\'ambiance des grands jeux du cirque dans des arènes reconstituées. Gladiateurs, chars romains et effets spéciaux vous transportent au cœur de la Rome antique.',
            'Les Vikings' => 'Assistez au débarquement des drakkars vikings sur un lac de 4 hectares. Effets pyrotechniques et cascades spectaculaires vous plongent dans l\'univers des conquérants nordiques.',
            'Le Secret de la Lance' => 'Plongez dans la Guerre de Cent Ans avec cette épopée mettant en scène des cavaliers acrobates, des combats à l\'épée et des effets spéciaux impressionnants.',
            'Mousquetaire de Richelieu' => 'Duel à l\'épée, voltige équestre et cascades dans la plus pure tradition des mousquetaires. Un spectacle rythmé par la musique baroque.',
            'Le Bal des Oiseaux Fantômes' => 'Admirez le vol de plus de 300 oiseaux rapaces dans un ballet aérien unique. Faucons, aigles et vautours évoluent au-dessus des spectateurs.',
            'Les Noces de Feu' => 'La Cinéscénie revisitée en version nocturne. Jeux d\'eau, feux d\'artifice, projections géantes et 2000 acteurs pour un spectacle grandiose.',
            'La Cinéscénie' => 'Spectacle nocturne monumental avec 2400 acteurs bénévoles sur une scène de 23 hectares. Retrace l\'histoire de la Vendée à travers les siècles.',
            'Le Premier Royaume' => 'Remontez le temps jusqu\'à l\'époque mérovingienne. Découvrez la naissance de la France avec Clovis et les premiers rois francs.',
            'Le Dernier Panache' => 'Suivez le destin héroïque du général Charette durant la Révolution française. Spectacle scénographique innovant.',
            'Les Amoureux de Verdun' => 'Expérience immersive dans les tranchées de la Première Guerre mondiale. Reconstitution émouvante de la vie des poilus.',
            'Le Mystère de La Pérouse' => 'Embarquez avec l\'explorateur La Pérouse dans son voyage autour du monde. Effets spéciaux et décors maritimes époustouflants.'
        ];
        
        return $details[$titre] ?? 'Découvrez un spectacle unique mêlant histoire, émotion et effets spéciaux.';
    }
    
    private function getEmplacementSpectacle($titre) {
        $emplacements = [
            'Le Signe du Triomphe' => 'Arènes Gallo-Romaines',
            'Les Vikings' => 'Théâtre sur l\'Eau', 
            'Le Secret de la Lance' => 'Château Fort',
            'Mousquetaire de Richelieu' => 'Grand Carrousel',
            'Le Bal des Oiseaux Fantômes' => 'Ruines du Vieux Château',
            'Les Noces de Feu' => 'Grand Lac',
            'La Cinéscénie' => 'Scène Géante',
            'Le Premier Royaume' => 'Théâtre des Conquêtes',
            'Le Dernier Panache' => 'Théâtre du Dernier Panache',
            'Les Amoureux de Verdun' => 'Village 1914',
            'Le Mystère de La Pérouse' => 'Port de Commerce'
        ];
        
        return $emplacements[$titre] ?? 'Puy du Fou';
    }
    
    private function formatDuree($duree) {
        $parts = explode(':', $duree);
        if (count($parts) >= 2) {
            $heures = intval($parts[0]);
            $minutes = intval($parts[1]);
            
            if ($heures > 0) {
                return $heures . 'h' . ($minutes > 0 ? $minutes : '');
            } else {
                return $minutes . 'min';
            }
        }
        return '30min';
    }

    public function getElementById($id) {
        $spectacles = $this->getSpectacles();
        foreach ($spectacles as $spectacle) {
            if ($spectacle['id'] == $id) {
                return $spectacle;
            }
        }
        
        $restaurants = $this->getRestaurants();
        foreach ($restaurants as $restaurant) {
            if ($restaurant['id'] == $id) {
                return $restaurant;
            }
        }
        
        $toilettes = $this->getToilettes();
        foreach ($toilettes as $toilettes) {
            if ($toilettes['id'] == $id) {
                return $toilettes;
            }
        }
        
        return null;
    }

    public function getAllPoints() {
        return array_merge(
            $this->getSpectacles(),
            $this->getRestaurants(),
            $this->getToilettes()
        );
    }
}
?>