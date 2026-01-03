<?php include('../includes/auth.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Garden</title>
    <link rel="stylesheet" href="../public_assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="form-box" id="login-form">
            <form action="../includes/auth.php" method="POST">
                <h2>login</h2>
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="password">
                <button type="submit" name="login">Login</button>
                <?php if (isset($_SESSION["login_error"])): ?>
                <p style="color:red"><?= $_SESSION["login_error"]?></p>
                <?php unset($_SESSION["login_error"]) ?> 
                <?php endif ?>
                <p>Don't have an account ?<a href="register.php">Register</a></p>
            </form>
        </div>
    </div>

</body>

</html>