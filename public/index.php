<?php
session_start();

require_once __DIR__ . '/../app/MobileMiddleware.php';

// Vérifier l'accès mobile AVANT tout traitement
MobileMiddleware::checkMobileAccess();

require_once __DIR__ . '/../app/controllers/inscriptionController.php';
require_once __DIR__ . '/../app/controllers/listeController.php';

$action = $_GET['action'] ?? '';

switch($action) {

    case 'afficherConnexion':
        afficherInscription();
        break;

    case 'traiterConnexion':
        traiterConnexion();
        break;

    case 'traiterInscription':
        traiterInscription();
        break;

    case 'carte':
        afficherCarte();
        break;

    case 'liste':
        $controller = new ListeController();
        $controller->index();
        break;

    case 'favoris':
        afficherFavoris();
        break;

    case 'ajouterFavori':
        ajouterFavori();
        break;

    case 'supprimerFavori':
        supprimerFavori();
        break;

    case 'itineraire':
        afficherItineraire();
        break;

    case 'calculerItineraire':
        calculerItineraire();
        break;

    case 'ajouterEtape':
        ajouterEtape();
        break;

    case 'supprimerEtape':
        supprimerEtape();
        break;

    case 'viderItineraire':
        viderItineraire();
        break;

    case 'profil':
        afficherProfil();
        break;

    case 'deconnexion':
        deconnexion();
        break;

    case 'modifierVitesseMarche':
        modifierVitesseMarche();
        break;

    default:
        header('Location: index.php?action=afficherConnexion');
        exit();
        break;
}

function afficherCarte() {
    require_once __DIR__ . '/../app/Views/carteView.php';
}