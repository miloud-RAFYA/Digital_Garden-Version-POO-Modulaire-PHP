<?php
include('config/database.php');
session_start();


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["login"])) {
    formLogin($cnx);
}
function formLogin($cnx)
{
    $name = $_POST['username'];
    $pwd = $_POST['password'];
    $stm = Mysqli_prepare($cnx, "SELECT * FROM users WHERE username = ? ");
    mysqli_stmt_bind_param($stm, "s", $name);
    mysqli_stmt_execute($stm);
    $result = mysqli_stmt_get_result($stm);
    if (mysqli_num_rows($result) > 0) {
        $usres = mysqli_fetch_assoc($result);
        if (password_verify($pwd, $usres["password"])) {
            $_SESSION['user_id'] = $usres['id'];
            $_SESSION['username'] = $usres['fName'];
            $_SESSION['date_inscription'] = $usres['created_at'];
            $_SESSION['login_time'] = date('H:i:s');
            header("location: dashboard.php");
            exit();
        } else {
            $_SESSION["login_error"] = "username ou mot de passe incorecte";
            header("location: login.php");
            exit();
        }
    } else {
        $_SESSION["login_error"] = "username ou mot de passe incorecte";
    }
}
?>