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

    public function Insert(Theme $theme)
    {
        try {
            $sql = "INSERT INTO themes (user_id, name, color, tags) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$theme->user, $theme->name, $theme->color, $theme->tags])) {
                $_SESSION['success_message'] = "Theme cree avec succes !";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la creation : ";
            }
        } catch (PDOException $e) {
            echo "error" . $e->getMessage();
        }
    }
    public function update($theme)
    {
        try {
            $sql = "UPDATE themes 
            SET user_id = :user_id,
                name    = :name,
                color   = :color,
                tags    = :tags
            WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $theme->user,
                ':name'    => $theme->name,
                ':color'   => $theme->color,
                ':tags'    => $theme->tags,
                ':id'      => $theme->id
            ]);
            $_SESSION['success_message'] = "Thème modifié avec succès !";
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la modification";
            // echo $e->getMessage();
        }
    }
    public function delete($themeId,$userId)
    {
       

    try {
        $checkSql = "SELECT COUNT(*) FROM notes WHERE theme_id = :theme_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->execute([
            ':theme_id' => $themeId
        ]);

        if ($checkStmt->fetchColumn() > 0) {
            $_SESSION['error_message'] = "Impossible de supprimer un thème contenant des notes";
            header("Location: themes.php");
            exit();
        }

        
        $sql = "DELETE FROM themes WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id'      => $themeId,
            ':user_id' => $userId
        ]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['success_message'] = "Thème supprimé avec succès !";
        } else {
            $_SESSION['error_message'] = "Suppression impossible (thème introuvable ou non autorisé)";
        }

        header("Location: themes.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la suppression";
        
        // echo $e->getMessage();
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
