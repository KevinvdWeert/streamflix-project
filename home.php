<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: pages/login.php?redirect=home");
    exit();
}

include 'includes/header.php';
require_once 'includes/db-connection.php';
require_once 'includes/image-helper.php';

// Fetch movies from database
$stmt = $pdo->query("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id LIMIT 12");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$featured_movies = array_slice($movies, 0, 3);
?>

<div class="container-fluid px-0">
    <div id="featuredCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($featured_movies as $index => $movie): ?>
                <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($featured_movies as $index => $movie): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" style="height: 60vh;">
                    <div class="position-relative w-100 h-100">
                        <img src="<?= getImageUrl($movie['image'], 'assets/img/') ?>" class="d-block w-100 h-100 object-fit-cover" alt="<?= $movie['title'] ?>">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
                        <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <h1 class="display-4 fw-bold text-white mb-3"><?= $movie['title'] ?></h1>
                                        <p class="lead mb-4"><?= substr($movie['description'], 0, 150) ?>...</p>
                                        <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                                            <a href="pages/detail.php?id=<?= $movie['id'] ?>" class="btn btn-danger btn-lg">
                                                <i class="bi bi-play-fill me-2"></i>Nu Kijken
                                            </a>
                                            <button class="btn btn-outline-light btn-lg">
                                                <i class="bi bi-plus-circle me-2"></i>Mijn Lijst
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Welcome Message for Logged-in User -->
<div class="container mt-4">
    <div class="alert alert-success bg-success text-white border-0">
        <h5 class="mb-2">
            <i class="bi bi-person-check-fill me-2"></i>
            Welkom terug, <?= htmlspecialchars($_SESSION['username']) ?>!
        </h5>
        <p class="mb-0">Geniet van onze uitgebreide collectie films en series.</p>
    </div>
</div>

<!-- Movie Section -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Populaire Films</h2>
        <a href="pages/movies.php" class="btn btn-outline-danger">Bekijk Alles</a>
    </div>
    
    <div class="row g-4">
        <?php foreach ($movies as $movie): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 bg-dark text-white border-0 shadow">
                    <img src="<?= getImageUrl($movie['image'], 'assets/img/') ?>" class="card-img-top object-fit-cover" style="height: 200px;" alt="<?= $movie['title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?= $movie['title'] ?></h5>
                        <div class="mb-2">
                            <?php
                            $rating = rand(1, 5);
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="bi bi-star-fill text-warning"></i>';
                                } else {
                                    echo '<i class="bi bi-star text-secondary"></i>';
                                }
                            }
                            ?>
                        </div>
                        <p class="card-text small text-secondary mb-3"><?= $movie['category'] ?></p>
                        <div class="d-grid">
                            <a href="pages/detail.php?id=<?= $movie['id'] ?>" class="btn btn-danger">
                                <i class="bi bi-play-fill me-2"></i>Bekijken
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>