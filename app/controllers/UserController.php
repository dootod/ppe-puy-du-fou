<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;
    
    public function __construct() {
        $this->model = new UserModel();
    }
    
    public function index() {
        $users = $this->model->getAllUsers();
        $data = [
            'title' => 'Gestion des Utilisateurs',
            'users' => $users
        ];
        require __DIR__ . '/../Views/admin/users/index.php';
    }

    public function create() {
        $data = [
            'title' => 'Ajouter un Utilisateur'
        ];
        require __DIR__ . '/../Views/admin/users/create.php';
    }
    
    public function store() {
        if ($_POST) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $type_profil = $_POST['type_profil'];
            $vitesse_marche = $_POST['vitesse_marche'] ?? 4.0;
            
            if ($this->model->createUser($nom, $prenom, $email, $mot_de_passe, $type_profil, $vitesse_marche)) {
                header('Location: index.php?action=admin_users_index&success=1');
            } else {
                header('Location: index.php?action=admin_users_create&error=1');
            }
        }
    }
    
    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $user = $this->model->getUserById($id);
            if ($user) {
                $data = [
                    'title' => 'Modifier l\'Utilisateur',
                    'user' => $user
                ];
                require __DIR__ . '/../Views/admin/users/edit.php';
            } else {
                header('Location: index.php?action=admin_users_index&error=2');
            }
        } else {
            header('Location: index.php?action=admin_users_index&error=3');
        }
    }
    
    public function update() {
        if ($_POST) {
            $id = $_POST['id_utilisateur'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $type_profil = $_POST['type_profil'];
            $vitesse_marche = $_POST['vitesse_marche'];
            
            // Gestion du mot de passe (changer seulement si fourni)
            $mot_de_passe = null;
            if (!empty($_POST['mot_de_passe'])) {
                $mot_de_passe = $_POST['mot_de_passe'];
            }
            
            if ($this->model->updateUser($id, $nom, $prenom, $email, $mot_de_passe, $type_profil, $vitesse_marche)) {
                header('Location: index.php?action=admin_users_index&success=2');
            } else {
                header('Location: index.php?action=admin_users_edit&id=' . $id . '&error=1');
            }
        }
    }
    
    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            if ($this->model->deleteUser($id)) {
                header('Location: index.php?action=admin_users_index&success=3');
            } else {
                header('Location: index.php?action=admin_users_index&error=4');
            }
        } else {
            header('Location: index.php?action=admin_users_index&error=5');
        }
    }
}
?>