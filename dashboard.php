<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'config/database.php';

$pageTitle = 'Менің саяхаттарым | TripWise';
$headerType = 'dashboard';
$footerText = '© 2026 TripWise';



$search = trim($_GET['search'] ?? '');

$country = trim($_GET['country'] ?? '');
$sort = $_GET['sort'] ?? 'newest';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;

$sortOptions = [
    'newest' => 'trips.created_at DESC',
    'budget_asc' => 'trips.budget ASC',
    'budget_desc' => 'trips.budget DESC'
];

$orderBy = $sortOptions[$sort] ?? $sortOptions['newest'];

$countryStmt = $pdo->prepare("
    SELECT DISTINCT destinations.country
    FROM trips
    LEFT JOIN destinations
        ON trips.destination_id = destinations.id
    WHERE trips.user_id = ?
    AND destinations.country IS NOT NULL
    ORDER BY destinations.country ASC
");

$countryStmt->execute([$_SESSION['user_id']]);

$countries = $countryStmt->fetchAll(PDO::FETCH_COLUMN);

$sql = "
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
";

$params = [$_SESSION['user_id']];

if ($search !== '') {
    $sql .= "
        AND (
            trips.title LIKE ?
            OR destinations.name LIKE ?
            OR destinations.country LIKE ?
        )
    ";

    $keyword = '%' . $search . '%';

    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
}

if ($country !== '') {
    $sql .= " AND destinations.country = ?";
    $params[] = $country;
}

$countSql = "SELECT COUNT(*) FROM (" . $sql . ") AS total_trips";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);

$totalTrips = $countStmt->fetchColumn();

$totalPages = max(1, ceil($totalTrips / $limit));

$sql .= " ORDER BY $orderBy LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

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

    <select name="country">
        <option value="">Барлық елдер</option>

        <?php foreach ($countries as $item): ?>
            <option
                value="<?= htmlspecialchars($item) ?>"
                <?= $country === $item ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($item) ?>
            </option>
        <?php endforeach; ?>
    </select>


    <select name="sort">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>
            Бюджет
        </option>

        <option value="budget_asc" <?= $sort === 'budget_asc' ? 'selected' : '' ?>>
            Бюджет: өсу ретімен
        </option>

        <option value="budget_desc" <?= $sort === 'budget_desc' ? 'selected' : '' ?>>
            Бюджет: кему ретімен
        </option>
    </select>


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
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
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


    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?= http_build_query([
                    'search' => $search,
                    'country' => $country,
                    'sort' => $sort,
                    'page' => $page - 1
                ]) ?>">
                    ← Алдыңғы
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a
                    href="?<?= http_build_query([
                        'search' => $search,
                        'country' => $country,
                        'sort' => $sort,
                        'page' => $i
                    ]) ?>"
                    class="<?= $page === $i ? 'active' : '' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?<?= http_build_query([
                    'search' => $search,
                    'country' => $country,
                    'sort' => $sort,
                    'page' => $page + 1
                ]) ?>">
                    Келесі →
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <p id="dashboard-message"></p>
</main>

<?php include 'includes/footer.php'; ?>
