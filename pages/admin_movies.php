<?php
// Movies Management Section
require_once '../includes/security-helper.php';

// Handle movie operations
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_movie':
                // Sanitize movie inputs
                $title = SecurityHelper::sanitizeString($_POST['title'] ?? '', 200);
                $description = SecurityHelper::sanitizeString($_POST['description'] ?? '', 1000);
                $image = SecurityHelper::sanitizeString($_POST['image'] ?? '', 500);
                $video_url = SecurityHelper::sanitizeString($_POST['video_url'] ?? '', 500);
                $category_id = SecurityHelper::sanitizeInt($_POST['category_id'] ?? '', 1);
                
                if (empty($title) || empty($description) || $category_id === false) {
                    $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-circle me-2'></i>Alle verplichte velden moeten ingevuld zijn.</div>";
                } else {
                    try {
                        $stmt = $pdo->prepare("INSERT INTO movies (title, description, image, video_url, category_id) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([
                            $title,
                            $description,
                            $image,
                            $video_url,
                            $category_id
                        ]);
                        $message = "<div class='alert alert-success'><i class='bi bi-check-circle me-2'></i>Film succesvol toegevoegd!</div>";
                    } catch (PDOException $e) {
                        $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-circle me-2'></i>Fout: " . htmlspecialchars($e->getMessage()) . "</div>";
                    }
                }
                break;
                
            case 'update_movie':
                // Sanitize movie inputs for update
                $movie_id = SecurityHelper::sanitizeInt($_POST['movie_id'] ?? '', 1);
                $title = SecurityHelper::sanitizeString($_POST['title'] ?? '', 200);
                $description = SecurityHelper::sanitizeString($_POST['description'] ?? '', 1000);
                $image = SecurityHelper::sanitizeString($_POST['image'] ?? '', 500);
                $video_url = SecurityHelper::sanitizeString($_POST['video_url'] ?? '', 500);
                $category_id = SecurityHelper::sanitizeInt($_POST['category_id'] ?? '', 1);
                
                if ($movie_id === false || empty($title) || empty($description) || $category_id === false) {
                    $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-circle me-2'></i>Alle verplichte velden moeten ingevuld zijn.</div>";
                } else {
                    try {
                        $stmt = $pdo->prepare("UPDATE movies SET title = ?, description = ?, image = ?, video_url = ?, category_id = ? WHERE id = ?");
                        $stmt->execute([
                            $title,
                            $description,
                            $image,
                            $video_url,
                            $category_id,
                            $movie_id
                        ]);
                        $message = "<div class='alert alert-success'><i class='bi bi-check-circle me-2'></i>Film succesvol bijgewerkt!</div>";
                    } catch (PDOException $e) {
                        $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-circle me-2'></i>Fout: " . htmlspecialchars($e->getMessage()) . "</div>";
                    }
                }
                break;
        }
    }
}

// Handle movie deletion
$delete_id = SecurityHelper::sanitizeInt($_GET['delete'] ?? '', 1);
if ($delete_id !== false) {
    try {
        $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$delete_id]);
        $message = "<div class='alert alert-success'><i class='bi bi-check-circle me-2'></i>Film succesvol verwijderd!</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-circle me-2'></i>Fout bij verwijderen: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Handle edit movie request
$edit_movie = null;
$edit_id = SecurityHelper::sanitizeInt($_GET['edit'] ?? '', 1);
if ($edit_id !== false) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_movie = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-circle me-2'></i>Fout bij laden van film: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Get all movies
try {
    $stmt = $pdo->query("SELECT m.*, c.name as category FROM movies m LEFT JOIN categories c ON m.category_id = c.id ORDER BY m.id DESC");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = $e->getMessage();
}
?>

<?php if ($message) echo $message; ?>

