<?php

function getPDO() {
    // Configuration selon l'environnement
    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == 'localhost') {
        // Local
        $dbHost = 'localhost';
        $dbName = 'bdd';
        $dbUser = 'root';
        $dbPassword = '';
    } 
    else {
        // Serveur gr03.sio-cholet.fr
        $dbHost = 'db672809222.db.1and1.com';
        $dbName = 'db672809222';
        $dbUser = 'dbo672809222';
        $dbPassword = '4FsiBA8FYNuk';
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