<?php
// Chargement de la configuration
require_once 'config/database.php';

// Routage basique
$page = $_GET['page'] ?? 'admin';

// Vérification de la connexion à la base de données
try {
    $testPdo = getPDO();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

switch ($page) {
    case 'admin':
        require 'app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;
        
    case 'admin/users':
        require 'app/controllers/UserController.php';
        $controller = new UserController();
        
        $action = $_GET['action'] ?? 'index';
        $id = $_GET['id'] ?? null;
        
        switch ($action) {
            case 'add':
                $controller->add();
                break;
            case 'edit':
                if ($id) {
                    $controller->edit($id);
                } else {
                    header('Location: index.php?page=admin/users&error=ID manquant');
                }
                break;
            case 'delete':
                if ($id) {
                    $controller->delete($id);
                } else {
                    header('Location: index.php?page=admin/users&error=ID manquant');
                }
                break;
            case 'toggle-status':
                if ($id) {
                    $controller->toggleStatus($id);
                } else {
                    header('Location: index.php?page=admin/users&error=ID manquant');
                }
                break;
            default:
                $controller->index();
                break;
        }
        break;
        
    default:
        header('HTTP/1.0 404 Not Found');
        echo 'Page non trouvée';
        break;
}
?>