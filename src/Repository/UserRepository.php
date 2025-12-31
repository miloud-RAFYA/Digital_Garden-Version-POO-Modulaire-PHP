<?php

require_once __DIR__ . '/../../config/database.php';
class UserRepository
{

    private $pdo;

    public function __construct()
    {
        $pd = new Database();
        $this->pdo = $pd->getConnection();
    }
   public function checkUser($user){
        $stmt = $this->pdo->prepare("SELECT u.id, u.username, u.password,u.created_at, r.userRole FROM users u JOIN role r ON u.id = r.id WHERE u.username = ?");
        $stmt->execute([$user->username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function isertUser($user)
    {
        $password = password_hash($user->password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users(fName,username,password) 
        VALUES ('$user->fname','$user->username','$password')");
        if ($stmt->execute()) {
            $id = $this->pdo->lastInsertId();
            $stmt = $this->pdo->prepare("INSERT INTO role(id) 
             VALUES ('$id')");
            return $stmt->execute();
        }
    }

}
?>