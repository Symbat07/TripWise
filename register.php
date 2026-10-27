<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тіркелу | TripWise</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">

<header class="header">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>
    <a href="index.php" class="login-link">← Басты бетке оралу</a>
</header>

<main class="auth-container">
    <section class="auth-card">
        <p class="eyebrow">САЯХАТЫҢДЫ БАСТА</p>
        <h1>Аккаунт құру</h1>
        <p class="auth-description">Өз саяхаттарыңды жоспарлауға қосыл.</p>

        <form>
            <label for="name">Аты-жөнің</label>
            <input type="text" id="name" placeholder="Атыңды енгіз" required>

            <label for="email">Электрондық пошта</label>
            <input type="email" id="email" placeholder="example@email.com" required>

            <label for="password">Құпиясөз</label>
            <input type="password" id="password" placeholder="Құпиясөз ойлап тап" required>

            <button type="submit" class="btn auth-submit">Тіркелу</button>
        </form>

        <p class="auth-switch">
            Аккаунтың бар ма? <a href="login.php">Жүйеге кіру</a>
        </p>
    </section>
</main>

<footer class="footer">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>
    <p>© 2026 TripWise</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>