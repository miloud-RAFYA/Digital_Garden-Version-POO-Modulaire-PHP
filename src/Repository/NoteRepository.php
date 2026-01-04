<?php 
require_once __DIR__ . '/../../config/database.php';

class NoteRepository {
    private $pdo;
    
    public function __construct() {
        $pd = new Database();
        $this->pdo = $pd->getConnection();
    }
    
    public function insertNote($themeId, $title, $importance, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO notes (theme_id, title, importance, content) VALUES (?, ?, ?, ?)");
        return $stmt->execute([(int)$themeId, $title, (int)$importance, $content]);
    }
    
    public function getNotesByUser($userId) {
        $stmt = $this->pdo->prepare("
            SELECT n.*, t.name as theme_name, t.color as theme_color 
            FROM notes n 
            JOIN themes t ON n.theme_id = t.id 
            WHERE t.user_id = ? 
            ORDER BY n.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function removeNote($noteId) {
        $stmt = $this->pdo->prepare("DELETE FROM notes WHERE id = ?");
        return $stmt->execute([$noteId]);
    }
    
    public function updateNote($noteId, $title, $importance, $content) {
        $stmt = $this->pdo->prepare("UPDATE notes SET title = ?, importance = ?, content = ? WHERE id = ?");
        return $stmt->execute([$title, $importance, $content, $noteId]);
    }
}