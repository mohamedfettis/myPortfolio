<?php
declare(strict_types=1);
session_start();

ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1'); 
ini_set('session.use_strict_mode', '1');

require_once __DIR__ . '/./db.php';

function authenticate(): void {
    if (empty($_SESSION['admin'])) {
        header('Location: /admin/login.php');
        exit;
    }

    if (!isset($_SESSION['generated']) || $_SESSION['generated'] < (time() - 3600)) {
        session_regenerate_id(true);
        $_SESSION['generated'] = time();
    }

    $fingerprint = hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'], hash('sha256', $_SERVER['REMOTE_ADDR'], true));
    
    if (!isset($_SESSION['fingerprint']) || $_SESSION['fingerprint'] !== $fingerprint) {
        session_destroy();
        header('Location: /admin/login.php?error=hacking');
        exit;
    }

    // Vérification en base de données (prévention compte supprimé)
    try {
        global $conn;
        $stmt = $conn->prepare("SELECT 1 FROM admin WHERE id = ? AND username = ?");
        $stmt->execute([$_SESSION['admin']['id'], $_SESSION['admin']['username']]);
        
        if (!$stmt->fetchColumn()) {
            session_destroy();
            header('Location: /admin/login.php?error=not_found');
            exit;
        }
    } catch(PDOException $e) {
        error_log('Auth error: ' . $e->getMessage());
        session_destroy();
        header('Location: /admin/login.php?error=db');
        exit;
    }
}

try {
    authenticate();
} catch(Exception $e) {
    error_log('Authentication system error: ' . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    exit('Une erreur critique est survenue');
}