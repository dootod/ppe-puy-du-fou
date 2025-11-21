<?php
// app/controllers/connexionController.php

require_once __DIR__ . '/../models/UtilisateurModel.php';

function afficherFormulaireConnexion() {
    require_once __DIR__ . '/../views/connexion.php';
}

function traiterConnexion() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['mot_de_passe'] ?? '';
        
        $erreurs = [];
        
        if (empty($email) || empty($motDePasse)) {
            $erreurs[] = "Email et mot de passe sont obligatoires";
        }
        
        if (empty($erreurs)) {
            $utilisateur = verifierConnexion($email, $motDePasse);
            
            if ($utilisateur) {
                $_SESSION['utilisateur'] = [
                    'id' => $utilisateur['id_utilisateur'],
                    'email' => $utilisateur['email'],
                    'nom' => $utilisateur['nom'],
                    'prenom' => $utilisateur['prenom'],
                    'type_profil' => $utilisateur['type_profil']
                ];
                
                $_SESSION['message'] = "Connexion réussie !";
                header('Location: index.php');
                exit();
            } else {
                $erreurs[] = "Email ou mot de passe incorrect";
            }
        }
        
        // Afficher le formulaire avec les erreurs
        require_once __DIR__ . '/../views/connexion.php';
    } else {
        afficherFormulaireConnexion();
    }
}
?>