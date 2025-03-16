<?php
require_once 'autorisation/db.php';

// Définir l'encodage de la connexion pour les caractères accentués
mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['name']) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $sujet = isset($_POST['subject']) ? mysqli_real_escape_string($conn, trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, trim($_POST['message'])) : '';
    
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom est requis";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }
    
    if (empty($sujet)) {
        $errors[] = "Le sujet est requis";
    }
    
    if (empty($message)) {
        $errors[] = "Le message est requis";
    }
    
    if (empty($errors)) {
        // Assurons-nous que le statut est explicitement défini comme 'non traité'
        $sql = "INSERT INTO messages (nom, email, message, date_envoi, statut) 
                VALUES ('$nom', '$email', '$message', NOW(), 'non traité')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?message_sent=success#contact");
            exit();
        } else {
            header("Location: index.php?message_sent=error#contact");
            exit();
        }
    } else {
        $error_string = implode(", ", $errors);
        header("Location: index.php?message_sent=validation_error&errors=" . urlencode($error_string) . "#contact");
        exit();
    }
} else {
    // Rediriger vers la page d'accueil si quelqu'un tente d'accéder directement à ce script
    header("Location: index.php");
    exit();
}
?>
