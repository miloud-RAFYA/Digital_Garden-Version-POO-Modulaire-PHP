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
    public function checkUser(User $user)
    {
        $stmt = $this->pdo->prepare("select u.username, r.userRole  from users u join role r  on  u.id = r.id Where  username = ?");
        $stmt->execute([$user->username]);
        return $stmt->fetchAll(pdo::FETCH_ASSOC);
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