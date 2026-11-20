
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])
    ) {
        die('Қате сұраныс! Қауіпсіздік тексерісінен өтпеді.');
    }

    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("
            DELETE FROM trips
            WHERE id = ? AND user_id = ?
        ");

        $stmt->execute([$id, $_SESSION['user_id']]);
    }
}

header('Location: dashboard.php');
exit;
