<?php
session_start();
require_once __DIR__ . '/../autorisation/db.php';
require_once __DIR__ . '/../autorisation/functions.php';

if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

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
    
    if ($user && isset($user['password_hash']) && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin'] = [
            'id' => $user['id'],
            'username' => $user['username']
        ];
        header('Location: dashboard.php');
        exit;
    }
    $error = "Identifiants incorrects";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <style>
    :root {
        --bg-color: #080808;
        --second-bg-color: #101010;
        --text-color: #fff;
        --main-color: #A3E635;
        --primary-color: #A3E635;
        --primary-hover: #84CC16;
        --text-dark: #333;
        --text-light: #fff;
        --success-bg: #d4edda;
        --success-text: #155724;
        --error-bg: #f8d7da;
        --error-text: #721c24;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    body {
        background: #f8f9fa;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 20px;
    }

    .login-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-content {
        padding: 2rem;
    }

    .login-title {
        text-align: center;
        font-size: 1.8rem;
        color: var(--text-dark);
        margin-bottom: 2rem;
    }

    .alert {
        padding: 12px;
        margin-bottom: 1.5rem;
        border-radius: 4px;
        font-size: 0.95rem;
    }

    .alert-success {
        background: var(--success-bg);
        color: var(--success-text);
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: var(--error-bg);
        color: var(--error-text);
        border: 1px solid #f5c6cb;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(238, 186, 43, 0.2);
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background: var(--primary-color);
        color: var(--text-light);
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background: var(--primary-hover);
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card-content">
                <h1 class="login-title">Connexion Admin</h1>
                
                <?php if(isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <input type="text" 
                               name="username" 
                               class="form-input" 
                               placeholder="Nom d'utilisateur" 
                               required>
                    </div>
                    <div class="form-group">
                        <input type="password" 
                               name="password" 
                               class="form-input" 
                               placeholder="Mot de passe" 
                               required>
                    </div>
                    <button type="submit" 
                            name="addpost" 
                            class="submit-btn">
                        Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>