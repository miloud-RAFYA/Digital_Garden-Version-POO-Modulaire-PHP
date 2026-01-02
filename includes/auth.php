<?php
include('../config/database.php');
include('../src/Repository/UserRepository.php');
include('../src/Entity/User.php');
include('../src/Entity/Role.php');
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user=new User($username,$password);


    $userRepo = new UserRepository();
    $user = $userRepo->checkUser($user);


    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['userRole'];
        $_SESSION['fName']=$user['fName'];
        $_SESSION['password']=$user['password'];
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