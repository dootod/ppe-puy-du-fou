<div class="search-container">
    <div class="search-bar">
        <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
        <input 
            type="text" 
            id="search-input" 
            class="search-input" 
            placeholder="Rechercher un lieu, spectacle, restaurant..."
            autocomplete="off"
        />
        <button id="clear-search" class="clear-btn hidden">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <div id="search-results" class="search-results hidden"></div>
    
    <!-- Filtres par catégorie -->
    <div class="category-filters">
        <button class="category-btn active" data-category="all">Tout</button>
        <?php foreach ($categories as $cat): ?>
            <button class="category-btn" data-category="<?php echo htmlspecialchars($cat); ?>">
                <?php echo htmlspecialchars($cat); ?>
            </button>
        <?php endforeach; ?>
    </div>
</div>
