<?php
// app/controllers/inscriptionController.php

require_once __DIR__ . '/../models/UtilisateurModel.php';

function afficherInscription() {
    require_once __DIR__ . '/../views/inscription.php';
}

function traiterInscription() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['mot_de_passe'] ?? '';
        $confirmationMotDePasse = $_POST['confirmation_mot_de_passe'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $typeProfil = $_POST['type_profil'] ?? '';
        $vitesseMarche = $_POST['vitesse_marche'] ?? null;
        
        $erreurs = [];
        
        // Validation
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "Email invalide";
        }
        
        if (empty($motDePasse) || strlen($motDePasse) < 6) {
            $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères";
        }
        
        if ($motDePasse !== $confirmationMotDePasse) {
            $erreurs[] = "Les mots de passe ne correspondent pas";
        }
        
        if (empty($nom)) {
            $erreurs[] = "Le nom est obligatoire";
        }
        
        if (empty($prenom)) {
            $erreurs[] = "Le prénom est obligatoire";
        }
        
        if (empty($typeProfil)) {
            $erreurs[] = "Le type de profil est obligatoire";
        }
        
        if (emailExisteDeja($email)) {
            $erreurs[] = "Cet email est déjà utilisé";
        }
        
        if (empty($erreurs)) {
            $success = creerUtilisateur($email, $motDePasse, $nom, $prenom, $typeProfil, $vitesseMarche);
            
            if ($success) {
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header('Location: index.php?action=afficherConnexion');
                exit();
            } else {
                $erreurs[] = "Erreur lors de l'inscription";
            }
        }
        
        // Afficher le formulaire avec les erreurs
        require_once __DIR__ . '/../views/inscription.php';
    } else {
        afficherInscription();
    }
}
?>