<?php
require_once 'config/config.php';
require_once 'controllers/NavigationController.php';

$controller = new NavigationController();
$poiModel = new POI();

// Récupérer tous les POIs pour la carte
$allPOIs = $poiModel->getAllPOIs();
$categories = $poiModel->getCategories();

// Inclure la vue
include 'views/header.php';
include 'views/map.php';
include 'views/footer.php';
?>