<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Entity/Note.php';

class NoteRepository
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function create(Note $note)
    {
        try {
            $sql = "INSERT INTO notes (theme_id, title, importance, content, created_at) 
                    VALUES (:theme_id, :title, :importance, :content, NOW())";

            $stmt = $this->conn->prepare($sql);

            $data = $note->toArray();

            $result = $stmt->execute([
                ':theme_id' => $data['theme_id'],
                ':title' => $data['title'],
                ':importance' => $data['importance'],
                ':content' => $data['content']
            ]);

            if ($result) {
                $note->setId($this->conn->lastInsertId());
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur création note: " . $e->getMessage());
            return false;
        }
    }

    public function update($noteData)
    {
        try {
            $sql = "UPDATE notes 
                    SET title = :title, 
                        importance = :importance, 
                        content = :content, 
                        theme_id = :theme_id,
                        created_at = NOW()
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $result = $stmt->execute([
                ':id' => $noteData['id'],
                ':title' => $noteData['title'],
                ':importance' => $noteData['importance'],
                ':content' => $noteData['content'],
                ':theme_id' => $noteData['theme_id']
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erreur modification note: " . $e->getMessage());
            return false;
        }
    }

    public function delete($noteId)
    {
        try {
            $sql = "DELETE FROM notes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([':id' => $noteId]);
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur suppression note: " . $e->getMessage());
            return false;
        }
    }
    public function search($motcle, $theme_id)
    {
        $stmt = $this->conn->prepare("
        SELECT *
        FROM notes n
        JOIN themes t ON n.theme_id = t.id
        WHERE (n.title LIKE :motcle 
        OR n.content LIKE :motcle)
        AND t.id = :theme_id
        ORDER BY n.created_at DESC;

    ");

        $stmt->execute([
            ':motcle' => '%' . $motcle . '%',
            ':theme_id' =>  $theme_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($noteId)
    {
        try {
            $sql = "SELECT * 
                    FROM notes n 
                    LEFT JOIN themes t ON n.theme_id = t.id 
                    WHERE n.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $noteId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur recherche note: " . $e->getMessage());
            return false;
        }
    }

    public function SelectedNote($theme_id)
    {
        try {
            $sql = "SELECT * 
                    FROM notes n 
                    LEFT JOIN themes t ON n.theme_id = t.id 
                    WHERE n.theme_id = :theme_id
                    and n.status ='active'
                    ORDER BY n.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':theme_id' => $theme_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur sélection notes: " . $e->getMessage());
            return [];
        }
    }

    public function getAllNotes()
    {
        try {
            $sql = "SELECT n.*, t.name as theme_name, t.color as theme_color 
                    FROM notes n 
                    LEFT JOIN themes t ON n.theme_id = t.id 
                    ORDER BY n.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération notes: " . $e->getMessage());
            return [];
        }
    }

 
}
