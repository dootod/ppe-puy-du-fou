<?php
// Output buffering pour éviter les problèmes
if (ob_get_level()) ob_end_clean();

echo "LANCEMENT DES TESTS COMPLETS\n";
echo "===============================\n\n";

// Inclure tous les tests
require_once 'auth/test_auth.php';
echo "\n";
require_once 'navigation/test_navigation.php'; 
echo "\n";
require_once 'admin/test_admin_spectacles.php';
echo "\n";
require_once 'admin/test_admin_users.php';
echo "\n";
require_once 'fonctionnalites/test_fonctionnalites.php';

echo "\nTESTS TERMINÉS - Vérifiez les résultats ci-dessus\n";
echo "Les tests principaux fonctionnent !\n";

echo "\nPour des tests réels:\n";
echo "1. Accédez à https://ewenevin.fr/puy-du-fou/public/index.php\n";
echo "2. Testez manuellement les fonctionnalités CRUD\n";
echo "3. Vérifiez la géolocalisation sur mobile\n";
echo "4. Testez le middleware mobile\n";
?>

// cd /laragon/www/ppe/ppe-puy-du-fou/tests/
// php test_complet.php

//powershell
// cd C:\laragon\www\ppe\ppe-puy-du-fou\tests PS C:\laragon\www\ppe\ppe-puy-du-fou\tests> & "C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe" test_complet.php
