<?php
require_once __DIR__ . '/../src/Repository/UserRepository.php';
require_once __DIR__.'/../src/Entity/User.php';
require_once __DIR__.'/../src/Entity/Role.php';
require_once __DIR__.'/../src/Service/AuthService.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user=new User($username,$password);

    $authService = new AuthService();
    $authService->authenticate($user);
}
?>