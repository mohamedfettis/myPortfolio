

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../autorisation/db.php';

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
    <meta name="description" content="Portfolio de développement web de Mohamed Fettis : découvrez mes projets React JS, sites responsives et applications interactives. Expertise en HTML5, CSS3, JavaScript et intégration frontend.">
    <meta name="keywords" content="développement, projets, portfolio, web, solutions">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Mohamed Fettis">
    <meta property="og:title" content="Projets de Développement - Mohamed Fettis">
    <meta property="og:description" content="Portfolio de développement web de Mohamed Fettis : découvrez mes projets React JS, sites responsives et applications interactives.">
    <meta property="og:image" content="<?= safe_html($projets[0]['photo']) ?>">
    <meta property="og:url" content="https://fettis.ct.ws/development">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Portfolio de Mohamed Fettis">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@moha98fts">
    <link rel="stylesheet" href="/../assets/css/style.css">

    <!-- Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">
</head>
<body style="background-color: var(--bg-color);">
  

    <div class="design-container">
        
        <div class="return" >
            <a href="/../index.php#projects"><i class='bx bx-arrow-back'></i></a>
            <h1>Development Projects</h1>

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
                                <h3  class="card-title"><?= safe_html($projet['titre']) ?></h3>
                                <p class="card-description">Description:  <br> <?= safe_html($projet['description']) ?></p>
                                <a href="<?= safe_html($projet['lien']) ?>" class="card-button" target="_blank">Review Project</a>
                            </div>
                        </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-projects">
                    <p>Aucun projet de développement n'a été ajouté pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    
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
