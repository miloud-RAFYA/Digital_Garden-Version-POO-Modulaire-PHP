<?php
include('../config/database.php');
include('../src/Repository/UserRepository.php');
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userRepo = new UserRepository();
    $user = $userRepo->checkUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['userRole'];
        // $_SESSION['login_time']=
        $_SESSION['date_inscription']=$user['created_at'];

        if ($user['userRole'] === 'admin') {
            echo "admin";
            header('Location: ../admin/dashboard.php');
        } else {
            echo "user";
            header('Location: ../public/dashboard.php');
        }
        exit();
    } else {
        $_SESSION['login_error'] = 'Invalid credentials';
        echo "error";
        header('Location: ../public/login.php');
        exit();
    }
}
?>