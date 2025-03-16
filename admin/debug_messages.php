<?php
session_start();
require_once '../autorisation/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Définir l'encodage de la connexion
mysqli_set_charset($conn, "utf8mb4");

// Afficher la structure de la table
echo "<h2>Structure de la table messages</h2>";
$result = mysqli_query($conn, "SHOW CREATE TABLE messages");
if ($result) {
    $row = mysqli_fetch_array($result);
    echo "<pre>" . htmlspecialchars($row[1]) . "</pre>";
} else {
    echo "Erreur lors de l'affichage de la structure de la table: " . mysqli_error($conn);
}

// Afficher les valeurs possibles pour le statut
echo "<h2>Valeurs possibles pour le statut</h2>";
$result = mysqli_query($conn, "SHOW COLUMNS FROM messages LIKE 'statut'");
if ($result) {
    $row = mysqli_fetch_array($result);
    echo "<pre>Type: " . htmlspecialchars($row['Type']) . "</pre>";
    echo "<pre>Default: " . htmlspecialchars($row['Default']) . "</pre>";
} else {
    echo "Erreur lors de l'affichage des valeurs possibles pour le statut: " . mysqli_error($conn);
}

// Afficher tous les messages avec leur statut
echo "<h2>Tous les messages</h2>";
$result = mysqli_query($conn, "SELECT id, nom, email, LEFT(message, 30) as message_preview, date_envoi, statut, HEX(statut) as statut_hex FROM messages ORDER BY date_envoi DESC");

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Message (aperçu)</th><th>Date d'envoi</th><th>Statut</th><th>Statut (HEX)</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['nom']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['message_preview']}...</td>";
        echo "<td>{$row['date_envoi']}</td>";
        echo "<td>{$row['statut']}</td>";
        echo "<td>{$row['statut_hex']}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Aucun message trouvé dans la base de données.";
}

// Tester l'insertion d'un message de test avec le statut explicitement défini
echo "<h2>Test d'insertion d'un message</h2>";
if (isset($_POST['test_insert'])) {
    $sql = "INSERT INTO messages (nom, email, message, date_envoi, statut) 
            VALUES ('Test', 'test@example.com', 'Message de test', NOW(), 'non traité')";
    
    if (mysqli_query($conn, $sql)) {
        echo "✅ Message de test inséré avec succès avec le statut 'non traité'.<br>";
        
        // Vérifier le statut du message inséré
        $id = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT statut, HEX(statut) as statut_hex FROM messages WHERE id = $id");
        $row = mysqli_fetch_assoc($result);
        echo "Statut du message inséré: {$row['statut']} (HEX: {$row['statut_hex']})<br>";
    } else {
        echo "❌ Erreur lors de l'insertion du message de test: " . mysqli_error($conn) . "<br>";
    }
}

// Formulaire pour tester l'insertion
echo "<form method='post'>";
echo "<button type='submit' name='test_insert'>Insérer un message de test</button>";
echo "</form>";

// Correction des messages existants
echo "<h2>Correction des messages existants</h2>";
if (isset($_POST['fix_messages'])) {
    $sql = "UPDATE messages SET statut = 'non traité' WHERE statut != 'non traité' AND statut != 'traité'";
    if (mysqli_query($conn, $sql)) {
        $affected_rows = mysqli_affected_rows($conn);
        if ($affected_rows > 0) {
            echo "✅ {$affected_rows} message(s) corrigés.<br>";
        } else {
            echo "✅ Aucun message à corriger.<br>";
        }
    } else {
        echo "❌ Erreur lors de la correction des messages: " . mysqli_error($conn) . "<br>";
    }
}

// Formulaire pour corriger les messages
echo "<form method='post'>";
echo "<button type='submit' name='fix_messages'>Corriger les messages existants</button>";
echo "</form>";

mysqli_close($conn);
?>
