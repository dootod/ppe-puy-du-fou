<?php
require_once __DIR__ . '/../models/listeModel.php';

function calculerItineraire() {
    if (!isset($_SESSION['itineraire']) || empty($_SESSION['itineraire'])) {
        $_SESSION['erreur'] = "Votre itinéraire est vide !";
        header('Location: index.php?action=itineraire');
        exit;
    }

    $model = new ListeModel();
    $itineraire = [];
    $heureDepart = isset($_POST['heure_depart']) ? $_POST['heure_depart'] : '10:00';
    
    foreach ($_SESSION['itineraire'] as $etapeId) {
        $etape = $model->getElementById($etapeId);
        if ($etape) {
            $itineraire[] = $etape;
        }
    }

    $itineraireCalcule = optimiserHoraires($itineraire, $heureDepart);
    $_SESSION['itineraire_calcule'] = $itineraireCalcule;

    header('Location: index.php?action=itineraire');
    exit;
}

function optimiserHoraires($etapes, $heureDepart) {
    $vitesseMarche = 5;
    $resultat = [];
    $heureActuelle = $heureDepart;

    foreach ($etapes as $index => $etape) {
        $tempsMarche = 0;
        if ($index > 0) {
            $etapePrecedente = $etapes[$index - 1];
            $distance = calculerDistance(
                $etapePrecedente['lat'], 
                $etapePrecedente['lng'],
                $etape['lat'], 
                $etape['lng']
            );
            $tempsMarche = ($distance / $vitesseMarche) * 60;
        }

        $heureArrivee = ajouterMinutes($heureActuelle, $tempsMarche);

        if ($etape['categorie'] === 'spectacles') {
            $horaireSpectacle = trouverHoraireDisponible($etape['horaires'], $heureArrivee);
            $heureDebut = $horaireSpectacle;
            $heureFin = ajouterMinutes($horaireSpectacle, convertirDureeMinutes($etape['duree']));
        } else {
            $heureDebut = $heureArrivee;
            $heureFin = ajouterMinutes($heureArrivee, 30);
        }

        $resultat[] = [
            'etape' => $etape,
            'ordre' => $index + 1,
            'heure_arrivee' => $heureArrivee,
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
            'temps_marche' => $tempsMarche,
            'statut' => 'planifie'
        ];

        $heureActuelle = $heureFin;
    }

    return $resultat;
}

function calculerDistance($lat1, $lon1, $lat2, $lon2) {
    $rayonTerre = 6371;
    
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat/2) * sin($dLat/2) + 
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
         sin($dLon/2) * sin($dLon/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $rayonTerre * $c;
    
    return $distance;
}

function ajouterMinutes($heure, $minutes) {
    $timestamp = strtotime($heure);
    $nouvelleHeure = date('H:i', $timestamp + ($minutes * 60));
    return $nouvelleHeure;
}

function convertirDureeMinutes($duree) {
    if (strpos($duree, 'h') !== false) {
        preg_match('/(\d+)h\s*(\d*)/', $duree, $matches);
        $heures = isset($matches[1]) ? (int)$matches[1] : 0;
        $minutes = isset($matches[2]) ? (int)$matches[2] : 0;
        return ($heures * 60) + $minutes;
    } else {
        return (int)str_replace('min', '', $duree);
    }
}

function trouverHoraireDisponible($horaires, $heureMinimale) {
    foreach ($horaires as $horaire) {
        if ($horaire >= $heureMinimale) {
            return $horaire;
        }
    }
    return $horaires[0];
}

function ajouterEtape() {
    if (!isset($_SESSION['itineraire'])) {
        $_SESSION['itineraire'] = [];
    }

    if (isset($_GET['id'])) {
        $etapeId = (int)$_GET['id'];
        
        if (!in_array($etapeId, $_SESSION['itineraire'])) {
            $_SESSION['itineraire'][] = $etapeId;
            $_SESSION['message'] = "Étape ajoutée à l'itinéraire !";
        } else {
            $_SESSION['erreur'] = "Cette étape est déjà dans votre itinéraire";
        }
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=liste';
    header("Location: $referer");
    exit;
}

function supprimerEtape() {
    if (isset($_GET['index']) && isset($_SESSION['itineraire'])) {
        $index = (int)$_GET['index'];
        if (isset($_SESSION['itineraire'][$index])) {
            unset($_SESSION['itineraire'][$index]);
            $_SESSION['itineraire'] = array_values($_SESSION['itineraire']);
            $_SESSION['message'] = "Étape supprimée de l'itinéraire !";
        }
    }

    header('Location: index.php?action=itineraire');
    exit;
}

function viderItineraire() {
    $_SESSION['itineraire'] = [];
    $_SESSION['itineraire_calcule'] = [];
    $_SESSION['message'] = "Itinéraire vidé !";
    
    header('Location: index.php?action=itineraire');
    exit;
}

function getItineraire() {
    if (!isset($_SESSION['itineraire']) || empty($_SESSION['itineraire'])) {
        return [];
    }

    $model = new ListeModel();
    $itineraire = [];
    
    foreach ($_SESSION['itineraire'] as $etapeId) {
        $etape = $model->getElementById($etapeId);
        if ($etape) {
            $itineraire[] = $etape;
        }
    }

    return $itineraire;
}

function getItineraireCalcule() {
    return $_SESSION['itineraire_calcule'] ?? [];
}
?>