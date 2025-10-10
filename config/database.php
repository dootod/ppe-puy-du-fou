<?php

function getPDO(){
    $dbHost = 'localhost';
    $dbName = 'bdd';
    $dbUser = 'root';
    $dbPassword = '';

    try {
        $pdo = new PDO(
            "mysql:host=$dbHost;dbname=$dbName;charset=utf8",
            $dbUser,
            $dbPassword);
            
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } 
    catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}