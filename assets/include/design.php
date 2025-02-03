<?php
require_once __DIR__ . '/../../autorisation/db.php';

// Récupérer tous les projets de design
$stmt = $conn->prepare("SELECT * FROM designprojects ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$projets = $result->fetch_all(MYSQLI_ASSOC);

// Fonction pour sécuriser l'affichage
function safe_html($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets de Design - Mon Portfolio</title>
    <meta name="description" content="Découvrez mes projets de design créatifs et innovants. Explorez mon portfolio et trouvez l'inspiration.">
    <meta name="keywords" content="design, projets, portfolio, créatif, artistique">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Votre Nom">
    <meta property="og:title" content="Projets de Design - Mon Portfolio">
    <meta property="og:description" content="Découvrez mes projets de design créatifs et innovants. Explorez mon portfolio et trouvez l'inspiration.">
    <meta property="og:image" content="<?= safe_html($projets[0]['photo']) ?>">
    <meta property="og:url" content="https://votre-site.com/portfolio/design.php">
    <link rel="stylesheet" href="/portfolio/assets/css/style.css">
</head>
<body>
    <?php include './cdn.php'; ?>

    <div class="dev-container">
    <div class="return">
            <a href="/portfolio/index.php"><i class='bx bx-arrow-back'></i></a>
            <h2>Design Projects</h2>

        </div>
        <hr>

        <div class="cards-container">
            <?php if($projets): ?>
                <?php foreach($projets as $projet): ?>
                    <div class="card">
                            <?php 
                            $file_extension = strtolower(pathinfo($projet['photo'], PATHINFO_EXTENSION));
                            $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                            $video_extensions = ['mp4', 'avi', 'mov'];

                            if (in_array($file_extension, $image_extensions)): ?>
                                <img class="cardstyle" src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>">
                            <?php elseif (in_array($file_extension, $video_extensions)): ?>
                                <video class="cardstyle" src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" controls autoplay muted></video>
                            <?php endif; ?>

                            <div class="card-content">
                                <h2  class="card-title"><?= safe_html($projet['titre']) ?></h2>
                                <p class="card-description"><?= safe_html($projet['description']) ?></p>
                                <a href="<?= safe_html($projet['lien']) ?>" class="card-button" target="_blank">Review Project</a>
                            </div>
                        </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-projects">
                    <p>Aucun projet de design n'a été ajouté pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>
</body>
</html>
