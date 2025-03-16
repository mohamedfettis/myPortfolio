<?php
require_once __DIR__ . '/../autorisation/db.php';

// Vérifier si la table existe
$table_exists = mysqli_query($conn, "SHOW TABLES LIKE 'messages'");

if (mysqli_num_rows($table_exists) > 0) {
    echo "✅ La table 'messages' existe.<br>";
    
    // Vérifier la structure de la colonne statut
    $column_info = mysqli_query($conn, "SHOW COLUMNS FROM messages LIKE 'statut'");
    $column = mysqli_fetch_assoc($column_info);
    
    if ($column) {
        echo "✅ La colonne 'statut' existe.<br>";
        
        // Vérifier si la valeur par défaut est correcte
        if ($column['Default'] === 'non traité') {
            echo "✅ La valeur par défaut de la colonne 'statut' est correcte ('non traité').<br>";
        } else {
            echo "❌ La valeur par défaut de la colonne 'statut' est incorrecte ('{$column['Default']}').<br>";
            
            // Modifier la colonne pour avoir la bonne valeur par défaut
            $alter_sql = "ALTER TABLE messages MODIFY COLUMN statut ENUM('non traité', 'traité') DEFAULT 'non traité'";
            
            if (mysqli_query($conn, $alter_sql)) {
                echo "✅ La colonne 'statut' a été modifiée avec succès pour avoir 'non traité' comme valeur par défaut.<br>";
            } else {
                echo "❌ Erreur lors de la modification de la colonne 'statut': " . mysqli_error($conn) . "<br>";
            }
        }
        
        // Vérifier si des messages ont un statut NULL ou vide et les corriger
        $update_sql = "UPDATE messages SET statut = 'non traité' WHERE statut IS NULL OR statut = ''";
        if (mysqli_query($conn, $update_sql)) {
            $affected_rows = mysqli_affected_rows($conn);
            if ($affected_rows > 0) {
                echo "✅ {$affected_rows} message(s) avec un statut NULL ou vide ont été corrigés.<br>";
            } else {
                echo "✅ Aucun message avec un statut NULL ou vide n'a été trouvé.<br>";
            }
        } else {
            echo "❌ Erreur lors de la mise à jour des messages avec un statut NULL ou vide: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "❌ La colonne 'statut' n'existe pas dans la table 'messages'.<br>";
    }
} else {
    echo "❌ La table 'messages' n'existe pas.<br>";
    
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
        echo "✅ La table 'messages' a été créée avec succès.<br>";
    } else {
        echo "❌ Erreur lors de la création de la table 'messages': " . mysqli_error($conn) . "<br>";
    }
}

// Afficher les messages actuels pour vérification
echo "<hr><h3>Messages actuels dans la base de données:</h3>";
$result = mysqli_query($conn, "SELECT id, nom, email, LEFT(message, 30) as message_preview, date_envoi, statut FROM messages ORDER BY date_envoi DESC");

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Message (aperçu)</th><th>Date d'envoi</th><th>Statut</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['nom']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['message_preview']}...</td>";
        echo "<td>{$row['date_envoi']}</td>";
        echo "<td>{$row['statut']}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Aucun message trouvé dans la base de données.";
}

mysqli_close($conn);
?>
