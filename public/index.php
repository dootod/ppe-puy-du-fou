<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

require_once __DIR__ . '/../app/MobileMiddleware.php';

$action = $_GET['action'] ?? '';
$page = $_GET['page'] ?? '';

// Si on accède via le système de pages (admin), on redirige vers les actions correspondantes
if (!empty($page)) {
    switch ($page) {
        case 'admin':
            $action = 'admin_dashboard';
            break;
        case 'spectacles':
            $action_spectacle = $_GET['action'] ?? 'index';
            $action = 'admin_spectacles_' . $action_spectacle;
            break;
        case 'users':
            $action_user = $_GET['action'] ?? 'index';
            $action = 'admin_users_' . $action_user;
            break;
        default:
            $action = 'admin_dashboard';
            break;
    }
}

// Liste des actions qui peuvent être accédées depuis un PC (sans vérification mobile)
$actions_pc = [
    'admin_dashboard',
    'admin_spectacles_index',
    'admin_spectacles_create',
    'admin_spectacles_store',
    'admin_spectacles_edit',
    'admin_spectacles_update',
    'admin_spectacles_delete',
    'admin_users_index',
    'admin_users_create',
    'admin_users_store',
    'admin_users_edit',
    'admin_users_update',
    'admin_users_delete',
    'afficherConnexion',
    'traiterConnexion',
    'traiterInscription'
];

// Vérifier l'accès mobile UNIQUEMENT pour les actions qui ne sont pas dans la liste PC
if (!in_array($action, $actions_pc)) {
    MobileMiddleware::checkMobileAccess();
}

require_once __DIR__ . '/../app/controllers/inscriptionController.php';
require_once __DIR__ . '/../app/controllers/listeController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/SpectacleController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';


switch($action) {
    // Pages d'authentification
    case 'afficherConnexion':
        afficherInscription();
        break;

    case 'traiterConnexion':
        traiterConnexion();
        break;

    case 'traiterInscription':
        traiterInscription();
        break;

    // Pages principales
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

    // Gestion d'itinéraire
    case 'itineraire':
        afficherItineraire();
        break;

    case 'navigation':
        afficherNavigation();
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

    // Profil utilisateur
    case 'profil':
        afficherProfil();
        break;

    case 'deconnexion':
        deconnexion();
        break;

    case 'modifierVitesseMarche':
        modifierVitesseMarche();
        break;

    // Administration - Tableau de bord
    case 'admin_dashboard':
        verifierAdmin();
        $controller = new AdminController();
        $controller->index();
        break;

    // Administration - Spectacles
    case 'admin_spectacles_index':
        verifierAdmin();
        $controller = new SpectacleController();
        $controller->index();
        break;

    case 'admin_spectacles_create':
        verifierAdmin();
        $controller = new SpectacleController();
        $controller->create();
        break;

    case 'admin_spectacles_store':
        verifierAdmin();
        $controller = new SpectacleController();
        $controller->store();
        break;

    case 'admin_spectacles_edit':
        verifierAdmin();
        $controller = new SpectacleController();
        $controller->edit();
        break;

    case 'admin_spectacles_update':
        verifierAdmin();
        $controller = new SpectacleController();
        $controller->update();
        break;

    case 'admin_spectacles_delete':
        verifierAdmin();
        $controller = new SpectacleController();
        $controller->delete();
        break;

    // Administration - Utilisateurs
    case 'admin_users_index':
        verifierAdmin();
        $controller = new UserController();
        $controller->index();
        break;

    case 'admin_users_create':
        verifierAdmin();
        $controller = new UserController();
        $controller->create();
        break;

    case 'admin_users_store':
        verifierAdmin();
        $controller = new UserController();
        $controller->store();
        break;

    case 'admin_users_edit':
        verifierAdmin();
        $controller = new UserController();
        $controller->edit();
        break;

    case 'admin_users_update':
        verifierAdmin();
        $controller = new UserController();
        $controller->update();
        break;

    case 'admin_users_delete':
        verifierAdmin();
        $controller = new UserController();
        $controller->delete();
        break;

    default:
        header('Location: index.php?action=afficherConnexion');
        exit();
        break;
}

// Fonction pour vérifier les droits admin
function verifierAdmin() {
    if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['type_profil'] !== 'admin') {
        $_SESSION['erreur'] = "Accès non autorisé. Droits administrateur requis.";
        header('Location: index.php?action=carte');
        exit;
    }
}

function afficherCarte() {
    require_once __DIR__ . '/../app/Views/carteView.php';
}

// Fonctions temporaires pour les favoris (à implémenter)
function afficherFavoris() {
    header('Location: index.php?action=liste&filtre=spectacles');
    exit;
}

function ajouterFavori() {
    $id = $_GET['id'] ?? 0;
    if (!isset($_SESSION['favoris'])) {
        $_SESSION['favoris'] = [];
    }
    if (!in_array($id, $_SESSION['favoris'])) {
        $_SESSION['favoris'][] = $id;
    }
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=liste&filtre=spectacles'));
    exit;
}

function supprimerFavori() {
    $id = $_GET['id'] ?? 0;
    if (isset($_SESSION['favoris'])) {
        $_SESSION['favoris'] = array_filter($_SESSION['favoris'], function($favori) use ($id) {
            return $favori != $id;
        });
    }
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=liste&filtre=spectacles'));
    exit;
}