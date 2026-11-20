
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';

$pageTitle = 'Менің профилім | TripWise';
$headerType = 'dashboard';
$footerText = '© 2026 TripWise';

$userId = (int) $_SESSION['user_id'];
$message = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals(
        $_SESSION['csrf_token'],
        $_POST['csrf_token'] ?? ''
    )) {
        $message = 'Сұраныс расталмады. Қайта көріңіз!';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($name === '' || $email === '') {
            $message = 'Барлық өрісті толтырыңыз!';
        } elseif (mb_strlen($name) > 100) {
            $message = 'Аты-жөні 100 таңбадан аспауы керек!';

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Email мекенжайы дұрыс емес!';
        } else {
            $check = $pdo->prepare(
                "SELECT id FROM users WHERE email = ? AND id != ?"
            );

            $check->execute([$email, $userId]);

            if ($check->fetch()) {
                $message = 'Бұл email басқа аккаунтта қолданылып тұр!';
            } else {
                $update = $pdo->prepare(
                    "UPDATE users SET name = ?, email = ? WHERE id = ?"
                );

                $update->execute([$name, $email, $userId]);

                $_SESSION['user_name'] = $name;

                $message = 'Профиль сәтті жаңартылды!';
            }
        }
    }
}

$stmt = $pdo->prepare(
    "SELECT name, email FROM users WHERE id = ?"
);

$stmt->execute([$userId]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

include 'includes/header.php';
?>

<main class="auth-container">
    <section class="auth-card">
        <p class="eyebrow">ЖЕКЕ КАБИНЕТ</p>

        <h1>Менің профилім</h1>

        <p class="auth-description">
            Жеке мәліметтеріңді осы жерден басқара аласың.
        </p>

        <?php if ($message !== ''): ?>
            <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="POST" action="profile.php">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
            >

            <label for="name">Аты-жөнің</label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="email">Электрондық пошта</label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <button type="submit" class="btn auth-submit">
                Өзгерістерді сақтау
            </button>

        </form>

        <p class="auth-switch">
            <a href="dashboard.php">Саяхаттарыма оралу</a>
        </p>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
