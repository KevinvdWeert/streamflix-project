<?php
// Update movie images with online URLs
require_once 'includes/db-connection.php';

echo "<h2>Movie Images Update - Van Lokale naar Online URLs</h2>";

try {
    // Array met movie updates (title => nieuwe image URL)
    $movie_updates = [
        'Inception' => 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg',
        'The Hangover' => 'https://image.tmdb.org/t/p/w500/cs36xSvuVKBW8qz1qjbVe9yRNxf.jpg',
        'The Shawshank Redemption' => 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg',
        'John Wick' => 'https://image.tmdb.org/t/p/w500/fZPSd91yGE9fCcCe6OoQr6E3Bev.jpg',
        'Mad Max: Fury Road' => 'https://image.tmdb.org/t/p/w500/hA2ple9q4qnwxp3hKVNhroipsir.jpg',
        'The Dark Knight' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
        'Avengers: Endgame' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
        'Gladiator' => 'https://image.tmdb.org/t/p/w500/ty8TGRuvJLPUmAR1H1nRIsgwvim.jpg',
        'Superbad' => 'https://image.tmdb.org/t/p/w500/ek8e8txUyUwd2BNqj6lFEerJfbq.jpg',
        'Anchorman' => 'https://image.tmdb.org/t/p/w500/7LAk3Kd0nHJdH8VrhECIlfut1eb.jpg',
        'Step Brothers' => 'https://image.tmdb.org/t/p/w500/wRR62XfbHbDvKOq4YydMr28HLpJ.jpg',
        'Tropic Thunder' => 'https://image.tmdb.org/t/p/w500/zAurB9mNxfYRoVrVjAJJwGV3ePG.jpg',
        'Zoolander' => 'https://image.tmdb.org/t/p/w500/qdrbSneHZjJG2Dj0hhBxzzAo4HB.jpg',
        'The Godfather' => 'https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg',
        'Forrest Gump' => 'https://image.tmdb.org/t/p/w500/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg',
        'Pulp Fiction' => 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg',
        'Schindler\'s List' => 'https://image.tmdb.org/t/p/w500/sF1U4EUQS8YHUYjNl3pMGNIQyr0.jpg',
        '12 Years a Slave' => 'https://image.tmdb.org/t/p/w500/xdANQijuNrJaw1HA61rDccME4Tm.jpg',
        'Get Out' => 'https://image.tmdb.org/t/p/w500/tFXcEccSQMf3lfhfXKSU9iRBma3.jpg',
        'A Quiet Place' => 'https://image.tmdb.org/t/p/w500/nAU74GmpUk7t5iklEp3bufwDq4n.jpg',
        'Hereditary' => 'https://image.tmdb.org/t/p/w500/p81a0FyNE0Se4dTxi5CwXYcPGKh.jpg',
        'The Conjuring' => 'https://image.tmdb.org/t/p/w500/wVYREutTvI2tmxr6ujrHT704wGF.jpg',
        'Blade Runner 2049' => 'https://image.tmdb.org/t/p/w500/gajva2L0rPYkEWjzgFlBXCAVBE5.jpg',
        'The Matrix' => 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
        'Interstellar' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
        'Dune' => 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg',
        'The Notebook' => 'https://image.tmdb.org/t/p/w500/qom1SZSENdmHFNZBXbtJAU0WTlC.jpg',
        'Titanic' => 'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg',
        'La La Land' => 'https://image.tmdb.org/t/p/w500/uDO8zWDhfWwoFdKS4fzkUJt0Rf0.jpg',
        'Gone Girl' => 'https://image.tmdb.org/t/p/w500/gdiLTof3rbPDAmPaCf4g6op46bj.jpg',
        'Se7en' => 'https://image.tmdb.org/t/p/w500/69Sns8WoET6CfaYlIkHbla4l7nC.jpg',
        'Shutter Island' => 'https://image.tmdb.org/t/p/w500/4GDy0PHYX3VRXUtwK5ysFbg3kEx.jpg',
        'Toy Story' => 'https://image.tmdb.org/t/p/w500/uXDfjJbdP4ijW5hWSBrPrlKpxab.jpg',
        'Finding Nemo' => 'https://image.tmdb.org/t/p/w500/eHuGQ10FUzK1mdOY69wF5pGgEf5.jpg',
        'The Lion King' => 'https://image.tmdb.org/t/p/w500/sKCr78MXSLixwmZ8DyJLrpMsd15.jpg',
        'Spider-Man: Into the Spider-Verse' => 'https://image.tmdb.org/t/p/w500/iiZZdoQBEYBv6id8su7ImL0oCbD.jpg',
        'Goodfellas' => 'https://image.tmdb.org/t/p/w500/aKuFiU82s5ISJpGZp7YkIr3kCUd.jpg',
        'The Departed' => 'https://image.tmdb.org/t/p/w500/nT97ifVT2J1yMQmeq20Qblg61T.jpg',
        'Casino' => 'https://image.tmdb.org/t/p/w500/4TS5O1vmaZVltvh4t8ZoWPAZfO8.jpg'
    ];
    
    $updated_count = 0;
    
    // Update elke movie met nieuwe image URL
    foreach ($movie_updates as $title => $image_url) {
        $stmt = $pdo->prepare("UPDATE movies SET image = ? WHERE title = ?");
        $result = $stmt->execute([$image_url, $title]);
        
        if ($result && $stmt->rowCount() > 0) {
            $updated_count++;
            echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 5px; margin: 5px 0;'>";
            echo "✅ Bijgewerkt: <strong>{$title}</strong>";
            echo "</div>";
        } else {
            echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 5px; margin: 5px 0;'>";
            echo "⚠️ Niet gevonden: <strong>{$title}</strong>";
            echo "</div>";
        }
    }
    
    echo "<div style='background: #e7f3ff; border: 1px solid #bee5eb; padding: 10px; margin: 10px 0;'>";
    echo "<strong>📊 Resultaten:</strong><br>";
    echo "Totaal films bijgewerkt: {$updated_count} van " . count($movie_updates) . "<br>";
    echo "Alle film posters gebruiken nu online URLs van TMDb!";
    echo "</div>";
    
    // Toon een preview van enkele bijgewerkte films
    $stmt = $pdo->query("SELECT id, title, image FROM movies WHERE image LIKE 'https://image.tmdb.org%' LIMIT 5");
    $sample_movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($sample_movies) > 0) {
        echo "<div style='background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px 0;'>";
        echo "<strong>🎬 Preview van bijgewerkte films:</strong><br><br>";
        
        foreach ($sample_movies as $movie) {
            echo "<div style='display: inline-block; margin: 10px; text-align: center; width: 150px;'>";
            echo "<img src='{$movie['image']}' style='width: 100px; height: 150px; object-fit: cover; border-radius: 8px;' alt='{$movie['title']}'><br>";
            echo "<small><strong>{$movie['title']}</strong></small>";
            echo "</div>";
        }
        
        echo "</div>";
    }
    
} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; margin: 10px 0;'>";
    echo "<strong>❌ Database Fout:</strong> " . $e->getMessage();
    echo "</div>";
}
?>

<div style="margin-top: 20px;">
    <a href="home.php" style="text-decoration: none; background: #007bff; color: white; padding: 10px 15px; border-radius: 5px;">🎬 Bekijk Films</a>
    <a href="pages/admin.php" style="text-decoration: none; background: #28a745; color: white; padding: 10px 15px; border-radius: 5px; margin-left: 10px;">⚙️ Admin Panel</a>
    <a href="test-database-structure.php" style="text-decoration: none; background: #6c757d; color: white; padding: 10px 15px; border-radius: 5px; margin-left: 10px;">🔍 Database Info</a>
</div>