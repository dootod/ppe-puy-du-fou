<?php
header('Content-Type: application/json');
require_once '../models/POI.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query)) {
    echo json_encode(['results' => []]);
    exit;
}

$poiModel = new POI();
$results = $poiModel->searchPOIs($query);

echo json_encode(['results' => $results]);
?>
