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
    <link rel="stylesheet" href="../public_assets\css\style.css">
</head>
<body>
<header>
    <p class="logo">
        <span class="lg_1">Digital</span>
        <span class="lg_2">Garden</span>
    </p>
    <nav>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="../public/themes.php">Gestion Thèmes</a>
            <a href="../public/login.php">Déconnexion</a>
        <?php else: ?>
            <a href="../public/login.php">Login</a>
            <a href="../public/register.php">S'inscrire</a>
        <?php endif; ?>
    </nav>
</header>
</body>
</html>