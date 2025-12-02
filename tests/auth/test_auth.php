<?php
require_once __DIR__ . '/../../config/database_puy.php';

echo "TESTS AUTHENTIFICATION\n";
echo "========================\n";

// TEST 1 - Connexion administrateur
function test_connexion_admin() {
    $pdo = getPDO();
    if (!$pdo) {
        echo "TEST 1 - Connexion admin: ERREUR BDD\n";
        return false;
    }
    
    $email = 'admin@puydufou.com';
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "TEST 1 - Connexion admin: Utilisateur trouvé - {$user['email']}\n";
        return true;
    }
    
    echo "TEST 1 - Connexion admin: Utilisateur non trouvé\n";
    return false;
}

// TEST 2 - Connexion utilisateur normal  
function test_connexion_user() {
    $pdo = getPDO();
    if (!$pdo) {
        echo "TEST 2 - Connexion user: ERREUR BDD\n";
        return false;
    }
    
    $email = 'user1@gmail.com';
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "TEST 2 - Connexion user: Utilisateur trouvé - {$user['email']}\n";
        return true;
    }
    
    echo "TEST 2 - Connexion user: Utilisateur non trouvé\n";
    return false;
}

// TEST 3 - Vérification données utilisateurs
function test_donnees_utilisateurs() {
    $pdo = getPDO();
    if (!$pdo) {
        echo "TEST 3 - Données utilisateurs: ERREUR BDD\n";
        return false;
    }
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM utilisateur");
    $count = $stmt->fetch()['count'];
    
    if ($count > 0) {
        echo "TEST 3 - Données utilisateurs: $count utilisateur(s) en base\n";
        return true;
    }
    
    echo "TEST 3 - Données utilisateurs: AUCUN utilisateur\n";
    return false;
}

// Exécution des tests
test_connexion_admin();
test_connexion_user(); 
test_donnees_utilisateurs();
?>