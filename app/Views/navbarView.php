<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="bottom-navigation">
    <a href="index.php?action=carte" class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'carte') ? 'active' : ''; ?>">
        <i class="fas fa-map"></i>
        <span>Carte</span>
    </a>
    <a href="index.php?action=liste&filtre=spectacles" class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'liste' && (!isset($_GET['filtre']) || $_GET['filtre'] == 'spectacles')) ? 'active' : ''; ?>">
        <i class="fas fa-theater-masks"></i>
        <span>Spectacles</span>
    </a>
    <a href="index.php?action=liste&filtre=restaurants" class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'liste' && isset($_GET['filtre']) && $_GET['filtre'] == 'restaurants') ? 'active' : ''; ?>">
        <i class="fas fa-utensils"></i>
        <span>Restaurants</span>
    </a>
    <a href="index.php?action=itineraire" class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'itineraire') ? 'active' : ''; ?>">
        <i class="fas fa-route"></i>
        <span>Itinéraire</span>
    </a>
    <a href="index.php?action=profil" class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'profil') ? 'active' : ''; ?>">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</nav>