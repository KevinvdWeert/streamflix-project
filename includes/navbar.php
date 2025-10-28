<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
$base_path = '';

if (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) {
    $base_path = '../';
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) : null;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_path; ?>home.php">
            <svg width="40" height="40" viewBox="0 0 150 165" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="streamflix-logo" class="me-2">
                <title id="streamflix-logo">Streamflix Logo</title>
                <defs>
                    <linearGradient id="gIcon-navbar" x1="12" y1="12" x2="132" y2="132" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FF2E63"/>
                        <stop offset="0.5" stop-color="#FF5F32"/>
                        <stop offset="1" stop-color="#FF8A00"/>
                    </linearGradient>
                </defs>
                <path d="M118 54c0-24.3-18.7-42-42-42H66.5c-9.6 0-17.5 7.9-17.5 17.5S56.9 47 66.5 47H76c8.3 0 15 6.7 15 15 0 6-3.6 11.5-9.2 13.8L53.4 89.4C38.2 95.8 30 107.9 30 123c0 24.3 18.7 42 42 42h11.5c9.6 0 17.5-7.9 17.5-17.5S93.1 130 83.5 130H74c-8.3 0-15-6.7-15-15 0-6 3.6-11.5 9.2-13.8l28.4-13.6C109.8 81.2 118 69.1 118 54Z" fill="url(#gIcon-navbar)"/>
                <path d="M78 60c2 0 3.8 0.5 5.5 1.6l16.2 10c4.6 2.8 4.6 9.4 0 12.2l-16.2 10A10 10 0 0 1 68 85.9V70.1A10 10 0 0 1 78 60Z" fill="#0D0F17" opacity="0.9"/>
            </svg>
            <span class="fw-bold text-danger">Streamflix</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'home.php') ? 'active fw-bold' : ''; ?>" href="<?php echo $base_path; ?>home.php">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'movies.php') ? 'active fw-bold' : ''; ?>" href="<?php echo $base_path; ?>pages/movies.php">
                        <i class="bi bi-film"></i> Films
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'mylist.php') ? 'active fw-bold' : ''; ?>" href="<?php echo $base_path; ?>pages/mylist.php">
                        <i class="bi bi-bookmark-heart"></i> Mijn Lijst
                    </a>
                </li>
            </ul>
            <form class="d-flex me-2 mb-2 mb-lg-0" action="<?php echo $base_path; ?>pages/search.php" method="get">
                <div class="input-group">
                    <input class="form-control bg-dark text-white border-secondary" type="search" name="q" placeholder="Zoeken..." aria-label="Search" required>
                    <button class="btn btn-outline-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <button id="themeToggle" class="btn btn-outline-secondary me-2 mb-2 mb-lg-0">
                <span class="theme-icon">🌙</span>
            </button>
            
            <?php if ($is_logged_in): ?>
                <!-- Logged in user options -->
                <div class="d-flex align-items-center">
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-<?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'shield-check' : 'person-circle'; ?> me-1"></i>
                            <?php echo $username; ?>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <span class="badge bg-warning text-dark ms-1" style="font-size: 0.6rem;">ADMIN</span>
                            <?php endif; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>pages/account.php">
                                <i class="bi bi-gear me-2"></i>Account
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>pages/mylist.php">
                                <i class="bi bi-bookmark-heart me-2"></i>Mijn Lijst
                            </a></li>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-warning" href="<?php echo $base_path; ?>pages/admin.php">
                                    <i class="bi bi-shield-check me-2"></i>Admin Panel
                                </a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo $base_path; ?>pages/logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>Uitloggen
                            </a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <!-- Not logged in options -->
                <div class="d-flex">
                    <a href="<?php echo $base_path; ?>pages/login.php" class="btn btn-outline-light me-2 mb-2 mb-lg-0">Inloggen</a>
                    <a href="<?php echo $base_path; ?>pages/register.php" class="btn btn-danger mb-2 mb-lg-0">Registreren</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>