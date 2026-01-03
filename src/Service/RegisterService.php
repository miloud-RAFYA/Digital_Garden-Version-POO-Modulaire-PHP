<?php
require_once __DIR__.'/../Repository/UserRepository.php';

class RegisterService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function createUser($fname, $name, $password, $Confirme)
    {
        if ($this->userRepository->userExists($name)) {
            $_SESSION['register_error'] = 'User already exists';
            return false;
        }
        
        if ($password !== $Confirme) {
            $_SESSION['register_error'] = 'Passwords do not match';
            return false;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
         $user = new User($name, $hashedPassword);
        $user->setFname($fname);
        if ($this->userRepository->insertUser($user)) {
            header("location: login.php");
            exit();
        } else {
            $_SESSION['register_error'] = 'Registration failed';
            return false;
        }
    }
}
?>
