<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itinéraire - Puy du Fou</title>
    <link rel="stylesheet" href="css/liste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>MON ITINÉRAIRE</h1>
                <div class="header-actions">
                    <i class="fas fa-route"></i>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-wrapper">
                <?php
                require_once __DIR__ . '/../controllers/itineraireController.php';
                $itineraire = getItineraire();
                $itineraireCalcule = getItineraireCalcule();

                if (isset($_SESSION['message'])) {
                    echo '<div class="message-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['erreur'])) {
                    echo '<div class="error-message">' . $_SESSION['erreur'] . '</div>';
                    unset($_SESSION['erreur']);
                }
                ?>

                <!-- Panneau de contrôle -->
                <div class="itineraire-controls">
                    <div class="control-stats">
                        <div class="stat-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo count($itineraire); ?> étape(s)</span>
                        </div>
                        <?php if (!empty($itineraireCalcule)): ?>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo calculerDureeTotale($itineraireCalcule); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="control-buttons">
                        <?php if (!empty($itineraire)): ?>
                            <form method="post" action="index.php?action=calculerItineraire" class="heure-depart-form">
                                <label>Heure de départ :</label>
                                <input type="time" name="heure_depart" value="10:00" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calculator"></i>
                                    Calculer
                                </button>
                            </form>
                            <a href="index.php?action=viderItineraire" class="btn btn-secondary" onclick="return confirm('Vider tout l\'itinéraire ?')">
                                <i class="fas fa-trash"></i>
                                Vider
                            </a>
                        <?php else: ?>
                            <p class="empty-message">Votre itinéraire est vide</p>
                            <a href="index.php?action=liste" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Ajouter des étapes
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Itinéraire calculé -->
                <?php if (!empty($itineraireCalcule)): ?>
                    <div class="itineraire-calcule">
                        <h3>📅 Votre journée planifiée</h3>
                        
                        <?php foreach ($itineraireCalcule as $index => $etapeCalcule): 
                            $etape = $etapeCalcule['etape'];
                        ?>
                            <div class="etape-item">
                                <div class="etape-ordre"><?php echo $etapeCalcule['ordre']; ?></div>
                                <div class="etape-content">
                                    <div class="etape-header">
                                        <h4><?php echo htmlspecialchars($etape['titre']); ?></h4>
                                        <span class="etape-categorie <?php echo $etape['categorie']; ?>">
                                            <?php 
                                            if ($etape['categorie'] == 'spectacles') echo '<i class="fas fa-theater-masks"></i> Spectacle';
                                            elseif ($etape['categorie'] == 'restaurants') echo '<i class="fas fa-utensils"></i> Restaurant';
                                            else echo '<i class="fas fa-restroom"></i> Toilettes';
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <div class="etape-horaires">
                                        <?php if ($etapeCalcule['temps_marche'] > 0): ?>
                                            <div class="horaire-item marche">
                                                <i class="fas fa-walking"></i>
                                                <span>Marche : <?php echo formatDuree($etapeCalcule['temps_marche']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="horaire-item arrivee">
                                            <i class="fas fa-flag-checkered"></i>
                                            <span>Arrivée : <?php echo $etapeCalcule['heure_arrivee']; ?></span>
                                        </div>

                                        <?php if ($etape['categorie'] === 'spectacles'): ?>
                                            <div class="horaire-item spectacle">
                                                <i class="fas fa-play-circle"></i>
                                                <span>Spectacle : <?php echo $etapeCalcule['heure_debut']; ?> - <?php echo $etapeCalcule['heure_fin']; ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="horaire-item visite">
                                                <i class="fas fa-clock"></i>
                                                <span>Sur place : <?php echo $etapeCalcule['heure_debut']; ?> - <?php echo $etapeCalcule['heure_fin']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="etape-actions">
                                        <a href="index.php?action=supprimerEtape&index=<?php echo $index; ?>" class="btn-small btn-danger" onclick="return confirm('Supprimer cette étape ?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="itineraire-resume">
                            <h4>📊 Résumé de votre journée</h4>
                            <div class="resume-stats">
                                <div class="resume-item">
                                    <strong>Départ :</strong> 
                                    <span><?php echo $itineraireCalcule[0]['heure_arrivee']; ?></span>
                                </div>
                                <div class="resume-item">
                                    <strong>Fin :</strong> 
                                    <span><?php echo end($itineraireCalcule)['heure_fin']; ?></span>
                                </div>
                                <div class="resume-item">
                                    <strong>Distance totale :</strong> 
                                    <span><?php echo calculerDistanceTotale($itineraireCalcule); ?> km</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Itinéraire brut (sans calcul) -->
                <?php if (!empty($itineraire) && empty($itineraireCalcule)): ?>
                    <div class="itineraire-brut">
                        <h3>🗺️ Votre itinéraire</h3>
                        <?php foreach ($itineraire as $index => $etape): ?>
                            <div class="etape-item">
                                <div class="etape-ordre"><?php echo $index + 1; ?></div>
                                <div class="etape-content">
                                    <div class="etape-header">
                                        <h4><?php echo htmlspecialchars($etape['titre']); ?></h4>
                                        <span class="etape-categorie <?php echo $etape['categorie']; ?>">
                                            <?php 
                                            if ($etape['categorie'] == 'spectacles') echo '<i class="fas fa-theater-masks"></i> Spectacle';
                                            elseif ($etape['categorie'] == 'restaurants') echo '<i class="fas fa-utensils"></i> Restaurant';
                                            else echo '<i class="fas fa-restroom"></i> Toilettes';
                                            ?>
                                        </span>
                                    </div>
                                    <p class="etape-description"><?php echo htmlspecialchars($etape['description']); ?></p>
                                    <div class="etape-actions">
                                        <a href="index.php?action=supprimerEtape&index=<?php echo $index; ?>" class="btn-small btn-danger" onclick="return confirm('Supprimer cette étape ?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <nav class="bottom-navigation">
            <a href="index.php?action=carte" class="nav-item">
                <i class="fas fa-map"></i>
                <span>Carte</span>
            </a>
            <a href="index.php?action=liste&filtre=spectacles" class="nav-item">
                <i class="fas fa-theater-masks"></i>
                <span>Spectacles</span>
            </a>
            <a href="index.php?action=liste&filtre=restaurants" class="nav-item">
                <i class="fas fa-utensils"></i>
                <span>Restaurants</span>
            </a>
            <a href="index.php?action=itineraire" class="nav-item active">
                <i class="fas fa-route"></i>
                <span>Itinéraire</span>
            </a>
            <a href="index.php?action=afficherInscription" class="nav-item">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </nav>
    </div>

    <script>
        function confirmerCalcul() {
            return confirm("Calculer l'itinéraire avec les horaires optimisés ?");
        }
    </script>
</body>
</html>

<?php
// Fonctions helper pour l'affichage
function formatDuree($minutes) {
    if ($minutes < 60) {
        return $minutes . ' min';
    } else {
        $heures = floor($minutes / 60);
        $minutesRestantes = $minutes % 60;
        return $heures . 'h' . ($minutesRestantes > 0 ? $minutesRestantes . 'min' : '');
    }
}

function calculerDureeTotale($itineraire) {
    if (empty($itineraire)) return '0 min';
    
    $debut = strtotime($itineraire[0]['heure_arrivee']);
    $fin = strtotime(end($itineraire)['heure_fin']);
    $dureeMinutes = ($fin - $debut) / 60;
    
    return formatDuree($dureeMinutes);
}

function calculerDistanceTotale($itineraire) {
    $distanceTotale = 0;
    for ($i = 1; $i < count($itineraire); $i++) {
        $etapePrecedente = $itineraire[$i-1]['etape'];
        $etapeActuelle = $itineraire[$i]['etape'];
        
        $distance = calculerDistance(
            $etapePrecedente['lat'], 
            $etapePrecedente['lng'],
            $etapeActuelle['lat'], 
            $etapeActuelle['lng']
        );
        $distanceTotale += $distance;
    }
    return number_format($distanceTotale, 1);
}

// Fonction calculerDistance dupliquée pour l'affichage
function calculerDistance($lat1, $lon1, $lat2, $lon2) {
    $rayonTerre = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat/2) * sin($dLat/2) + 
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
         sin($dLon/2) * sin($dLon/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $rayonTerre * $c;
}
?>