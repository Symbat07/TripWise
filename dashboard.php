<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менің саяхаттарым | TripWise</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>
    <nav>
        <a href="index.php">Басты бет</a>
        <a href="dashboard.php">Менің саяхаттарым</a>
    </nav>
    <a href="login.php" class="login-link">Шығу</a>
</header>

<main class="dashboard">
    <div class="dashboard-heading">
        <div>
            <p class="eyebrow">ЖЕКЕ КАБИНЕТ</p>
            <h1>Менің саяхаттарым</h1>
            <p>Келесі саяхатыңды жоспарлауға дайынсың ба?</p>
        </div>
        <button class="btn" id="add-trip">+ Саяхат қосу</button>
    </div>

    <div class="trip-grid">
        <article class="trip-card">
            <div class="trip-picture trip-one"></div>
            <div class="trip-info">
                <span class="trip-status">Жоспарланған</span>
                <h2>Стамбулға саяхат</h2>
                <p>📍 Стамбул, Түркия</p>
                <p>📅 15–20 наурыз</p>
                <p>💰 Бюджет: 250 000 ₸</p>
                <button class="btn trip-button">Толығырақ</button>
            </div>
        </article>

        <article class="trip-card">
            <div class="trip-picture trip-two"></div>
            <div class="trip-info">
                <span class="trip-status">Армандағы бағыт</span>
                <h2>Бали аралы</h2>
                <p>📍 Бали, Индонезия</p>
                <p>📅 Күні белгіленбеген</p>
                <p>💰 Бюджет: Әлі белгіленбеген</p>
                <button class="btn trip-button">Толығырақ</button>
            </div>
        </article>
    </div>

    <p id="dashboard-message"></p>
</main>

<footer class="footer">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>
    <p>© 2026 TripWise</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>