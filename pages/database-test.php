<?php
session_start();
require_once '../includes/db-connection.php';

echo "<h2>Database Test & User Data</h2>";

// Test database connectie
echo "<h3>Database Connectie:</h3>";
try {
    $pdo->query("SELECT 1");
    echo "✅ Database connectie werkt!<br>";
} catch (PDOException $e) {
    echo "❌ Database connectie mislukt: " . $e->getMessage() . "<br>";
}

// Test users tabel
echo "<h3>Users Tabel Test:</h3>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch()['count'];
    echo "✅ Users tabel bestaat. Aantal gebruikers: $count<br>";
    
    // Toon alle gebruikers
    $stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created At</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
        echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "❌ Users tabel fout: " . $e->getMessage() . "<br>";
}

// Test huidige sessie
echo "<h3>Sessie Informatie:</h3>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Niet ingesteld') . "<br>";
echo "Username: " . ($_SESSION['username'] ?? 'Niet ingesteld') . "<br>";
echo "Role: " . ($_SESSION['role'] ?? 'Niet ingesteld') . "<br>";

// Test admin credentials
echo "<h3>Admin Credentials Test:</h3>";
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
$stmt->execute();
$admin_user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin_user) {
    echo "✅ Admin user bestaat in database<br>";
    echo "Admin ID: " . $admin_user['id'] . "<br>";
    echo "Admin Email: " . $admin_user['email'] . "<br>";
    echo "Admin Role: " . $admin_user['role'] . "<br>";
    
    // Test password verificatie
    if (password_verify('admin', $admin_user['password'])) {
        echo "✅ Admin wachtwoord 'admin' werkt correct<br>";
    } else {
        echo "❌ Admin wachtwoord werkt niet<br>";
    }
} else {
    echo "❌ Admin user bestaat niet in database<br>";
}

// Test andere tabellen
echo "<h3>Andere Tabellen:</h3>";
$tables = ['categories', 'movies', 'ratings'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
        $count = $stmt->fetch()['count'];
        echo "✅ Tabel '$table' bestaat. Records: $count<br>";
    } catch (PDOException $e) {
        echo "⚠️ Tabel '$table': " . $e->getMessage() . "<br>";
    }
}

echo "<br><a href='account.php'>← Terug naar Account</a>";
echo "<br><a href='admin.php'>→ Naar Admin Panel</a>";
?>