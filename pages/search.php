<?php
// Start session for navbar
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db-connection.php';
require_once '../includes/security-helper.php';
include '../includes/header.php';

$search_term = SecurityHelper::sanitizeString($_GET['q'] ?? '', 100);

if (!empty($search_term)) {
    try {
        $stmt = $pdo->prepare("SELECT m.*, c.name as category_name 
                              FROM movies m 
                              JOIN categories c ON m.category_id = c.id 
                              WHERE m.title LIKE ? OR m.description LIKE ?
                              ORDER BY m.title");
        $search_param = "%{$search_term}%";
        $stmt->execute([$search_param, $search_param]);
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form action="search.php" method="get" class="d-flex">
                <input type="text" name="q" class="form-control bg-dark text-white border-secondary me-2" 
                       placeholder="Zoek films..." value="<?php echo htmlspecialchars($search_term); ?>" required>
                <button type="submit" class="btn btn-danger">Zoeken</button>
            </form>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif (!empty($search_term)): ?>
        <h2 class="mb-4">Zoekresultaten voor: "<?php echo htmlspecialchars($search_term); ?>"</h2>
        
        <?php if (empty($movies)): ?>
            <div class="alert alert-warning">Geen films gevonden voor "<?php echo htmlspecialchars($search_term); ?>".</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($movies as $movie): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 bg-dark text-white border-secondary movie-card">
                        <img src="<?php echo htmlspecialchars($movie['image_url']); ?>" class="card-img-top movie-thumbnail" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                            <p class="card-text">
                                <small class="text-muted"><?php echo htmlspecialchars($movie['category_name']); ?></small>
                            </p>
                            <p class="card-text">
                                <small>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $movie['rating']): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-muted"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </small>
                            </p>
                            <div class="mt-auto">
                                <a href="detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-danger w-100">Bekijk film</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <h2>Zoek naar je favoriete films</h2>
            <p class="text-muted">Voer een zoekterm in om te beginnen</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>