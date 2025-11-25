<?php

require_once __DIR__ . '/../models/inscriptionModel.php';

function afficherInscription() {
    require_once __DIR__ . '/../Views/inscriptionView.php';
}

function traiterInscription() {
    if (isset($_POST['inscription'])) {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $mdp = trim($_POST['mdp']);
        $vitesse_marche = isset($_POST['vitesse_marche']) ? floatval($_POST['vitesse_marche']) : 4.0;

        $utilisateurExistant = utilisateurExistant($email);

        if ($utilisateurExistant) {
            $_SESSION['erreurRegister'] = "Cet email est déjà utilisé";
            header('Location: index.php?action=afficherInscription');
            exit;
        }

        creerUtilisateur($nom, $prenom, $email, $mdp, $vitesse_marche);
        $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }
}

function traiterConnexion() {
    if (isset($_POST['connexion'])) {
        $email = trim($_POST['email']);
        $mdp = trim($_POST['mdp']);

        $utilisateur = verifierConnexion($email, $mdp);

        if ($utilisateur) {
            $_SESSION['utilisateur'] = [
                'id' => $utilisateur['id_utilisateur'],
                'email' => $utilisateur['email'],
                'nom' => $utilisateur['nom'],
                'prenom' => $utilisateur['prenom'],
                'type_profil' => $utilisateur['type_profil'],
                'vitesse_marche' => $utilisateur['vitesse_marche']
            ];
            
            // Rediriger vers la page demandée ou vers le profil par défaut
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header('Location: ' . $redirect);
            } else {
                header('Location: index.php?action=profil');
            }
            exit;
        } else {
            $_SESSION['erreurLogin'] = "Email ou mot de passe incorrect";
            header('Location: index.php?action=afficherConnexion');
            exit;
        }
    }
}

function afficherProfil() {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['redirect_after_login'] = 'index.php?action=profil';
        $_SESSION['erreurLogin'] = "Veuillez vous connecter pour accéder à votre profil";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }
    
    require_once __DIR__ . '/../Views/profilView.php';
}

// NOUVELLE FONCTION : Traiter la modification de la vitesse de marche
function modifierVitesseMarche() {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['erreur'] = "Veuillez vous connecter pour modifier vos préférences";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }

    if (isset($_POST['modifier_vitesse'])) {
        $nouvelle_vitesse = floatval($_POST['vitesse_marche']);
        
        // Validation de la vitesse
        if ($nouvelle_vitesse < 1 || $nouvelle_vitesse > 10) {
            $_SESSION['erreur'] = "La vitesse de marche doit être comprise entre 1 et 10 km/h";
            header('Location: index.php?action=profil');
            exit;
        }

        $id_utilisateur = $_SESSION['utilisateur']['id'];
        $resultat = mettreAJourVitesseMarche($id_utilisateur, $nouvelle_vitesse);

        if ($resultat) {
            // Mettre à jour la session
            $_SESSION['utilisateur']['vitesse_marche'] = $nouvelle_vitesse;
            $_SESSION['message'] = "Votre vitesse de marche a été mise à jour avec succès !";
        } else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour de la vitesse de marche";
        }
        
        header('Location: index.php?action=profil');
        exit;
    }
}

function deconnexion() {
    session_destroy();
    header('Location: index.php?action=afficherConnexion');
    exit;
}

function getUtilisateurConnecte() {
    if (isset($_SESSION['utilisateur'])) {
        return $_SESSION['utilisateur'];
    }
    return null;
}