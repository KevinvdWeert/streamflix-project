<?php
// Start session before any output
session_start();

require_once '../includes/db-connection.php';
require_once '../includes/security-helper.php';
include '../includes/header.php';

// Check if user is logged in
$user_logged_in = isset($_SESSION['user_id']);

if (!$user_logged_in) {
    // If no session, create demo session for testing
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'demo_user';
    $_SESSION['role'] = $_SESSION['role'] ?? 'member';
}

// Fetch user data from database
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If user not found in database, create demo user
    if (!$user_data) {
        // Check if demo user exists, if not create it
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'demo_user'");
        $stmt->execute();
        $demo_user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$demo_user) {
            // Create demo user
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute(['demo_user', 'demo@example.com', password_hash('demo123', PASSWORD_DEFAULT), $_SESSION['role'] ?? 'member']);
            $_SESSION['user_id'] = $pdo->lastInsertId();
        } else {
            $_SESSION['user_id'] = $demo_user['id'];
            $user_data = $demo_user;
        }
        
        // Fetch again after creation
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update session with current user data
    $_SESSION['username'] = $user_data['username'];
    $_SESSION['role'] = $user_data['role'];
    
} catch (PDOException $e) {
    // Fallback to demo data if database error
    $user_data = [
        'id' => 1,
        'username' => 'demo_user', 
        'email' => 'demo@example.com',
        'created_at' => date('Y-m-d H:i:s', strtotime('-6 months')),
        'role' => $_SESSION['role'] ?? 'member'
    ];
}

// Handle form submissions
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'change_password':
                // Sanitize inputs
                $current_password = $_POST['current_password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';
                
                if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                    $error_message = 'Alle velden zijn verplicht.';
                } elseif ($new_password !== $confirm_password) {
                    $error_message = 'Nieuwe wachtwoorden komen niet overeen.';
                } elseif (($passwordValidation = SecurityHelper::validatePassword($new_password)) !== true) {
                    $error_message = $passwordValidation;
                } else {
                    try {
                        // Verify current password
                        if (password_verify($current_password, $user_data['password'])) {
                            // Update password in database
                            $hashedPassword = SecurityHelper::hashPassword($new_password);
                            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                            $stmt->execute([$hashedPassword, $_SESSION['user_id']]);
                            $success_message = 'Wachtwoord succesvol gewijzigd.';
                        } else {
                            $error_message = 'Huidig wachtwoord is onjuist.';
                        }
                    } catch (PDOException $e) {
                        $error_message = 'Fout bij het wijzigen van wachtwoord.';
                    }
                }
                break;
                
            case 'update_email':
                // Sanitize email input
                $new_email = SecurityHelper::sanitizeEmail($_POST['new_email'] ?? '');
                
                if (empty($new_email)) {
                    $error_message = 'E-mailadres is verplicht.';
                } elseif (!SecurityHelper::sanitizeEmail($new_email, true)) {
                    $error_message = 'Ongeldig email adres.';
                } else {
                    try {
                        // Update email in database
                        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
                        $stmt->execute([$new_email, $_SESSION['user_id']]);
                        
                        // Refresh user data uit database na update
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        $success_message = 'Email adres succesvol gewijzigd.';
                    } catch (PDOException $e) {
                        $error_message = 'Fout bij het wijzigen van email adres.';
                    }
                }
                break;
                
            case 'delete_account':
                // Sanitize confirm delete input
                $confirm_delete = SecurityHelper::sanitizeString($_POST['confirm_delete'] ?? '');
                
                if ($confirm_delete === 'DELETE') {
                    try {
                        // In a real app, you might want to soft delete or anonymize data
                        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        
                        // Destroy session
                        session_destroy();
                        header('Location: ../index.php?message=account_deleted');
                        exit();
                    } catch (PDOException $e) {
                        $error_message = 'Fout bij het verwijderen van account.';
                    }
                } else {
                    $error_message = 'Type "DELETE" om je account te verwijderen.';
                }
                break;
                
            case 'enable_admin':
                // Sanitize admin credentials
                $admin_username = SecurityHelper::sanitizeString($_POST['admin_username'] ?? '');
                $admin_password = $_POST['admin_password'] ?? '';
                
                if ($admin_username === 'admin' && $admin_password === 'admin') {
                    try {
                        // Update user role to admin in database
                        $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        
                        // Refresh user data uit database na update
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        $_SESSION['role'] = $user_data['role'];
                        $_SESSION['username'] = $user_data['username'];
                        $success_message = 'Admin rechten succesvol geactiveerd! Je hebt nu volledige toegang tot het admin panel.';
                    } catch (PDOException $e) {
                        $error_message = 'Fout bij het activeren van admin rechten: ' . $e->getMessage();
                    }
                } else {
                    $error_message = 'Ongeldige admin credentials.';
                }
                break;
        }
        
        // Na elke successful actie: herlaad user data uit database voor consistentie
        if (isset($success_message) && !empty($success_message)) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $refreshed_user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($refreshed_user) {
                    $user_data = $refreshed_user;
                    $_SESSION['username'] = $user_data['username'];
                    $_SESSION['role'] = $user_data['role'];
                }
            } catch (PDOException $e) {
                error_log("Failed to refresh user data: " . $e->getMessage());
            }
        }
    }
}
?>

