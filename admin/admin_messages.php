<?php
session_start();
require_once '../autorisation/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Traitement des actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Marquer comme traité
    if ($_GET['action'] === 'marquer_traite') {
        $sql = "UPDATE messages SET statut = 'traité' WHERE id = '$id'";
        mysqli_query($conn, $sql);
    }
    
    // Supprimer un message
    if ($_GET['action'] === 'supprimer') {
        $sql = "DELETE FROM messages WHERE id = '$id'";
        mysqli_query($conn, $sql);
    }
    
    // Rediriger pour éviter les soumissions multiples
    header("Location: admin_messages.php" . (isset($_GET['voir_tout']) ? '?voir_tout=1' : ''));
    exit();
}

// Déterminer le mode d'affichage
$voir_tout = isset($_GET['voir_tout']) ? true : false;

// Définir l'encodage de la connexion pour les caractères accentués
mysqli_set_charset($conn, "utf8mb4");

// Recherche
$recherche = isset($_GET['recherche']) ? trim($_GET['recherche']) : '';

// Construction de la requête de base
$where_conditions = [];

// Condition pour le statut
if (!$voir_tout) {
    $where_conditions[] = "statut = 'non traité'";
}

// Condition pour la recherche
if (!empty($recherche)) {
    $recherche = mysqli_real_escape_string($conn, $recherche);
    $where_conditions[] = "(nom LIKE '%$recherche%' OR email LIKE '%$recherche%')";
}

// Construction de la clause WHERE
$where_clause = '';
if (!empty($where_conditions)) {
    $where_clause = "WHERE " . implode(" AND ", $where_conditions);
}

// Requête complète
$sql = "SELECT * FROM messages $where_clause ORDER BY date_envoi DESC";

// Pagination
$messages_par_page = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$debut = ($page - 1) * $messages_par_page;

// Compter le nombre total de messages pour la pagination
$count_sql = "SELECT COUNT(*) FROM messages $where_clause";
$count_result = mysqli_query($conn, $count_sql);

if ($count_result) {
    $total_messages = mysqli_fetch_array($count_result)[0];
    $total_pages = ceil($total_messages / $messages_par_page);
} else {
    // En cas d'erreur dans la requête
    $total_messages = 0;
    $total_pages = 1;
    error_log("Erreur SQL: " . mysqli_error($conn));
}

// Ajouter la limite pour la pagination
$sql .= " LIMIT $debut, $messages_par_page";
$result = mysqli_query($conn, $sql);

