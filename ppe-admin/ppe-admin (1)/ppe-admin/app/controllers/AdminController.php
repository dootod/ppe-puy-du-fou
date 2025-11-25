<?php
require_once 'app/models/AdminModel.php';

class AdminController {
    private $model;
    
    public function __construct() {
        $this->model = new AdminModel();
    }
    
    public function index() {
        $data = [
            'title' => 'Administration - Puy du Fou'
        ];
        require 'app/views/admin/dashboard.php';
    }
}
?>