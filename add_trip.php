
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';

$pageTitle = 'Саяхат қосу | TripWise';
$headerType = 'dashboard';
$footerText = '© 2026 TripWise';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $budget = $_POST['budget'] ?? '';

    if ($title === '' || $destination === '' || $country === '' ||
        $startDate === '' || $endDate === '' || $budget === '') {

        $message = 'Барлық өрісті толтырыңыз!';

    } elseif ($endDate < $startDate) {
        $message = 'Аяқталу күні басталу күнінен ерте болмауы керек!';

    } elseif (!is_numeric($budget) || $budget <= 0) {
        $message = 'Бюджетті дұрыс енгізіңіз!';

    } else {
        $pdo->beginTransaction();

        try {
            $destinationStmt = $pdo->prepare(
                "INSERT INTO destinations (name, country) VALUES (?, ?)"
            );

            $destinationStmt->execute([$destination, $country]);

            $destinationId = $pdo->lastInsertId();

            $tripStmt = $pdo->prepare(
                "INSERT INTO trips
                (user_id, destination_id, title, start_date, end_date, budget)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            $tripStmt->execute([
                $_SESSION['user_id'],
                $destinationId,
                $title,
                $startDate,
                $endDate,
                $budget
            ]);

            $pdo->commit();

            header('Location: dashboard.php');
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = 'Саяхатты сақтау кезінде қате пайда болды!';
        }
    }
}

include 'includes/header.php';
?>

<main class="auth-container">
    <section class="auth-card">
        <p class="eyebrow">ЖАҢА САЯХАТ</p>
        <h1>Саяхат қосу</h1>
        <p class="auth-description">Келесі сапарыңды жоспарла.</p>

        <?php if ($message !== ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="add_trip.php">

            <label for="title">Саяхат атауы</label>
            <input type="text" id="title" name="title"
                   placeholder="Мысалы: Парижге саяхат" required>

            <label for="destination">Қала</label>
            <input type="text" id="destination" name="destination"
                   placeholder="Мысалы: Париж" required>

            <label for="country">Ел</label>
            <input type="text" id="country" name="country"
                   placeholder="Мысалы: Франция" required>

            <label for="start_date">Басталу күні</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">Аяқталу күні</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="budget">Бюджет (₸)</label>
            <input type="number" id="budget" name="budget"
                   placeholder="250000" min="1" step="0.01" required>

            <button type="submit" class="btn auth-submit">
                Саяхатты сақтау
            </button>
        </form>

        <p class="auth-switch">
            <a href="dashboard.php">Артқа қайту</a>
        </p>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
