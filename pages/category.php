<?php
// Start session for navbar
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db-connection.php';
require_once '../includes/security-helper.php';
include '../includes/header.php';

$category_id = SecurityHelper::sanitizeInt($_GET['id'] ?? '', 1);
$category_id = ($category_id !== false) ? $category_id : 0;

if ($category_id > 0) {
    try {
        // Get category name
        $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($category) {
            $category_name = $category['name'];
            
            // Get movies in this category
            $stmt = $pdo->prepare("SELECT m.*, c.name as category_name FROM movies m 
                                  JOIN categories c ON m.category_id = c.id 
                                  WHERE m.category_id = ?");
            $stmt->execute([$category_id]);
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-4">
    <h1 class="mb-4">Films in categorie: <?php echo htmlspecialchars($category_name); ?></h1>
    
    <?php if (count($movies) > 0): ?>
    <div class="row">
        <?php foreach ($movies as $movie): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 bg-dark text-white border-secondary movie-card">
                <img src="<?php echo htmlspecialchars($movie['image_url']); ?>" class="card-img-top movie-thumbnail" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
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
    <?php else: ?>
        <div class="alert alert-warning">Geen films gevonden in deze categorie.</div>
    <?php endif; ?>
</div>
<?php
        } else {
            echo "<div class='container py-4'><div class='alert alert-danger'>Categorie niet gevonden.</div></div>";
        }
    } catch (PDOException $e) {
        echo "<div class='container py-4'><div class='alert alert-danger'>Database fout: " . htmlspecialchars($e->getMessage()) . "</div></div>";
    }
} else {
    echo "<div class='container py-4'><div class='alert alert-danger'>Ongeldige categorie ID.</div></div>";
}

include '../includes/footer.php';
?>