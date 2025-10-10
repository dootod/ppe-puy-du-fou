<?php
require_once 'listeModel.php';

class ListeController {
    private $model;
    
    public function __construct() {
        $this->model = new ListeModel();
    }
    
    public function index() {
        $filtre = isset($_GET['filtre']) ? $_GET['filtre'] : 'spectacles';
        $elements = $this->model->getElements($filtre);
        
        require_once 'listeView.php';
    }
}
?>