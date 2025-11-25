<?php
require_once __DIR__ . '/../../config/database_puy.php';

echo "TESTS FONCTIONNALITÉS\n";
echo "========================\n";

// TEST 6 - Liste spectacles avec données
function test_donnees_spectacles() {
    $pdo = getPDO();
    if (!$pdo) {
        echo "TEST 6 - Données spectacles: ERREUR BDD\n";
        return false;
    }
    
    $stmt = $pdo->query("SELECT * FROM spectacle");
    $spectacles = $stmt->fetchAll();
    
    $success = true;
    foreach ($spectacles as $spectacle) {
        if (empty($spectacle['libelle']) || empty($spectacle['duree_spectacle'])) {
            echo "Spectacle #{$spectacle['id_spectacle']} données incomplètes\n";
            $success = false;
        }
    }
    
    if ($success) {
        echo "TEST 6 - Données spectacles: " . count($spectacles) . " spectacles valides\n";
    }
    
    return $success;
}

// TEST 9 - Simulation itinéraire
function test_itineraire() {
    echo "TEST 9 - Itinéraire: PRÊT (simulation)\n";
    return true;
}

// TEST 20 - Vérification coordonnées GPS
function test_coordonnees_gps() {
    $pdo = getPDO();
    if (!$pdo) {
        echo "TEST 20 - Coordonnées GPS: ERREUR BDD\n";
        return false;
    }
    
    $stmt = $pdo->query("SELECT * FROM lieu WHERE coordonnees_gps IS NOT NULL");
    $lieux = $stmt->fetchAll();
    
    if (count($lieux) > 0) {
        echo "TEST 20 - Coordonnées GPS: " . count($lieux) . " lieux avec coordonnées\n";
        return true;
    }
    
    echo "TEST 20 - Coordonnées GPS: AUCUNE coordonnée\n";
    return false;
}

test_donnees_spectacles();
test_itineraire();
test_coordonnees_gps();
?>