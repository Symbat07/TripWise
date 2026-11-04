
<?php
$pageTitle = 'Тіркелу | TripWise';
$bodyClass = 'auth-page';
$headerType = 'auth';
$footerText = '© 2026 TripWise';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $message = 'Барлық өрісті толтырыңыз!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email мекенжайы дұрыс емес!';
    } elseif (strlen($password) < 8) {
        $message = 'Құпиясөз кемінде 8 таңбадан тұруы керек!';
    } else {
        $message = 'Деректер дұрыс енгізілді! Тіркелуді сақтау 11-аптада қосылады.';
    }
}

include 'includes/header.php';
?>

<main class="auth-container">
    <section class="auth-card">
        <p class="eyebrow">САЯХАТЫҢДЫ БАСТА</p>
        <h1>Аккаунт құру</h1>
        <p class="auth-description">Өз саяхаттарыңды жоспарлауға қосыл.</p>

        <?php if ($message !== ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <label for="name">Аты-жөнің</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Атыңды енгіз"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                required
            >

            <label for="email">Электрондық пошта</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="example@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
            >

            <label for="password">Құпиясөз</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Құпиясөз ойлап тап"
                required
            >

            <button type="submit" class="btn auth-submit">Тіркелу</button>
        </form>

        <p class="auth-switch">
            Аккаунтың бар ма? <a href="login.php">Жүйеге кіру</a>
        </p>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
