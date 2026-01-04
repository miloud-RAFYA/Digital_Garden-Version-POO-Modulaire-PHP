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

    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT u.id, u.username, u.password, u.created_at, r.userRole FROM users u JOIN role r ON u.id = r.id WHERE u.username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($fname, $username, $hashedPassword)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users(fName, username, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$fname, $username, $hashedPassword])) {
            $id = $this->pdo->lastInsertId();
            $stmt = $this->pdo->prepare("INSERT INTO role(id) VALUES (?)");
            return $stmt->execute([$id]);
        }
        return false;
        }

    public function userExists($username)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}