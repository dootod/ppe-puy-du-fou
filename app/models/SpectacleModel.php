<?php
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == 'localhost') {
    // Environnement local - depuis app/models/
    require_once __DIR__ . '/../../config/database_puy.php';
} else {
    // Environnement de production/hebergé
    require_once '/home/ewenevh/config/database_puy.php';
}

class SpectacleModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getPDO();
    }
    
    public function getAllSpectacles() {
        $stmt = $this->pdo->query("
            SELECT s.id_spectacle, s.libelle, s.duree_spectacle, s.duree_attente, 
                   l.id_lieu, l.coordonnees_gps
            FROM spectacle s 
            LEFT JOIN lieu l ON s.id_lieu = l.id_lieu 
            ORDER BY s.id_spectacle DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSpectacleById($id) {
        $stmt = $this->pdo->prepare("
            SELECT s.id_spectacle, s.libelle, s.duree_spectacle, s.duree_attente, 
                   s.id_lieu, l.coordonnees_gps
            FROM spectacle s 
            LEFT JOIN lieu l ON s.id_lieu = l.id_lieu 
            WHERE s.id_spectacle = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createSpectacle($libelle, $duree_spectacle, $duree_attente, $coordonnees_gps) {
    try {
        $this->pdo->beginTransaction();
        
        // Debug: afficher les valeurs reçues
        error_log("Valeurs reçues - libelle: $libelle, duree_spectacle: $duree_spectacle, duree_attente: $duree_attente, coords: $coordonnees_gps");
        
        // Valider le format des coordonnées GPS (version plus permissive)
        if (!$this->isValidGPSCoordinates($coordonnees_gps)) {
            throw new Exception("Format de coordonnées GPS invalide: $coordonnees_gps");
        }
        
        // 1. Créer d'abord le lieu
        $stmt_lieu = $this->pdo->prepare("INSERT INTO lieu (coordonnees_gps) VALUES (?)");
        if (!$stmt_lieu->execute([$coordonnees_gps])) {
            $errorInfo = $stmt_lieu->errorInfo();
            throw new Exception("Erreur lieu: " . $errorInfo[2]);
        }
        $id_lieu = $this->pdo->lastInsertId();
        
        // 2. Formater correctement les durées pour SQL
        $duree_spectacle_formatted = $this->formatTimeForSQL($duree_spectacle);
        $duree_attente_formatted = $this->formatTimeForSQL($duree_attente);
        
        // 3. Créer le spectacle avec l'id_lieu généré
        $stmt_spectacle = $this->pdo->prepare("
            INSERT INTO spectacle (libelle, duree_spectacle, duree_attente, id_lieu) 
            VALUES (?, ?, ?, ?)
        ");
        
        $result = $stmt_spectacle->execute([
            $libelle, 
            $duree_spectacle_formatted,
            $duree_attente_formatted,
            $id_lieu
        ]);
        
        if (!$result) {
            $errorInfo = $stmt_spectacle->errorInfo();
            throw new Exception("Erreur spectacle: " . $errorInfo[2]);
        }
        
        $this->pdo->commit();
        return true;
        
    } catch (Exception $e) {
        $this->pdo->rollBack();
        error_log("Erreur création spectacle: " . $e->getMessage());
        return false;
    }
    }

    // Nouvelle méthode pour formater le temps
    private function formatTimeForSQL($time) {
        // Si le format est déjà HH:MM:SS, le garder
        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $time)) {
            return $time;
        }
        // Si c'est HH:MM, ajouter :00
        if (preg_match('/^\d{1,2}:\d{2}$/', $time)) {
            return $time . ':00';
        }
        return $time;
    }

    // Validation GPS plus permissive
    private function isValidGPSCoordinates($coords) {
        // Accepte: "lat, lng" ou "lat,lng" avec des nombres décimaux
        return preg_match('/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/', trim($coords));
    }
    
    public function updateSpectacle($id, $libelle, $duree_spectacle, $duree_attente, $coordonnees_gps) {
        try {
            $this->pdo->beginTransaction();
            
            // 1. Récupérer l'id_lieu du spectacle
            $stmt_get = $this->pdo->prepare("SELECT id_lieu FROM spectacle WHERE id_spectacle = ?");
            $stmt_get->execute([$id]);
            $spectacle = $stmt_get->fetch(PDO::FETCH_ASSOC);
            
            if (!$spectacle) {
                throw new Exception("Spectacle non trouvé");
            }
            
            $id_lieu = $spectacle['id_lieu'];
            
            // 2. Mettre à jour les coordonnées du lieu
            $stmt_lieu = $this->pdo->prepare("UPDATE lieu SET coordonnees_gps = ? WHERE id_lieu = ?");
            $stmt_lieu->execute([$coordonnees_gps, $id_lieu]);
            
            // 3. Mettre à jour le spectacle
            $stmt_spectacle = $this->pdo->prepare("
                UPDATE spectacle 
                SET libelle = ?, duree_spectacle = ?, duree_attente = ? 
                WHERE id_spectacle = ?
            ");
            $result = $stmt_spectacle->execute([$libelle, $duree_spectacle, $duree_attente, $id]);
            
            $this->pdo->commit();
            return $result;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur modification spectacle: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteSpectacle($id) {
        try {
            $this->pdo->beginTransaction();
            
            // 1. Récupérer l'id_lieu du spectacle
            $stmt_get = $this->pdo->prepare("SELECT id_lieu FROM spectacle WHERE id_spectacle = ?");
            $stmt_get->execute([$id]);
            $spectacle = $stmt_get->fetch(PDO::FETCH_ASSOC);
            
            if (!$spectacle) {
                throw new Exception("Spectacle non trouvé");
            }
            
            $id_lieu = $spectacle['id_lieu'];
            
            // 2. Supprimer les références dans choisir
            $stmt_choisir = $this->pdo->prepare("DELETE FROM choisir WHERE id_spectacle = ?");
            $stmt_choisir->execute([$id]);
            
            // 3. Supprimer le spectacle
            $stmt_spectacle = $this->pdo->prepare("DELETE FROM spectacle WHERE id_spectacle = ?");
            $stmt_spectacle->execute([$id]);
            
            // 4. Supprimer le lieu associé
            $stmt_lieu = $this->pdo->prepare("DELETE FROM lieu WHERE id_lieu = ?");
            $stmt_lieu->execute([$id_lieu]);
            
            $this->pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur suppression spectacle: " . $e->getMessage());
            return false;
        }
    }
    
    // Cette fonction n'est plus nécessaire pour la création
    public function getAllLieux() {
        return []; // On ne demande plus à choisir un lieu existant
    }
}
?>