<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "portfolio";

// Connexion à la base de données
$conn = mysqli_connect($hostname, $username, $password, $db);

// Vérifier la connexion
if (!$conn) {
    die("❌ Connexion échouée : " . mysqli_connect_error());
} 

?>
