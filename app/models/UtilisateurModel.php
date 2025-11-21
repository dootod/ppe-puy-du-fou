<?php
// app/models/UtilisateurModel.php

require_once __DIR__ . '/../../config/database.php';

function creerUtilisateur($email, $motDePasse, $nom, $prenom, $typeProfil, $vitesseMarche = null) {
    $db = getDBConnection();
    $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO Utilisateur (email, mot_de_passe, nom, prenom, type_profil, vitesse_marche) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    return $stmt->execute([$email, $motDePasseHash, $nom, $prenom, $typeProfil, $vitesseMarche]);
}

function trouverUtilisateurParEmail($email) {
    $db = getDBConnection();
    $sql = "SELECT * FROM Utilisateur WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function verifierConnexion($email, $motDePasse) {
    $utilisateur = trouverUtilisateurParEmail($email);
    
    if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
        return $utilisateur;
    }
    return false;
}

function emailExisteDeja($email) {
    $utilisateur = trouverUtilisateurParEmail($email);
    return $utilisateur !== false;
}
?>