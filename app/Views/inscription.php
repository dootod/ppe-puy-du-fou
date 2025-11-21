<!-- app/views/inscription.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($erreurs)): ?>
        <div style="color: red;">
            <?php foreach ($erreurs as $erreur): ?>
                <p><?php echo $erreur; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?action=traiterInscription">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        </div>
        
        <div>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
        </div>
        
        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
        </div>
        
        <div>
            <label for="type_profil">Type de profil:</label>
            <select id="type_profil" name="type_profil" required>
                <option value="">Sélectionnez un type</option>
                <option value="visiteur" <?php echo (isset($_POST['type_profil']) && $_POST['type_profil'] === 'visiteur') ? 'selected' : ''; ?>>Visiteur</option>
                <option value="admin" <?php echo (isset($_POST['type_profil']) && $_POST['type_profil'] === 'admin') ? 'selected' : ''; ?>>Administrateur</option>
            </select>
        </div>
        
        <div>
            <label for="vitesse_marche">Vitesse de marche (km/h):</label>
            <input type="number" id="vitesse_marche" name="vitesse_marche" step="0.01" min="0" value="<?php echo isset($_POST['vitesse_marche']) ? htmlspecialchars($_POST['vitesse_marche']) : ''; ?>">
        </div>
        
        <div>
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        
        <div>
            <label for="confirmation_mot_de_passe">Confirmer le mot de passe:</label>
            <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
        </div>
        
        <button type="submit">S'inscrire</button>
    </form>
    
    <p>Déjà un compte ? <a href="index.php?action=afficherConnexion">Se connecter</a></p>
</body>
</html>