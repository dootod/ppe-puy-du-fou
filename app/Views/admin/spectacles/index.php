<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/puy-du-fou/public/css/style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Gestion des Spectacles - Puy du Fou</h1>
            <nav>
                <a href="index.php?action=admin_dashboard" class="admin-btn">Retour à l'accueil</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    switch ($_GET['success']) {
                        case '1': echo "Spectacle ajouté avec succès!"; break;
                        case '2': echo "Spectacle modifié avec succès!"; break;
                        case '3': echo "Spectacle supprimé avec succès!"; break;
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php
                    switch ($_GET['error']) {
                        case '1': echo "Erreur lors de l'ajout du spectacle."; break;
                        case '2': echo "Spectacle non trouvé."; break;
                        case '3': echo "ID spectacle manquant."; break;
                        case '4': echo "Erreur lors de la suppression."; break;
                        case '5': echo "ID manquant pour la suppression."; break;
                        default: echo "Une erreur est survenue. Veuillez réessayer."; break;
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="table-header">
                <h2>Liste des Spectacles</h2>
                <a href="index.php?action=admin_spectacles_create" class="admin-btn">Ajouter un spectacle</a>
            </div>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Libellé</th>
                            <th>Durée Spectacle</th>
                            <th>Durée Attente</th>
                            <th>Coordonnées GPS</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['spectacles'])): ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucun spectacle trouvé</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['spectacles'] as $spectacle): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($spectacle['id_spectacle']); ?></td>
                                <td><?php echo htmlspecialchars($spectacle['libelle']); ?></td>
                                <td><?php echo htmlspecialchars($spectacle['duree_spectacle']); ?></td>
                                <td><?php echo htmlspecialchars($spectacle['duree_attente']); ?></td>
                                <td><?php echo htmlspecialchars($spectacle['coordonnees_gps']); ?></td>
                                <td class="actions">
                                    <a href="index.php?action=admin_spectacles_edit&id=<?php echo $spectacle['id_spectacle']; ?>" class="btn-edit">Modifier</a>
                                    <a href="index.php?action=admin_spectacles_delete&id=<?php echo $spectacle['id_spectacle']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce spectacle ? Cette action est irréversible.')">Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>