<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/profil.css">
    <link rel="stylesheet" href="../public/css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Profil - Puy du Fou</title>
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>MON PROFIL</h1>
                <div class="header-actions">
                    <a href="index.php?action=profil" style="color: white; text-decoration: none;">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-wrapper">
                <?php                
                // Afficher les messages de succès ou d'erreur
                if (isset($_SESSION['message'])) {
                    echo '<div class="message-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['erreur'])) {
                    echo '<div class="error-message">' . $_SESSION['erreur'] . '</div>';
                    unset($_SESSION['erreur']);
                }
                
                if (isset($_SESSION['utilisateur'])): 
                    $utilisateur = $_SESSION['utilisateur'];
                ?>
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="profile-info">
                                <h2><?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?></h2>
                                <p class="profile-email"><?php echo htmlspecialchars($utilisateur['email']); ?></p>
                                <span class="profile-badge"><?php echo ucfirst($utilisateur['type_profil']); ?></span>
                            </div>
                        </div>

                        <div class="profile-details">
                            <div class="detail-section">
                                <h3><i class="fas fa-info-circle"></i> Informations personnelles</h3>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <i class="fas fa-user"></i>
                                        <div>
                                            <strong>Nom complet</strong>
                                            <span><?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?></span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-envelope"></i>
                                        <div>
                                            <strong>Email</strong>
                                            <span><?php echo htmlspecialchars($utilisateur['email']); ?></span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-tachometer-alt"></i>
                                        <div>
                                            <strong>Vitesse de marche</strong>
                                            <span><?php echo htmlspecialchars($utilisateur['vitesse_marche']); ?> km/h</span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-user-tag"></i>
                                        <div>
                                            <strong>Type de compte</strong>
                                            <span><?php echo ucfirst($utilisateur['type_profil']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-section">
                                <h3><i class="fas fa-walking"></i> Modifier la vitesse de marche</h3>
                                <form method="POST" action="index.php?action=modifierVitesseMarche" class="vitesse-form">
                                    <div class="form-group">
                                        <label for="vitesse_marche">Vitesse de marche (km/h) :</label>
                                        <div class="range-container">
                                            <input type="range" id="vitesse_marche" name="vitesse_marche" 
                                                   min="1" max="10" step="0.5" 
                                                   value="<?php echo htmlspecialchars($utilisateur['vitesse_marche']); ?>"
                                                   oninput="updateSpeedValue(this.value)">
                                            <span id="speedValue" class="speed-value">
                                                <?php echo htmlspecialchars($utilisateur['vitesse_marche']); ?> km/h
                                            </span>
                                        </div>
                                        <div class="speed-labels">
                                            <span>Lent (1 km/h)</span>
                                            <span>Rapide (10 km/h)</span>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" name="modifier_vitesse" class="btn-save">
                                            <i class="fas fa-save"></i>
                                            Enregistrer la vitesse
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <?php if ($utilisateur['type_profil'] === 'admin'): ?>
                                <div class="detail-section">
                                    <h3><i class="fas fa-crown"></i> Fonctions administrateur</h3>
                                    <div class="admin-actions">
                                        <a href="index.php?action=admin_dashboard" class="btn-admin">
                                            <i class="fas fa-users-cog"></i>
                                            Panel de gestion
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="profile-actions">
                            <a href="index.php?action=deconnexion" class="btn-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Se déconnecter
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="not-connected">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Non connecté</h3>
                        <p>Vous devez être connecté pour voir votre profil</p>
                        <a href="index.php?action=afficherConnexion" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Se connecter
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <?php include __DIR__ . '/navbarView.php'; ?>
    </div>

    <script>
        function updateSpeedValue(value) {
            document.getElementById('speedValue').textContent = value + ' km/h';
        }
    </script>
</body>
</html>