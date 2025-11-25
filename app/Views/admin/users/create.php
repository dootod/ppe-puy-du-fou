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
            <h1>Ajouter un Utilisateur</h1>
            <nav>
                <a href="index.php?action=admin_users_index" class="admin-btn">Retour à la liste</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    Erreur lors de l'ajout de l'utilisateur. L'email est peut-être déjà utilisé.
                </div>
            <?php endif; ?>
            
            <div class="form-container">
                <form action="index.php?action=admin_users_store" method="POST" class="user-form">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe:</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="type_profil">Type de profil:</label>
                        <select id="type_profil" name="type_profil" required class="form-control">
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="vitesse_marche">Vitesse de marche (km/h):</label>
                        <input type="number" id="vitesse_marche" name="vitesse_marche" step="0.1" min="1" max="10" value="4.0" class="form-control">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn">Ajouter l'utilisateur</button>
                        <a href="index.php?action=admin_users_index" class="btn-cancel">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>