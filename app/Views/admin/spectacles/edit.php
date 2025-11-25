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
            <h1>Modifier le Spectacle</h1>
            <nav>
                <a href="index.php?action=admin_spectacles_index" class="admin-btn">Retour à la liste</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    Erreur lors de la modification du spectacle. Veuillez réessayer.
                </div>
            <?php endif; ?>
            
            <div class="form-container">
                <form action="index.php?action=admin_spectacles_update" method="POST" class="spectacle-form">
                    <input type="hidden" name="id_spectacle" value="<?php echo $data['spectacle']['id_spectacle']; ?>">
                    
                    <div class="form-group">
                        <label for="libelle">Nom du spectacle:</label>
                        <input type="text" id="libelle" name="libelle" value="<?php echo htmlspecialchars($data['spectacle']['libelle']); ?>" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="duree_spectacle">Durée du spectacle (HH:MM:SS):</label>
                        <input type="time" id="duree_spectacle" name="duree_spectacle" value="<?php echo htmlspecialchars($data['spectacle']['duree_spectacle']); ?>" step="1" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="duree_attente">Durée d'attente (HH:MM:SS):</label>
                        <input type="time" id="duree_attente" name="duree_attente" value="<?php echo htmlspecialchars($data['spectacle']['duree_attente']); ?>" step="1" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="coordonnees_gps">Coordonnées GPS:</label>
                        <input type="text" id="coordonnees_gps" name="coordonnees_gps" value="<?php echo htmlspecialchars($data['spectacle']['coordonnees_gps']); ?>" required class="form-control">
                        <small style="color: #666;">Format: latitude, longitude (séparés par une virgule)</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn">Modifier le spectacle</button>
                        <a href="index.php?action=admin_spectacles_index" class="btn-cancel">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>