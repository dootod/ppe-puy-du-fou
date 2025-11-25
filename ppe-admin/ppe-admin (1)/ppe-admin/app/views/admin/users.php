<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>👥 Gestion des Utilisateurs - Puy du Fou</h1>
            <nav>
                <a href="index.php?page=admin" class="admin-btn">🏠 Retour au Dashboard</a>
            </nav>
        </header>
        
        <main class="admin-main">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    ✅ <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    ❌ <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="admin-actions">
                <a href="index.php?page=admin/users&action=add" class="admin-btn">➕ Ajouter un Utilisateur</a>
                <div class="stats-bar">
                    <span class="stat">Total: <?php echo count($data['users']); ?> utilisateurs</span>
                    <span class="stat">Actifs: <?php echo count(array_filter($data['users'], fn($u) => $u['status'] === 'active')); ?></span>
                    <span class="stat">Admins: <?php echo count(array_filter($data['users'], fn($u) => $u['role'] === 'admin')); ?></span>
                </div>
            </div>
            
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
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
                                <tr class="user-row <?php echo $user['status'] === 'inactive' ? 'user-inactive' : ''; ?>">
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span class="role-badge role-<?php echo htmlspecialchars($user['role']); ?>">
                                            <?php 
                                            $roleLabels = [
                                                'user' => 'Utilisateur',
                                                'admin' => 'Administrateur',
                                                'moderator' => 'Modérateur'
                                            ];
                                            echo $roleLabels[$user['role']] ?? htmlspecialchars($user['role']);
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars($user['status']); ?>">
                                            <?php 
                                            $statusLabels = [
                                                'active' => 'Actif',
                                                'inactive' => 'Inactif'
                                            ];
                                            echo $statusLabels[$user['status']] ?? htmlspecialchars($user['status']);
                                            ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                    <td class="actions">
                                        <a href="index.php?page=admin/users&action=edit&id=<?php echo $user['id']; ?>" class="btn-edit" title="Modifier">✏️</a>
                                        <a href="index.php?page=admin/users&action=toggle-status&id=<?php echo $user['id']; ?>" 
                                           class="btn-status" 
                                           title="<?php echo $user['status'] === 'active' ? 'Désactiver' : 'Activer'; ?>">
                                            <?php echo $user['status'] === 'active' ? '⏸️' : '▶️'; ?>
                                        </a>
                                        <a href="index.php?page=admin/users&action=delete&id=<?php echo $user['id']; ?>" 
                                           class="btn-delete" 
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">🗑️</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        
        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Puy du Fou - Administration</p>
        </footer>
    </div>
</body>
</html>