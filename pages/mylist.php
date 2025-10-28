<?php
// Start session before any output
session_start();

require_once '../includes/db-connection.php';
include '../includes/header.php';

// For demonstration, we'll simulate a user's watchlist
// In a real application, this would be stored in a database table

// Simulate some watchlist items (in real app, this would come from database)
$watchlist_ids = [1, 2, 3]; // These would be stored per user in database

if (!empty($watchlist_ids)) {
    $placeholders = str_repeat('?,', count($watchlist_ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id WHERE m.id IN ($placeholders)");
    $stmt->execute($watchlist_ids);
    $watchlist_movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $watchlist_movies = [];
}

// Get recommended movies (not in watchlist)
$stmt = $pdo->query("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id ORDER BY RAND() LIMIT 6");
$recommended_movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-danger">Mijn Lijst</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" onclick="sortList('title')">
                <i class="bi bi-sort-alpha-down"></i> Titel
            </button>
            <button class="btn btn-outline-secondary" onclick="sortList('date')">
                <i class="bi bi-calendar-date"></i> Toegevoegd
            </button>
        </div>
    </div>

    <?php if (empty($watchlist_movies)): ?>
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-bookmark-heart display-1 text-muted"></i>
            </div>
            <h3 class="text-muted mb-3">Je lijst is nog leeg</h3>
            <p class="text-secondary mb-4">Voeg films en series toe aan je lijst om ze later terug te kijken.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="movies.php" class="btn btn-danger">
                    <i class="bi bi-film me-2"></i>Browse Films
                </a>
                <a href="series.php" class="btn btn-outline-danger">
                    <i class="bi bi-tv me-2"></i>Browse Series
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Watchlist Items -->
        <div class="row g-4 mb-5">
            <?php foreach ($watchlist_movies as $movie): ?>
                <div class="col-12">
                    <div class="card bg-dark text-white border-0 shadow">
                        <div class="row g-0">
                            <div class="col-md-2">
                                <img src="../assets/img/<?= !empty($movie['image']) ? $movie['image'] : 'placeholder.jpg' ?>" 
                                     class="img-fluid h-100 w-100 object-fit-cover" alt="<?= htmlspecialchars($movie['title']) ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold mb-0"><?= htmlspecialchars($movie['title']) ?></h5>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($movie['category']) ?></span>
                                    </div>
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
                                        <span class="ms-2 small text-secondary"><?= number_format(rand(70, 98)/10, 1) ?>/10</span>
                                    </div>
                                    <p class="card-text"><?= htmlspecialchars($movie['description']) ?></p>
                                    <p class="card-text">
                                        <small class="text-secondary">
                                            <i class="bi bi-calendar-plus"></i> Toegevoegd op <?= date('d M Y', strtotime('-' . rand(1, 30) . ' days')) ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card-body d-flex flex-column h-100 justify-content-center">
                                    <div class="d-grid gap-2">
                                        <a href="detail.php?id=<?= $movie['id'] ?>" class="btn btn-danger">
                                            <i class="bi bi-play-fill"></i> Kijken
                                        </a>
                                        <button class="btn btn-outline-light" onclick="removeFromList(<?= $movie['id'] ?>)">
                                            <i class="bi bi-trash"></i> Verwijder
                                        </button>
                                        <button class="btn btn-outline-secondary">
                                            <i class="bi bi-share"></i> Delen
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Statistics -->
        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <div class="card bg-dark text-white border-secondary">
                    <div class="card-body text-center">
                        <i class="bi bi-collection-play display-6 text-danger"></i>
                        <h4 class="mt-2"><?= count($watchlist_movies) ?></h4>
                        <p class="text-secondary mb-0">Items in lijst</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white border-secondary">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history display-6 text-warning"></i>
                        <h4 class="mt-2"><?= count($watchlist_movies) * rand(90, 150) ?></h4>
                        <p class="text-secondary mb-0">Minuten content</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white border-secondary">
                    <div class="card-body text-center">
                        <i class="bi bi-star-fill display-6 text-success"></i>
                        <h4 class="mt-2"><?= number_format(rand(70, 95)/10, 1) ?></h4>
                        <p class="text-secondary mb-0">Gemiddelde rating</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white border-secondary">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-plus display-6 text-info"></i>
                        <h4 class="mt-2"><?= rand(1, 10) ?></h4>
                        <p class="text-secondary mb-0">Deze maand toegevoegd</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Recommended Section -->
    <div class="mb-5">
        <h2 class="fw-bold mb-3">Aanbevolen voor jou</h2>
        <div class="row g-4">
            <?php foreach ($recommended_movies as $movie): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card h-100 bg-dark text-white border-0 shadow">
                        <img src="../assets/img/<?= !empty($movie['image']) ? $movie['image'] : 'placeholder.jpg' ?>" 
                             class="card-img-top object-fit-cover" style="height: 200px;" alt="<?= htmlspecialchars($movie['title']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold"><?= htmlspecialchars($movie['title']) ?></h6>
                            <p class="card-text small text-secondary"><?= htmlspecialchars($movie['category']) ?></p>
                            <div class="mt-auto d-grid gap-1">
                                <button class="btn btn-outline-danger btn-sm" onclick="addToList(<?= $movie['id'] ?>)">
                                    <i class="bi bi-plus-circle me-1"></i>Toevoegen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function removeFromList(movieId) {
    if (confirm('Weet je zeker dat je deze film wilt verwijderen uit je lijst?')) {
        // In a real application, this would make an AJAX call to remove from database
        alert('Film verwijderd uit je lijst!');
        // Reload page to simulate removal
        location.reload();
    }
}

function addToList(movieId) {
    // In a real application, this would make an AJAX call to add to database
    alert('Film toegevoegd aan je lijst!');
}

function sortList(sortBy) {
    // In a real application, this would reload the page with sort parameters
    alert('Lijst gesorteerd op: ' + (sortBy === 'title' ? 'titel' : 'datum'));
}
</script>

<?php include '../includes/footer.php'; ?>