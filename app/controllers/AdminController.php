<?php
require_once __DIR__ . '/../models/AdminModel.php';

class AdminController {
    private $model;
    
    public function __construct() {
        $this->model = new AdminModel();
    }
    
    public function index() {
        $stats = $this->model->getStats();
        $data = [
            'title' => 'Administration - Puy du Fou',
            'stats' => $stats
        ];
        require __DIR__ . '/../Views/admin/dashboard.php';
    }
}
?>