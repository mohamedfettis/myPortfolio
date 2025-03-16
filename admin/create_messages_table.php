<?php
require_once __DIR__ . '/../autorisation/db.php';

// Vérifier si la table existe déjà
$table_exists = mysqli_query($conn, "SHOW TABLES LIKE 'messages'");

if (mysqli_num_rows($table_exists) > 0) {
    echo "✅ La table 'messages' existe déjà.";
} else {
    // Créer la table messages
    $sql = "CREATE TABLE messages (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
        statut ENUM('non traité', 'traité') DEFAULT 'non traité'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if (mysqli_query($conn, $sql)) {
        echo "✅ La table 'messages' a été créée avec succès.";
    } else {
        echo "❌ Erreur lors de la création de la table 'messages': " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
