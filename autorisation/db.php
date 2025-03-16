<?php
$hostname = "sql301.infinityfree.com";
$username = "if0_37789755";
$password = "EZkYAsVpsN";
$db = "if0_37789755_portfolio";

// Connexion à la base de données
$conn = mysqli_connect($hostname, $username, $password, $db);

// Vérifier la connexion
if (!$conn) {
    die("❌ Connexion échouée : " . mysqli_connect_error());
} 

?>
