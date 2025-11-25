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
            <h1>Administration Puy du Fou</h1>
        </header>
        
        <main class="admin-main">
            <div class="admin-cards">
                <div class="admin-card">
                    <h2>Gestion des Spectacles</h2>
                    <p>Gérez les spectacles, les horaires et les informations</p>
                    <a href="#" class="admin-btn">Accéder à la gestion</a>
                </div>
                
                <div class="admin-card">
                    <h2>Gestion des Utilisateurs</h2>
                    <p>Gérez les comptes utilisateurs et les permissions</p>
                    <a href="index.php?page=admin/users" class="admin-btn">Accéder à la gestion</a>
                </div>
            </div>
        </main>
        
        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Puy du Fou - Administration</p>
        </footer>
    </div>
</body>
</html>