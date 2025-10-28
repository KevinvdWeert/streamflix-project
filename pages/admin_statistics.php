<?php
// Statistics Section
try {
    // Get movie statistics
    $stmt = $pdo->query("SELECT c.name, COUNT(m.id) as movie_count FROM categories c 
                        LEFT JOIN movies m ON c.id = m.category_id 
                        GROUP BY c.id, c.name ORDER BY movie_count DESC");
    $categoryStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get ratings statistics
    $stmt = $pdo->query("SELECT m.title, r.rating, r.votes FROM movies m 
                        JOIN ratings r ON m.id = r.movie_id 
                        ORDER BY r.rating DESC LIMIT 10");
    $topRatedMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get total statistics
    $stmt = $pdo->query("SELECT 
        COUNT(DISTINCT m.id) as total_movies,
        COUNT(DISTINCT c.id) as total_categories,
        AVG(r.rating) as avg_rating,
        SUM(r.votes) as total_votes
        FROM movies m 
        LEFT JOIN categories c ON m.category_id = c.id 
        LEFT JOIN ratings r ON m.id = r.movie_id");
    $totalStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $error = $e->getMessage();
}

// Simulate additional statistics
$monthlyUsers = [
    'Jan' => 120, 'Feb' => 135, 'Mar' => 150, 'Apr' => 145, 
    'May' => 180, 'Jun' => 195, 'Jul' => 220, 'Aug' => 210, 
    'Sep' => 235, 'Oct' => 250, 'Nov' => 240, 'Dec' => 260
];

$deviceStats = [
    'Desktop' => 45,
    'Mobile' => 35,
    'Tablet' => 20
];
?>

<div class="row g-4">
    
    <!-- Overview Statistics -->
    <div class="col-12">
        <div class="stats-chart-container">
            <h4 class="text-danger mb-4">
                <i class="bi bi-graph-up me-2"></i>Platform Overzicht
            </h4>
            
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="display-4 text-danger mb-2"><?= $totalStats['total_movies'] ?></div>
                        <h6 class="text-muted">Totaal Films</h6>
                        <div class="stats-progress">
                            <div class="stats-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="display-4 text-warning mb-2"><?= $totalStats['total_categories'] ?></div>
                        <h6 class="text-muted">Categorieën</h6>
                        <div class="stats-progress">
                            <div class="stats-progress-bar" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="display-4 text-info mb-2"><?= number_format($totalStats['avg_rating'], 1) ?></div>
                        <h6 class="text-muted">Gemiddelde Rating</h6>
                        <div class="stats-progress">
                            <div class="stats-progress-bar" style="width: <?= ($totalStats['avg_rating'] / 10) * 100 ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="display-4 text-success mb-2"><?= number_format($totalStats['total_votes']) ?></div>
                        <h6 class="text-muted">Totaal Votes</h6>
                        <div class="stats-progress">
                            <div class="stats-progress-bar" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="col-lg-6">
        <div class="stats-chart-container">
            <h5 class="mb-4">
                <i class="bi bi-pie-chart me-2"></i>Films per Categorie
            </h5>
            
            <?php foreach ($categoryStats as $stat): ?>
                <?php $percentage = $totalStats['total_movies'] > 0 ? ($stat['movie_count'] / $totalStats['total_movies']) * 100 : 0; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold"><?= htmlspecialchars($stat['name']) ?></span>
                        <span class="text-muted"><?= $stat['movie_count'] ?> films (<?= round($percentage, 1) ?>%)</span>
                    </div>
                    <div class="stats-progress">
                        <div class="stats-progress-bar" style="width: <?= $percentage ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top Rated Movies -->
    <div class="col-lg-6">
        <div class="stats-chart-container">
            <h5 class="mb-4">
                <i class="bi bi-star me-2"></i>Best Beoordeelde Films
            </h5>
            
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Film</th>
                            <th>Rating</th>
                            <th>Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($topRatedMovies, 0, 8) as $index => $movie): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#<?= $index + 1 ?></span>
                            </td>
                            <td><?= htmlspecialchars($movie['title']) ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-1"><?= $movie['rating'] ?></span>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                            </td>
                            <td><?= number_format($movie['votes']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Monthly Users Growth -->
    <div class="col-lg-8">
        <div class="stats-chart-container">
            <h5 class="mb-4">
                <i class="bi bi-graph-up-arrow me-2"></i>Maandelijkse Gebruikersgroei
            </h5>
            
            <div class="row g-2">
                <?php foreach ($monthlyUsers as $month => $users): ?>
                    <?php $maxUsers = max($monthlyUsers); ?>
                    <?php $height = ($users / $maxUsers) * 100; ?>
                    <div class="col">
                        <div class="text-center">
                            <div class="position-relative" style="height: 150px;">
                                <div class="position-absolute bottom-0 w-100 bg-gradient" 
                                     style="height: <?= $height ?>%; background: linear-gradient(to top, var(--primary-color), #ff8a00); border-radius: 4px 4px 0 0;">
                                </div>
                            </div>
                            <small class="text-muted mt-1 d-block"><?= $month ?></small>
                            <small class="text-warning fw-bold"><?= $users ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Device Usage -->
    <div class="col-lg-4">
        <div class="stats-chart-container">
            <h5 class="mb-4">
                <i class="bi bi-devices me-2"></i>Apparaat Gebruik
            </h5>
            
            <?php foreach ($deviceStats as $device => $percentage): ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-<?= strtolower($device) === 'desktop' ? 'laptop' : (strtolower($device) === 'mobile' ? 'phone' : 'tablet') ?> me-2"></i>
                            <span><?= $device ?></span>
                        </div>
                        <span class="text-muted"><?= $percentage ?>%</span>
                    </div>
                    <div class="stats-progress">
                        <div class="stats-progress-bar" style="width: <?= $percentage ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="mt-4 p-3" style="background: rgba(0,0,0,0.2); border-radius: 8px;">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Gebaseerd op de laatste 30 dagen van gebruikersactiviteit
                </small>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-12">
        <div class="stats-chart-container">
            <h5 class="mb-4">
                <i class="bi bi-activity me-2"></i>Recente Activiteit
            </h5>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3" style="background: rgba(40, 167, 69, 0.1); border-radius: 8px; border-left: 4px solid #28a745;">
                        <i class="bi bi-film text-success me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <div class="fw-bold">5 nieuwe films toegevoegd</div>
                            <small class="text-muted">Laatste 7 dagen</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3" style="background: rgba(255, 193, 7, 0.1); border-radius: 8px; border-left: 4px solid #ffc107;">
                        <i class="bi bi-person-plus text-warning me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <div class="fw-bold">23 nieuwe gebruikers</div>
                            <small class="text-muted">Laatste 7 dagen</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3" style="background: rgba(220, 53, 69, 0.1); border-radius: 8px; border-left: 4px solid #dc3545;">
                        <i class="bi bi-star text-danger me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <div class="fw-bold">156 nieuwe reviews</div>
                            <small class="text-muted">Laatste 7 dagen</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3" style="background: rgba(13, 202, 240, 0.1); border-radius: 8px; border-left: 4px solid #0dcaf0;">
                        <i class="bi bi-eye text-info me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <div class="fw-bold">1,234 views vandaag</div>
                            <small class="text-muted">+15% t.o.v. gisteren</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>