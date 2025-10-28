<?php
// Script om handmatig gebruikers toe te voegen aan database
require_once '../includes/db-connection.php';

echo "<h2>Gebruikers Toevoegen aan Database</h2>";

// Controleer huidige gebruikers
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
$current_count = $stmt->fetch()['count'];
echo "Huidige aantal gebruikers: $current_count<br><br>";

// Voeg testgebruikers toe
$test_users = [
    ['admin', 'admin@streamflix.nl', 'admin', 'admin'],
    ['demo_user', 'demo@streamflix.nl', 'demo123', 'member'],
    ['john_doe', 'john@example.com', 'password123', 'member'],
    ['jane_smith', 'jane@example.com', 'password123', 'member'],
    ['test_admin', 'testadmin@streamflix.nl', 'admin123', 'admin']
];

foreach ($test_users as $user) {
    try {
        // Check if user already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$user[0]]);
        
        if ($stmt->fetchColumn() == 0) {
            // User doesn't exist, add them
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $user[0],
                $user[1],
                password_hash($user[2], PASSWORD_DEFAULT),
                $user[3]
            ]);
            echo "✅ Gebruiker '{$user[0]}' toegevoegd.<br>";
        } else {
            echo "ℹ️ Gebruiker '{$user[0]}' bestaat al.<br>";
        }
    } catch (PDOException $e) {
        echo "❌ Fout bij toevoegen van '{$user[0]}': " . $e->getMessage() . "<br>";
    }
}

// Toon alle gebruikers na toevoegen
echo "<br><h3>Alle Gebruikers in Database:</h3>";
try {
    $stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; width: 100%;'>";
    echo "<tr style='background: #333; color: white;'><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created At</th></tr>";
    foreach ($users as $user) {
        $bg = $user['role'] === 'admin' ? 'background: #ffe6cc;' : 'background: #f8f9fa;';
        echo "<tr style='$bg'>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td><strong>" . htmlspecialchars($user['username']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td><span style='padding: 2px 8px; border-radius: 4px; " . 
             ($user['role'] === 'admin' ? 'background: #ffc107; color: #000;' : 'background: #6c757d; color: white;') . 
             "'>" . ucfirst($user['role']) . "</span></td>";
        echo "<td>" . $user['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><strong>Totaal: " . count($users) . " gebruikers</strong>";
    
} catch (PDOException $e) {
    echo "❌ Fout bij ophalen gebruikers: " . $e->getMessage();
}

echo "<br><br><a href='admin.php?section=users'>→ Ga naar Admin Users Panel</a>";
echo "<br><a href='account.php'>← Terug naar Account</a>";
?>