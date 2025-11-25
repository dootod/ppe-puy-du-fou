<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/ppe/ppe-puy-du-fou/public/css/style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Modifier l'Utilisateur</h1>
            <nav>
                <a href="index.php?action=admin_users_index" class="admin-btn">Retour à la liste</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    Erreur lors de la modification de l'utilisateur. L'email est peut-être déjà utilisé.
                </div>
            <?php endif; ?>
            
            <div class="form-container">
                <form action="index.php?action=admin_users_update" method="POST" class="user-form">
                    <input type="hidden" name="id_utilisateur" value="<?php echo $data['user']['id_utilisateur']; ?>">
                    
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($data['user']['nom']); ?>" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($data['user']['prenom']); ?>" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['user']['email']); ?>" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="mot_de_passe">Nouveau mot de passe (laisser vide pour ne pas changer):</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control">
                        <small style="color: #666;">Laisser vide pour conserver le mot de passe actuel</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="type_profil">Type de profil:</label>
                        <select id="type_profil" name="type_profil" required class="form-control">
                            <option value="user" <?php echo $data['user']['type_profil'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                            <option value="admin" <?php echo $data['user']['type_profil'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="vitesse_marche">Vitesse de marche (km/h):</label>
                        <input type="number" id="vitesse_marche" name="vitesse_marche" step="0.1" min="1" max="10" 
                               value="<?php echo htmlspecialchars($data['user']['vitesse_marche']); ?>" class="form-control">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn">Modifier l'utilisateur</button>
                        <a href="index.php?action=admin_users_index" class="btn-cancel">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>