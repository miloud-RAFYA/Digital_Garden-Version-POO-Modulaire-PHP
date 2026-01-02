<?php
require_once __DIR__.'/../Repository/UserRepository.php';
require_once __DIR__.'/../Entity/User.php';
class RegisterService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function createUser($fname, $name, $password, $Confirme)
    {
        $user = new User($name, $password);
        $user->setFname($fname);
        $userRep = new UserRepository();
        $resultat = $userRep->checkUser($user); 
        if (!$resultat && $Confirme == $user->password) {
            $create = $userRep->isertUser($user);
            if ($create) {
                header("location: login.php");
                exit();
            } else {
                $_SESSION['register_error'] = 'les donnes non valaid';
            }

        } else {
               $_SESSION['register_error'] = 'les donnes non valaid';
        }
    }


}
?>
