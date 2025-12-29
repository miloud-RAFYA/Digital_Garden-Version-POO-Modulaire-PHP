<?php
session_start();
// require_once 'includes/auth.php';
require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Digital Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <main class="info-dashboard">
            <h3>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?></h3>
            <p>Inscrit le : <?= $_SESSION['date_inscription'] ?></p>
            <p>Connecté à : <?= $_SESSION['login_time'] ?></p>
        </main>
    </div>
    <?php
    require_once 'includes/footer.php';
    ?>
</body>

</html>