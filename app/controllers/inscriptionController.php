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
            
            // Initialiser l'itinéraire si non existant
            if (!isset($_SESSION['itineraire'])) {
                $_SESSION['itineraire'] = [];
            }
            
            // Rediriger vers la page demandée ou vers le carte par défaut
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header('Location: ' . $redirect);
            } else {
                header('Location: index.php?action=carte');
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

function afficherItineraire() {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['redirect_after_login'] = 'index.php?action=itineraire';
        $_SESSION['erreurLogin'] = "Veuillez vous connecter pour accéder à l'itinéraire";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }
    
    require_once __DIR__ . '/../Views/itineraireView.php';
}

function afficherNavigation() {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['erreur'] = "Veuillez vous connecter pour utiliser la navigation";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }

    // Vérifier qu'il y a un itinéraire
    if (empty($_SESSION['itineraire'])) {
        $_SESSION['erreur'] = "Votre itinéraire est vide";
        header('Location: index.php?action=itineraire');
        exit;
    }

    require_once __DIR__ . '/../Views/navigationView.php';
}

function ajouterEtape() {
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['erreur'] = "Veuillez vous connecter pour ajouter une étape";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id) {
        // Récupérer l'élément depuis le modèle
        require_once __DIR__ . '/../models/listeModel.php';
        $model = new ListeModel();
        $element = $model->getElementById($id);
        
        if ($element) {
            // Initialiser l'itinéraire si non existant
            if (!isset($_SESSION['itineraire'])) {
                $_SESSION['itineraire'] = [];
            }
            
            // Vérifier si l'élément n'est pas déjà dans l'itinéraire
            $existeDeja = false;
            foreach ($_SESSION['itineraire'] as $etape) {
                if ($etape['id'] == $element['id']) {
                    $existeDeja = true;
                    break;
                }
            }
            
            if (!$existeDeja) {
                $_SESSION['itineraire'][] = $element;
                $_SESSION['message'] = "Étape ajoutée à l'itinéraire !";
            } else {
                $_SESSION['erreur'] = "Cette étape est déjà dans votre itinéraire";
            }
        } else {
            $_SESSION['erreur'] = "Élément non trouvé";
        }
    }
    
    // Rediriger vers la page précédente ou la liste
    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=liste&filtre=spectacles';
    header('Location: ' . $referer);
    exit;
}

function supprimerEtape() {
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['erreur'] = "Veuillez vous connecter pour modifier l'itinéraire";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }

    $index = isset($_GET['index']) ? intval($_GET['index']) : -1;
    
    if ($index >= 0 && isset($_SESSION['itineraire'][$index])) {
        unset($_SESSION['itineraire'][$index]);
        $_SESSION['itineraire'] = array_values($_SESSION['itineraire']); // Réindexer
        $_SESSION['message'] = "Étape supprimée de l'itinéraire";
    } else {
        $_SESSION['erreur'] = "Étape non trouvée";
    }
    
    header('Location: index.php?action=itineraire');
    exit;
}

function viderItineraire() {
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['erreur'] = "Veuillez vous connecter pour modifier l'itinéraire";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }

    $_SESSION['itineraire'] = [];
    $_SESSION['message'] = "Itinéraire vidé avec succès";
    
    header('Location: index.php?action=itineraire');
    exit;
}

function calculerItineraire() {
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['erreur'] = "Veuillez vous connecter pour calculer l'itinéraire";
        header('Location: index.php?action=afficherConnexion');
        exit;
    }

    if (empty($_SESSION['itineraire'])) {
        $_SESSION['erreur'] = "Votre itinéraire est vide";
        header('Location: index.php?action=itineraire');
        exit;
    }

    // Rediriger vers l'écran de navigation
    header('Location: index.php?action=navigation');
    exit;
}

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