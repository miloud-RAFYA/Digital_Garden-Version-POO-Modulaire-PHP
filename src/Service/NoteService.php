<?php
require_once __DIR__ . '/../Repository/NoteRepository.php';
require_once __DIR__ . '/../Entity/Note.php';

class NoteService
{
    private $NoteRepository;

    public function __construct()
    {
        $this->NoteRepository = new NoteRepository();
    }
    public function card($notes)
    {
?>
        <div class="theme-list">
            <?php if ($notes && count($notes) > 0): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note-card">
                        <div class="note-header">
                            <div class="note-title-section">
                                <h3><?= htmlspecialchars($note['title']) ?></h3>
                                <div class="note-meta">
                                    <span class="note-theme" style="color: <?= $note['theme_color'] ?? '#4CAF50' ?>;">
                                        <?= htmlspecialchars($note['name']) ?>
                                    </span>
                                    <span class="note-date">
                                        <i class="far fa-calendar"></i> <?= date('d/m/Y', strtotime($note['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="note-actions">
                                <button
                                    class="btn-note-action"
                                    onclick="editNote(
                                        <?= $note['id'] ?>,
                                        '<?= htmlspecialchars($note['title'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($note['content'], ENT_QUOTES) ?>',
                                        <?= $note['theme_id'] ?>,
                                        <?= $note['importance'] ?>
                                    )"
                                    title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="notes.php" method="post" class="archive-form">
                                    <input type="hidden" name="id" value="<?= $note['id'] ?>">
                                    <button type="submit" class="btn-note-action archive" name="Archiver">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </form>

                                <button
                                    class="btn-note-action delete"
                                    onclick="confirmDelete(<?= $note['id'] ?>)"
                                    title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="note-content">
                            <?= nl2br(htmlspecialchars($note['content'])) ?>
                        </div>
                        <div class="note-footer">
                            <div class="note-importance">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?= $i <= $note['importance'] ? 'fas' : 'far' ?> fa-star"
                                        style="color: <?= $i <= $note['importance'] ? '#FF9800' : '#ccc' ?>;"></i>
                                <?php endfor; ?>
                                <span style="color: #666; margin-left: 5px;"><?= $note['importance'] . "/5" ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-sticky-note"></i>
                    <p>Aucune note pour ce thème</p>
                    <p style="font-size: 14px; color: #999;">Cliquez sur "Nouvelle note" pour commencer</p>
                </div>
            <?php endif ?>
        </div>
<?php }

    public function displayNote($theme_id)
    {
        $notes = $this->NoteRepository->SelectedNote($theme_id);
        $this->card($notes);
    }

    public function createNote($data, $theme_id)
    {
        try {
            $note = new Note(
                $data['title'] ?? '',
                $data['importance'] ?? 3,
                $data['content'] ?? '',
                $theme_id ?? null
            );

            $result = $this->NoteRepository->create($note);

            if ($result) {
                $_SESSION['success_message_note'] = "Note créée avec succès !";
                header("location: notes.php");
                exit();
            } else {
                $_SESSION['error_message_note'] = "Erreur lors de la création de la note";
                header("location: notes.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Erreur: " . $e->getMessage();
            return false;
        }
    }

    public function updateNote($data, $theme_id)
    {
        try {
            $result = $this->NoteRepository->update([
                'id' => $data['note_id'] ?? null,
                'title' => $data['title'] ?? '',
                'importance' => $data['importance'] ?? 3,
                'content' => $data['content'] ?? '',
                'theme_id' => $theme_id ?? null
            ]);

            if ($result) {
                $_SESSION['success_message_note'] = "Note modifiée avec succès !";
                return true;
            } else {
                $_SESSION['error_message_note'] = "Erreur lors de la modification de la note";
                return false;
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Erreur: " . $e->getMessage();
            return false;
        }
    }

    public function deleteNote($noteId)
    {
        try {
            $result = $this->NoteRepository->delete($noteId);

            if ($result) {
                $_SESSION['success_message'] = "Note supprimée avec succès !";
                return true;
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de la note";
                return false;
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Erreur: " . $e->getMessage();
            return false;
        }
    }

    public function search($motcle, $theme_id)
    {
        $results = $this->NoteRepository->search($motcle, $theme_id);

        $this->card($results);
    }
    public function getNoteById($noteId)
    {
        return $this->NoteRepository->findById($noteId);
    }

    

    public function getNotesByTheme($themeId)
    {
        return $this->NoteRepository->SelectedNote($themeId);
    }

    public function getAllNotes()
    {
        return $this->NoteRepository->getAllNotes();
    }
}
