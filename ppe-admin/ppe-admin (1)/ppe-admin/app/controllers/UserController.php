<?php
require_once 'app/models/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function index() {
        $users = $this->userModel->getAllUsers();
        $data = [
            'title' => 'Gestion des Utilisateurs - Puy du Fou',
            'users' => $users
        ];
        require 'app/views/admin/users.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';
            
            // Validation des données
            if (empty($username) || empty($email) || empty($password)) {
                header('Location: index.php?page=admin/users&error=Tous les champs obligatoires doivent être remplis');
                exit;
            }
            
            if (strlen($password) < 6) {
                header('Location: index.php?page=admin/users&error=Le mot de passe doit contenir au moins 6 caractères');
                exit;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?page=admin/users&error=Adresse email invalide');
                exit;
            }
            
            // Création de l'utilisateur
            $result = $this->userModel->createUser($username, $email, $password, $role);
            
            if ($result) {
                header('Location: index.php?page=admin/users&success=Utilisateur créé avec succès');
            } else {
                header('Location: index.php?page=admin/users&error=Erreur lors de la création. Vérifiez que le nom d\'utilisateur ou l\'email n\'existe pas déjà.');
            }
            exit;
        }
        
        $data = [
            'title' => 'Ajouter un Utilisateur - Puy du Fou'
        ];
        require 'app/views/admin/add_user.php';
    }
    
    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        
        if (!$user) {
            header('Location: index.php?page=admin/users&error=Utilisateur non trouvé');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = $_POST['role'] ?? 'user';
            $password = $_POST['password'] ?? '';
            
            if (!empty($password) && strlen($password) < 6) {
                header('Location: index.php?page=admin/users&action=edit&id=' . $id . '&error=Le mot de passe doit contenir au moins 6 caractères');
                exit;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?page=admin/users&action=edit&id=' . $id . '&error=Adresse email invalide');
                exit;
            }
            
            $result = $this->userModel->updateUser($id, $username, $email, $role, $password);
            if ($result) {
                header('Location: index.php?page=admin/users&success=Utilisateur modifié avec succès');
            } else {
                header('Location: index.php?page=admin/users&error=Erreur lors de la modification de l\'utilisateur');
            }
            exit;
        }
        
        $data = [
            'title' => 'Modifier l\'Utilisateur - Puy du Fou',
            'user' => $user
        ];
        require 'app/views/admin/edit_user.php';
    }
    
    public function delete($id) {
        $result = $this->userModel->deleteUser($id);
        if ($result) {
            header('Location: index.php?page=admin/users&success=Utilisateur supprimé avec succès');
        } else {
            header('Location: index.php?page=admin/users&error=Erreur lors de la suppression de l\'utilisateur');
        }
        exit;
    }
    
    public function toggleStatus($id) {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
            $result = $this->userModel->toggleUserStatus($id, $newStatus);
            if ($result) {
                header('Location: index.php?page=admin/users&success=Statut utilisateur modifié');
            } else {
                header('Location: index.php?page=admin/users&error=Erreur lors du changement de statut');
            }
        } else {
            header('Location: index.php?page=admin/users&error=Utilisateur non trouvé');
        }
        exit;
    }
}
?>