<?php
session_start();

// Vérifier si l'utilisateur était connecté
$was_logged_in = isset($_SESSION['admin']);

// Supprimer toutes les variables de session
$_SESSION = array();

// Détruire le cookie de session si il existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion avec un message
$redirect_url = '/admin/login.php';
if ($was_logged_in) {
    $redirect_url .= '?message=logout_success';
}

header('Location: ' . $redirect_url);
exit;