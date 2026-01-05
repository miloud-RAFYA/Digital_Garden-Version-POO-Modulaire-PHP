<?php
session_start();
require_once '../includes/header.php';
require_once '../src/Service/NoteService.php';

$noteService = new NoteService();

if (isset($_POST['theme_id']) && !empty($_POST['theme_id'])) {  
$_SESSION['theme_id'] = $_POST['theme_id'];
}
$theme_id = $_SESSION['theme_id'];

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Création
    if (isset($_POST['create'])) {
        
        $noteService->createNote($_POST,$theme_id);
    }
    // Modification
    elseif (isset($_POST['update'])) {
        var_dump($theme_id);
        $noteService->updateNote($_POST,$theme_id);
    }
    // Suppression
    elseif (isset($_POST['delete'])) {
        $noteService->deleteNote($_POST['note_id']);
    }
}

// Récupérer les statistiques
$stats = $noteService->getStats();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes | Digital Garden</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public_assets/css/style.css">
</head>

<body>

    <main class="page">
        <!-- En-tête -->
        <div class="page-header">
            <div>
                <h1><i class="fas fa-sticky-note"></i> Mes Notes</h1>
                <p class="page-description">Capturez et organisez vos idées</p>
            </div>
            <div class="main-actions">
                <button class="btn-create" onclick="openCreateModal()">
                    <i class="fas fa-plus"></i> Nouvelle note
                </button>
            </div>
        </div>

        <!-- Statistiques -->
        
        <!-- Filtres -->
       
         <!-- Afficher les messages -->
        <?php if (isset($_SESSION['success_message_note'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($_SESSION['success_message_note']) ?>
                <?php unset($_SESSION['success_message_note']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message_note'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($_SESSION['error_message_note']) ?>
                <?php unset($_SESSION['error_message_note']); ?>
            </div>
        <?php endif; ?>
        <!-- Liste des notes -->
        <div class="notes-list">
            <?php 
            if ($theme_id) {
                $noteService->displayNote($theme_id);
            } else {
                echo '<div class="empty-state"><p>Sélectionnez un thème pour voir les notes</p></div>';
            }
            ?>
        </div>
    </main>

    <!-- Modal de création de note -->
    <div class="modal-overlay" id="createModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-plus-circle"></i> Nouvelle note</h2>
            </div>
            <form id="createNoteForm" method="POST" action="notes.php">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="noteTitle">Titre *</label>
                        <input type="text" class="form-input" id="noteTitle" name="title"
                            placeholder="Donnez un titre à votre note" required>
                    </div>

                    <div class="form-group">
                        <label>Importance</label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="note-importance" id="importanceStars" style="cursor: pointer;">
                                <i class="far fa-star" data-value="1"></i>
                                <i class="far fa-star" data-value="2"></i>
                                <i class="far fa-star" data-value="3"></i>
                                <i class="far fa-star" data-value="4"></i>
                                <i class="far fa-star" data-value="5"></i>
                            </div>
                            <input type="hidden" id="importanceValue" name="importance" value="3">
                            <span id="importanceText">Moyenne (3/5)</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="noteContent">Contenu *</label>
                        <textarea class="form-input form-textarea" id="noteContent" name="content"
                            placeholder="Saisissez le contenu de votre note..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-filter" onclick="closeModal()">
                        Annuler
                    </button>
                    <button type="submit" class="btn-create" name="create" value="1">
                        <i class="fas fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal d'édition de note -->
    <div class="modal-overlay" id="editModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Modifier la note</h2>
            </div>
            <form id="editNoteForm" method="POST" action="notes.php">
                <input type="hidden" id="editNoteId" name="note_id">
                <input type="hidden" name="update" value="1">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editNoteTitle">Titre *</label>
                        <input type="text" class="form-input" id="editNoteTitle" name="title" required>
                    </div>

                    

                    <div class="form-group">
                        <label>Importance</label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="note-importance" id="editImportanceStars" style="cursor: pointer;">
                                <i class="far fa-star" data-value="1"></i>
                                <i class="far fa-star" data-value="2"></i>
                                <i class="far fa-star" data-value="3"></i>
                                <i class="far fa-star" data-value="4"></i>
                                <i class="far fa-star" data-value="5"></i>
                            </div>
                            <input type="hidden" id="editImportanceValue" name="importance" value="3">
                            <span id="editImportanceText">Moyenne (3/5)</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editNoteContent">Contenu *</label>
                        <textarea class="form-input form-textarea" id="editNoteContent" name="content" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-filter" onclick="closeModal()">
                        Annuler
                    </button>
                    <button type="submit" class="btn-create" class="btn-create" name="update" value="1">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal-overlay" id="deleteModal" style="display: none;">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h2><i class="fas fa-exclamation-triangle"></i> Confirmation</h2>
            </div>
            <div class="modal-body">
                <div style="text-align: center; padding: 20px 0;">
                    <i class="fas fa-trash-alt fa-3x" style="color: #f44336; margin-bottom: 20px;"></i>
                    <h3 style="margin-bottom: 10px;">Supprimer la note ?</h3>
                    <p style="color: #666; margin-bottom: 20px;">
                        Cette action est irréversible. Voulez-vous vraiment supprimer cette note ?
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-filter" onclick="closeModal()">
                    Annuler
                </button>
                <form id="deleteForm" method="POST" action="notes.php" style="display: inline;">
                    <input type="hidden" id="deleteNoteId" name="note_id">
                    <input type="hidden" name="delete" value="1">
                    <button type="submit" class="btn-create" style="background: #f44336;">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="../public_assets/js/script.js"></script>
</body>

</html>