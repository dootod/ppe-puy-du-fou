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
            <h1>Gestion des Utilisateurs - Puy du Fou</h1>
            <nav>
                <a href="index.php?action=admin_dashboard" class="admin-btn">Retour à l'accueil</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    switch ($_GET['success']) {
                        case '1': echo "Utilisateur ajouté avec succès!"; break;
                        case '2': echo "Utilisateur modifié avec succès!"; break;
                        case '3': echo "Utilisateur supprimé avec succès!"; break;
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php
                    switch ($_GET['error']) {
                        case '1': echo "Erreur lors de l'ajout de l'utilisateur."; break;
                        case '2': echo "Utilisateur non trouvé."; break;
                        case '3': echo "ID utilisateur manquant."; break;
                        case '4': echo "Erreur lors de la suppression."; break;
                        case '5': echo "ID manquant pour la suppression."; break;
                        default: echo "Une erreur est survenue. Veuillez réessayer."; break;
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="table-header">
                <h2>Liste des Utilisateurs</h2>
                <a href="index.php?action=admin_users_create" class="admin-btn">Ajouter un utilisateur</a>
            </div>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Type de profil</th>
                            <th>Vitesse marche</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['users'])): ?>
                            <tr>
                                <td colspan="7" class="text-center">Aucun utilisateur trouvé</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id_utilisateur']); ?></td>
                                <td><?php echo htmlspecialchars($user['nom']); ?></td>
                                <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-weight: bold; 
                                          background-color: <?php echo $user['type_profil'] === 'admin' ? '#800020' : '#2E8B57'; ?>; 
                                          color: white;">
                                        <?php echo ucfirst($user['type_profil']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($user['vitesse_marche']); ?> km/h</td>
                                <td class="actions">
                                    <a href="index.php?action=admin_users_edit&id=<?php echo $user['id_utilisateur']; ?>" class="btn-edit">Modifier</a>
                                    <a href="index.php?action=admin_users_delete&id=<?php echo $user['id_utilisateur']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">Supprimer</a>
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