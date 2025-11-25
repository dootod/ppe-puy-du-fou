<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/puy-du-fou/public/css/style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Administration Puy du Fou</h1>
        </header>
        
        <main class="admin-main">
            <!-- Ajouter les statistiques -->
            <div class="stats-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <h3 style="color: #800020; margin: 0 0 0.5rem 0;">Spectacles</h3>
                    <p style="font-size: 2rem; font-weight: bold; margin: 0; color: #333;"><?php echo $data['stats']['spectacles_count']; ?></p>
                </div>
                <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <h3 style="color: #800020; margin: 0 0 0.5rem 0;">Utilisateurs</h3>
                    <p style="font-size: 2rem; font-weight: bold; margin: 0; color: #333;"><?php echo $data['stats']['users_count']; ?></p>
                </div>
            </div>

            <div class="admin-cards">
                <div class="admin-card">
                    <h2>Gestion des Spectacles</h2>
                    <p>Gérez les spectacles, les horaires et les informations</p>
                    <a href="index.php?action=admin_spectacles_index" class="admin-btn">Accéder à la gestion</a>
                </div>
                
                <div class="admin-card">
                    <h2>Gestion des Utilisateurs</h2>
                    <p>Gérez les comptes utilisateurs et les permissions</p>
                    <a href="index.php?action=admin_users_index" class="admin-btn">Accéder à la gestion</a>
                </div>
            </div>
        </main>
        
        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Puy du Fou - Administration</p>
        </footer>
    </div>
</body>
</html>