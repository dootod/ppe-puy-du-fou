let map;
let userMarker;
let destinationMarker;
let routeLine;
let currentPosition = null;
let selectedPOI = null;
let isNavigating = false;
let watchId = null;
let poiMarkers = [];

// Initialisation de la carte
document.addEventListener('DOMContentLoaded', function() {
    initMap();
    initSearch();
    initButtons();
    initCategoryFilters();
    startLocationTracking();
});

function initMap() {
    // Créer la carte centrée sur le Puy du Fou
    map = L.map('map').setView(DEFAULT_CENTER, 16);

    // Ajouter la couche de tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Ajouter tous les POIs sur la carte
    addPOIMarkers();
}

function addPOIMarkers() {
    POI_DATA.forEach(poi => {
        const icon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #2563eb; width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3); cursor: pointer;"></div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 32]
        });

        const marker = L.marker([poi.lat, poi.lng], { icon: icon })
            .addTo(map)
            .on('click', function() {
                showPOIDetails(poi);
            });

        marker.bindTooltip(poi.name, {
            permanent: false,
            direction: 'top',
            offset: [0, -35]
        });

        poiMarkers.push({ marker: marker, poi: poi });
    });
}

function startLocationTracking() {
    if ('geolocation' in navigator) {
        // Position initiale
        navigator.geolocation.getCurrentPosition(
            position => {
                updateUserPosition(position.coords.latitude, position.coords.longitude);
            },
            error => {
                // Utiliser position par défaut
                updateUserPosition(DEFAULT_CENTER[0], DEFAULT_CENTER[1]);
            }
        );

        // Suivi en temps réel
        watchId = navigator.geolocation.watchPosition(
            position => {
                updateUserPosition(position.coords.latitude, position.coords.longitude);
                if (isNavigating && selectedPOI) {
                    updateNavigation();
                }
            },
            null,
            { enableHighAccuracy: true, maximumAge: 1000 }
        );
    } else {
        updateUserPosition(DEFAULT_CENTER[0], DEFAULT_CENTER[1]);
    }
}

