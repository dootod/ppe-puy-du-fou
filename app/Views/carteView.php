<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte - Puy du Fou</title>
    <link rel="stylesheet" href="css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* [Tous les styles CSS restent identiques] */
        #map {
            height: 400px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .leaflet-container {
            background: #aad3df;
        }
        .map-filter-container {
            background: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-map-btn {
            flex: 1;
            min-width: 80px;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: white;
            color: #6c757d;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 12px;
        }
        .filter-map-btn.active {
            border-color: #8B4513;
            background: #8B4513;
            color: white;
        }
        .filter-map-btn:hover {
            border-color: #A0522D;
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
        .marker-spectacle { border-color: #dc3545; color: #dc3545; }
        .marker-restaurant { border-color: #28a745; color: #28a745; }
        .marker-toilettes { border-color: #007bff; color: #007bff; }
        
        /* Styles pour la légende sur une seule ligne */
        .carte-legende {
            background: white;
            padding: 15px;
            border-radius: 12px;
            margin-top: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .carte-legende h3 {
            margin-bottom: 12px;
            color: #2c3e50;
            font-size: 16px;
            text-align: center;
        }
        .legende-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            gap: 10px;
        }
        .legende-item {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
        }
        .legende-item span {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>PUY DU FOU</h1>
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

                <!-- Filtres de la carte -->
                <div class="map-filter-container">
                    <div class="filter-buttons">
                        <button class="filter-map-btn active" data-filter="all">
                            <i class="fas fa-layer-group"></i>
                            Tout
                        </button>
                        <button class="filter-map-btn" data-filter="spectacles">
                            <i class="fas fa-theater-masks"></i>
                            Spectacles
                        </button>
                        <button class="filter-map-btn" data-filter="restaurants">
                            <i class="fas fa-utensils"></i>
                            Restaurants
                        </button>
                        <button class="filter-map-btn" data-filter="chiottes">
                            <i class="fas fa-restroom"></i>
                            Toilettes
                        </button>
                    </div>
                </div>

                <!-- Carte Leaflet -->
                <div id="map"></div>

                <!-- Légende sur une seule ligne -->
                <div class="carte-legende">
                    <h3>Légende</h3>
                    <div class="legende-items">
                        <div class="legende-item">
                            <div class="custom-marker marker-spectacle">
                                <i class="fas fa-theater-masks"></i>
                            </div>
                            <span>Spectacles</span>
                        </div>
                        <div class="legende-item">
                            <div class="custom-marker marker-restaurant">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <span>Restaurants</span>
                        </div>
                        <div class="legende-item">
                            <div class="custom-marker marker-toilettes">
                                <i class="fas fa-restroom"></i>
                            </div>
                            <span>Toilettes</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/navbarView.php'; ?>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // [Tout le code JavaScript reste identique]
        const pointsInteret = [
            <?php
            require_once __DIR__ . '/../models/listeModel.php';
            $model = new ListeModel();
            $points = $model->getAllPoints();
            foreach ($points as $point) {
                echo "{
                    id: {$point['id']},
                    titre: '" . addslashes($point['titre']) . "',
                    description: '" . addslashes($point['description']) . "',
                    categorie: '{$point['categorie']}',
                    emplacement: '" . addslashes($point['emplacement']) . "',
                    lat: {$point['lat']},
                    lng: {$point['lng']},
                    horaires: " . (isset($point['horaires']) ? (is_array($point['horaires']) ? json_encode($point['horaires']) : "'{$point['horaires']}'") : "null") . ",
                    details: '" . addslashes($point['details']) . "'
                },";
            }
            ?>
        ];

        let map;
        let markers = [];
        let currentFilter = 'all';

        function initMap() {
            map = L.map('map').setView([46.8900, -0.9290], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            addMarkersToMap();
        }

        function addMarkersToMap() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            pointsInteret.forEach(point => {
                if (currentFilter !== 'all' && point.categorie !== currentFilter) {
                    return;
                }

                let iconClass, icon;
                switch(point.categorie) {
                    case 'spectacles':
                        iconClass = 'marker-spectacle';
                        icon = '<i class="fas fa-theater-masks"></i>';
                        break;
                    case 'restaurants':
                        iconClass = 'marker-restaurant';
                        icon = '<i class="fas fa-utensils"></i>';
                        break;
                    case 'chiottes':
                        iconClass = 'marker-toilettes';
                        icon = '<i class="fas fa-restroom"></i>';
                        break;
                }

                const customIcon = L.divIcon({
                    className: 'custom-marker ' + iconClass,
                    html: icon,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                const marker = L.marker([point.lat, point.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width: 200px;">
                            <h3 style="margin: 0 0 8px 0; color: #2c3e50;">${point.titre}</h3>
                            <p style="margin: 0 0 8px 0; color: #6c757d; font-size: 14px;">${point.description}</p>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-map-marker-alt" style="color: #8B4513;"></i>
                                <span style="font-size: 12px;">${point.emplacement}</span>
                            </div>
                            ${point.horaires ? `
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <i class="fas fa-clock" style="color: #8B4513;"></i>
                                    <span style="font-size: 12px;">${Array.isArray(point.horaires) ? point.horaires.join(' • ') : point.horaires}</span>
                                </div>
                            ` : ''}
                            <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                <button onclick="viewDetails(${point.id})" style="
                                    flex: 1;
                                    padding: 8px; 
                                    background: #8B4513; 
                                    color: white; 
                                    border: none; 
                                    border-radius: 6px; 
                                    cursor: pointer;
                                    font-size: 12px;
                                ">
                                    Voir détails
                                </button>
                                <button onclick="addToItineraire(${point.id})" style="
                                    flex: 1;
                                    padding: 8px; 
                                    background: #28a745; 
                                    color: white; 
                                    border: none; 
                                    border-radius: 6px; 
                                    cursor: pointer;
                                    font-size: 12px;
                                ">
                                    <i class="fas fa-route"></i>
                                </button>
                            </div>
                        </div>
                    `);

                markers.push(marker);
            });
        }

        function viewDetails(pointId) {
            const point = pointsInteret.find(p => p.id === pointId);
            if (point.categorie === 'spectacles') {
                window.location.href = `index.php?action=liste#spectacle-${pointId}`;
            } else {
                alert(`Détails de: ${point.titre}\n\n${point.details}`);
            }
        }

        function addToItineraire(pointId) {
            window.location.href = `index.php?action=ajouterEtape&id=${pointId}`;
        }

        function filterMarkers(filter) {
            currentFilter = filter;
            addMarkersToMap();
            
            document.querySelectorAll('.filter-map-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', initMap);

        document.querySelectorAll('.filter-map-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                filterMarkers(this.dataset.filter);
            });
        });
    </script>
</body>
</html>