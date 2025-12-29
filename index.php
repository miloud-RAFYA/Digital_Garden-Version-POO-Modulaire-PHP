<?php

include('config/database.php');
    session_start();

$_SESSION['user_id']= null;

require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Digital Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<main class="hero-section">
    <div class="info-app">
        <h1 class="gradient-text">Bienvenue sur Digital Garden</h1>
        <p class="description">
            Digital Garden est une plateforme numérique conçue pour organiser,
            cultiver et faire évoluer vos idées sous forme de notes.
            Chaque pensée est une graine qui grandit avec le temps.
        </p>
    </div>
</main>

<?php
require_once 'includes/footer.php';
?>
</body>
</html>