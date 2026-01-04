<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Digital Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Digital_Garden-Version-POO-Modulaire-PHP/public_assets/css/style.css">
</head>
<body>
<header>
    <p class="logo">
        <span class="lg_1">Digital</span>
        <span class="lg_2">Garden</span>
    </p>
    <nav>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/admin/dashboard.php">Dashboard</a>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/admin/users.php">Manage Users</a>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/public/login.php">Logout</a>
            <?php else: ?>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/public/dashboard.php">Dashboard</a>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/themes.php">Gestion Thèmes</a>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/notes.php">Gestion Notes</a>
                <a href="/Digital_Garden-Version-POO-Modulaire-PHP/public/login.php">Logout</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/Digital_Garden-Version-POO-Modulaire-PHP/public/login.php">Login</a>
            <a href="/Digital_Garden-Version-POO-Modulaire-PHP/public/register.php">S'inscrire</a>
        <?php endif; ?>
    </nav>
</header>
</body>
</html>