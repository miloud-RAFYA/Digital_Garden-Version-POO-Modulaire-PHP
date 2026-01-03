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

    public function IsertTheme(Theme $theme)
    {
        try {
            $sql = "INSERT INTO themes (user_id, name, color, tags) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([ $theme->user,$theme->name,$theme->color,$theme->tags])) {
                $_SESSION['success_message'] = "Theme cree avec succes !";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la creation : ";
            }
        } catch (PDOException $e) {
            echo "error" . $e->getMessage();
        }
    }
    public function SelectedTeams($user_Id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM themes WHERE user_id = ?");
            $stmt->execute([$user_Id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Erreur de connexion " . $e->getMessage();
            return $result = false;
        }
    }
}

