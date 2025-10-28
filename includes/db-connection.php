<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'streamflix');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Controleer of benodigde tabellen bestaan, zo niet maak ze aan
    ensureDatabaseStructure($pdo);
    
} catch (PDOException $e) {
    die("Database verbinding mislukt: " . $e->getMessage());
}

function ensureDatabaseStructure($pdo) {
    try {
        // Controleer of users tabel bestaat
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() == 0) {
            // Maak users tabel aan
            $pdo->exec("CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL DEFAULT '',
                password VARCHAR(255) NOT NULL,
                role ENUM('member','admin') DEFAULT 'member',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            
            // Voeg default admin user toe
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@streamflix.nl', password_hash('admin', PASSWORD_DEFAULT), 'admin']);
        } else {
            // Check en voeg missende kolommen toe
            $stmt = $pdo->query("DESCRIBE users");
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Voeg email kolom toe als deze niet bestaat
            if (!in_array('email', $columns)) {
                $pdo->exec("ALTER TABLE users ADD COLUMN email VARCHAR(100) NOT NULL DEFAULT '' AFTER username");
                // Update bestaande users met email
                $pdo->exec("UPDATE users SET email = CONCAT(username, '@streamflix.nl') WHERE email = ''");
            }
            
            // Voeg created_at kolom toe als deze niet bestaat  
            if (!in_array('created_at', $columns)) {
                $pdo->exec("ALTER TABLE users ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER role");
            }
        }
        
        // Controleer en maak movies tabel als nodig
        $stmt = $pdo->query("SHOW TABLES LIKE 'movies'");
        if ($stmt->rowCount() == 0) {
            // Maak movies tabel aan
            $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL
            )");
            
            $pdo->exec("CREATE TABLE IF NOT EXISTS movies (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(200) NOT NULL,
                description TEXT,
                image VARCHAR(500),
                video_url VARCHAR(255),
                category_id INT,
                FOREIGN KEY (category_id) REFERENCES categories(id)
            )");
            
            $pdo->exec("CREATE TABLE IF NOT EXISTS ratings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                movie_id INT,
                rating DECIMAL(2,1),
                votes INT DEFAULT 0,
                FOREIGN KEY (movie_id) REFERENCES movies(id)
            )");
        }
        
        // Update image column length for URLs
        $stmt = $pdo->query("DESCRIBE movies");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $col) {
            if ($col['Field'] === 'image' && strpos($col['Type'], '255') !== false) {
                $pdo->exec("ALTER TABLE movies MODIFY image VARCHAR(500)");
                break;
            }
        }

        // Zorg ervoor dat er minimaal wat gebruikers bestaan
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        $user_count = $stmt->fetchColumn();
        
        if ($user_count == 0) {
            // Voeg standaard gebruikers toe (met IGNORE om duplicates te voorkomen)
            $default_users = [
                ['admin', 'admin@streamflix.nl', 'admin', 'admin'],
                ['demo_user', 'demo@streamflix.nl', 'demo123', 'member'],
                ['john_doe', 'john@example.com', 'password123', 'member'],
                ['jane_smith', 'jane@example.com', 'password123', 'member']
            ];
            
            $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            foreach ($default_users as $user) {
                try {
                    $stmt->execute([
                        $user[0], 
                        $user[1], 
                        password_hash($user[2], PASSWORD_DEFAULT), 
                        $user[3]
                    ]);
                } catch (PDOException $e) {
                    // Ignore duplicate entry errors
                    if ($e->getCode() != '23000') {
                        throw $e;
                    }
                }
            }
        }
        
        // Zorg dat admin user bestaat (altijd controleren)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute(['admin', 'admin@streamflix.nl', password_hash('admin', PASSWORD_DEFAULT), 'admin']);
            } catch (PDOException $e) {
                // Ignore duplicate entry errors
                if ($e->getCode() != '23000') {
                    throw $e;
                }
            }
        }
        
    } catch (PDOException $e) {
        error_log("Database structure check failed: " . $e->getMessage());
    }
}
?>