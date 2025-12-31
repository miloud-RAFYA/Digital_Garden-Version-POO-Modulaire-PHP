<?php
require_once __DIR__.'/../src/Service/RegisterService.php';
session_start();

 if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["register"])) {
        $addUser=new RegisterService();
        $addUser->createUser($_POST['fname'],$_POST['username'],$_POST['password'],$_POST['Confirme']) ;
        }
?>
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
        <div class="form-box" id="register-form">
            <form action="register.php" method="POST">
                <h2>Register</h2>
                <input type="text" name="fname" placeholder="fName" required>
                <input type="text" name="username" placeholder="username" required>
                <input type="password" name="password" placeholder="password" required>
                <input type="password" name="Confirme" placeholder="Confirme password" required>
                <?php if(!empty($_SESSION['register_error'])):?>
                <span><?= $_SESSION['register_error'] ?></span>
                <?php unset($_SESSION['register_error']) ?>
                <?php endif?>
                <button type="submit" name="register">Register</button>
                <p>Already have an account ?<a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

</body>

</html>
