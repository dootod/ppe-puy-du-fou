<?php
function utilisateurExistant($email) {
    $pdo = getPDO();
    $requete = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = :email");
    $requete->execute(["email" => $email]);
    $idUser = $requete->fetch();
    return $idUser ? true : false;
}

function creerUtilisateur($nom, $prenom, $email, $mdp, $vitesse_marche = 4.0) {
    $pdo = getPDO();
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    $requete = $pdo->prepare("INSERT INTO utilisateur (id_utilisateur, mot_de_passe, email, nom, prenom, type_profil, vitesse_marche) VALUES (NULL, :mdp, :email, :nom, :prenom, :type, :vitesse)");
    $requete->execute([
        "mdp" => $mdp_hash,
        "email" => $email,
        "nom" => $nom,
        "prenom" => $prenom,
        "type" => "user",
        "vitesse" => $vitesse_marche
    ]);
}

function verifierConnexion($email, $mdp) {
    $pdo = getPDO();
    $requete = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $requete->execute(["email" => $email]);
    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC); // Ajoutez FETCH_ASSOC

    // Debug
    error_log("Résultat BD: " . print_r($utilisateur, true));
    
    if ($utilisateur && password_verify($mdp, $utilisateur['mot_de_passe'])) {
        return $utilisateur;
    }
    return false;
}

// NOUVELLE FONCTION : Mettre à jour la vitesse de marche
function mettreAJourVitesseMarche($id_utilisateur, $nouvelle_vitesse) {
    $pdo = getPDO();
    $requete = $pdo->prepare("UPDATE utilisateur SET vitesse_marche = :vitesse WHERE id_utilisateur = :id");
    $resultat = $requete->execute([
        "vitesse" => $nouvelle_vitesse,
        "id" => $id_utilisateur
    ]);
    
    return $resultat;
}