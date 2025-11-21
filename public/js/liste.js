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