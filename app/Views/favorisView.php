<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoris - Puy du Fou</title>
    <link rel="stylesheet" href="css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>MES FAVORIS</h1>
                <div class="header-actions">
                    <i class="fas fa-search"></i>
                    <a href="index.php?action=afficherInscription" style="color: white; text-decoration: none;">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-wrapper">
                <?php
                require_once __DIR__ . '/../controllers/favorisController.php';
                $favoris = getFavoris();

                if (isset($_SESSION['message'])) {
                    echo '<div class="message-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }

                if (empty($favoris)): ?>
                    <div class="no-results">
                        <i class="fas fa-heart" style="color: #dc3545;"></i>
                        <h3>Aucun favori</h3>
                        <p>Ajoutez des spectacles et restaurants à vos favoris pour les retrouver facilement !</p>
                        <a href="index.php?action=liste" class="btn btn-primary" style="margin-top: 15px;">
                            <i class="fas fa-theater-masks"></i>
                            Explorer les activités
                        </a>
                    </div>
                <?php else: ?>
                    <div class="favoris-stats">
                        <p><?php echo count($favoris); ?> élément(s) dans vos favoris</p>
                    </div>

                    <?php foreach ($favoris as $element): ?>
                        <div class="card favori-card" data-id="<?php echo $element['id']; ?>">
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
                                <div class="favori-header">
                                    <h3 class="card-title"><?php echo htmlspecialchars($element['titre']); ?></h3>
                                    <a href="index.php?action=supprimerFavori&id=<?php echo $element['id']; ?>" class="btn-favori active">
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
                                
                                <div class="card-actions">
                                    <button class="details-btn" onclick="openModal(<?php echo $element['id']; ?>)">
                                        <span>Voir détails</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <a href="index.php?action=ajouterEtape&id=<?php echo $element['id']; ?>" class="btn-itineraire" title="Ajouter à l'itinéraire">
                                        <i class="fas fa-route"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal" id="modal-<?php echo $element['id']; ?>">
                            <div class="modal-backdrop" onclick="closeModal(<?php echo $element['id']; ?>)"></div>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2><?php echo htmlspecialchars($element['titre']); ?></h2>
                                    <button class="close-btn" onclick="closeModal(<?php echo $element['id']; ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-image" style="background: linear-gradient(135deg, 
                                        <?php echo $colors[($element['id']-1) % count($colors)]; ?>, 
                                        <?php echo $colors[($element['id'] % count($colors))]; ?>)">
                                        <div class="modal-image-overlay">
                                            <h3><?php echo htmlspecialchars($element['titre']); ?></h3>
                                            <p><?php echo $element['emplacement']; ?></p>
                                        </div>
                                    </div>
                                    <div class="modal-info">
                                        <p class="info-text"><?php echo htmlspecialchars($element['details']); ?></p>
                                        
                                        <?php if ($element['categorie'] === 'spectacles'): ?>
                                            <div class="info-section">
                                                <h4><i class="fas fa-info-circle"></i> Informations spectacle</h4>
                                                <div class="info-grid">
                                                    <div class="info-item">
                                                        <i class="fas fa-clock"></i>
                                                        <div>
                                                            <strong>Durée</strong>
                                                            <span><?php echo $element['duree']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-calendar"></i>
                                                        <div>
                                                            <strong>Horaires</strong>
                                                            <span><?php echo implode(' - ', $element['horaires']); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <div>
                                                            <strong>Lieu</strong>
                                                            <span><?php echo $element['emplacement']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-tag"></i>
                                                        <div>
                                                            <strong>Tarif</strong>
                                                            <span><?php echo $element['prix']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php elseif ($element['categorie'] === 'restaurants'): ?>
                                            <div class="info-section">
                                                <h4><i class="fas fa-utensils"></i> Informations restaurant</h4>
                                                <div class="info-grid">
                                                    <div class="info-item">
                                                        <i class="fas fa-clock"></i>
                                                        <div>
                                                            <strong>Horaires</strong>
                                                            <span><?php echo $element['horaires']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <div>
                                                            <strong>Emplacement</strong>
                                                            <span><?php echo $element['emplacement']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-star"></i>
                                                        <div>
                                                            <strong>Spécialités</strong>
                                                            <span><?php echo implode(', ', $element['specialites']); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-euro-sign"></i>
                                                        <div>
                                                            <strong>Prix moyen</strong>
                                                            <span><?php echo $element['prix_moyen']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="info-section">
                                                <h4><i class="fas fa-info-circle"></i> Informations sanitaires</h4>
                                                <div class="info-grid">
                                                    <div class="info-item">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <div>
                                                            <strong>Emplacement</strong>
                                                            <span><?php echo $element['emplacement']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="info-item">
                                                        <i class="fas fa-concierge-bell"></i>
                                                        <div>
                                                            <strong>Services</strong>
                                                            <span><?php echo implode(', ', $element['services']); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" onclick="closeModal(<?php echo $element['id']; ?>)">
                                        <i class="fas fa-times"></i>
                                        Fermer
                                    </button>
                                    <a href="index.php?action=supprimerFavori&id=<?php echo $element['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-heart-broken"></i>
                                        Retirer des favoris
                                    </a>
                                    <a href="index.php?action=ajouterEtape&id=<?php echo $element['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-route"></i>
                                        Ajouter à l'itinéraire
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <nav class="bottom-navigation">
            <a href="index.php?action=carte" class="nav-item">
                <i class="fas fa-map"></i>
                <span>Carte</span>
            </a>
            <a href="index.php?action=liste&filtre=spectacles" class="nav-item">
                <i class="fas fa-theater-masks"></i>
                <span>Spectacles</span>
            </a>
            <a href="index.php?action=liste&filtre=restaurants" class="nav-item">
                <i class="fas fa-utensils"></i>
                <span>Restaurants</span>
            </a>
            <a href="index.php?action=favoris" class="nav-item active">
                <i class="fas fa-heart"></i>
                <span>Favoris</span>
            </a>
            <a href="index.php?action=afficherInscription" class="nav-item">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </nav>
    </div>

    <script src="js/listelavascript.js"></script>
</body>
</html>