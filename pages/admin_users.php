<?php
// Include security helper
require_once '../includes/security-helper.php';

// Users Management Section - Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_action'])) {
    try {
        switch ($_POST['user_action']) {
            case 'add_user':
                // Sanitize inputs
                $username = SecurityHelper::sanitizeString($_POST['username'] ?? '', 50);
                $email = SecurityHelper::sanitizeEmail($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $role = SecurityHelper::validateRole($_POST['role'] ?? 'member');
                
                // Validate inputs
                if (empty($username) || empty($password)) {
                    $error_message = "Gebruikersnaam en wachtwoord zijn verplicht";
                } elseif (!$email) {
                    $error_message = "Geldig e-mailadres is verplicht";
                } elseif (($passwordValidation = SecurityHelper::validatePassword($password)) !== true) {
                    $error_message = $passwordValidation;
                } else {
                    // Check if username exists
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                    $stmt->execute([$username]);
                    if ($stmt->rowCount() > 0) {
                        $error_message = "Gebruikersnaam bestaat al";
                    } else {
                        $hashedPassword = SecurityHelper::hashPassword($password);
                        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$username, $email, $hashedPassword, $role]);
                        $success_message = "Gebruiker succesvol toegevoegd!";
                    }
                }
                break;
                
            case 'update_role':
                $user_id = SecurityHelper::sanitizeInt($_POST['user_id'] ?? '', 1);
                $new_role = SecurityHelper::validateRole($_POST['new_role'] ?? 'member');
                
                if (!$user_id) {
                    $error_message = "Ongeldige gebruiker ID";
                } elseif ($user_id == $_SESSION['user_id']) {
                    $error_message = "Je kunt je eigen rol niet wijzigen";
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
                    if ($stmt->execute([$new_role, $user_id]) && $stmt->rowCount() > 0) {
                        $success_message = "Gebruikersrol succesvol bijgewerkt!";
                    } else {
                        $error_message = "Gebruiker niet gevonden";
                    }
                }
                break;
                
            case 'delete_user':
                $user_id = SecurityHelper::sanitizeInt($_POST['user_id'] ?? '', 1);
                
                if (!$user_id) {
                    $error_message = "Ongeldige gebruiker ID";
                } elseif ($user_id == $_SESSION['user_id']) {
                    $error_message = "Je kunt jezelf niet verwijderen";
                } else {
                    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                    if ($stmt->execute([$user_id]) && $stmt->rowCount() > 0) {
                        $success_message = "Gebruiker succesvol verwijderd!";
                    } else {
                        $error_message = "Gebruiker niet gevonden";
                    }
                }
                break;
        }
    } catch (PDOException $e) {
        $error_message = "Database fout: " . $e->getMessage();
    }
}

