<?php
require_once __DIR__ . '/../models/SpectacleModel.php';

class SpectacleController {
    private $model;
    
    public function __construct() {
        $this->model = new SpectacleModel();
    }
    
    public function index() {
        $spectacles = $this->model->getAllSpectacles();
        $data = [
            'title' => 'Gestion des Spectacles',
            'spectacles' => $spectacles
        ];
        require __DIR__ . '/../Views/admin/spectacles/index.php';
    }

    public function create() {
        // Plus besoin de récupérer les lieux
        $data = [
            'title' => 'Ajouter un Spectacle'
        ];
        require __DIR__ . '/../Views/admin/spectacles/create.php';
    }
    
    public function store() {
        if ($_POST) {
            $libelle = $_POST['libelle'];
            $duree_spectacle = $_POST['duree_spectacle'];
            $duree_attente = $_POST['duree_attente'];
            $coordonnees_gps = $_POST['coordonnees_gps'];
            
            if ($this->model->createSpectacle($libelle, $duree_spectacle, $duree_attente, $coordonnees_gps)) {
                header('Location: index.php?action=admin_spectacles_index&success=1');
            } else {
                header('Location: index.php?action=admin_spectacles_create&error=1');
            }
        }
    }
    
    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $spectacle = $this->model->getSpectacleById($id);
            if ($spectacle) {
                $data = [
                    'title' => 'Modifier le Spectacle',
                    'spectacle' => $spectacle
                ];
                require __DIR__ . '/../Views/admin/spectacles/edit.php';
            } else {
                header('Location: index.php?action=admin_spectacles_index&error=2');
            }
        } else {
            header('Location: index.php?action=admin_spectacles_index&error=3');
        }
    }
    
    public function update() {
        if ($_POST) {
            $id = $_POST['id_spectacle'];
            $libelle = $_POST['libelle'];
            $duree_spectacle = $_POST['duree_spectacle'];
            $duree_attente = $_POST['duree_attente'];
            $coordonnees_gps = $_POST['coordonnees_gps'];
            
            if ($this->model->updateSpectacle($id, $libelle, $duree_spectacle, $duree_attente, $coordonnees_gps)) {
                header('Location: index.php?action=admin_spectacles_index&success=2');
            } else {
                header('Location: index.php?action=admin_spectacles_edit&id=' . $id . '&error=1');
            }
        }
    }
    
    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            if ($this->model->deleteSpectacle($id)) {
                header('Location: index.php?action=admin_spectacles_index&success=3');
            } else {
                header('Location: index.php?action=admin_spectacles_index&error=4');
            }
        } else {
            header('Location: index.php?action=admin_spectacles_index&error=5');
        }
    }
}
?>