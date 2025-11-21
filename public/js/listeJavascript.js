// Gestion des modals
function openModal(id) {
    document.getElementById('modal-' + id).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById('modal-' + id).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Gestion du clavier (Echap pour fermer les modals)
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const openModal = document.querySelector('.modal[style*="display: block"]');
        if (openModal) {
            const id = openModal.id.split('-')[1];
            closeModal(id);
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Fermer le modal en cliquant en dehors
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                const id = this.id.split('-')[1];
                closeModal(id);
            }
        });
    });
    
    // Animation des cartes au défilement
    const cards = document.querySelectorAll('.card');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    } else {
        // Fallback pour les navigateurs qui ne supportent pas IntersectionObserver
        cards.forEach(card => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }
    
    // Effet de survol amélioré pour les cartes (seulement sur desktop)
    if (window.matchMedia('(hover: hover)').matches) {
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    // Animation des boutons favoris
    const favorisButtons = document.querySelectorAll('.btn-favori');
    favorisButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.classList.contains('active')) {
                this.classList.add('adding');
                setTimeout(() => {
                    this.classList.remove('adding');
                }, 600);
            }
        });
    });

    // Confirmation pour les actions importantes
    const deleteButtons = document.querySelectorAll('a[href*="supprimer"], a[href*="vider"]');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir effectuer cette action ?')) {
                e.preventDefault();
            }
        });
    });

    // Gestion du scroll pour les ancres
    if (window.location.hash) {
        const element = document.querySelector(window.location.hash);
        if (element) {
            setTimeout(() => {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
});

// Fonction pour ajouter aux favoris avec feedback
function addToFavorites(elementId) {
    const btn = document.querySelector(`[href*="ajouterFavori&id=${elementId}"]`);
    if (btn) {
        btn.classList.add('adding');
        setTimeout(() => {
            btn.classList.remove('adding');
        }, 600);
    }
}

// Fonction pour ajouter à l'itinéraire avec feedback
function addToItinerary(elementId) {
    const btn = document.querySelector(`[href*="ajouterEtape&id=${elementId}"]`);
    if (btn) {
        btn.style.transform = 'scale(1.2)';
        btn.style.background = '#218838';
        setTimeout(() => {
            btn.style.transform = 'scale(1)';
            btn.style.background = '#28a745';
        }, 300);
    }
}