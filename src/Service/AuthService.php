<?php
// require_once('../config/database.php');
require_once __DIR__ . '/../Repository/UserRepository.php';

class AuthService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function authenticate($useraut)
    {
        $user = $this->userRepository->findByUsername($useraut->username);

        if ($user && ($useraut->password === $user['password'] || password_verify($useraut->password, $user['password']))) {
            $this->startSession($user);
            $this->redirectUser($user['userRole']);
        } else {
            $this->setLoginError();
        }
    }

    private function startSession($user)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['userRole'];
        $_SESSION['fName'] = $user['fName'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['date_inscription'] = $user['created_at'];
    }

    private function redirectUser($role)
    {
        if ($role === 'admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../public/dashboard.php');
        }
        exit();
    }
    private function setLoginError()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['login_error'] = 'Invalid credentials';
        header('Location: ../public/login.php');
        exit();
    }
}
