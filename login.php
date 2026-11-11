
<?php
session_start();
require_once 'config/database.php';

$pageTitle = 'Жүйеге кіру | TripWise';
$bodyClass = 'auth-page';
$headerType = 'auth';
$footerText = '© 2026 TripWise';

$message = '';

if (isset($_GET['registered'])) {
    $message = 'Тіркелу сәтті аяқталды! Енді жүйеге кіріңіз.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $message = 'Email мен құпиясөзді енгізіңіз!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email мекенжайы дұрыс емес!';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header('Location: dashboard.php');
            exit;
        } else {
            $message = 'Email немесе құпиясөз қате!';
        }
    }
}

include 'includes/header.php';
?>

<main class="auth-container">
    <section class="auth-card">
        <p class="eyebrow">ҚАЙТА ҚОШ КЕЛДІҢ!</p>
        <h1>Жүйеге кіру</h1>
        <p class="auth-description">Саяхат жоспарларыңды жалғастыр.</p>

        <?php if ($message !== ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Электрондық пошта</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="example@email.com"
                required
            >

            <label for="password">Құпиясөз</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Құпиясөзіңді енгіз"
                required
            >

            <button type="submit" class="btn auth-submit">Кіру</button>
        </form>

        <p class="auth-switch">
            Аккаунтың жоқ па? <a href="register.php">Тіркелу</a>
        </p>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
