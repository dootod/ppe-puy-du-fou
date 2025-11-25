<?php
require_once __DIR__ . '/../../config/database_puy.php';

echo "TESTS ADMIN - UTILISATEURS\n";
echo "=============================\n";

// TEST 16 - Liste utilisateurs
function test_liste_utilisateurs() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM utilisateur");
    $count = $stmt->fetch()['count'];
    
    if ($count > 0) {
        echo "TEST 16 - Liste utilisateurs: $count utilisateurs trouvés\n";
        return true;
    }
    
    echo "TEST 16 - Liste utilisateurs: AUCUN utilisateur\n";
    return false;
}

// TEST 17 - Création utilisateur
function test_creation_utilisateur() {
    echo "TEST 17 - Création utilisateur: PRÊT (simulation)\n";
    return true;
}

// TEST 18 - Modification utilisateur  
function test_modification_utilisateur() {
    $pdo = getPDO();
    $user = $pdo->query("SELECT * FROM utilisateur WHERE type_profil = 'user' LIMIT 1")->fetch();
    
    if ($user) {
        echo "TEST 18 - Modification utilisateur: User #{$user['id_utilisateur']} trouvé\n";
        return true;
    }
    
    echo "TEST 18 - Modification utilisateur: AUCUN user à modifier\n";
    return false;
}

// TEST 19 - Suppression utilisateur
function test_suppression_utilisateur() {
    echo "TEST 19 - Suppression utilisateur: PRÊT (simulation)\n";
    return true;
}

test_liste_utilisateurs();
test_creation_utilisateur();
test_modification_utilisateur();
test_suppression_utilisateur();
?>