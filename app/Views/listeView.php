<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste - Vikings</title>
    <style>
        <?php include 'liste.css'; ?>
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <header class="app-header">
            <div class="header-content">
                <h1>VIKINGS</h1>
                <div class="header-actions">
                    <i class="fas fa-search"></i>
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </header>

        <!-- Filtres -->
        <nav class="filters-nav">
            <div class="filters-container">
                <a href="?filtre=spectacles" class="filter-btn <?php echo (!isset($_GET['filtre']) || $_GET['filtre'] == 'spectacles') ? 'active' : ''; ?>">
                    <i class="fas fa-theater-masks"></i>
                    <span>Spectacles</span>
                </a>
                <a href="?filtre=restaurants" class="filter-btn <?php echo (isset($_GET['filtre']) && $_GET['filtre'] == 'restaurants') ? 'active' : ''; ?>">
                    <i class="fas fa-utensils"></i>
                    <span>Restaurants</span>
                </a>
                <a href="?filtre=chiottes" class="filter-btn <?php echo (isset($_GET['filtre']) && $_GET['filtre'] == 'chiottes') ? 'active' : ''; ?>">
                    <i class="fas fa-restroom"></i>
                    <span>Sanitaires</span>
                </a>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main class="main-content">
            <div class="content-wrapper">
                <?php if (empty($elements)): ?>
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <p>Aucun résultat trouvé</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($elements as $element): ?>
                        <div class="card" data-id="<?php echo $element['id']; ?>">
                            <div class="card-header">
                                <div class="card-image" style="background: linear-gradient(135deg, 
                                    <?php 
                                    $colors = [
                                        '#8B4513', '#A0522D', '#CD853F', '#D2691E', 
                                        '#5F9EA0', '#4682B4', '#B8860B', '#8B0000'
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
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($element['titre']); ?></h3>
                                <p class="card-description"><?php echo htmlspecialchars($element['description']); ?></p>
                                <button class="details-btn" onclick="openModal(<?php echo $element['id']; ?>)">
                                    <span>Voir détails</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
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
                                                            <strong>Prix</strong>
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
                                    <button class="btn btn-secondary" onclick="closeModal(<?php echo $element['id']; ?>)">Fermer</button>
                                    <?php if ($element['categorie'] === 'spectacles'): ?>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-ticket-alt"></i>
                                            Réserver
                                        </button>
                                    <?php elseif ($element['categorie'] === 'restaurants'): ?>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-utensils"></i>
                                            Réserver une table
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <!-- Navigation du bas -->
        <nav class="bottom-navigation">
            <a href="#" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-map"></i>
                <span>Carte</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-calendar"></i>
                <span>Programme</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-heart"></i>
                <span>Favoris</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </nav>
    </div>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fermer le modal en cliquant en dehors
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        const id = this.id.split('-')[1];
                        closeModal(id);
                    }
                });
            });
        });
    </script>
</body>
</html>