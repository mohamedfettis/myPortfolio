<!-- // Page de connexion pour les administrateurs    -->
<?php
session_start();
require_once __DIR__ . '/../autorisation/db.php';
require_once __DIR__ . '/../autorisation/functions.php';

// Si l'utilisateur est déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['admin'])) {
    header('Location: /portfolio/admin/dashboard.php');
    exit;
}

// Message de déconnexion
if (isset($_GET['message']) && $_GET['message'] === 'logout_success') {
    $success = "Vous avez été déconnecté avec succès.";
}

if (isset($_POST['addpost'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Débogage
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    if ($user && isset($user['password_hash']) && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin'] = [
            'id' => $user['id'],
            'username' => $user['username']
        ];
        header('Location: /portfolio/admin/dashboard.php');
        exit;
    }
    $error = "Identifiants incorrects";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Connexion Admin</h2>
                
                <?php if(isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    </div>
                    <button name="addpost" type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>