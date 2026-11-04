
<?php
$pageTitle = 'Менің саяхаттарым | TripWise';
$headerType = 'dashboard';
$footerText = '© 2026 TripWise';

$search = trim($_GET['search'] ?? '');

$trips = [
    [
        'title' => 'Стамбулға саяхат',
        'place' => 'Стамбул, Түркия',
        'date' => '15–20 наурыз',
        'budget' => '250 000 ₸',
        'status' => 'Жоспарланған',
        'picture' => 'trip-one'
    ],
    [
        'title' => 'Бали аралы',
        'place' => 'Бали, Индонезия',
        'date' => 'Күні белгіленбеген',
        'budget' => 'Әлі белгіленбеген',
        'status' => 'Армандағы бағыт',
        'picture' => 'trip-two'
    ]
];

include 'includes/header.php';
?>

<main class="dashboard">
    <div class="dashboard-heading">
        <div>
            <p class="eyebrow">ЖЕКЕ КАБИНЕТ</p>
            <h1>Менің саяхаттарым</h1>
            <p>Келесі саяхатыңды жоспарлауға дайынсың ба?</p>
        </div>

        <button class="btn" id="add-trip">+ Саяхат қосу</button>
    </div>

    <form method="GET" action="dashboard.php">
        <input
            type="search"
            name="search"
            placeholder="Саяхатты іздеу..."
            value="<?= htmlspecialchars($search) ?>"
        >
        <button type="submit" class="btn">Іздеу</button>
        <a href="dashboard.php">Тазалау</a>
    </form>

    <div class="trip-grid">
        <?php
        $found = false;

        foreach ($trips as $trip):
            $searchText = $trip['title'] . ' ' . $trip['place'];

            if (
                $search === '' ||
                stripos($searchText, $search) !== false
            ):
                $found = true;
        ?>
            <article class="trip-card">
                <div class="trip-picture <?= htmlspecialchars($trip['picture']) ?>"></div>

                <div class="trip-info">
                    <span class="trip-status">
                        <?= htmlspecialchars($trip['status']) ?>
                    </span>

                    <h2><?= htmlspecialchars($trip['title']) ?></h2>
                    <p>📍 <?= htmlspecialchars($trip['place']) ?></p>
                    <p>📅 <?= htmlspecialchars($trip['date']) ?></p>
                    <p>💰 Бюджет: <?= htmlspecialchars($trip['budget']) ?></p>

                    <button type="button" class="btn trip-button">
                        Толығырақ
                    </button>
                </div>
            </article>
        <?php
            endif;
        endforeach;

        if (!$found):
        ?>
            <p>Іздеу бойынша саяхат табылмады.</p>
        <?php endif; ?>
    </div>

    <p id="dashboard-message"></p>
</main>

<?php include 'includes/footer.php'; ?>
