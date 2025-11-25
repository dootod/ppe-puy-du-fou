<?php
header('Content-Type: application/json');
require_once '../controllers/NavigationController.php';

$userLat = isset($_GET['lat']) ? floatval($_GET['lat']) : DEFAULT_LAT;
$userLng = isset($_GET['lng']) ? floatval($_GET['lng']) : DEFAULT_LNG;
$maxDistance = isset($_GET['max_distance']) ? floatval($_GET['max_distance']) : 1.0;

$controller = new NavigationController();
$nearbyPOIs = $controller->getNearbyPOIs($userLat, $userLng, $maxDistance);

echo json_encode(['nearby' => $nearbyPOIs]);
?>