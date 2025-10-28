<?php
// Start session to check if user is already logged in
session_start();

// If user is already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: ../home.php");
    exit();
}

require_once '../includes/db-connection.php';
require_once '../includes/security-helper.php';
include '../includes/header.php';

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $username = SecurityHelper::sanitizeString($_POST['username'] ?? '', 50);
    $email = SecurityHelper::sanitizeEmail($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Gebruikersnaam en wachtwoord zijn verplicht";
    } elseif (strlen($username) < 3) {
        $error = "Gebruikersnaam moet minimaal 3 karakters zijn";
    } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
        $error = "Gebruikersnaam mag alleen letters, cijfers, _ en - bevatten";
    } elseif (($passwordValidation = SecurityHelper::validatePassword($password)) !== true) {
        $error = $passwordValidation;
    } elseif (!empty($_POST['email']) && !$email) {
        $error = "Ongeldig e-mailadres";
    } else {
        // Set default email if not provided
        $defaultEmail = $email ?: $username . '@streamflix.nl';
        
        // Hash password securely
        $hashedPassword = SecurityHelper::hashPassword($password);
        
        try {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->rowCount() > 0) {
                $error = "Gebruikersnaam bestaat al";
            } else {
                // Insert new user
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'member')");
                $stmt->execute([$username, $defaultEmail, $hashedPassword]);
                $success = true;
            }
        } catch (PDOException $e) {
            $error = "Database fout. Probeer het later opnieuw.";
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Registreren</h1>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            Account aangemaakt! Je kunt nu <a href="login.php" class="alert-link">inloggen</a>.
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <?php if (!$success): ?>
                        <form method="post" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label">Gebruikersnaam</label>
                                <input type="text" 
                                       name="username" 
                                       id="username" 
                                       class="form-control bg-dark text-white border-secondary" 
                                       maxlength="50"
                                       minlength="3"
                                       pattern="[a-zA-Z0-9_-]+"
                                       title="Minimaal 3 karakters, alleen letters, cijfers, _ en -"
                                       value="<?= isset($_POST['username']) ? SecurityHelper::sanitizeString($_POST['username']) : '' ?>"
                                       required>
                                <small class="text-muted">Min. 3 karakters, alleen letters, cijfers, _ en -</small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail (optioneel)</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control bg-dark text-white border-secondary" 
                                       maxlength="100"
                                       value="<?= isset($_POST['email']) ? SecurityHelper::sanitizeString($_POST['email']) : '' ?>">
                                <small class="text-muted">Als je geen e-mail opgeeft, wordt automatisch een gegenereerd</small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Wachtwoord</label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control bg-dark text-white border-secondary" 
                                       minlength="6"
                                       maxlength="255"
                                       required>
                                <small class="text-muted">Minimaal 6 karakters</small>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger">Registreren</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>Heb je al een account? <a href="login.php" class="text-danger">Log hier in</a></p>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="../index.php" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i>Terug naar Hoofdpagina
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>