function updateUserPosition(lat, lng) {
    currentPosition = { lat: lat, lng: lng };

    if (!userMarker) {
        const icon = L.divIcon({
            className: 'user-marker',
            html: `<div style="width: 20px; height: 20px; background: #2563eb; border: 3px solid white; border-radius: 50%; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2), 0 2px 8px rgba(0,0,0,0.3);"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        userMarker = L.marker([lat, lng], { icon: icon }).addTo(map);
    } else {
        userMarker.setLatLng([lat, lng]);
    }
}

function initSearch() {
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search');
    const resultsDiv = document.getElementById('search-results');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query) {
            clearBtn.classList.remove('hidden');
            searchPOIs(query);
        } else {
            clearBtn.classList.add('hidden');
            resultsDiv.classList.add('hidden');
        }
    });

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        resultsDiv.classList.add('hidden');
    });
}

function searchPOIs(query) {
    fetch(`api/search.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            displaySearchResults(data.results);
        });
}

function displaySearchResults(results) {
    const resultsDiv = document.getElementById('search-results');
    
    if (results.length === 0) {
        resultsDiv.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">Aucun résultat trouvé</div>';
        resultsDiv.classList.remove('hidden');
        return;
    }

    let html = '';
    results.forEach(poi => {
        const distance = currentPosition ? 
            calculateDistance(currentPosition.lat, currentPosition.lng, poi.lat, poi.lng) : null;
        
        html += `
            <div class="search-result-item" onclick="showPOIDetails(${JSON.stringify(poi).replace(/"/g, '&quot;')})">
                <div class="result-name">${poi.name}</div>
                <div class="result-category">${poi.category}</div>
                <div class="result-description">${poi.description}</div>
                ${distance ? `<div class="result-distance">${distance.toFixed(2)} km</div>` : ''}
            </div>
        `;
    });

    resultsDiv.innerHTML = html;
    resultsDiv.classList.remove('hidden');
}

function showPOIDetails(poi) {
    selectedPOI = poi;
    
    document.getElementById('poi-name').textContent = poi.name;
    document.getElementById('poi-category').textContent = poi.category;
    document.getElementById('poi-description').textContent = poi.description;
    
    if (currentPosition) {
        const distance = calculateDistance(currentPosition.lat, currentPosition.lng, poi.lat, poi.lng);
        const time = calculateWalkingTime(distance);
        document.getElementById('poi-distance').textContent = `${distance.toFixed(2)} km`;
        document.getElementById('poi-duration').textContent = time;
    }
    
    document.getElementById('poi-details').classList.remove('hidden');
    document.getElementById('search-results').classList.add('hidden');
    
    // Centrer la carte sur le POI
    map.setView([poi.lat, poi.lng], 17);
}

function initButtons() {
    document.getElementById('close-poi').addEventListener('click', function() {
        document.getElementById('poi-details').classList.add('hidden');
    });

    document.getElementById('start-navigation').addEventListener('click', function() {
        if (selectedPOI && currentPosition) {
            startNavigation(selectedPOI);
        }
    });

    document.getElementById('locate-btn').addEventListener('click', function() {
        if (currentPosition) {
            map.setView([currentPosition.lat, currentPosition.lng], 17);
        }
    });

    document.getElementById('stop-nav-btn').addEventListener('click', function() {
        stopNavigation();
    });
}

function startNavigation(poi) {
    isNavigating = true;
    selectedPOI = poi;
    
    document.getElementById('poi-details').classList.add('hidden');
    document.getElementById('navigation-panel').classList.remove('hidden');
    document.getElementById('stop-nav-btn').classList.remove('hidden');
    
    if (destinationMarker) {
        map.removeLayer(destinationMarker);
    }
    
    const icon = L.divIcon({
        className: 'destination-marker',
        html: `<div style="background: #ef4444; width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 4px solid white; box-shadow: 0 2px 12px rgba(0,0,0,0.4);"></div>`,
        iconSize: [40, 40],
        iconAnchor: [20, 40]
    });
    
    destinationMarker = L.marker([poi.lat, poi.lng], { icon: icon }).addTo(map);
    
    updateNavigation();
    
    // Ajuster la vue pour voir le trajet complet
    const bounds = L.latLngBounds([currentPosition.lat, currentPosition.lng], [poi.lat, poi.lng]);
    map.fitBounds(bounds, { padding: [100, 100] });
}

function updateNavigation() {
    if (!isNavigating || !selectedPOI || !currentPosition) return;

    const distance = calculateDistance(currentPosition.lat, currentPosition.lng, selectedPOI.lat, selectedPOI.lng);
    const time = calculateWalkingTime(distance);
    const bearing = calculateBearing(currentPosition.lat, currentPosition.lng, selectedPOI.lat, selectedPOI.lng);
    const direction = getDirectionText(bearing);

    document.getElementById('nav-distance').textContent = `${distance.toFixed(2)} km`;
    document.getElementById('nav-time').textContent = time;
    document.getElementById('nav-poi-name').textContent = selectedPOI.name;
    document.getElementById('nav-direction-text').textContent = `Direction: ${direction}`;
    document.getElementById('direction-arrow').style.transform = `rotate(${bearing}deg)`;

    // Points intermédiaires pour suivre le chemin interne du parc
    const pathPoints = [
        [currentPosition.lat, currentPosition.lng],
        // ajoute ici les points intermédiaires du parc
        [46.8907, -0.9343],  // point intermédiaire 1
        [46.8912, -0.9338],  // point intermédiaire 2
        [46.8918, -0.9330],  // point intermédiaire 3
        [selectedPOI.lat, selectedPOI.lng]
    ];

    // Supprimer la polyline précédente
    if (routeLine) {
        map.removeLayer(routeLine);
    }

    // Dessiner la nouvelle polyline
    routeLine = L.polyline(pathPoints, {
        color: '#2563eb',
        weight: 4,
        opacity: 0.8
    }).addTo(map);

    // Vérifier si on est arrivé (moins de 20 mètres)
    if (distance < 0.02) {
        alert('Vous êtes arrivé à destination !');
        stopNavigation();
    }
}




function stopNavigation() {
    isNavigating = false;
    selectedPOI = null;
    
    document.getElementById('navigation-panel').classList.add('hidden');
    document.getElementById('stop-nav-btn').classList.add('hidden');
    
    if (destinationMarker) {
        map.removeLayer(destinationMarker);
        destinationMarker = null;
    }
    
    if (routeLine) {
        map.removeLayer(routeLine);
        routeLine = null;
    }
}

function initCategoryFilters() {
    const categoryBtns = document.querySelectorAll('.category-btn');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            filterPOIsByCategory(category);
        });
    });
}

function filterPOIsByCategory(category) {
    poiMarkers.forEach(item => {
        if (category === 'all' || item.poi.category === category) {
            item.marker.addTo(map);
        } else {
            map.removeLayer(item.marker);
        }
    });
}

// Fonctions utilitaires
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function calculateWalkingTime(distanceKm) {
    const minutes = Math.round((distanceKm / 5) * 60);
    if (minutes < 1) return "< 1 min";
    if (minutes >= 60) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours}h ${mins} min`;
    }
    return `${minutes} min`;
}

function calculateBearing(lat1, lon1, lat2, lon2) {
    const dLon = (lon2 - lon1) * Math.PI / 180;
    lat1 = lat1 * Math.PI / 180;
    lat2 = lat2 * Math.PI / 180;
    
    const y = Math.sin(dLon) * Math.cos(lat2);
    const x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(dLon);
    const bearing = Math.atan2(y, x) * 180 / Math.PI;
    
    return (bearing + 360) % 360;
}

function getDirectionText(bearing) {
    const directions = ['Nord', 'Nord-Est', 'Est', 'Sud-Est', 'Sud', 'Sud-Ouest', 'Ouest', 'Nord-Ouest'];
    const index = Math.round(bearing / 45) % 8;
    return directions[index];
}
