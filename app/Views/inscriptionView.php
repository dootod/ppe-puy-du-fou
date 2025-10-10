<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form action="index.php?action=traiterInscription" method="post">
        <div>
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required>
        </div>

        <div>
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prenom" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Entrez votre email" required>
        </div>

        <div>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="Entrez votre mot de passe" required>
        </div>

        <input type="submit" value="S'inscrire" name="inscription">

        <p>Déjà un compte ? <a href="index.php?action=afficherConnexion">Se connecter</a></p>
    </form>
</body>
</html>