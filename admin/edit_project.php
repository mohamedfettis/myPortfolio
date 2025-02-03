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
    header('Location: /portfolio/admin/dashboard.php');
    exit;
}

$id = $_GET['id'];
$type = $_GET['type'];
$table = $type === 'dev' ? 'devprojects' : 'designprojects';

// Récupérer les informations du projet
$stmt = $conn->prepare("SELECT * FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$projet = $result->fetch_assoc();

if (!$projet) {
    header('Location: /portfolio/admin/dashboard.php');
    exit;
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $lien = trim($_POST['lien']);
    
    // Vérifier si une nouvelle image a été uploadée
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../assets/imgs/projects/';
        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = uniqid($type.'_') . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                // Supprimer l'ancienne image si elle existe
                $old_photo_path = __DIR__ . '/..' . $projet['photo'];
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }
                $photo = '/portfolio/assets/imgs/projects/' . $new_filename;
                
                $stmt = $conn->prepare("UPDATE $table SET titre = ?, description = ?, lien = ?, photo = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $titre, $description, $lien, $photo, $id);
            }
        }
    } else {
        // Pas de nouvelle image, on garde l'ancienne
        $stmt = $conn->prepare("UPDATE $table SET titre = ?, description = ?, lien = ? WHERE id = ?");
        $stmt->bind_param("sssi", $titre, $description, $lien, $id);
    }
    
    if($stmt->execute()) {
        $success = "Projet modifié avec succès!";
    } else {
        $error = "Erreur lors de la modification du projet : " . $stmt->error;
    }
    
    // Recharger les informations du projet
    $stmt = $conn->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $projet = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier le projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Modifier le projet</h1>
            <a href="/portfolio/admin/dashboard.php" class="btn btn-secondary">Retour au dashboard</a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <?php if(isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" id="titre" name="titre" class="form-control" value="<?= htmlspecialchars($projet['titre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required><?= htmlspecialchars($projet['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="lien" class="form-label">Lien</label>
                        <input type="url" id="lien" name="lien" class="form-control" value="<?= htmlspecialchars($projet['lien']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo actuelle</label>
                        <img src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" style="max-width: 200px; display: block; margin-bottom: 10px;">
                        <input type="file" id="photo" name="photo" class="form-control" accept="image/*, video/*">
                        <small class="text-muted">Laissez vide pour garder l'image actuelle</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
