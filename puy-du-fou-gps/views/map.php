<div class="app-container">
    <!-- Barre de recherche -->
    <?php include 'views/components/search_bar.php'; ?>

    <!-- Carte -->
    <div id="map"></div>

    <!-- Panneau de navigation (caché par défaut) -->
    <div id="navigation-panel" class="navigation-panel hidden">
        <?php include 'views/components/navigation_panel.php'; ?>
    </div>

    <!-- Détails POI (caché par défaut) -->
    <div id="poi-details" class="poi-details hidden">
        <?php include 'views/components/poi_details.php'; ?>
    </div>

    <!-- Bouton position -->
    <button id="locate-btn" class="locate-btn" title="Ma position">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
    </button>

    <!-- Bouton arrêter navigation -->
    <button id="stop-nav-btn" class="stop-nav-btn hidden" title="Arrêter la navigation">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<script>
    // Passer les données PHP à JavaScript
    const POI_DATA = <?php echo json_encode($allPOIs); ?>;
    const DEFAULT_CENTER = [<?php echo DEFAULT_LAT; ?>, <?php echo DEFAULT_LNG; ?>];
</script>