<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../autorisation/db.php';

// Fonction pour gérer l'upload de fichier
function handle_file_upload($type) {
    if (!isset($_FILES[$type.'_photo']) || $_FILES[$type.'_photo']['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    $upload_dir = __DIR__ . '/../assets/imgs/projects/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $file_extension = strtolower(pathinfo($_FILES[$type.'_photo']['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }
    $new_filename = uniqid($type.'_') . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;
    if (move_uploaded_file($_FILES[$type.'_photo']['tmp_name'], $upload_path)) {
        return '/../assets/imgs/projects/' . $new_filename;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['dev_submit'])) {
        // Traitement du formulaire de développement
        $titre = trim($_POST['dev_titre']);
        $description = trim($_POST['dev_description']);
        $lien = trim($_POST['dev_lien']);
        $photo = handle_file_upload('dev');

        if($photo) {
            $stmt = $conn->prepare("INSERT INTO devprojects (titre, description, lien, photo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $titre, $description, $lien, $photo);
            if($stmt->execute()) {
                $dev_success = "Projet de développement ajouté avec succès!";
            } else {
                $dev_error = "Erreur lors de l'ajout du projet : " . $stmt->error;
            }
        } else {
            $dev_error = "Erreur lors de l'upload de l'image";
        }
    }
    elseif(isset($_POST['design_submit'])) {
        // Traitement du formulaire de design
        $titre = trim($_POST['design_titre']);
        $description = trim($_POST['design_description']);
        $lien = trim($_POST['design_lien']);
        $photo = handle_file_upload('design');

        if($photo) {
            $stmt = $conn->prepare("INSERT INTO designprojects (titre, description, lien, photo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $titre, $description, $lien, $photo);
            if($stmt->execute()) {
                $design_success = "Projet de design ajouté avec succès!";
            } else {
                $design_error = "Erreur lors de l'ajout du projet : " . $stmt->error;
            }
        } else {
            $design_error = "Erreur lors de l'upload de l'image";
        }
    }
}

// Récupérer tous les projets de développement
$stmt = $conn->prepare("SELECT * FROM devprojects ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$dev_projets = $result->fetch_all(MYSQLI_ASSOC);

// Récupérer tous les projets de design
$stmt = $conn->prepare("SELECT * FROM designprojects ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$design_projets = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/../assets/css/admin.css" rel="stylesheet">
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: -300px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        .notification.success {
            background-color: #28a745;
        }
        .notification.error {
            background-color: #dc3545;
        }
        .image-preview {
            transition: all 0.3s ease;
        }
        .image-preview:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Administration</h1>
            <div>
                <a href="admin_messages.php" class="btn btn-primary me-2">Gestion des Messages</a>
                <a href="/admin/logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>

        <!-- Formulaire pour les projets de développement -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-4">Ajouter un projet de développement</h3>
                
                <?php if(isset($dev_success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($dev_success) ?></div>
                <?php endif; ?>
                
                <?php if(isset($dev_error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($dev_error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="dev_titre" class="form-label">Titre</label>
                        <input type="text" id="dev_titre" name="dev_titre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dev_description" class="form-label">Description</label>
                        <textarea name="dev_description" id="dev_description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="dev_lien" class="form-label">Lien</label>
                        <input type="url" id="dev_lien" name="dev_lien" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dev_photo" class="form-label">Photo/Video</label>
                        <input type="file" id="dev_photo" name="dev_photo" class="form-control" accept="image/*,video/*" required>
                    </div>
                    <button type="submit" name="dev_submit" class="btn btn-primary">Ajouter le projet de développement</button>
                </form>
            </div>
        </div>

        <!-- Formulaire pour les projets de design -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-4">Ajouter un projet de design</h3>
                
                <?php if(isset($design_success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($design_success) ?></div>
                <?php endif; ?>
                
                <?php if(isset($design_error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($design_error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="design_titre" class="form-label">Titre</label>
                        <input type="text" id="design_titre" name="design_titre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="design_description" class="form-label">Description</label>
                        <textarea name="design_description" id="design_description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="design_lien" class="form-label">Lien</label>
                        <input type="url" id="design_lien" name="design_lien" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="design_photo" class="form-label">Photo/Video</label>
                        <input type="file" id="design_photo" name="design_photo" class="form-control" accept="image/*,video/*" required>
                    </div>
                    <button type="submit" name="design_submit" class="btn btn-primary">Ajouter le projet de design</button>
                </form>
            </div>
        </div>

        <!-- Liste des projets de développement -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-4">Liste des projets de développement</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="d-none d-md-table-cell">ID</th>
                                <th scope="col">Titre</th>
                                <th scope="col" class="d-none d-lg-table-cell">Description</th>
                                <th scope="col" class="d-none d-md-table-cell">Lien</th>
                                <th scope="col">Photo/Video</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dev_projets as $projet): ?>
                            <tr>
                                <td class="d-none d-md-table-cell"><?= htmlspecialchars($projet['id']) ?></td>
                                <td>
                                    <span class="fw-bold"><?= htmlspecialchars($projet['titre']) ?></span>
                                    <div class="d-lg-none small text-muted">
                                        <?= substr(htmlspecialchars($projet['description']), 0, 50) ?>...
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell"><?= htmlspecialchars($projet['description']) ?></td>
                                <td class="d-none d-md-table-cell">
                                    <a href="<?= htmlspecialchars($projet['lien']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> Voir
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                    $file_extension = strtolower(pathinfo($projet['photo'], PATHINFO_EXTENSION));
                                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                        <img src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                    <?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov'])): ?>
                                        <video src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" style="max-width: 80px; max-height: 80px;" controls muted></video>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/admin/edit_project.php?type=dev&id=<?= $projet['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Modifier</span>
                                        </a>
                                        <a href="/admin/delete_project.php?type=dev&id=<?= $projet['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                            <i class="fas fa-trash-alt"></i> <span class="d-none d-md-inline">Supprimer</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Liste des projets de design -->
        <div class="card shadow">
            <div class="card-body">
                <h3 class="mb-4">Liste des projets de design</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="d-none d-md-table-cell">ID</th>
                                <th scope="col">Titre</th>
                                <th scope="col" class="d-none d-lg-table-cell">Description</th>
                                <th scope="col" class="d-none d-md-table-cell">Lien</th>
                                <th scope="col">Photo/Video</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($design_projets as $projet): ?>
                            <tr>
                                <td class="d-none d-md-table-cell"><?= htmlspecialchars($projet['id']) ?></td>
                                <td>
                                    <span class="fw-bold"><?= htmlspecialchars($projet['titre']) ?></span>
                                    <div class="d-lg-none small text-muted">
                                        <?= substr(htmlspecialchars($projet['description']), 0, 50) ?>...
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell"><?= htmlspecialchars($projet['description']) ?></td>
                                <td class="d-none d-md-table-cell">
                                    <a href="<?= htmlspecialchars($projet['lien']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> Voir
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                    $file_extension = strtolower(pathinfo($projet['photo'], PATHINFO_EXTENSION));
                                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                        <img src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                    <?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov'])): ?>
                                        <video src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" style="max-width: 80px; max-height: 80px;" controls muted></video>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/admin/edit_project.php?type=design&id=<?= $projet['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Modifier</span>
                                        </a>
                                        <a href="/admin/delete_project.php?type=design&id=<?= $projet['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                            <i class="fas fa-trash-alt"></i> <span class="d-none d-md-inline">Supprimer</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/../assets/js/admin.js"></script>
</body>
</html>