<div class="row g-4">
    
    <!-- Add/Edit Movie Form -->
    <div class="col-xl-4 col-lg-5">
        <div class="admin-form-section">
            <h3>
                <i class="bi bi-<?= $edit_movie ? 'pencil' : 'plus-circle' ?> me-2"></i>
                <?= $edit_movie ? 'Film Bewerken' : 'Film Toevoegen' ?>
            </h3>
            <?php if ($edit_movie): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Je bewerkt: <strong><?= htmlspecialchars($edit_movie['title']) ?></strong>
                    <a href="?section=movies" class="btn btn-sm btn-outline-secondary ms-2">Annuleren</a>
                </div>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="action" value="<?= $edit_movie ? 'update_movie' : 'add_movie' ?>">
                <?php if ($edit_movie): ?>
                    <input type="hidden" name="movie_id" value="<?= $edit_movie['id'] ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-film me-1"></i>Titel
                    </label>
                    <input type="text" name="title" 
                           value="<?= $edit_movie ? htmlspecialchars($edit_movie['title']) : '' ?>"
                           class="form-control bg-dark text-white border-secondary" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-file-text me-1"></i>Beschrijving
                    </label>
                    <textarea name="description" rows="4" class="form-control bg-dark text-white border-secondary" required><?= $edit_movie ? htmlspecialchars($edit_movie['description']) : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-image me-1"></i>Afbeelding
                    </label>
                    <input type="text" name="image" 
                           value="<?= $edit_movie ? htmlspecialchars($edit_movie['image']) : '' ?>"
                           class="form-control bg-dark text-white border-secondary" 
                           placeholder="bijv. movie_poster.jpg" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-play-circle me-1"></i>Video URL
                    </label>
                    <input type="text" name="video_url" 
                           value="<?= $edit_movie ? htmlspecialchars($edit_movie['video_url']) : '' ?>"
                           class="form-control bg-dark text-white border-secondary" 
                           placeholder="assets/videos/movie.mp4" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-tags me-1"></i>Categorie
                    </label>
                    <select name="category_id" class="form-select bg-dark text-white border-secondary" required>
                        <option value="">Selecteer categorie...</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" 
                                    <?= ($edit_movie && $edit_movie['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-<?= $edit_movie ? 'primary' : 'success' ?> w-100">
                    <i class="bi bi-<?= $edit_movie ? 'check-circle' : 'plus-circle' ?> me-2"></i>
                    <?= $edit_movie ? 'Film Bijwerken' : 'Film Toevoegen' ?>
                </button>
                <?php if ($edit_movie): ?>
                    <a href="?section=movies" class="btn btn-secondary w-100 mt-2">
                        <i class="bi bi-x-circle me-2"></i>Annuleren
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Movies List -->
    <div class="col-xl-8 col-lg-7">
        <div class="admin-content-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-collection me-2"></i>Films Beheer (<?= count($movies) ?> films)
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                        </button>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titel</th>
                                <th>Categorie</th>
                                <th>Beschrijving</th>
                                <th>Afbeelding</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($movies)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-film text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2 mb-0">Geen films gevonden</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($movies as $movie): ?>
                                <tr>
                                    <td><?= $movie['id'] ?></td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($movie['title']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($movie['category'] ?? 'Geen categorie') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small><?= substr(htmlspecialchars($movie['description']), 0, 60) ?>...</small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= htmlspecialchars($movie['image']) ?></small>
                                    </td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <a href="?section=movies&edit=<?= $movie['id'] ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Bewerken">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-info" title="Bekijken">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <a href="?section=movies&delete=<?= $movie['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Verwijderen"
                                               onclick="return confirm('Weet je zeker dat je deze film wilt verwijderen?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Management -->
<div class="row mt-4">
    <div class="col-12">
        <div class="admin-content-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-tags me-2"></i>Categorieën Beheer
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($categories as $category): ?>
                                <span class="badge bg-secondary fs-6 py-2 px-3">
                                    <?= htmlspecialchars($category['name']) ?>
                                    <button class="btn btn-sm ms-2 p-0" style="color: inherit;">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control bg-dark text-white border-secondary" 
                                   placeholder="Nieuwe categorie...">
                            <button class="btn btn-success" type="button">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>