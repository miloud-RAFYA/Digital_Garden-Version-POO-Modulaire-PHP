<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Digital Garden</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <footer class="footer">
        <div class="footer-container">

            <!-- Strategy -->
            <div class="footer-column">
                <h4>About Digital Garden</h4>
                <p>
                    Digital Garden est une application conçue pour aider les utilisateurs à organiser,
                    structurer et faire évoluer leurs idées dans un espace personnel et privé.
                    Le projet repose sur une approche minimaliste favorisant la clarté, la créativité
                    et une gestion intuitive des informations au quotidien.
                </p>
            </div>

            <!-- Useful Links -->
            <div class="footer-column">
                <h4>Useful Links</h4>
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="dashboard.php">Mon espace</a></li>
                        <li><a href="themes.php">Mes thèmes</a></li>
                        <li><a href="notes.php">Mes notes</a></li>
                    <?php else: ?>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="register.php">Créer un compte</a></li>
                        <li><a href="login.php">Se connecter</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Our Services -->
            <div class="footer-column">
                <h4>Our Services</h4>
                <ul>
                    <li>Organisation personnelle des idées</li>
                    <li>Classement par thèmes visuels</li>
                    <li>Gestion intuitive des notes</li>
                    <li>Espace privé et sécurisé</li>
                    <li>Interface claire et responsive</li>
                    <li>Expérience utilisateur fluide</li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            © 2025 Digital Garden — Organisez vos idées simplement
        </div>
    </footer>
</body>

</html>