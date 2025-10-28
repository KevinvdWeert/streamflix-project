<?php
session_start();
include '../includes/header.php';
require_once '../includes/db-connection.php';
require_once '../includes/security-helper.php';

// Check if user is admin - verify against database for security
$is_admin = false;
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $user['role'] === 'admin') {
            $is_admin = true;
            $_SESSION['role'] = 'admin'; // Sync session with database
        } else {
            $_SESSION['role'] = $user['role'] ?? 'member'; // Update session
        }
    } catch (PDOException $e) {
        error_log("Admin verification error: " . $e->getMessage());
    }
}

if (!$is_admin) {
    echo "<div class='container py-4'><div class='alert alert-danger'><i class='bi bi-shield-exclamation me-2'></i>Je hebt geen admin rechten om deze pagina te bekijken. <a href='account.php' class='text-decoration-none'>Ga naar je account</a> om admin rechten in te schakelen.</div></div>";
    include '../includes/footer.php';
    exit;
}

// Get current section from URL parameter (sanitize)
$section = SecurityHelper::sanitizeString($_GET['section'] ?? 'dashboard', 20);

// Get statistics for dashboard
try {
    $stats = [];
    
    // Count movies
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM movies");
    $stats['movies'] = $stmt->fetch()['count'];
    
    // Count categories
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $stats['categories'] = $stmt->fetch()['count'];
    
    // Count users
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $stats['users'] = $stmt->fetch()['count'];
    
    // Average rating
    $stmt = $pdo->query("SELECT AVG(rating) as avg_rating FROM ratings");
    $avgRating = $stmt->fetch()['avg_rating'];
    $stats['avg_rating'] = round($avgRating, 1);
    
    // Get recent movies
    $stmt = $pdo->query("SELECT m.*, c.name as category FROM movies m 
                        JOIN categories c ON m.category_id = c.id 
                        ORDER BY m.id DESC LIMIT 5");
    $recentMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $error = $e->getMessage();
}

?>

<div class="admin-dashboard">
    <div class="container-fluid py-4">
        
        <!-- Admin Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="text-danger mb-1">
                            <i class="bi bi-shield-check me-2"></i>Admin Dashboard
                        </h1>
                        <p class="text-muted mb-0">Welkom, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>!</p>
                    </div>
                    <div>
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-dot me-1"></i>Online
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="admin-nav">
                    <nav class="nav nav-pills nav-justified">
                        <a class="nav-link <?= $section === 'dashboard' ? 'active' : '' ?>" href="?section=dashboard">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a class="nav-link <?= $section === 'users' ? 'active' : '' ?>" href="?section=users">
                            <i class="bi bi-people me-2"></i>Gebruikers Beheren
                        </a>
                        <a class="nav-link <?= $section === 'movies' ? 'active' : '' ?>" href="?section=movies">
                            <i class="bi bi-film me-2"></i>Films Beheren
                        </a>
                        <a class="nav-link <?= $section === 'statistics' ? 'active' : '' ?>" href="?section=statistics">
                            <i class="bi bi-bar-chart me-2"></i>Statistieken
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success bg-success text-white border-0 mb-4">
                <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger bg-danger text-white border-0 mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?= $error_message ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Dashboard Content -->
        <?php if ($section === 'dashboard'): ?>
            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="admin-stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-danger mb-1"><?= $stats['movies'] ?></h3>
                                    <p class="text-muted mb-0">Totaal Films</p>
                                </div>
                                <i class="bi bi-film text-danger" style="font-size: 2rem; opacity: 0.6;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="admin-stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-warning mb-1"><?= $stats['categories'] ?></h3>
                                    <p class="text-muted mb-0">Categorieën</p>
                                </div>
                                <i class="bi bi-tags text-warning" style="font-size: 2rem; opacity: 0.6;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="admin-stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-success mb-1"><?= $stats['users'] ?></h3>
                                    <p class="text-muted mb-0">Gebruikers</p>
                                </div>
                                <i class="bi bi-people text-success" style="font-size: 2rem; opacity: 0.6;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="admin-stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-info mb-1"><?= $stats['avg_rating'] ?>/10</h3>
                                    <p class="text-muted mb-0">Gem. Rating</p>
                                </div>
                                <i class="bi bi-star text-info" style="font-size: 2rem; opacity: 0.6;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Movies -->
            <div class="row">
                <div class="col-12">
                    <div class="admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history me-2"></i>Recent Toegevoegde Films
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Titel</th>
                                            <th>Categorie</th>
                                            <th>Beschrijving</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentMovies as $movie): ?>
                                        <tr>
                                            <td><?= $movie['id'] ?></td>
                                            <td><?= htmlspecialchars($movie['title']) ?></td>
                                            <td>
                                                <span class="badge bg-secondary"><?= htmlspecialchars($movie['category']) ?></span>
                                            </td>
                                            <td><?= substr(htmlspecialchars($movie['description']), 0, 50) ?>...</td>
                                            <td>
                                                <span class="badge bg-success">Actief</span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($section === 'users'): ?>
            <?php include 'admin_users.php'; ?>
            
        <?php elseif ($section === 'movies'): ?>
            <?php include 'admin_movies.php'; ?>
            
        <?php elseif ($section === 'statistics'): ?>
            <?php include 'admin_statistics.php'; ?>
            
        <?php endif; ?>

    </div>
</div>

<script>
// Handle tab switching from URL hash or localStorage
document.addEventListener('DOMContentLoaded', function() {
    // Check for hash in URL
    const hash = window.location.hash.substring(1);
    const savedTab = localStorage.getItem('adminActiveTab');
    
    if (hash && ['dashboard', 'users', 'movies', 'statistics'].includes(hash)) {
        // Redirect to the correct section based on hash
        if (window.location.search !== `?section=${hash}`) {
            window.location.href = `admin.php?section=${hash}`;
        }
    } else if (savedTab && ['dashboard', 'users', 'movies', 'statistics'].includes(savedTab)) {
        // Redirect to saved tab if no hash present
        if (window.location.search !== `?section=${savedTab}`) {
            window.location.href = `admin.php?section=${savedTab}`;
        }
    }
    
    // Clear localStorage after use
    localStorage.removeItem('adminActiveTab');
});

// Add click handlers for nav links to save current section
document.querySelectorAll('.admin-nav .nav-link').forEach(link => {
    link.addEventListener('click', function() {
        const url = new URL(this.href);
        const section = url.searchParams.get('section');
        if (section) {
            localStorage.setItem('adminCurrentSection', section);
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>