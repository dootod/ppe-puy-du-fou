<?php
header('Content-Type: application/json');
require_once '../controllers/NavigationController.php';

$poiId = isset($_GET['poi_id']) ? intval($_GET['poi_id']) : 0;
$userLat = isset($_GET['lat']) ? floatval($_GET['lat']) : 0;
$userLng = isset($_GET['lng']) ? floatval($_GET['lng']) : 0;

if (!$poiId || !$userLat || !$userLng) {
    echo json_encode(['error' => 'Paramètres invalides']);
    exit;
}

$controller = new NavigationController();
$navData = $controller->prepareNavigationData($userLat, $userLng, $poiId);

if (!$navData) {
    echo json_encode(['error' => 'POI non trouvé']);
    exit;
}

echo json_encode($navData);
?>