<?php

require_once __DIR__ . '/../../config/database.php';
class ThemeRepository
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function isertTheme($theme)
    {
        try {
            $sql = "INSERT INTO themes (user_id, name, color, tags) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$theme->user, $theme->name, $theme->color, $theme->tags]);
            $_SESSION['success_message'] = "Theme cree avec succes !";
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la creation : " . $e->getMessage();
        }
    }
    public function getThemesByUser($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM themes WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
