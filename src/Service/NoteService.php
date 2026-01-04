<?php
require_once __DIR__ . '/../Repository/NoteRepository.php';
require_once __DIR__ . '/../Repository/ThemeRepository.php';

class NoteService {
    private $noteRepository;
    private $themeRepository;
    
    public function __construct() {
        $this->noteRepository = new NoteRepository();
        $this->themeRepository = new ThemeRepository();
    }
    
    public function createNote($title, $themeId, $importance, $content) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user_id'];
        
        // Validate and convert importance to integer
        $importance = (int)$importance;
        if ($importance < 1 || $importance > 5) {
            $importance = 3; // Default to 3 if invalid
        }
        
        // Validate themeId is numeric
        $themeId = (int)$themeId;
        if ($themeId <= 0) {
            $_SESSION['note_error'] = 'Thème invalide';
            return false;
        }
        
        if ($this->noteRepository->insertNote($themeId, $title, $importance, $content)) {
            $_SESSION['note_success'] = 'Note créée avec succès';
            return true;
        } else {
            $_SESSION['note_error'] = 'Erreur lors de la création de la note';
            return false;
        }
    }
    
    public function getAllThemes() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user_id'];
        return $this->themeRepository->getThemesByUser($userId);
    }
    
    public function getAllNotes() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user_id'];
        return $this->noteRepository->getNotesByUser($userId);
    }
}
?>