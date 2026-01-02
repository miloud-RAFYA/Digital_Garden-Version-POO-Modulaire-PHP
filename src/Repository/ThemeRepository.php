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

    public function isertTheme( Theme $theme)
    {
        try {
            $sql = "INSERT INTO themes (user_id, name, color, tags) VALUES ('$theme->user', '$theme->name', '$theme->color', '$theme->tags')";
            $stmt = $this->conn->prepare( $sql);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Theme cree avec succes !";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la creation : ";
            }
        } catch (PDOException $e) {
              echo "error".$e->getMessage();
        }
    }
    // public function displayThemes($user_Id)
    // {
    //     var_dump($this->conn);
    //     exit;
    //     try {
    //         $stmt = $this->conn->query("SELECT * FROM themes WHERE user_id = '$user_Id'");
    //         $stmt->execute();
    //         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         return $result;
    //     } catch (Exception $e) {
    //         $result = false;
    //         $_SESSION['error_message'] = "Erreur de connexion " . $e->getMessage();
    //         return $result;
    //     }
    // }

}

// $db = new ThemeRepository();
// var_dump($db->displayThemes(1));