// Fetch users from database
try {
    $stmt = $pdo->query("SELECT DISTINCT id, username, email, role, created_at, DATE(created_at) as created FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Remove duplicates based on user ID (just in case)
    $unique_users = [];
    $seen_ids = [];
    foreach ($users as $user) {
        if (!in_array($user['id'], $seen_ids)) {
            $unique_users[] = $user;
            $seen_ids[] = $user['id'];
        }
    }
    $users = $unique_users;
    
    // Debug: Check if we got users
    if (empty($users)) {
        $error_message = "Geen gebruikers gevonden in database. Controleer of de users tabel bestaat en data bevat.";
    } else {
        // Add status field (simulate active/inactive)
        foreach ($users as &$user) {
            $user['status'] = 'active'; // In real app, this could be based on last_login or status field
            // Ensure created field exists
            if (!isset($user['created'])) {
                $user['created'] = 'N/A';
            }
        }
    }
    
} catch (PDOException $e) {
    $users = [];
    $error_message = "Kan gebruikers niet laden: " . $e->getMessage();
}
?>

<?php if (isset($error_message) && !empty($error_message)): ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i><?= $error_message ?>
    </div>
<?php endif; ?>

<?php if (isset($success_message) && !empty($success_message)): ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
    </div>
<?php endif; ?>

<!-- Debug info -->
<div class="alert alert-info">
    <strong>Debug Info:</strong> 
    Aantal gebruikers geladen: <?= isset($users) ? count($users) : 0 ?> |
    PDO Object: <?= isset($pdo) ? 'Ja' : 'Nee' ?> |
    Database connectie: <?= isset($pdo) ? 'Actief' : 'Niet beschikbaar' ?>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-content-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-people me-2"></i>Gebruikers Beheer
                    </h5>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-person-plus me-2"></i>Nieuwe Gebruiker
                    </button>
                </div>
            </div>
            <div class="card-body">
                
                <!-- User Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success mb-1"><?= isset($users) ? count(array_filter($users, fn($u) => $u['status'] === 'active')) : 0 ?></h3>
                            <small class="text-muted">Actieve Gebruikers</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning mb-1"><?= isset($users) ? count(array_filter($users, fn($u) => $u['role'] === 'admin')) : 0 ?></h3>
                            <small class="text-muted">Admins</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-info mb-1"><?= isset($users) ? count(array_filter($users, fn($u) => $u['status'] === 'inactive')) : 0 ?></h3>
                            <small class="text-muted">Inactieve Gebruikers</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-danger mb-1"><?= isset($users) ? count($users) : 0 ?></h3>
                            <small class="text-muted">Totaal Gebruikers</small>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gebruiker</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Aangemaakt</th>
                                <th>Status</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($users) && !empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar">
                                                <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($user['username']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge <?= $user['role'] === 'admin' ? 'bg-warning text-dark' : 'bg-secondary' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td><?= date('d M Y', strtotime($user['created'])) ?></td>
                                <td>
                                    <span class="badge <?= $user['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= ucfirst($user['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="admin-table-actions">
                                        <button class="btn btn-sm btn-outline-primary" title="Rol Wijzigen" onclick="changeRole(<?= $user['id'] ?>, '<?= $user['role'] ?>')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" title="Reset Wachtwoord" onclick="resetPassword(<?= $user['id'] ?>)">
                                            <i class="bi bi-key"></i>
                                        </button>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <button class="btn btn-sm btn-outline-danger" title="Verwijderen" onclick="deleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-person-x" style="font-size: 3rem; opacity: 0.5;"></i>
                                        <br>
                                        <strong>Geen gebruikers gevonden</strong>
                                        <br>
                                        <small class="text-muted">Er zijn nog geen gebruikers in de database of er is een connectieprobleem.</small>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus me-2"></i>Nieuwe Gebruiker Toevoegen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="addUserForm">
                    <input type="hidden" name="user_action" value="add_user">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Gebruikersnaam</label>
                            <input type="text" name="username" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Wachtwoord</label>
                            <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select name="role" class="form-select bg-dark text-white border-secondary">
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                <button type="submit" form="addUserForm" class="btn btn-success">
                    <i class="bi bi-person-plus me-2"></i>Gebruiker Toevoegen
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden forms for user actions -->
<form id="roleChangeForm" method="POST" style="display: none;">
    <input type="hidden" name="user_action" value="update_role">
    <input type="hidden" name="user_id" id="roleUserId">
    <input type="hidden" name="new_role" id="newRole">
</form>

<form id="deleteUserForm" method="POST" style="display: none;">
    <input type="hidden" name="user_action" value="delete_user">
    <input type="hidden" name="user_id" id="deleteUserId">
</form>

<script>
function changeRole(userId, currentRole) {
    const newRole = currentRole === 'admin' ? 'member' : 'admin';
    const action = newRole === 'admin' ? 'admin rechten geven' : 'admin rechten intrekken';
    
    if (confirm(`Weet je zeker dat je wilt ${action} voor deze gebruiker?`)) {
        document.getElementById('roleUserId').value = userId;
        document.getElementById('newRole').value = newRole;
        document.getElementById('roleChangeForm').submit();
    }
}

function resetPassword(userId) {
    if (confirm('Weet je zeker dat je het wachtwoord wilt resetten? De gebruiker ontvangt een email met instructies.')) {
        // In a real app, this would trigger a password reset email
        alert('Wachtwoord reset email verzonden!');
    }
}

function deleteUser(userId, username) {
    if (confirm(`Weet je zeker dat je gebruiker "${username}" permanent wilt verwijderen? Deze actie kan niet ongedaan gemaakt worden.`)) {
        document.getElementById('deleteUserId').value = userId;
        document.getElementById('deleteUserForm').submit();
    }
}
</script>