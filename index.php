<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripWise — Саяхат жоспарлаушы</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>

    <nav>
        <a href="index.php">Басты бет</a>
        <a href="#features">Мүмкіндіктер</a>
        <a href="#about">Біз туралы</a>
    </nav>

    <div class="header-buttons">
        <a href="login.php" class="login-link">Кіру</a>
        <a href="register.php" class="btn btn-small">Тіркелу</a>
    </div>
</header>

<main>
    <section class="hero">
        <div class="hero-content">
            <p class="eyebrow">САЯХАТЫҢДЫ БҮГІН ЖОСПАРЛА</p>
            <h1>Әлемді аш.<br><span>Өз жолыңды таңда.</span></h1>
            <p class="hero-text">
                Армандаған сапарыңды жоспарла, баратын жерлеріңді сақта
                және саяхатыңды бір жерде ұйымдастыр.
            </p>

            <div class="hero-buttons">
                <a href="register.php" class="btn">Саяхатты жоспарлау ↗</a>
                <a href="#features" class="btn btn-light">Толығырақ</a>
            </div>

            <div class="hero-note">
                <span>✦</span> Жоспарла. Саяхатта. Естелік жина.
            </div>
        </div>

        <div class="hero-image">
            <div class="image-overlay">
                <span>✈</span>
                <div>
                    <strong>Келесі аялдамаң қайда?</strong>
                    <p>Саяхат жаңа мүмкіндіктер ашады</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-heading">
            <p class="eyebrow">TRIPWISE МҮМКІНДІКТЕРІ</p>
            <h2>Саяхаттың әр сәтін жоспарла</h2>
            <p>Барлық жоспарың бір жерде.</p>
        </div>

        <div class="feature-grid">
            <article class="feature-card">
                <div class="feature-icon">🌍</div>
                <h3>Бағыттарды сақтау</h3>
                <p>Барғың келетін қалалар мен орындарды бір жерге жина.</p>
            </article>

            <article class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Күндерді жоспарлау</h3>
                <p>Сапар күндерін белгілеп, саяхатыңды алдын ала ұйымдастыр.</p>
            </article>

            <article class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Бюджетті есептеу</h3>
                <p>Саяхатқа бөлетін қаражатыңды жоспарла.</p>
            </article>
        </div>
    </section>

    <section class="about" id="about">
        <div>
            <p class="eyebrow">СЕНІҢ САЯХАТЫҢ — СЕНІҢ ЕРЕЖЕҢ</p>
            <h2>Жоспарлау оңай болғанда, саяхат та ерекше.</h2>
        </div>
        <a href="register.php" class="btn">Бастау ↗</a>
    </section>
</main>

<footer class="footer">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>
    <p>Саяхаттарыңды жоспарла, естеліктеріңді жина.</p>
    <p>© 2026 TripWise</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>