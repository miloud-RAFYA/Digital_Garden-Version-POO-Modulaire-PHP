<?php
require_once('../src/Service/AuthService.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['login'])) {
    $authService = new AuthService();
    $authService->authenticate($_POST['username'], $_POST['password']);
}
?>