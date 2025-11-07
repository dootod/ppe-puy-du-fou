<?php
// index.php

session_start();

// Chemins corrigés
require_once __DIR__ . '/../app/controllers/inscriptionController.php';
require_once __DIR__ . '/../app/controllers/connexionController.php';

$action = $_GET['action'] ?? '';

switch($action) {
    case 'traiterInscription':
        traiterInscription();
        break;

    case 'afficherInscription':
        afficherInscription();
        break;

    case 'traiterConnexion':
        traiterConnexion();
        break;

    case 'afficherConnexion':
        afficherFormulaireConnexion();
        break;

    case 'deconnexion':
        session_destroy();
        header('Location: index.php');
        exit();
        break;

    default:
        traiterConnexion();
        break;
}
?>