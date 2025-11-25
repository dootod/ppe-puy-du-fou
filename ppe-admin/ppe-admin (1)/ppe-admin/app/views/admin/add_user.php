<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>➕ Ajouter un Utilisateur - Puy du Fou</h1>
            <nav>
                <a href="index.php?page=admin/users" class="admin-btn">📋 Retour à la liste</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <div class="admin-form-container">
                <form method="POST" class="admin-form">
                    <div class="form-group">
                        <label for="username">👤 Nom d'utilisateur *</label>
                        <input type="text" id="username" name="username" required placeholder="Entrez le nom d'utilisateur">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">📧 Email *</label>
                        <input type="email" id="email" name="email" required placeholder="entrez@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">🔒 Mot de passe *</label>
                        <input type="password" id="password" name="password" required placeholder="Minimum 6 caractères">
                        <div class="form-help">Le mot de passe doit contenir au moins 6 caractères</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">🎭 Rôle</label>
                        <select id="role" name="role">
                            <option value="user">👤 Utilisateur</option>
                            <option value="admin">👑 Administrateur</option>
                            <option value="moderator">🛡️ Modérateur</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn admin-btn-success">✅ Créer l'utilisateur</button>
                        <a href="index.php?page=admin/users" class="admin-btn admin-btn-secondary">❌ Annuler</a>
                    </div>
                </form>
            </div>
        </main>
        
        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Puy du Fou - Administration</p>
        </footer>
    </div>
</body>
</html>