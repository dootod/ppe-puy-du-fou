<?php

session_start();

require_once __DIR__ . '/../app/controllers/inscriptionController.php';

$action = $_GET['action'] ?? '';

switch($action) {
    case 'traiterInscription':
        traiterInscription();
        break;

    case 'afficherInscription':
        afficherInscription();
        break;

    default:
        // Fonction qui appelle la page d'accueil
        break;
}