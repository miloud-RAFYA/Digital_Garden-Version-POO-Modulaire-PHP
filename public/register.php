<?php
include('../config/database.php');
include('../src/Entity/User.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
if (isset($_POST["register"])) {
    $fname = $_POST['fname'];
    $name = $_POST['username'];
    $password = $_POST['password'];
    $Confirme = $_POST['Confirme'];
    $user=new User($fname, $name, $password);
    $userRep=new UserRepository();
    $userRep->createUser($user,$Confirme);
    
}
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
                <button type="submit" name="register">Register</button>
                <p>Already have an account ?<a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

</body>

</html>