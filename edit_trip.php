
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';

$pageTitle = 'Саяхатты өңдеу | TripWise';
$headerType = 'dashboard';
$footerText = '© 2026 TripWise';

$id = $_GET['id'] ?? 0;
$message = '';

$stmt = $pdo->prepare("
    SELECT trips.*, destinations.name AS destination,
           destinations.country
    FROM trips
    JOIN destinations ON trips.destination_id = destinations.id
    WHERE trips.id = ? AND trips.user_id = ?
");

$stmt->execute([$id, $_SESSION['user_id']]);
$trip = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$trip) {
    die('Саяхат табылмады!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $budget = $_POST['budget'] ?? '';

    if (
        $title === '' || $destination === '' || $country === '' ||
        $startDate === '' || $endDate === '' || $budget === ''
    ) {
        $message = 'Барлық өрісті толтырыңыз!';
    } elseif ($endDate < $startDate) {
        $message = 'Аяқталу күні басталу күнінен ерте болмауы керек!';
    } elseif (!is_numeric($budget) || $budget <= 0) {
        $message = 'Бюджетті дұрыс енгізіңіз!';
    } else {
        try {
            $pdo->beginTransaction();

            $destinationStmt = $pdo->prepare("
                UPDATE destinations
                SET name = ?, country = ?
                WHERE id = ?
            ");

            $destinationStmt->execute([
                $destination,
                $country,
                $trip['destination_id']
            ]);

            $tripStmt = $pdo->prepare("
                UPDATE trips
                SET title = ?, start_date = ?, end_date = ?, budget = ?
                WHERE id = ? AND user_id = ?
            ");

            $tripStmt->execute([
                $title,
                $startDate,
                $endDate,
                $budget,
                $id,
                $_SESSION['user_id']
            ]);

            $pdo->commit();

            header('Location: dashboard.php');
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = 'Өзгерістерді сақтау кезінде қате пайда болды!';
        }
    }
}

include 'includes/header.php';
?>

<main class="auth-container">
    <section class="auth-card">
        <p class="eyebrow">САЯХАТТЫ ӨҢДЕУ</p>
        <h1>Мәліметтерді өзгерту</h1>

        <?php if ($message !== ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Саяхат атауы</label>
            <input type="text" name="title"
                   value="<?= htmlspecialchars($trip['title']) ?>" required>

            <label>Қала</label>
            <input type="text" name="destination"
                   value="<?= htmlspecialchars($trip['destination']) ?>" required>

            <label>Ел</label>
            <input type="text" name="country"
                   value="<?= htmlspecialchars($trip['country']) ?>" required>

            <label>Басталу күні</label>
            <input type="date" name="start_date"
                   value="<?= htmlspecialchars($trip['start_date']) ?>" required>

            <label>Аяқталу күні</label>
            <input type="date" name="end_date"
                   value="<?= htmlspecialchars($trip['end_date']) ?>" required>

            <label>Бюджет (₸)</label>
            <input type="number" name="budget"
                   value="<?= htmlspecialchars($trip['budget']) ?>"
                   min="1" step="0.01" required>

            <button type="submit" class="btn auth-submit">
                Өзгерістерді сақтау
            </button>
        </form>

        <p class="auth-switch">
            <a href="dashboard.php">Артқа қайту</a>
        </p>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
