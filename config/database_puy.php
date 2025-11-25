<?php
function getPDO(){
    // Configuration pour environnement CLI (terminal)
    if (php_sapi_name() === 'cli' || !isset($_SERVER['HTTP_HOST'])) {
        $dbHost = 'localhost';
        $dbName = 'bdd';
        $dbUser = 'root';
        $dbPassword = '';
    }
    // Configuration pour navigateur
    elseif ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == 'localhost') {
        $dbHost = 'localhost';
        $dbName = 'bdd';
        $dbUser = 'root';
        $dbPassword = '';
    } else {
        // Environnement de production
        $dbHost = 'localhost';
        $dbName = 'bdd';
        $dbUser = 'root';
        $dbPassword = '';
    }

    try {
        $pdo = new PDO(
            "mysql:host=$dbHost;dbname=$dbName;charset=utf8",
            $dbUser,
            $dbPassword
        );
            
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } 
    catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}
?>