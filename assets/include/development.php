<?php
require_once __DIR__ . '/../../autorisation/db.php';

// Récupérer tous les projets de développement
$stmt = $conn->prepare("SELECT * FROM devprojects ORDER BY id DESC");
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
    <?php include 'cdn.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets de Développement - Mon Portfolio</title>
    <meta name="description" content="Explorez mes projets de développement web. Découvrez des solutions innovantes et créatives.">
    <meta name="keywords" content="développement, projets, portfolio, web, solutions">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Votre Nom">
    <meta property="og:title" content="Projets de Développement - Mon Portfolio">
    <meta property="og:description" content="Explorez mes projets de développement web. Découvrez des solutions innovantes et créatives.">
    <meta property="og:image" content="<?= safe_html($projets[0]['photo']) ?>">
    <meta property="og:url" content="https://votre-site.com/portfolio/development.php">
    <meta property="og:type" content="website">
    <!-- Boxicons -->
    
</head>
<body style="background-color: var(--bg-color);">
  

    <div class="design-container">
        
        <div class="return" >
            <a href="/portfolio/index.php"><i class='bx bx-arrow-back'></i></a>
            <h2>Development Projects</h2>

        </div>
        <hr>
     

        <div class="cards-container">
            <?php if($projets): ?>
                <?php foreach ($projets as $projet): ?>
                   
                        <div class="card">
                        <?php 
                                $file_extension = strtolower(pathinfo($projet['photo'], PATHINFO_EXTENSION));
                                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <img class="cardstyle" src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>">
                                <?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov'])): ?>
                                    <video class="cardstyle" src="<?= htmlspecialchars($projet['photo']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" controls autoplay muted></video>
                                <?php endif; ?>
                            <div class="card-content">
                                <h2  class="card-title"><?= safe_html($projet['titre']) ?></h2>
                                <p class="card-description"><?= safe_html($projet['description']) ?></p>
                                <a href="<?= safe_html($projet['lien']) ?>" class="card-button" target="_blank">Review Project</a>
                            </div>
                  </div>
                    <!-- <div class="card">
                        <img src="https://via.placeholder.com/300x200" alt="Image Card 3">
                        <div class="card-content">
                            <h2 class="card-title">Titre de la Carte 3</h2>
                            <p class="card-description">Description courte pour la troisième carte.</p>
                            <a href="#" class="card-button">Voir Plus</a>
                        </div>
                    </div> -->
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-projects">
                    <p>Aucun projet de développement n'a été ajouté pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>
</body>
</html>
