<?php
// Start session before any output
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../home.php");
    exit();
}

require_once '../includes/db-connection.php';
require_once '../includes/security-helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $username = SecurityHelper::sanitizeString($_POST['username'] ?? '', 50);
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Gebruikersnaam en wachtwoord zijn verplicht";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($user = $stmt->fetch()) {
            if (password_verify($password, $user['password'])) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Set user data in session
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['last_activity'] = time();
                
                // Redirect to home page
                header("Location: ../home.php");
                exit();
            } else {
                $error = "Ongeldige gebruikersnaam of wachtwoord";
            }
        } else {
            $error = "Ongeldige gebruikersnaam of wachtwoord";
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Inloggen</h1>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form method="post" action="" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Gebruikersnaam</label>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   class="form-control bg-dark text-white border-secondary" 
                                   maxlength="50"
                                   value="<?= isset($_POST['username']) ? SecurityHelper::sanitizeString($_POST['username']) : '' ?>"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Wachtwoord</label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control bg-dark text-white border-secondary" 
                                   maxlength="255"
                                   required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">Inloggen</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>Nog geen account? <a href="register.php" class="text-danger">Registreer hier</a></p>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="../index.php" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Terug naar Hoofdpagina
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>