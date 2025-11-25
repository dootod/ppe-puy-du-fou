<?php
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == 'localhost') {
    // Environnement local - depuis app/models/
    require_once __DIR__ . '/../../config/database_puy.php';
} else {
    // Environnement de production/hebergé
    require_once '/home/ewenevh/config/database_puy.php';
}

class UserModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getPDO();
    }
    
    public function getAllUsers() {
        $stmt = $this->pdo->query("
            SELECT id_utilisateur, email, nom, prenom, type_profil, vitesse_marche 
            FROM utilisateur 
            ORDER BY id_utilisateur DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("
            SELECT id_utilisateur, email, nom, prenom, type_profil, vitesse_marche 
            FROM utilisateur 
            WHERE id_utilisateur = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createUser($nom, $prenom, $email, $mot_de_passe, $type_profil, $vitesse_marche) {
        try {
            // Vérifier si l'email existe déjà
            $stmt_check = $this->pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ?");
            $stmt_check->execute([$email]);
            if ($stmt_check->fetch()) {
                return false; // Email déjà utilisé
            }
            
            // Hasher le mot de passe
            $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            
            $stmt = $this->pdo->prepare("
                INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, type_profil, vitesse_marche) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$nom, $prenom, $email, $mot_de_passe_hash, $type_profil, $vitesse_marche]);
            
        } catch (Exception $e) {
            error_log("Erreur création utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateUser($id, $nom, $prenom, $email, $mot_de_passe, $type_profil, $vitesse_marche) {
        try {
            // Vérifier si l'email existe déjà pour un autre utilisateur
            $stmt_check = $this->pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ? AND id_utilisateur != ?");
            $stmt_check->execute([$email, $id]);
            if ($stmt_check->fetch()) {
                return false; // Email déjà utilisé par un autre utilisateur
            }
            
            if ($mot_de_passe) {
                // Mettre à jour avec le nouveau mot de passe
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("
                    UPDATE utilisateur 
                    SET nom = ?, prenom = ?, email = ?, mot_de_passe = ?, type_profil = ?, vitesse_marche = ? 
                    WHERE id_utilisateur = ?
                ");
                return $stmt->execute([$nom, $prenom, $email, $mot_de_passe_hash, $type_profil, $vitesse_marche, $id]);
            } else {
                // Mettre à jour sans changer le mot de passe
                $stmt = $this->pdo->prepare("
                    UPDATE utilisateur 
                    SET nom = ?, prenom = ?, email = ?, type_profil = ?, vitesse_marche = ? 
                    WHERE id_utilisateur = ?
                ");
                return $stmt->execute([$nom, $prenom, $email, $type_profil, $vitesse_marche, $id]);
            }
            
        } catch (Exception $e) {
            error_log("Erreur modification utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteUser($id) {
        try {
            $this->pdo->beginTransaction();
            
            // Supprimer les visites associées
            $stmt_visites = $this->pdo->prepare("DELETE FROM visite WHERE id_utilisateur = ?");
            $stmt_visites->execute([$id]);
            
            // Supprimer l'utilisateur
            $stmt_user = $this->pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
            $result = $stmt_user->execute([$id]);
            
            $this->pdo->commit();
            return $result;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur suppression utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    public function getUsersCount() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM utilisateur");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
}
?>