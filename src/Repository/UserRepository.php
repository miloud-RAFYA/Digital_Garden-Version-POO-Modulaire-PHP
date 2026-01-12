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
        $stmt = $this->pdo->prepare("SELECT * FROM users u JOIN roles r ON u.id = r.user_id WHERE u.username = ?");
        $stmt->execute([$user->username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    
    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users u JOIN roles r ON u.id = r.user_id WHERE u.username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($user)
{
    try {
        $this->pdo->beginTransaction();
        
        $stmt = $this->pdo->prepare("INSERT INTO users(fName, username, password) VALUES (?, ?, ?)");
        if (!$stmt->execute([$user->fname, $user->username, $user->password])) {
            throw new Exception("Failed to insert user");
        }
        
        $id = $this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare("INSERT INTO roles(user_id, role) VALUES (?, 'user')");
        
        if (!$stmt->execute([$id])) {
            throw new Exception("Failed to insert role");
        }
        
        $this->pdo->commit();
        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();
        error_log("User insertion failed: " . $e->getMessage());
        return false;
    }
}

    public function userExists($username)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}