<!-- app/views/connexion.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    
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
    
    <form method="POST" action="index.php?action=traiterConnexion">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        </div>
        
        <div>
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        
        <button type="submit">Se connecter</button>
    </form>
    
    <p>Pas encore de compte ? <a href="index.php?action=afficherInscription">S'inscrire</a></p>
</body>
</html>