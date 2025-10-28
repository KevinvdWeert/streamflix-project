<?php
// Start session for navbar
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db-connection.php';
require_once '../includes/image-helper.php';
require_once '../includes/security-helper.php';
include '../includes/header.php';

$movie_id = SecurityHelper::sanitizeInt($_GET['id'] ?? '', 1);
if ($movie_id !== false) {
    $stmt = $pdo->prepare("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id WHERE m.id = ?");
    $stmt->execute([$movie_id]);
    
    if ($stmt->rowCount() > 0) {
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get recommended movies
        $category_id = $movie['category_id'];
        $stmt2 = $pdo->prepare("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id WHERE m.category_id = ? AND m.id != ? LIMIT 4");
        $stmt2->execute([$category_id, $movie_id]);
        $recommended = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../home.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($movie['title']); ?></li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="video-player-container">
                <video id="moviePlayer" class="video-js vjs-big-play-centered" controls preload="auto" poster="<?= getPosterUrl($movie['image'], '../assets/img/') ?>" data-setup='{}'>
                    <source src="../<?= htmlspecialchars($movie['video_url'] ?? 'assets/videos/placeholder.mp4'); ?>" type="video/mp4">
                    <p class="vjs-no-js">
                        Je browser ondersteunt geen HTML5 video.
                    </p>
                </video>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="movie-details">
                <h1 class="movie-title"><?= htmlspecialchars($movie['title']); ?></h1>
                <div class="rating-stars mb-3" data-rating="<?= rand(30, 50) / 10; ?>"></div>
                <div class="movie-meta">
                    <span class="badge bg-danger"><?= htmlspecialchars($movie['category'] ?? 'Algemeen'); ?></span>
                    <span class="movie-duration">1h 45m</span>
                </div>
                <div class="movie-description mt-3">
                    <h4>Beschrijving</h4>
                    <p><?= htmlspecialchars($movie['description']); ?></p>
                </div>
                <div class="movie-actions mt-4">
                    <button class="btn btn-danger btn-lg me-2"><i class="bi bi-play-fill"></i> Afspelen</button>
                    <button class="btn btn-outline-light"><i class="bi bi-plus-lg"></i> Toevoegen aan lijst</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="section-header">Aanbevolen films</h3>
            <div class="row">
                <?php
                $stmt = $pdo->prepare("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id WHERE m.id != ? LIMIT 4");
                $stmt->execute([$movie_id]);
                $recommendedMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($recommendedMovies as $recMovie) {
                    echo '<div class="col-md-3 col-sm-6 mb-4">
                        <div class="movie-card">
                            <div class="card-img-container">
                                <img src="' . getImageUrl($recMovie['image'], '../assets/img/') . '" class="card-img" alt="' . htmlspecialchars($recMovie['title']) . '">
                                <div class="card-img-overlay">
                                    <a href="detail.php?id=' . $recMovie['id'] . '" class="play-button"><i class="bi bi-play-fill"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($recMovie['title']) . '</h5>
                                <div class="rating-stars" data-rating="' . (rand(30, 50) / 10) . '"></div>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <a href="../home.php" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Terug naar Home</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<?php
    }
}
?>