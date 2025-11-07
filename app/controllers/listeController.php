<?php
require_once __DIR__ . '/../models/listeModel.php';

class ListeController {
    private $model;
    
    public function __construct() {
        $this->model = new ListeModel();
    }
    
    public function index() {
        $filtre = isset($_GET['filtre']) ? $_GET['filtre'] : 'spectacles';
        $elements = $this->model->getElements($filtre);
        
        require_once __DIR__ . '/../Views/listeView.php';
    }
}
?>