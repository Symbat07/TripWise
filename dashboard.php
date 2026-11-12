<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';

$pageTitle = 'Менің саяхаттарым | TripWise';
$headerType = 'dashboard';
$footerText = '© 2026 TripWise';


$search = trim($_GET['search'] ?? '');

$stmt = $pdo->prepare("
    SELECT
        trips.id,
        trips.title,
        CONCAT(destinations.name, ', ', destinations.country) AS place,
        CONCAT(
            DATE_FORMAT(trips.start_date, '%d.%m.%Y'),
            ' – ',
            DATE_FORMAT(trips.end_date, '%d.%m.%Y')
        ) AS date,
        CONCAT(FORMAT(trips.budget, 0), ' ₸') AS budget,
        'Жоспарланған' AS status,
        'trip-one' AS picture
    FROM trips
    LEFT JOIN destinations
        ON trips.destination_id = destinations.id
    WHERE trips.user_id = ?
    ORDER BY trips.created_at DESC
");

$stmt->execute([$_SESSION['user_id']]);

$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);


include 'includes/header.php';
?>

<main class="dashboard">
    <div class="dashboard-heading">
        <div>
            <p class="eyebrow">ЖЕКЕ КАБИНЕТ</p>
            <h1>Менің саяхаттарым</h1>
            <p>Келесі саяхатыңды жоспарлауға дайынсың ба?</p>
        </div>

        <a href="add_trip.php" class="btn" id="add-trip">+ Саяхат қосу</a>
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

                    <a href="edit_trip.php?id=<?= $trip['id'] ?>" class="btn trip-button">
                        Өңдеу
                    </a>
                    <form method="POST" action="delete_trip.php"
                          onsubmit="return confirm('Бұл саяхатты өшіргіңіз келе ме?');">
                        <input type="hidden" name="id" value="<?= $trip['id'] ?>">
                        <button type="submit" class="btn trip-button">
                            Өшіру
                        </button>
                    </form>
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
