<?php
require_once __DIR__ . '/../autorisation/db.php';

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
    <meta name="description" content="Portfolio de design UI/UX de Mohamed Fettis : explorez mes maquettes Figma, interfaces utilisateur modernes et designs créatifs. Découvrez comment mes compétences en design enrichissent l'expérience utilisateur de mes projets web.">
    <meta name="keywords" content="design, projets, portfolio, créatif, artistique">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Mohamed Fettis">
    <meta property="og:title" content="Projets de Design UI/UX - Mohamed Fettis">
    <meta property="og:description" content="Portfolio de design UI/UX de Mohamed Fettis : explorez mes maquettes Figma, interfaces utilisateur modernes et designs créatifs.">
    <meta property="og:image" content="<?= safe_html($projets[0]['photo']) ?>">
    <meta property="og:url" content="https://fettis.ct.ws/design">
    <meta property="og:site_name" content="Portfolio de Mohamed Fettis">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@moha98fts">
    <link rel="stylesheet" href="/../assets/css/style.css">
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">
    <?php include './cdn.php'; ?>
</head>
<body>

    <div class="dev-container">
    <div class="return">
            <a href="/../index.php#projects"><i class='bx bx-arrow-back'></i></a>
            <h1>Design Projects</h1>

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
                                <h3  class="card-title"><?= safe_html($projet['titre']) ?></h3>
                                <p class="card-description">Description: <br><?= safe_html($projet['description']) ?></p>
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

    <?php include './footer.php'; ?>
    
    <!-- Scripts non bloquants avec defer -->
    <script defer src="/../assets/js/script.js"></script>
    
    <!-- Google Analytics - Chargé de manière asynchrone -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4EXGZ6DQJ3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-4EXGZ6DQJ3');
    </script>
</body>
</html>
