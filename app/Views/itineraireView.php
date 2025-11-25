<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itinéraire - Puy du Fou</title>
    <link rel="stylesheet" href="../public/css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        .leaflet-container {
            background: #aad3df;
        }
        .itineraire-container {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        .etapes-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        .etape-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 8px;
            border-left: 4px solid #8B4513;
        }
        .etape-info {
            flex: 1;
        }
        .etape-nom {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }
        .etape-type {
            font-size: 12px;
            color: #6c757d;
        }
        .etape-actions {
            display: flex;
            gap: 8px;
        }
        .btn-supprimer {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-supprimer:hover {
            background: #c82333;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }
        .actions-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-primary {
            flex: 1;
            background: linear-gradient(135deg, #8B4513, #A0522D);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #A0522D, #CD853F);
        }
        .btn-secondary {
            flex: 1;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-secondary:hover {
            background: #5a6268;
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
        .marker-start { border-color: #28a745; color: #28a745; }
        .marker-end { border-color: #dc3545; color: #dc3545; }
        .marker-waypoint { border-color: #007bff; color: #007bff; }
        .marker-user { border-color: #ff6b00; color: #ff6b00; }
        
        .location-permission {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
        .btn-location {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 12px;
        }
        .location-status {
            font-size: 12px;
            border-radius: 4px;
        }
        .location-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .location-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>MON ITINÉRAIRE</h1>
                <div class="header-actions">
                    <a href="index.php?action=profil" style="color: white; text-decoration: none;">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

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
                ?>

                <!-- Demande de localisation compacte -->
                <div class="location-permission" id="locationPermission" style="display: none;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-map-marker-alt" style="color: #007bff; font-size: 16px;"></i>
                        <div style="flex: 1;">
                            <p style="margin: 0; color: #495057; font-size: 12px; line-height: 1.3;">
                                Activez votre localisation pour voir votre position
                            </p>
                        </div>
                        <button class="btn-location" onclick="requestLocationPermission()">
                            <i class="fas fa-location-arrow"></i>
                            Activer
                        </button>
                    </div>
                    <div id="locationStatus" class="location-status"></div>
                </div>

                <!-- Carte de l'itinéraire -->
                <div id="map"></div>

                <!-- Liste des étapes -->
                <div class="itineraire-container">
                    <h3 style="margin-bottom: 15px; color: #2c3e50;">
                        <i class="fas fa-route"></i> Votre itinéraire
                    </h3>
                    
                    <div class="etapes-list">
                        <?php if (empty($_SESSION['itineraire']) || !is_array($_SESSION['itineraire'])): ?>
                            <div class="empty-state">
                                <i class="fas fa-route"></i>
                                <h4>Votre itinéraire est vide</h4>
                                <p>Ajoutez des spectacles, restaurants ou toilettes à votre itinéraire</p>
                                <a href="index.php?action=liste&filtre=spectacles" class="btn-primary" style="margin-top: 15px;">
                                    <i class="fas fa-plus"></i>
                                    Découvrir les points d'intérêt
                                </a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($_SESSION['itineraire'] as $index => $etape): ?>
                                <div class="etape-item">
                                    <div class="etape-info">
                                        <div class="etape-nom"><?php echo htmlspecialchars($etape['titre']); ?></div>
                                        <div class="etape-type">
                                            <?php 
                                            if ($etape['categorie'] == 'spectacles') echo 'Spectacle';
                                            elseif ($etape['categorie'] == 'restaurants') echo 'Restaurant';
                                            else echo 'Toilettes';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="etape-actions">
                                        <a href="index.php?action=supprimerEtape&index=<?php echo $index; ?>" class="btn-supprimer">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($_SESSION['itineraire']) && is_array($_SESSION['itineraire'])): ?>
                        <div class="actions-buttons">
                            <a href="index.php?action=navigation" class="btn-primary">
                                <i class="fas fa-play"></i>
                                Démarrer la navigation
                            </a>
                            <a href="index.php?action=viderItineraire" class="btn-secondary">
                                <i class="fas fa-trash"></i>
                                Vider l'itinéraire
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/navbarView.php'; ?>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map;
        let routeLine;
        let markers = [];
        let userLocation = null;
        let userMarker = null;
        let watchId = null;

        function initMap() {
            map = L.map('map').setView([46.8900, -0.9290], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            if (!navigator.geolocation) {
                return;
            }

            showLocationPermission();
            <?php if (!empty($_SESSION['itineraire']) && is_array($_SESSION['itineraire'])): ?>
                displayItineraire();
            <?php endif; ?>
        }

        function showLocationPermission() {
            const permissionDiv = document.getElementById('locationPermission');
            permissionDiv.style.display = 'block';
        }

        function hideLocationPermission() {
            const permissionDiv = document.getElementById('locationPermission');
            permissionDiv.style.display = 'none';
        }

        function showLocationSuccess(message) {
            const statusDiv = document.getElementById('locationStatus');
            statusDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            statusDiv.className = 'location-status location-success';
        }

        function showLocationError(message) {
            const statusDiv = document.getElementById('locationStatus');
            statusDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
            statusDiv.className = 'location-status location-error';
        }

        function requestLocationPermission() {
            if (!navigator.geolocation) return;

            showLocationSuccess("Localisation en cours...");

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    showLocationSuccess("Localisation activée !");
                    setTimeout(() => hideLocationPermission(), 2000);
                    addUserLocationToMap();
                    startTrackingLocation();
                    
                    if (<?php echo !empty($_SESSION['itineraire']) ? 'false' : 'true'; ?>) {
                        map.setView([userLocation.lat, userLocation.lng], 16);
                    }
                },
                function(error) {
                    let errorMessage = "Impossible d'obtenir votre position";
                    showLocationError(errorMessage);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        }

        function addUserLocationToMap() {
            if (!userLocation) return;

            if (userMarker) {
                map.removeLayer(userMarker);
            }

            const userIcon = L.divIcon({
                className: 'custom-marker marker-user',
                html: '<i class="fas fa-user"></i>',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            userMarker = L.marker([userLocation.lat, userLocation.lng], { icon: userIcon })
                .addTo(map)
                .bindPopup(`<div style="min-width: 150px;"><h4 style="margin: 0 0 8px 0;">Votre position</h4></div>`);
        }

        function startTrackingLocation() {
            if (!navigator.geolocation) return;

            watchId = navigator.geolocation.watchPosition(
                function(position) {
                    userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    if (userMarker) {
                        userMarker.setLatLng([userLocation.lat, userLocation.lng]);
                    }
                },
                function(error) {
                    console.log("Erreur de suivi de localisation:", error);
                },
                {
                    enableHighAccuracy: true,
                    maximumAge: 30000,
                    timeout: 27000
                }
            );
        }

        function stopTrackingLocation() {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }
        }

        function displayItineraire() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            if (routeLine) {
                map.removeLayer(routeLine);
            }

            const etapes = <?php echo json_encode($_SESSION['itineraire'] ?? []); ?>;
            const points = [];

            if (userLocation) {
                points.push([userLocation.lat, userLocation.lng]);
            }

            etapes.forEach((etape, index) => {
                let iconClass, icon, label;
                if (index === 0 && !userLocation) {
                    iconClass = 'marker-start';
                    icon = '<i class="fas fa-play"></i>';
                    label = 'Départ';
                } else if (index === etapes.length - 1) {
                    iconClass = 'marker-end';
                    icon = '<i class="fas fa-flag-checkered"></i>';
                    label = 'Arrivée';
                } else {
                    iconClass = 'marker-waypoint';
                    icon = '<i class="fas fa-map-marker-alt"></i>';
                    label = 'Étape ' + (index + 1);
                }

                const customIcon = L.divIcon({
                    className: 'custom-marker ' + iconClass,
                    html: icon,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                const marker = L.marker([etape.lat, etape.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`<div style="min-width: 200px;"><h4 style="margin: 0 0 8px 0;">${etape.titre}</h4></div>`);

                markers.push(marker);
                points.push([etape.lat, etape.lng]);
            });

            if (points.length > 1) {
                routeLine = L.polyline(points, {
                    color: '#8B4513',
                    weight: 4,
                    opacity: 0.7,
                    dashArray: '10, 10'
                }).addTo(map);

                const bounds = L.latLngBounds(points);
                map.fitBounds(bounds, { padding: [20, 20] });
            }
        }

        window.addEventListener('beforeunload', stopTrackingLocation);
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>
</html>