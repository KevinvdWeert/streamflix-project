<?php
// Start session for navbar
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db-connection.php';
require_once '../includes/image-helper.php';
include '../includes/header.php';

// For now, we'll use the movies table but filter for series-like content
// In a real application, you might have a separate series table
$stmt = $pdo->query("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id ORDER BY m.title");
$all_movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get categories
$categories_stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-danger">Series</h1>
        <div class="d-flex gap-3">
            <select class="form-select bg-dark text-white border-secondary">
                <option value="">Alle Genres</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Featured Series Section -->
    <div class="mb-5">
        <h2 class="fw-bold mb-3">Trending Series</h2>
        <div class="row g-3">
            <?php for ($i = 0; $i < min(4, count($all_movies)); $i++): 
                $series = $all_movies[$i]; ?>
                <div class="col-6 col-lg-3">
                    <div class="card bg-dark text-white border-0 shadow">
                        <img src="<?= getImageUrl($series['image'], '../assets/img/') ?>" 
                             class="card-img-top object-fit-cover" style="height: 200px;" alt="<?= htmlspecialchars($series['title']) ?>">
                        <div class="card-img-overlay d-flex align-items-end p-0">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($series['title']) ?></h5>
                                <span class="badge bg-danger">Serie</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Popular Series Section -->
    <div class="mb-5">
        <h2 class="fw-bold mb-3">Populaire Series</h2>
        <div class="row g-4">
            <?php foreach ($all_movies as $series): ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card h-100 bg-dark text-white border-0 shadow">
                        <div class="position-relative">
                            <img src="<?= getImageUrl($series['image'], '../assets/img/') ?>" 
                                 class="card-img-top object-fit-cover" style="height: 250px;" alt="<?= htmlspecialchars($series['title']) ?>">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">Serie</span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-dark bg-opacity-75">
                                    <i class="bi bi-star-fill text-warning"></i> <?= number_format(rand(70, 98)/10, 1) ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($series['title']) ?></h5>
                            <p class="card-text small text-secondary mb-2">
                                <i class="bi bi-calendar"></i> 2023 • <i class="bi bi-collection-play"></i> <?= rand(1, 5) ?> seizoen(en)
                            </p>
                            <p class="card-text small text-secondary mb-2">
                                <i class="bi bi-tag"></i> <?= htmlspecialchars($series['category']) ?>
                            </p>
                            <p class="card-text small mb-3"><?= substr(htmlspecialchars($series['description']), 0, 80) ?>...</p>
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="detail.php?id=<?= $series['id'] ?>&type=series" class="btn btn-danger btn-sm">
                                        <i class="bi bi-play-fill me-1"></i>Bekijken
                                    </a>
                                    <button class="btn btn-outline-light btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>Mijn Lijst
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Coming Soon Section -->
    <div class="mb-5">
        <h2 class="fw-bold mb-3">Binnenkort Beschikbaar</h2>
        <div class="row g-3">
            <?php for ($i = 0; $i < min(3, count($all_movies)); $i++): 
                $upcoming = $all_movies[$i]; ?>
                <div class="col-md-4">
                    <div class="card bg-dark text-white border-secondary">
                        <div class="row g-0">
                            <div class="col-4">
                                <img src="<?= getImageUrl($upcoming['image'], '../assets/img/') ?>" 
                                     class="img-fluid h-100 object-fit-cover" alt="<?= htmlspecialchars($upcoming['title']) ?>">
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold"><?= htmlspecialchars($upcoming['title']) ?></h6>
                                    <p class="card-text small text-secondary">Beschikbaar vanaf: <?= date('d M Y', strtotime('+' . rand(1, 90) . ' days')) ?></p>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-bell"></i> Herinner me
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Info Section -->
    <div class="text-center py-4">
        <div class="alert alert-info bg-dark border-secondary text-light">
            <i class="bi bi-info-circle"></i>
            <strong>Nieuw bij Streamflix?</strong> Ontdek duizenden series uit verschillende genres. Van spannende thrillers tot hilarische komedies!
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>