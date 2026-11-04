<?php
$pageTitle = $pageTitle ?? 'TripWise — Саяхат жоспарлаушы';
$bodyClass = $bodyClass ?? '';
$headerType = $headerType ?? 'home';
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">

<header class="header">
    <a href="index.php" class="logo">Trip<span>Wise</span></a>

    <?php if ($headerType === 'home'): ?>
        <nav>
            <a href="index.php">Басты бет</a>
            <a href="#features">Мүмкіндіктер</a>
            <a href="#about">Біз туралы</a>
        </nav>

        <div class="header-buttons">
            <a href="login.php" class="login-link">Кіру</a>
            <a href="register.php" class="btn btn-small">Тіркелу</a>
        </div>

    <?php elseif ($headerType === 'auth'): ?>
        <a href="index.php" class="login-link">← Басты бетке оралу</a>

    <?php elseif ($headerType === 'dashboard'): ?>
        <nav>
            <a href="index.php">Басты бет</a>
            <a href="dashboard.php">Менің саяхаттарым</a>
        </nav>
        <a href="login.php" class="login-link">Шығу</a>
    <?php endif; ?>
</header>
