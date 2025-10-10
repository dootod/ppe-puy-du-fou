<?php

require_once __DIR__ . '/../../config/database.php';

function creerUtilisateur($nom, $prenom, $email, $mdp) {

    $pdo = getPDO();

    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    $requete = $pdo->prepare("INSERT INTO utilisateur (id_utilisateur, mot_de_passe, email, nom, prenom, type_profil) VALUES (NULL, :mdp, :email, :nom, :prenom, :type)");
    $requete->execute([
        "mdp" => $mdp_hash,
        "email" => $email,
        "nom" => $nom,
        "prenom" => $prenom,
        "type" => "user"
    ]);
}