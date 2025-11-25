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
            <h1>✏️ Modifier un Utilisateur - Puy du Fou</h1>
            <nav>
                <a href="index.php?page=admin/users" class="admin-btn">📋 Retour à la liste</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <div class="admin-form-container">
                <form method="POST" class="admin-form">
                    <div class="form-group">
                        <label for="username">👤 Nom d'utilisateur *</label>
                        <input type="text" id="username" name="username" required 
                               value="<?php echo htmlspecialchars($data['user']['username']); ?>"
                               placeholder="Entrez le nom d'utilisateur">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">📧 Email *</label>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo htmlspecialchars($data['user']['email']); ?>"
                               placeholder="entrez@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">🔒 Mot de passe</label>
                        <input type="password" id="password" name="password" 
                               placeholder="Laissez vide pour ne pas modifier">
                        <div class="form-help">Laissez ce champ vide si vous ne souhaitez pas modifier le mot de passe</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">🎭 Rôle</label>
                        <select id="role" name="role">
                            <option value="user" <?php echo $data['user']['role'] === 'user' ? 'selected' : ''; ?>>👤 Utilisateur</option>
                            <option value="admin" <?php echo $data['user']['role'] === 'admin' ? 'selected' : ''; ?>>👑 Administrateur</option>
                            <option value="moderator" <?php echo $data['user']['role'] === 'moderator' ? 'selected' : ''; ?>>🛡️ Modérateur</option>
                        </select>
                    </div>
                    
                    <div class="user-info">
                        <h3>Informations complémentaires</h3>
                        <p><strong>Statut du compte:</strong> 
                            <?php 
                            $statusLabels = [
                                'active' => 'Actif',
                                'inactive' => 'Inactif'
                            ];
                            echo $statusLabels[$data['user']['status']] ?? htmlspecialchars($data['user']['status']);
                            ?>
                        </p>
                        <p><strong>ID Utilisateur:</strong> <?php echo htmlspecialchars($data['user']['id']); ?></p>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn admin-btn-success">✅ Mettre à jour</button>
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