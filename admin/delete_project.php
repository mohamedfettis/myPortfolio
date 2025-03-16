<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: /portfolio/admin/login.php');
    exit;
}

require_once __DIR__ . '/../autorisation/db.php';

// Vérifier si on a l'ID et le type du projet
if (!isset($_GET['id']) || !isset($_GET['type']) || !in_array($_GET['type'], ['dev', 'design'])) {
    header('Location: dashboard.php');
    exit;
}

$id = $_GET['id'];
$type = $_GET['type'];
$table = $type === 'dev' ? 'devprojects' : 'designprojects';

// Récupérer le chemin de la photo avant la suppression
$stmt = $conn->prepare("SELECT photo FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$projet = $result->fetch_assoc();

if ($projet) {
    // Supprimer l'image du serveur
    $photo_path = __DIR__ . '/..' . $projet['photo'];
    if (file_exists($photo_path)) {
        unlink($photo_path);
    }

    // Supprimer le projet de la base de données
    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Rediriger vers le dashboard avec un message
header('Location: dashboard.php?message=delete_success');
exit;
