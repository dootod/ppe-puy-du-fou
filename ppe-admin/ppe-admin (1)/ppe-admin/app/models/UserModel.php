<?php
require_once __DIR__ . '/../../config/database.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getPDO();
    }
    
    public function getAllUsers() {
        try {
            $sql = "SELECT id, username, email, role, created_at, status 
                    FROM utilisateur 
                    ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getAllUsers: " . $e->getMessage());
            return [];
        }
    }
    
    public function getUserById($id) {
        try {
            $sql = "SELECT id, username, email, role, status 
                    FROM utilisateur 
                    WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getUserById: " . $e->getMessage());
            return false;
        }
    }
    
    public function createUser($username, $email, $password, $role = 'user') {
        try {
            // Vérifier si l'utilisateur existe déjà
            $checkSql = "SELECT id FROM utilisateur WHERE username = ? OR email = ?";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([$username, $email]);
            
            if ($checkStmt->fetch()) {
                error_log("Utilisateur ou email déjà existant: $username / $email");
                return false;
            }
            
            $sql = "INSERT INTO utilisateur (username, email, password, role, status) 
                    VALUES (?, ?, ?, ?, 'active')";
            $stmt = $this->pdo->prepare($sql);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $result = $stmt->execute([$username, $email, $hashedPassword, $role]);
            
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("Erreur SQL createUser: " . print_r($errorInfo, true));
                return false;
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans createUser: " . $e->getMessage());
            error_log("Username: $username, Email: $email, Role: $role");
            return false;
        }
    }
    
    public function updateUser($id, $username, $email, $role, $password = null) {
        try {
            if ($password) {
                $sql = "UPDATE utilisateur 
                        SET username = ?, email = ?, role = ?, password = ? 
                        WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                return $stmt->execute([$username, $email, $role, $hashedPassword, $id]);
            } else {
                $sql = "UPDATE utilisateur 
                        SET username = ?, email = ?, role = ? 
                        WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([$username, $email, $role, $id]);
            }
        } catch (PDOException $e) {
            error_log("Erreur dans updateUser: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteUser($id) {
        try {
            $sql = "DELETE FROM utilisateur WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur dans deleteUser: " . $e->getMessage());
            return false;
        }
    }
    
    public function toggleUserStatus($id, $status) {
        try {
            $sql = "UPDATE utilisateur SET status = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("Erreur dans toggleUserStatus: " . $e->getMessage());
            return false;
        }
    }
}
?>