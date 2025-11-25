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
    <title>Liste - Puy du Fou</title>
    <link rel="stylesheet" href="../public/css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styles temporaires pour s'assurer que les détails sont masqués */
        .card-details {
            display: none;
        }
        .card-details.open {
            display: block;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>
                    <?php 
                    if (!isset($_GET['filtre']) || $_GET['filtre'] == 'spectacles') echo 'SPECTACLES';
                    elseif ($_GET['filtre'] == 'restaurants') echo 'RESTAURANTS';
                    else echo 'TOILETTES';
                    ?>
                </h1>
                <div class="header-actions">
                    <a href="index.php?action=profil" style="color: white; text-decoration: none;">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

        <nav class="filters-nav">
            <div class="filters-container">
                <a href="index.php?action=liste&filtre=spectacles" class="filter-btn <?php echo (!isset($_GET['filtre']) || $_GET['filtre'] == 'spectacles') ? 'active' : ''; ?>">
                    <i class="fas fa-theater-masks"></i>
                    <span>Spectacles</span>
                </a>
                <a href="index.php?action=liste&filtre=restaurants" class="filter-btn <?php echo (isset($_GET['filtre']) && $_GET['filtre'] == 'restaurants') ? 'active' : ''; ?>">
                    <i class="fas fa-utensils"></i>
                    <span>Restaurants</span>
                </a>
                <a href="index.php?action=liste&filtre=chiottes" class="filter-btn <?php echo (isset($_GET['filtre']) && $_GET['filtre'] == 'chiottes') ? 'active' : ''; ?>">
                    <i class="fas fa-restroom"></i>
                    <span>Toilettes</span>
                </a>
            </div>
        </nav>

        <main class="main-content">
            <div class="content-wrapper">
                <?php 
                if (isset($_SESSION['message'])) {
                    echo '<div class="message-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['erreur'])) {
                    echo '<div class="error-message">' . $_SESSION['erreur'] . '</div>';
                    unset($_SESSION['erreur']);
                }

                if (empty($elements)): ?>
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <p>Aucun résultat trouvé</p>
                        <p class="debug-info" style="font-size: 12px; color: #666; margin-top: 10px;">
                            Filtre: <?php echo $_GET['filtre'] ?? 'spectacles'; ?> | 
                            Nombre d'éléments: 0
                        </p>
                    </div>
                <?php else: ?>
                    <div class="debug-info" style="font-size: 12px; color: #666; padding: 10px; background: #f5f5f5; margin-bottom: 15px;">
                        Filtre: <?php echo $_GET['filtre'] ?? 'spectacles'; ?> | 
                        Nombre d'éléments: <?php echo count($elements); ?>
                    </div>
                    
                    <?php foreach ($elements as $element): 
                        $isFavori = isset($_SESSION['favoris']) && in_array($element['id'], $_SESSION['favoris']);
                    ?>
                        <div class="card" data-id="<?php echo $element['id']; ?>">
                            <div class="card-header">
                                <div class="card-image" style="background: linear-gradient(135deg, 
                                    <?php 
                                    $colors = [
                                        '#8B4513', '#A0522D', '#CD853F', '#D2691E', 
                                        '#2E8B57', '#4682B4', '#B8860B', '#8B0000',
                                        '#6f42c1', '#e83e8c', '#20c997', '#fd7e14'
                                    ];
                                    echo $colors[($element['id']-1) % count($colors)]; ?>, 
                                    <?php echo $colors[($element['id'] % count($colors))]; ?>)">
                                    <div class="card-category">
                                        <?php 
                                        if ($element['categorie'] == 'spectacles') echo '<i class="fas fa-theater-masks"></i>';
                                        elseif ($element['categorie'] == 'restaurants') echo '<i class="fas fa-utensils"></i>';
                                        else echo '<i class="fas fa-restroom"></i>';
                                        ?>
                                    </div>
                                    <?php if ($element['categorie'] == 'spectacles'): ?>
                                        <div class="card-duree">
                                            <?php echo $element['duree']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-header-row">
                                    <h3 class="card-title"><?php echo htmlspecialchars($element['titre']); ?></h3>
                                    <a href="index.php?action=<?php echo $isFavori ? 'supprimerFavori' : 'ajouterFavori'; ?>&id=<?php echo $element['id']; ?>" class="btn-favori <?php echo $isFavori ? 'active' : ''; ?>">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                </div>
                                <p class="card-description"><?php echo htmlspecialchars($element['description']); ?></p>
                                
                                <?php if ($element['categorie'] == 'spectacles'): ?>
                                    <div class="spectacle-info">
                                        <div class="info-item-small">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?php echo $element['emplacement']; ?></span>
                                        </div>
                                        <div class="info-item-small">
                                            <i class="fas fa-clock"></i>
                                            <span><?php echo implode(' • ', $element['horaires']); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($element['categorie'] == 'restaurants'): ?>
                                    <div class="spectacle-info">
                                        <div class="info-item-small">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?php echo $element['emplacement']; ?></span>
                                        </div>
                                        <div class="info-item-small">
                                            <i class="fas fa-clock"></i>
                                            <span><?php echo $element['horaires']; ?></span>
                                        </div>
                                        <div class="info-item-small">
                                            <i class="fas fa-euro-sign"></i>
                                            <span><?php echo $element['prix_moyen']; ?></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="spectacle-info">
                                        <div class="info-item-small">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?php echo $element['emplacement']; ?></span>
                                        </div>
                                        <div class="info-item-small">
                                            <i class="fas fa-concierge-bell"></i>
                                            <span><?php echo implode(', ', $element['services']); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- BOUTONS D'ACTION -->
                                <div class="card-actions">
                                    <button class="details-btn" onclick="toggleDetails(<?php echo $element['id']; ?>)">
                                        <span>Voir détails</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <a href="index.php?action=ajouterEtape&id=<?php echo $element['id']; ?>" class="btn-itineraire" title="Y aller">
                                        <i class="fas fa-route"></i>
                                        <span>Y aller</span>
                                    </a>
                                </div>
                            </div>

                            <!-- SECTION DÉTAILS DÉPLIANTE - MASQUÉE PAR DÉFAUT -->
                            <div class="card-details" id="details-<?php echo $element['id']; ?>">
                                <div class="details-content">
                                    <div class="details-section">
                                        <h4><i class="fas fa-info-circle"></i> Description détaillée</h4>
                                        <p class="info-text"><?php echo htmlspecialchars($element['details']); ?></p>
                                    </div>

                                    <?php if ($element['categorie'] === 'spectacles'): ?>
                                        <div class="details-section">
                                            <h4><i class="fas fa-info-circle"></i> Informations spectacle</h4>
                                            <div class="details-grid">
                                                <div class="detail-item">
                                                    <i class="fas fa-clock"></i>
                                                    <div>
                                                        <strong>Durée</strong>
                                                        <span><?php echo $element['duree']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-calendar"></i>
                                                    <div>
                                                        <strong>Horaires</strong>
                                                        <div class="horaires-list">
                                                            <?php foreach ($element['horaires'] as $horaire): ?>
                                                                <span class="horaire-badge"><?php echo $horaire; ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <div>
                                                        <strong>Lieu</strong>
                                                        <span><?php echo $element['emplacement']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-tag"></i>
                                                    <div>
                                                        <strong>Tarif</strong>
                                                        <span><?php echo $element['prix']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif ($element['categorie'] === 'restaurants'): ?>
                                        <div class="details-section">
                                            <h4><i class="fas fa-utensils"></i> Informations restaurant</h4>
                                            <div class="details-grid">
                                                <div class="detail-item">
                                                    <i class="fas fa-clock"></i>
                                                    <div>
                                                        <strong>Horaires</strong>
                                                        <span><?php echo $element['horaires']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <div>
                                                        <strong>Emplacement</strong>
                                                        <span><?php echo $element['emplacement']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-star"></i>
                                                    <div>
                                                        <strong>Spécialités</strong>
                                                        <div class="specialites-list">
                                                            <?php foreach ($element['specialites'] as $specialite): ?>
                                                                <span class="specialite-badge"><?php echo $specialite; ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-euro-sign"></i>
                                                    <div>
                                                        <strong>Prix moyen</strong>
                                                        <span><?php echo $element['prix_moyen']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="details-section">
                                            <h4><i class="fas fa-info-circle"></i> Informations sanitaires</h4>
                                            <div class="details-grid">
                                                <div class="detail-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <div>
                                                        <strong>Emplacement</strong>
                                                        <span><?php echo $element['emplacement']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="fas fa-concierge-bell"></i>
                                                    <div>
                                                        <strong>Services</strong>
                                                        <div class="services-list">
                                                            <?php foreach ($element['services'] as $service): ?>
                                                                <span class="service-badge"><?php echo $service; ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($element['categorie'] === 'spectacles'): ?>
                                        <div class="details-section">
                                            <h4><i class="fas fa-lightbulb"></i> Conseil du Puy du Fou</h4>
                                            <div class="conseil-box">
                                                <p>Arrivez 15 minutes avant le début du spectacle pour avoir de bonnes places. Ce spectacle est très populaire !</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="details-actions">
                                        <a href="index.php?action=<?php echo $isFavori ? 'supprimerFavori' : 'ajouterFavori'; ?>&id=<?php echo $element['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-heart"></i>
                                            <?php echo $isFavori ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>
                                        </a>
                                        <a href="index.php?action=ajouterEtape&id=<?php echo $element['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-route"></i>
                                            Y aller
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <?php include __DIR__ . '/navbarView.php'; ?>
    </div>

    <script src="js/liste.js"></script>
</body>
</html>