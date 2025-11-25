<?php
if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/inscription.css">
    <title>Puy du Fou - Connexion/Inscription</title>
</head>
<body>
    <!-- Formulaire d'inscription -->
    <form id="formInscription" action="index.php?action=traiterInscription" method="post" class="form-container">

        <?php
        if (isset($_SESSION['erreurRegister'])) {
            echo "<div class='message erreur'>" . $_SESSION['erreurRegister'] . "</div>";
            unset($_SESSION['erreurRegister']);
        }
        if (isset($_SESSION['success'])) {
            echo "<div class='message success'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        }
        ?>

        <h2>S'inscrire</h2>

        <div>
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required>
        </div>

        <div>
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Entrez votre email" required>
        </div>

        <div>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="Entrez votre mot de passe" required>
        </div>

        <div>
            <label for="vitesse_marche">Vitesse de marche (km/h)</label>
            <input type="number" name="vitesse_marche" id="vitesse_marche" placeholder="Ex: 4.0" step="0.1" min="1" max="10" value="4.0">
        </div>

        <input type="submit" value="S'inscrire" name="inscription">

        <p>Déjà un compte ? <a href="#" onclick="afficherConnexion()">Se connecter</a></p>
    </form>

    <!-- Formulaire de connexion -->
    <form id="formConnexion" action="index.php?action=traiterConnexion" method="post" class="form-container" style="display: none;">

        <?php
        if (isset($_SESSION['erreurLogin'])) {
            echo "<div class='message erreur'>" . $_SESSION['erreurLogin'] . "</div>";
            unset($_SESSION['erreurLogin']);
        }
        ?>

        <h2>Se connecter</h2>

        <div>
            <label for="email_login">Email</label>
            <input type="email" name="email" id="email_login" placeholder="Entrez votre email" required>
        </div>

        <div>
            <label for="mdp_login">Mot de passe</label>
            <input type="password" name="mdp" id="mdp_login" placeholder="Entrez votre mot de passe" required>
        </div>

        <input type="submit" value="Se connecter" name="connexion">

        <p>Pas de compte ? <a href="#" onclick="afficherInscription()">S'inscrire</a></p>
    </form>

    <script>
        function afficherConnexion() {
            document.getElementById('formInscription').style.display = 'none';
            document.getElementById('formConnexion').style.display = 'block';
        }

        function afficherInscription() {
            document.getElementById('formConnexion').style.display = 'none';
            document.getElementById('formInscription').style.display = 'block';
        }

        // Afficher le bon formulaire selon l'URL ou les erreurs
        <?php if (isset($_SESSION['erreurLogin']) || (isset($_GET['action']) && $_GET['action'] == 'afficherConnexion')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                afficherConnexion();
            });
        <?php endif; ?>
    </script>
</body>
</html>