// Fonction pour afficher/masquer les détails
function toggleDetails(elementId) {
    const card = document.querySelector(`[data-id="${elementId}"]`);
    const detailsSection = document.getElementById(`details-${elementId}`);
    const detailsBtn = card.querySelector('.details-btn i');
    
    // Vérifier si les détails sont déjà ouverts
    const isOpen = detailsSection.classList.contains('open');
    
    // Fermer tous les autres détails ouverts
    closeAllDetails();
    
    // Basculer l'état actuel
    if (!isOpen) {
        // Ouvrir les détails
        detailsSection.classList.add('open');
        card.classList.add('active');
        detailsBtn.style.transform = 'rotate(180deg)';
    }
}

// Fonction pour fermer tous les détails
function closeAllDetails() {
    const allOpenDetails = document.querySelectorAll('.card-details.open');
    const allActiveCards = document.querySelectorAll('.card.active');
    const allDetailsBtns = document.querySelectorAll('.details-btn i');
    
    allOpenDetails.forEach(detail => {
        detail.classList.remove('open');
    });
    
    allActiveCards.forEach(card => {
        card.classList.remove('active');
    });
    
    allDetailsBtns.forEach(btn => {
        btn.style.transform = 'rotate(0deg)';
    });
}

// Fermer les détails en cliquant en dehors
document.addEventListener('click', function(event) {
    if (!event.target.closest('.card') && !event.target.closest('.details-btn')) {
        closeAllDetails();
    }
});

// Gestionnaire pour la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAllDetails();
    }
});

// Animation pour l'ajout aux favoris
document.addEventListener('DOMContentLoaded', function() {
    const favoriButtons = document.querySelectorAll('.btn-favori');
    
    favoriButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.classList.contains('active')) {
                this.classList.add('removing');
                setTimeout(() => {
                    this.classList.remove('removing');
                }, 600);
            } else {
                this.classList.add('adding');
                setTimeout(() => {
                    this.classList.remove('adding');
                }, 600);
            }
        });
    });
});

// Fonction de recherche/filtrage des éléments
function filterElements() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.toLowerCase().trim();
    const elements = document.querySelectorAll('.searchable-element');
    const container = document.getElementById('elementsContainer');
    
    let visibleCount = 0;
    
    elements.forEach(element => {
        const name = element.getAttribute('data-name');
        const description = element.getAttribute('data-description');
        const emplacement = element.getAttribute('data-emplacement');
        
        // Vérifier si l'élément correspond à la recherche
        const matchesSearch = name.includes(searchTerm) || 
                             description.includes(searchTerm) ||
                             emplacement.includes(searchTerm);
        
        if (matchesSearch || searchTerm === '') {
            element.classList.remove('hidden');
            visibleCount++;
        } else {
            element.classList.add('hidden');
        }
    });
    
    // Afficher un message si aucun résultat
    const existingNoResults = document.getElementById('noSearchResults');
    if (existingNoResults) {
        existingNoResults.remove();
    }
    
    if (visibleCount === 0 && searchTerm !== '') {
        const noResultsDiv = document.createElement('div');
        noResultsDiv.id = 'noSearchResults';
        noResultsDiv.className = 'no-search-results';
        noResultsDiv.innerHTML = `
            <i class="fas fa-search"></i>
            <p>Aucun résultat trouvé pour "${searchTerm}"</p>
            <p style="margin-top: 10px; color: #999;">Essayez avec d'autres termes de recherche</p>
        `;
        container.appendChild(noResultsDiv);
    }
    
    // Mettre à jour le compteur d'éléments
    updateElementCount(visibleCount, searchTerm);
}

// Mettre à jour le compteur d'éléments
function updateElementCount(visibleCount, searchTerm) {
    const debugInfo = document.querySelector('.debug-info');
    if (debugInfo) {
        const filtre = new URLSearchParams(window.location.search).get('filtre') || 'spectacles';
        if (searchTerm) {
            debugInfo.innerHTML = `
                Filtre: ${filtre} | 
                Recherche: "${searchTerm}" | 
                Résultats: ${visibleCount}
            `;
        } else {
            debugInfo.innerHTML = `
                Filtre: ${filtre} | 
                Nombre d'éléments: ${visibleCount}
            `;
        }
    }
}

// Focus sur la barre de recherche quand on appuie sur Ctrl+F
document.addEventListener('keydown', function(event) {
    if ((event.ctrlKey || event.metaKey) && event.key === 'f') {
        event.preventDefault();
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.focus();
        }
    }
});

// Effacer la recherche avec la touche Echap dans la barre de recherche
document.addEventListener('keydown', function(event) {
    const searchInput = document.getElementById('searchInput');
    if (event.key === 'Escape' && document.activeElement === searchInput) {
        searchInput.value = '';
        filterElements();
    }
});

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        // Filtrer les éléments au chargement (au cas où il y aurait une valeur par défaut)
        filterElements();
        
        // Écouter les événements de saisie en temps réel
        searchInput.addEventListener('input', filterElements);
        
        // Effacer la recherche en cliquant sur la croix (si on en ajoute une plus tard)
        searchInput.addEventListener('search', function() {
            setTimeout(filterElements, 100);
        });
    }
});