<div class="account-page">
    <div class="container py-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center">
                <h1 class="fw-bold text-danger mb-2">Mijn Account</h1>
                <p class="text-muted">Beheer je profiel en instellingen</p>
            </div>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success bg-success text-white border-0 mb-4">
                <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger bg-danger text-white border-0 mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?= $error_message ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Account Overview -->
            <div class="col-lg-4">
                <div class="account-overview-card text-white">
                    <div class="settings-card-header text-center">
                        <div class="mb-3">
                            <i class="bi bi-person-circle profile-icon"></i>
                        </div>
                        <h4 class="mb-2"><?= htmlspecialchars($user_data['username']) ?></h4>
                        <span class="account-badge <?= $user_data['role'] === 'admin' ? 'bg-success' : 'bg-secondary' ?>">
                            <i class="bi <?= $user_data['role'] === 'admin' ? 'bi-shield-check' : 'bi-person' ?> me-1"></i>
                            <?= ucfirst($user_data['role']) ?> Account
                        </span>
                    </div>
                    <div class="settings-card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-envelope me-2 text-danger"></i>
                                <small class="text-muted">Email:</small>
                            </div>
                            <span class="ms-4"><?= htmlspecialchars($user_data['email']) ?></span>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar me-2 text-danger"></i>
                                <small class="text-muted">Lid sinds:</small>
                            </div>
                            <span class="ms-4"><?= date('d M Y', strtotime($user_data['created_at'])) ?></span>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle me-2 text-danger"></i>
                                <small class="text-muted">Status:</small>
                            </div>
                            <div class="ms-4">
                                <span class="badge bg-success">Actief</span>
                                <?php if ($user_data['role'] === 'admin'): ?>
                                    <span class="badge bg-warning text-dark ms-1">
                                        <i class="bi bi-star me-1"></i>Premium
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="settings-card text-white mt-4">
                    <div class="settings-card-header">
                        <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Account Statistieken</h6>
                    </div>
                    <div class="settings-card-body">
                        <div class="account-stats">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end border-secondary pe-3">
                                        <div class="stat-number text-danger"><?= rand(15, 150) ?></div>
                                        <small class="text-muted">Films gekeken</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-number text-warning"><?= rand(500, 2500) ?></div>
                                    <small class="text-muted">Uren gestreamd</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Settings Column -->
            <div class="col-lg-8">
                
                <!-- 1. Password Change Section -->
                <div class="settings-card text-white mb-4">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-lock me-2 text-danger"></i>
                            Wachtwoord Wijzigen
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="change_password">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="current_password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Huidig Wachtwoord
                                    </label>
                                    <input type="password" class="form-control form-control-custom" 
                                           id="current_password" name="current_password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="new_password" class="form-label">
                                        <i class="bi bi-key me-1"></i>Nieuw Wachtwoord
                                    </label>
                                    <input type="password" class="form-control form-control-custom" 
                                           id="new_password" name="new_password" required minlength="6">
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm_password" class="form-label">
                                        <i class="bi bi-check-circle me-1"></i>Bevestig Nieuw Wachtwoord
                                    </label>
                                    <input type="password" class="form-control form-control-custom" 
                                           id="confirm_password" name="confirm_password" required minlength="6">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger btn-custom">
                                        <i class="bi bi-key me-2"></i>Wachtwoord Wijzigen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 2. Email Change Section -->
                <div class="settings-card text-white mb-4">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-envelope me-2 text-danger"></i>
                            Email Adres Wijzigen
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_email">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-8">
                                    <label for="new_email" class="form-label">
                                        <i class="bi bi-at me-1"></i>Nieuw Email Adres
                                    </label>
                                    <input type="email" class="form-control form-control-custom" 
                                           id="new_email" name="new_email" 
                                           value="<?= htmlspecialchars($user_data['email']) ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-warning btn-custom w-100">
                                        <i class="bi bi-envelope-check me-2"></i>Wijzig Email
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 3. Privacy Settings Section -->
                <div class="settings-card text-white mb-4">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check me-2 text-danger"></i>
                            Privacy Instellingen
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="privacy-switch">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">
                                    <i class="bi bi-envelope me-2"></i>Email notificaties ontvangen
                                </label>
                            </div>
                        </div>
                        <div class="privacy-switch">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="shareHistory">
                                <label class="form-check-label" for="shareHistory">
                                    <i class="bi bi-clock-history me-2"></i>Kijkgeschiedenis delen voor aanbevelingen
                                </label>
                            </div>
                        </div>
                        <div class="privacy-switch">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="marketingEmails">
                                <label class="form-check-label" for="marketingEmails">
                                    <i class="bi bi-megaphone me-2"></i>Marketing emails ontvangen
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-success btn-custom" onclick="savePrivacySettings()">
                                <i class="bi bi-check-circle me-2"></i>Instellingen Opslaan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4. Admin Rights Section -->
                <?php if ($user_data['role'] !== 'admin'): ?>
                <div class="settings-card text-white admin-section mb-4">
                    <div class="settings-card-header" style="background: linear-gradient(90deg, #ffc107, #ff8500); color: #000;">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-exclamation me-2"></i>
                            Administrator Rechten
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <p class="text-muted mb-3">
                            Beheerders hebben toegang tot extra functionaliteiten zoals gebruikersbeheer, 
                            film toevoegen/bewerken en systeem instellingen.
                        </p>
                        
                        <button type="button" class="btn btn-warning btn-custom text-dark" onclick="toggleAdminForm()">
                            <i class="bi bi-key me-2"></i>Admin Rechten Inschakelen
                        </button>
                        
                        <div id="adminForm" class="admin-form-container" style="display: none;">
                            <form method="POST">
                                <input type="hidden" name="action" value="enable_admin">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="admin_username" class="form-label text-warning">
                                            <i class="bi bi-person me-1"></i>Admin Gebruikersnaam
                                        </label>
                                        <input type="text" class="form-control form-control-custom" 
                                               id="admin_username" name="admin_username" 
                                               placeholder="Voer admin gebruikersnaam in" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="admin_password" class="form-label text-warning">
                                            <i class="bi bi-lock me-1"></i>Admin Wachtwoord
                                        </label>
                                        <input type="password" class="form-control form-control-custom" 
                                               id="admin_password" name="admin_password" 
                                               placeholder="Voer admin wachtwoord in" required>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-warning btn-custom text-dark">
                                            <i class="bi bi-shield-check me-2"></i>Admin Rechten Activeren
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-custom ms-2" onclick="toggleAdminForm()">
                                            <i class="bi bi-x-circle me-2"></i>Annuleren
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="settings-card admin-active-card text-white mb-4">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>
                            Administrator Account
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-award me-3" style="font-size: 2.5rem;"></i>
                            <div>
                                <h6 class="mb-1">Admin Rechten Actief</h6>
                                <p class="mb-0 opacity-75">Je hebt volledige toegang tot alle admin functionaliteiten.</p>
                            </div>
                        </div>
                        
                        <div class="admin-panel-buttons">
                            <a href="admin.php" class="admin-btn">
                                <i class="bi bi-gear"></i>Admin Dashboard
                            </a>
                            <a href="admin.php#users" class="admin-btn" onclick="localStorage.setItem('adminActiveTab', 'users')">
                                <i class="bi bi-people"></i>Gebruikers Beheren
                            </a>
                            <a href="admin.php#movies" class="admin-btn" onclick="localStorage.setItem('adminActiveTab', 'movies')">
                                <i class="bi bi-film"></i>Films Beheren
                            </a>
                            <a href="admin.php#statistics" class="admin-btn" onclick="localStorage.setItem('adminActiveTab', 'statistics')">
                                <i class="bi bi-bar-chart"></i>Statistieken
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 5. Danger Zone Section -->
                <div class="settings-card danger-zone text-white mb-4">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Gevaarlijke Acties
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-trash me-3" style="font-size: 2rem;"></i>
                            <div>
                                <h6 class="mb-1">Account Verwijderen</h6>
                                <p class="mb-0 opacity-75">
                                    Let op: Het verwijderen van je account is permanent en kan niet ongedaan worden gemaakt.
                                </p>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-outline-light btn-custom" 
                                data-bs-toggle="collapse" data-bs-target="#deleteAccountForm">
                            <i class="bi bi-trash me-2"></i>Account Verwijderen
                        </button>
                        
                        <div class="collapse mt-3" id="deleteAccountForm">
                            <div class="admin-form-container" style="border-color: #dc3545; background: rgba(220, 53, 69, 0.1);">
                                <form method="POST">
                                    <input type="hidden" name="action" value="delete_account">
                                    <div class="mb-3">
                                        <label for="confirm_delete" class="form-label text-danger">
                                            <i class="bi bi-shield-exclamation me-1"></i>Type "DELETE" om te bevestigen:
                                        </label>
                                        <input type="text" class="form-control form-control-custom" 
                                               id="confirm_delete" name="confirm_delete" required>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-custom">
                                        <i class="bi bi-trash me-2"></i>Account Definitief Verwijderen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Account Settings Column -->
        </div>
        <!-- End Main Row -->

        <!-- Help Section -->
        <div class="help-section">
            <h5 class="text-danger mb-3">
                <i class="bi bi-life-preserver me-2"></i>Hulp Nodig?
            </h5>
            <p class="text-muted mb-4">Onze support team staat klaar om je te helpen met al je vragen.</p>
            
            <div class="help-buttons">
                <a href="faq.php" class="help-btn">
                    <i class="bi bi-question-circle"></i>FAQ
                </a>
                <a href="contact.php" class="help-btn">
                    <i class="bi bi-envelope"></i>Contact
                </a>
                <a href="helpdesk.php" class="help-btn">
                    <i class="bi bi-headset"></i>Helpdesk
                </a>
                <?php if ($user_logged_in): ?>
                    <a href="../home.php" class="help-btn" style="background: var(--primary-color); border-color: var(--primary-color); color: white;">
                        <i class="bi bi-house"></i>Terug naar Home
                    </a>
                <?php else: ?>
                    <a href="login.php" class="help-btn" style="background: var(--primary-color); border-color: var(--primary-color); color: white;">
                        <i class="bi bi-box-arrow-in-right"></i>Inloggen
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function savePrivacySettings() {
    // In a real application, this would save settings via AJAX
    alert('Privacy instellingen opgeslagen!');
}

function toggleAdminForm() {
    const adminForm = document.getElementById('adminForm');
    if (adminForm.style.display === 'none') {
        adminForm.style.display = 'block';
        // Clear form fields when showing
        document.getElementById('admin_username').value = '';
        document.getElementById('admin_password').value = '';
        // Focus on first input
        document.getElementById('admin_username').focus();
    } else {
        adminForm.style.display = 'none';
    }
}
</script>

<?php include '../includes/footer.php'; ?>