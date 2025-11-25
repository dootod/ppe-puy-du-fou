<?php
require_once __DIR__ . '/../models/POI.php';

class NavigationController {
    private $poiModel;

    public function __construct() {
        $this->poiModel = new POI();
    }

    // Calculer la distance entre deux points (formule de Haversine)
    public function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Rayon de la Terre en km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return round($distance, 2);
    }

    // Calculer le temps de marche
    public function calculateWalkingTime($distanceKm) {
        $minutes = round(($distanceKm / WALKING_SPEED) * 60);
        
        if ($minutes < 1) {
            return "< 1 min";
        } elseif ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $mins = $minutes % 60;
            return $hours . "h " . $mins . " min";
        } else {
            return $minutes . " min";
        }
    }

    // Calculer le bearing (direction) entre deux points
    public function calculateBearing($lat1, $lon1, $lat2, $lon2) {
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $dLon = deg2rad($lon2 - $lon1);

        $y = sin($dLon) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);
        $bearing = atan2($y, $x);

        return (rad2deg($bearing) + 360) % 360;
    }

    // Obtenir la direction en texte
    public function getDirectionText($bearing) {
        $directions = [
            'Nord', 'Nord-Est', 'Est', 'Sud-Est',
            'Sud', 'Sud-Ouest', 'Ouest', 'Nord-Ouest'
        ];
        $index = round($bearing / 45) % 8;
        return $directions[$index];
    }

    // Préparer les données de navigation
    public function prepareNavigationData($userLat, $userLng, $poiId) {
        $poi = $this->poiModel->getPOIById($poiId);
        
        if (!$poi) {
            return null;
        }

        $distance = $this->calculateDistance($userLat, $userLng, $poi['lat'], $poi['lng']);
        $duration = $this->calculateWalkingTime($distance);
        $bearing = $this->calculateBearing($userLat, $userLng, $poi['lat'], $poi['lng']);
        $direction = $this->getDirectionText($bearing);

        return [
            'poi' => $poi,
            'distance' => $distance,
            'duration' => $duration,
            'bearing' => round($bearing),
            'direction' => $direction
        ];
    }

    // Obtenir les POIs proches
    public function getNearbyPOIs($userLat, $userLng, $maxDistance = 1.0) {
        $allPOIs = $this->poiModel->getAllPOIs();
        $nearbyPOIs = [];

        foreach ($allPOIs as $poi) {
            $distance = $this->calculateDistance($userLat, $userLng, $poi['lat'], $poi['lng']);
            if ($distance <= $maxDistance) {
                $poi['distance'] = $distance;
                $poi['walkingTime'] = $this->calculateWalkingTime($distance);
                $nearbyPOIs[] = $poi;
            }
        }

        // Trier par distance
        usort($nearbyPOIs, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        return $nearbyPOIs;
    }

    // Récupérer tous les POIs avec distance
    public function getAllPOIsWithDistance($userLat, $userLng) {
        $allPOIs = $this->poiModel->getAllPOIs();
        
        foreach ($allPOIs as &$poi) {
            $poi['distance'] = $this->calculateDistance($userLat, $userLng, $poi['lat'], $poi['lng']);
            $poi['walkingTime'] = $this->calculateWalkingTime($poi['distance']);
        }

        return $allPOIs;
    }
}
?>