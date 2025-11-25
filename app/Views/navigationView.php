<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation - Puy du Fou</title>
    <link rel="stylesheet" href="../public/css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
        }
        .leaflet-container {
            background: #aad3df;
        }
        .navigation-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            padding: 20px;
            max-height: 40vh;
            overflow-y: auto;
        }
        .navigation-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        .direction-arrow {
            width: 40px;
            height: 40px;
            background: #8B4513;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        .nav-stats {
            flex: 1;
        }
        .nav-distance {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }
        .nav-time {
            font-size: 16px;
            color: #6c757d;
        }
        .nav-destination h3 {
            margin: 0 0 8px 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .direction-text {
            color: #6c757d;
            margin: 0 0 15px 0;
            font-size: 14px;
        }
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin-bottom: 10px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #8B4513, #A0522D);
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        .progress-text {
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            margin: 0;
        }
        .locate-btn {
            position: fixed;
            bottom: 45vh;
            right: 20px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .stop-nav-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            font-weight: 600;
            cursor: pointer;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .custom-marker {
            background: white;
            border: 3px solid;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .marker-user { border-color: #2563eb; color: #2563eb; }
        .marker-destination { border-color: #dc3545; color: #dc3545; }
        .user-marker {
            background: #2563eb;
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2), 0 2px 8px rgba(0,0,0,0.3);
        }
        .location-permission {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 2000;
            text-align: center;
            max-width: 300px;
            width: 90%;
        }
        .location-permission h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
        }
        .location-permission p {
            margin: 0 0 20px 0;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.4;
        }
        .btn-location {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
        }
        .btn-location:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Demande de permission de localisation -->
        <div id="location-permission" class="location-permission">
            <i class="fas fa-map-marker-alt" style="color: #007bff; font-size: 48px; margin-bottom: 15px;"></i>
            <h3>Localisation requise</h3>
            <p>Pour la navigation en temps réel, nous avons besoin d'accéder à votre position.</p>
            <button class="btn-location" onclick="requestLocationPermission()">
                <i class="fas fa-location-arrow"></i>
                Activer la localisation
            </button>
        </div>

        <!-- Carte -->
        <div id="map"></div>

        <!-- Panneau de navigation -->
        <div id="navigation-panel" class="navigation-panel" style="display: none;">
            <div class="navigation-header">
                <div class="direction-arrow">
                    <i class="fas fa-location-arrow" id="direction-arrow"></i>
                </div>
                <div class="nav-stats">
                    <div class="nav-distance" id="nav-distance">-- km</div>
                    <div class="nav-time" id="nav-time">-- min</div>
                </div>
            </div>
            
            <div class="nav-destination">
                <h3 id="nav-poi-name">Destination</h3>
                <p id="nav-direction-text" class="direction-text">Calcul de la direction...</p>
            </div>
            
            <div class="nav-progress">
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill" style="width: 0%"></div>
                </div>
                <p class="progress-text">Navigation en cours...</p>
            </div>
        </div>

        <!-- Bouton position -->
        <button id="locate-btn" class="locate-btn" title="Ma position" style="display: none;">
            <i class="fas fa-location-crosshairs"></i>
        </button>

        <!-- Bouton arrêter navigation -->
        <button id="stop-nav-btn" class="stop-nav-btn" style="display: none;">
            <i class="fas fa-stop"></i>
            Arrêter
        </button>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map;
        let userMarker;
        let destinationMarker;
        let routeLine;
        let currentPosition = null;
        let isNavigating = false;
        let watchId = null;
        let currentItineraire = <?php echo json_encode($_SESSION['itineraire'] ?? []); ?>;
        let currentEtapeIndex = 0;

        function initMap() {
            map = L.map('map').setView([46.8900, -0.9290], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Vérifier si la géolocalisation est disponible
            if (!navigator.geolocation) {
                alert("La géolocalisation n'est pas supportée par votre navigateur. La navigation ne fonctionnera pas correctement.");
                startNavigationWithoutLocation();
                return;
            }

            // Afficher la demande de permission
            document.getElementById('location-permission').style.display = 'block';
        }

        function requestLocationPermission() {
            if (!navigator.geolocation) {
                alert("La géolocalisation n'est pas supportée par votre navigateur.");
                startNavigationWithoutLocation();
                return;
            }

            // Masquer la demande de permission
            document.getElementById('location-permission').style.display = 'none';

            // Démarrer le suivi de localisation
            startLocationTracking();
            startNavigation();
        }

        function startLocationTracking() {
            // Position initiale
            navigator.geolocation.getCurrentPosition(
                position => {
                    updateUserPosition(position.coords.latitude, position.coords.longitude);
                    showNavigationUI();
                },
                error => {
                    console.error('Erreur géolocalisation:', error);
                    handleLocationError(error);
                },
                { 
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 30000
                }
            );

            // Suivi en temps réel
            watchId = navigator.geolocation.watchPosition(
                position => {
                    updateUserPosition(position.coords.latitude, position.coords.longitude);
                    if (isNavigating) {
                        updateNavigation();
                    }
                },
                error => {
                    console.error('Erreur suivi géolocalisation:', error);
                },
                { 
                    enableHighAccuracy: true, 
                    maximumAge: 1000,
                    timeout: 5000 
                }
            );
        }

        function handleLocationError(error) {
            let errorMessage = "Impossible d'obtenir votre position : ";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "Vous avez refusé l'accès à votre localisation. La navigation ne fonctionnera pas correctement.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Position indisponible. Vérifiez votre connexion et vos paramètres de localisation.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "Délai de localisation dépassé. Réessayez.";
                    break;
                default:
                    errorMessage = "Erreur inconnue de localisation.";
            }
            
            alert(errorMessage);
            startNavigationWithoutLocation();
        }

        function startNavigationWithoutLocation() {
            // Utiliser une position par défaut au centre du parc
            updateUserPosition(46.8900, -0.9290);
            showNavigationUI();
            startNavigation();
        }

        function showNavigationUI() {
            document.getElementById('navigation-panel').style.display = 'block';
            document.getElementById('locate-btn').style.display = 'flex';
            document.getElementById('stop-nav-btn').style.display = 'flex';
        }

        function updateUserPosition(lat, lng) {
            currentPosition = { lat: lat, lng: lng };

            if (!userMarker) {
                const icon = L.divIcon({
                    className: 'user-marker',
                    html: `<div style="width: 20px; height: 20px; background: #2563eb; border: 3px solid white; border-radius: 50%;"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });

                userMarker = L.marker([lat, lng], { 
                    icon: icon,
                    zIndexOffset: 1000 
                }).addTo(map);
            } else {
                userMarker.setLatLng([lat, lng]);
            }
        }

        function startNavigation() {
            if (currentItineraire.length === 0) {
                alert('Aucun itinéraire défini');
                window.history.back();
                return;
            }

            isNavigating = true;
            currentEtapeIndex = 0;
            
            // Afficher le premier point de destination
            showDestinationMarker(currentItineraire[0]);
            updateNavigation();
            
            // Ajuster la vue pour voir le trajet
            if (currentPosition) {
                const bounds = L.latLngBounds([
                    [currentPosition.lat, currentPosition.lng],
                    [currentItineraire[0].lat, currentItineraire[0].lng]
                ]);
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        }

        function showDestinationMarker(etape) {
            if (destinationMarker) {
                map.removeLayer(destinationMarker);
            }

            const customIcon = L.divIcon({
                className: 'custom-marker marker-destination',
                html: '<i class="fas fa-flag-checkered"></i>',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            destinationMarker = L.marker([etape.lat, etape.lng], { 
                icon: customIcon,
                zIndexOffset: 900 
            }).addTo(map).bindPopup(`
                <div style="min-width: 200px;">
                    <h4 style="margin: 0 0 8px 0;">${etape.titre}</h4>
                    <p style="margin: 0; color: #6c757d;">${etape.description}</p>
                </div>
            `).openPopup();
        }

        function updateNavigation() {
            if (!isNavigating || !currentPosition || currentItineraire.length === 0) return;

            const etape = currentItineraire[currentEtapeIndex];
            const distance = calculateDistance(currentPosition.lat, currentPosition.lng, etape.lat, etape.lng);
            const time = calculateWalkingTime(distance);
            const bearing = calculateBearing(currentPosition.lat, currentPosition.lng, etape.lat, etape.lng);
            const direction = getDirectionText(bearing);

            // Mettre à jour l'interface
            document.getElementById('nav-distance').textContent = distance < 1 ? 
                Math.round(distance * 1000) + ' m' : distance.toFixed(2) + ' km';
            document.getElementById('nav-time').textContent = time;
            document.getElementById('nav-poi-name').textContent = etape.titre;
            document.getElementById('nav-direction-text').textContent = `Direction: ${direction}`;
            document.getElementById('direction-arrow').style.transform = `rotate(${bearing}deg)`;

            // Calculer la progression
            const progress = Math.max(0, Math.min(100, 100 - (distance / 0.1) * 100));
            document.getElementById('progress-fill').style.width = progress + '%';

            // Dessiner la route
            drawRoute(currentPosition, etape);

            // Vérifier si on est arrivé (moins de 20 mètres)
            if (distance < 0.02) {
                handleArrival();
            }
        }

        function drawRoute(start, end) {
            if (routeLine) {
                map.removeLayer(routeLine);
            }

            const pathPoints = calculatePathPoints(start, end);
            
            routeLine = L.polyline(pathPoints, {
                color: '#8B4513',
                weight: 6,
                opacity: 0.8,
                lineJoin: 'round'
            }).addTo(map);
        }

        function calculatePathPoints(start, end) {
            const points = [
                [start.lat, start.lng]
            ];

            const midLat = (start.lat + end.lat) / 2;
            const midLng = (start.lng + end.lng) / 2;
            
            points.push([midLat + 0.0005, midLng - 0.0005]);
            points.push([end.lat, end.lng]);

            return points;
        }

        function handleArrival() {
            const etape = currentItineraire[currentEtapeIndex];
            
            currentEtapeIndex++;
            
            if (currentEtapeIndex < currentItineraire.length) {
                showDestinationMarker(currentItineraire[currentEtapeIndex]);
                alert(`Vous êtes arrivé à ${etape.titre} ! Direction la prochaine étape.`);
            } else {
                alert(`Félicitations ! Vous avez terminé votre itinéraire.`);
                stopNavigation();
            }
        }

        function stopNavigation() {
            isNavigating = false;
            
            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
            }
            
            if (destinationMarker) {
                map.removeLayer(destinationMarker);
            }
            
            if (routeLine) {
                map.removeLayer(routeLine);
            }
            
            window.history.back();
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
            const vitesseMarche = <?php echo $_SESSION['utilisateur']['vitesse_marche'] ?? 4; ?>;
            const minutes = Math.round((distanceKm / vitesseMarche) * 60);
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

        // Événements
        document.getElementById('locate-btn').addEventListener('click', function() {
            if (currentPosition) {
                map.setView([currentPosition.lat, currentPosition.lng], 18);
            }
        });

        document.getElementById('stop-nav-btn').addEventListener('click', stopNavigation);

        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>
</html>