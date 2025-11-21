<?php
session_start();

require_once __DIR__ . '/../app/controllers/listeController.php';
require_once __DIR__ . '/../app/controllers/favorisController.php';
require_once __DIR__ . '/../app/controllers/itineraireController.php';

$action = $_GET['action'] ?? 'carte';

switch($action) {
    // case 'traiterInscription':
    //     traiterInscription();
    //     break;

    // case 'afficherInscription':
    //     afficherInscription();
    //     break;

    // case 'afficherConnexion':
    //     header('Location: index.php?action=liste');
    //     exit;
    //     break;

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

    default:
        afficherCarte();
        break;
}

function afficherCarte() {
    require_once __DIR__ . '/../app/Views/carteView.php';
}

function afficherFavoris() {
    require_once __DIR__ . '/../app/Views/favorisView.php';
}

function afficherItineraire() {
    require_once __DIR__ . '/../app/Views/itineraireView.php';
}
?>