<?php
require_once 'autorisation/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['name']) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
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
    
    if (empty($message)) {
        $errors[] = "Le message est requis";
    }
    
    if (empty($errors)) {
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
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>
