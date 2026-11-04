
<?php
$pageTitle = 'TripWise — Саяхат жоспарлаушы';
$headerType = 'home';
$footerText = 'Саяхаттарыңды жоспарла, естеліктеріңді жина.';

include 'includes/header.php';
?>

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

<?php include 'includes/footer.php'; ?>
