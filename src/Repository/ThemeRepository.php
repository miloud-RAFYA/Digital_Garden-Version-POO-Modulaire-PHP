<?php
class ThemeRepository
{
    private $conn;

    public function _construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();

    }

    public function isertTheme()
    {


    }
    public function displayThemes()
    {
        try {
            $query = "SELECT * FROM themes WHERE 1 = 1";
            $stmt = $this->conn->prepare($query);
            // $stmt->bindParam(":user_id", 1);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            $result = false;
            $_SESSION['error_message'] = "Erreur de connexion " . $e->getMessage();
            return $result;
        }
    }

}