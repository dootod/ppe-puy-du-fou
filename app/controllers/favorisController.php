<?php
require_once __DIR__ . '/../models/listeModel.php';

function ajouterFavori() {
    if (!isset($_SESSION['favoris'])) {
        $_SESSION['favoris'] = [];
    }

    if (isset($_GET['id'])) {
        $elementId = (int)$_GET['id'];
        $model = new ListeModel();
        $element = $model->getElementById($elementId);
        
        if ($element && !in_array($elementId, $_SESSION['favoris'])) {
            $_SESSION['favoris'][] = $elementId;
            $_SESSION['message'] = "Ajouté aux favoris !";
        }
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=liste';
    header("Location: $referer");
    exit;
}

function supprimerFavori() {
    if (isset($_GET['id']) && isset($_SESSION['favoris'])) {
        $elementId = (int)$_GET['id'];
        $_SESSION['favoris'] = array_diff($_SESSION['favoris'], [$elementId]);
        $_SESSION['message'] = "Retiré des favoris !";
    }

    header('Location: index.php?action=favoris');
    exit;
}

function getFavoris() {
    if (!isset($_SESSION['favoris']) || empty($_SESSION['favoris'])) {
        return [];
    }

    $model = new ListeModel();
    $favoris = [];
    
    foreach ($_SESSION['favoris'] as $elementId) {
        $element = $model->getElementById($elementId);
        if ($element) {
            $favoris[] = $element;
        }
    }

    return $favoris;
}
?>