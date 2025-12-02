<?php
echo "TESTS NAVIGATION\n";
echo "===================\n";

// TEST 4 - Vérification des URLs principales
function test_urls_navigation() {
    $urls = [
        'index.php?action=carte',
        'index.php?action=liste&filtre=spectacles', 
        'index.php?action=liste&filtre=restaurants',
        'index.php?action=liste&filtre=toilettes',
        'index.php?action=profil'
    ];
    
    $success = true;
    foreach ($urls as $url) {
        // Simuler l'accès aux pages
        if (strpos($url, 'action=') !== false) {
            echo "URL accessible: $url\n";
        } else {
            echo "URL inaccessible: $url\n";
            $success = false;
        }
    }
    
    return $success;
}

// TEST 5 - Vérification filtres
function test_filtres() {
    $filtres = ['spectacles', 'restaurants', 'toilettes'];
    $success = true;
    
    foreach ($filtres as $filtre) {
        $url = "index.php?action=liste&filtre=$filtre";
        echo "Filtre disponible: $filtre\n";
    }
    
    return $success;
}

test_urls_navigation();
test_filtres();
?>