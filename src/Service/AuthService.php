<?php
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
        
        // Debug: Vérifiez ce que retourne la requête
        echo "<pre>";
        echo "Données utilisateur depuis la base :\n";
        print_r($user);
        echo "Mot de passe fourni : " . $useraut->password . "\n";
        if ($user) {
            echo "Mot de passe en base : " . $user['password'] . "\n";
            echo "password_verify résultat : " . (password_verify($useraut->password, $user['password']) ? 'VRAI' : 'FAUX') . "\n";
        }
        echo "</pre>";
        
        if ($user && password_verify($useraut->password, $user['password'])) {
            $this->startSession($user);
            $this->redirectUser($user['role']); // Changé de 'userRole' à 'role'
        } else {
            $this->setLoginError();
        }
    }

    private function startSession($user)
    {
        // La session devrait déjà être démarrée dans login.php
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Changé de 'userRole' à 'role'
        $_SESSION['fName'] = $user['fName'];
        $_SESSION['date_inscription'] = $user['created_at'];
        $_SESSION['login_time'] = date("d/m/Y H:i:s");
        
        // NE JAMAIS stocker le mot de passe en session !
        // $_SESSION['password'] = $user['password'];
    }

    private function redirectUser($role)
    {
        // Vérifiez la valeur de role
        echo "Redirection avec rôle : " . $role . "<br>";
        
        if ($role === 'admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../public/dashboard.php');
        }
        exit();
    }

    private function setLoginError()
    {
        $_SESSION['login_error'] = 'Invalid credentials';
        // header('Location: ../public/login.php');
        // exit();
    }
}