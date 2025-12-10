<?php
class AdminModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getPDO();
    }
    
    public function getStats() {
        // Compter le nombre de spectacles
        $stmt1 = $this->pdo->query("SELECT COUNT(*) as count FROM spectacle");
        $spectacles_count = $stmt1->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Compter le nombre d'utilisateurs
        $stmt2 = $this->pdo->query("SELECT COUNT(*) as count FROM utilisateur");
        $users_count = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];
        
        return [
            'spectacles_count' => $spectacles_count,
            'users_count' => $users_count
        ];
    }
}
?>