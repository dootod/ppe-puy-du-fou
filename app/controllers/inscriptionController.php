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

        $utilisateurExistant = utilisateurExistant($email);

        if ($utilisateurExistant) {
            $_SESSION['erreurRegister'] = "Cet email est déjà utilisé";
            header('Location: index.php?action=afficherInscription');
            exit;
        }

        creerUtilisateur($nom, $prenom, $email, $mdp);
        header('Location: index.php?action=afficherConnexion');
        exit;
    }
}