if (!$result) {
    error_log("Erreur SQL: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des Messages - Portfolio</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #00a78e;
            --secondary-color: #f8f9fa;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-header {
            background-color: var(--dark-color);
            color: white;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-bottom: 4px solid var(--primary-color);
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .admin-nav {
            display: flex;
            gap: 15px;
            margin-top: 1rem;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .message-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .message-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        
        .message-content {
            background-color: #f9f9f9;
            overflow: auto;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        .message-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .status-badge {
            position: absolute;
            top:25px;
            right: 20px;
            margin-right: 6rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.5rem;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .non-traite {
            background-color: var(--danger-color);
            color: white;
        }
        
        .traite {
            background-color: var(--success-color);
            color: white;
        }
        
        .search-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
        }
        
        .pagination a, .pagination span {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .pagination a {
            background-color: var(--primary-color);
            color: white;
        }
        
        .pagination a:hover {
            background-color: #008e78;
            transform: translateY(-2px);
        }
        
        .pagination span {
            background-color: #e9ecef;
            color: #6c757d;
        }
        
        .filter-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #008e78;
        }
        
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #218838;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .alert {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        
        .form-control {
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 167, 142, 0.25);
            outline: none;
        }
        
        .sender-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sender-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .date-info {
            color: #6c757d;
            font-size: 0.85rem;
        }
        
        .message-count {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1><i class="fas fa-envelope"></i> Gestion des Messages</h1>
            <div class="admin-nav">
                <a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
                <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </header>
        
        <main class="admin-content">
            <!-- En-tête avec statistiques -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-dark text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4>Messages
                                    <?php if (!$voir_tout): ?>
                                        non traités
                                    <?php endif; ?>
                                </h4>
                                <p class="mb-0">
                                    <?php 
                                    // Compter le nombre total de messages
                                    $count_all = mysqli_query($conn, "SELECT COUNT(*) FROM messages");
                                    $total_all = mysqli_fetch_array($count_all)[0];
                                    
                                    // Compter le nombre de messages non traités
                                    $count_unprocessed = mysqli_query($conn, "SELECT COUNT(*) FROM messages WHERE statut = 'non traité'");
                                    $total_unprocessed = mysqli_fetch_array($count_unprocessed)[0];
                                    
                                    echo "<span class='message-count'>$total_unprocessed</span> messages non traités sur un total de <span class='message-count'>$total_all</span> messages";
                                    ?>
                                </p>
                            </div>
                            <div class="filter-buttons">
                                <a href="admin_messages.php" class="btn <?php echo !$voir_tout ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    <i class="fas fa-filter"></i> Messages non traités
                                </a>
                                <a href="admin_messages.php?voir_tout=1" class="btn <?php echo $voir_tout ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    <i class="fas fa-list"></i> Voir tout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Barre de recherche -->
            <div class="search-container mb-4">
                <form action="" method="GET" class="row g-3">
                    <?php if ($voir_tout): ?>
                        <input type="hidden" name="voir_tout" value="1">
                    <?php endif; ?>
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="recherche" placeholder="Rechercher par nom ou email" value="<?php echo htmlspecialchars($recherche); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Rechercher</button>
                    </div>
                </form>
            </div>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <!-- Liste des messages -->
                <div class="messages-container">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="message-card">
                            <span class="status-badge <?php echo $row['statut'] === 'non traité' ? 'non-traite' : 'traite'; ?>">
                                <i class="fas <?php echo $row['statut'] === 'non traité' ? 'fa-clock' : 'fa-check'; ?>"></i>
                                <?php echo htmlspecialchars($row['statut']); ?>
                            </span>
                            
                            <div class="message-header">
                                <div class="sender-info">
                                    <div class="sender-avatar">
                                        <?php echo strtoupper(substr($row['nom'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong><?php echo htmlspecialchars($row['nom']); ?></strong><br>
                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a>
                                    </div>
                                </div>
                                <div class="date-info">
                                    <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($row['date_envoi'])); ?><br>
                                    <i class="far fa-clock"></i> <?php echo date('H:i', strtotime($row['date_envoi'])); ?>
                                </div>
                            </div>
                            
                            <div class="message-content">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </div>
                            
                            <div class="message-actions">
                                <?php if ($row['statut'] === 'non traité'): ?>
                                    <a href="admin_messages.php?action=marquer_traite&id=<?php echo $row['id']; ?><?php echo $voir_tout ? '&voir_tout=1' : ''; ?>" class="btn btn-success">
                                        <i class="fas fa-check"></i> Marquer comme traité
                                    </a>
                                <?php endif; ?>
                                <a href="admin_messages.php?action=supprimer&id=<?php echo $row['id']; ?><?php echo $voir_tout ? '&voir_tout=1' : ''; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?><?php echo $voir_tout ? '&voir_tout=1' : ''; ?><?php echo !empty($recherche) ? '&recherche=' . urlencode($recherche) : ''; ?>">
                                <i class="fas fa-chevron-left"></i> Précédent
                            </a>
                        <?php else: ?>
                            <span><i class="fas fa-chevron-left"></i> Précédent</span>
                        <?php endif; ?>
                        
                        <?php 
                        // Afficher un nombre limité de pages
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        if ($start_page > 1) {
                            echo '<a href="?page=1' . ($voir_tout ? '&voir_tout=1' : '') . (!empty($recherche) ? '&recherche=' . urlencode($recherche) : '') . '">1</a>';
                            if ($start_page > 2) {
                                echo '<span>...</span>';
                            }
                        }
                        
                        for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <?php if ($i == $page): ?>
                                <span><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; ?><?php echo $voir_tout ? '&voir_tout=1' : ''; ?><?php echo !empty($recherche) ? '&recherche=' . urlencode($recherche) : ''; ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; 
                        
                        if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                                echo '<span>...</span>';
                            }
                            echo '<a href="?page=' . $total_pages . ($voir_tout ? '&voir_tout=1' : '') . (!empty($recherche) ? '&recherche=' . urlencode($recherche) : '') . '">' . $total_pages . '</a>';
                        }
                        ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?><?php echo $voir_tout ? '&voir_tout=1' : ''; ?><?php echo !empty($recherche) ? '&recherche=' . urlencode($recherche) : ''; ?>">
                                Suivant <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span>Suivant <i class="fas fa-chevron-right"></i></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucun message <?php echo !$voir_tout ? 'non traité' : ''; ?> trouvé.
                </div>
            <?php endif; ?>
        </main>
        
        <footer class="mt-5 text-center text-muted">
            <p><small>&copy; <?php echo date('Y'); ?> - Système de gestion des messages</small></p>
        </footer>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
