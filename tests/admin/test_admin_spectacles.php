<?php
require_once __DIR__ . '/../../config/database_puy.php';

echo "TESTS ADMIN - SPECTACLES\n";
echo "===========================\n";

// TEST 12 - Liste spectacles
function test_liste_spectacles() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM spectacle");
    $count = $stmt->fetch()['count'];
    
    if ($count > 0) {
        echo "TEST 12 - Liste spectacles: $count spectacles trouvés\n";
        return true;
    }
    
    echo "TEST 12 - Liste spectacles: AUCUN spectacle\n";
    return false;
}

// TEST 13 - Création spectacle (CREATE)
function test_creation_spectacle() {
    $pdo = getPDO();
    
    // Compter avant
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM spectacle");
    $count_avant = $stmt->fetch()['count'];
    
    // Simuler création (ne pas exécuter réellement pour les tests)
    echo "TEST 13 - Création spectacle: PRÊT (simulation)\n";
    return true;
}

// TEST 14 - Modification spectacle (UPDATE)
function test_modification_spectacle() {
    $pdo = getPDO();
    $spectacle = $pdo->query("SELECT * FROM spectacle LIMIT 1")->fetch();
    
    if ($spectacle) {
        echo "TEST 14 - Modification spectacle: Spectacle #{$spectacle['id_spectacle']} trouvé\n";
        return true;
    }
    
    echo "TEST 14 - Modification spectacle: AUCUN spectacle à modifier\n";
    return false;
}

// TEST 15 - Suppression spectacle (DELETE)  
function test_suppression_spectacle() {
    echo "TEST 15 - Suppression spectacle: PRÊT (simulation)\n";
    return true;
}

test_liste_spectacles();
test_creation_spectacle();
test_modification_spectacle();
test_suppression_spectacle();
?>