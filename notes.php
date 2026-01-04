<?php
session_start();
require_once 'includes/header.php';
require_once 'src/Service/NoteService.php';

$noteService = new NoteService();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveNote'])) {
    $title = $_POST['noteTitle'];
    $themeId = $_POST['noteTheme'];
    $importance = $_POST['importanceValue'];
    $content = $_POST['noteContent'];
    
    // Debug: Check if data is received
    error_log("Note data: Title=$title, ThemeId=$themeId, Importance=$importance, Content=$content");
    
    if ($noteService->createNote($title, $themeId, $importance, $content)) {
        $_SESSION['note_success'] = 'Note créée avec succès';
    } else {
        $_SESSION['note_error'] = 'Erreur lors de la création de la note';
    }
    
    header('Location: notes.php');
    exit();
}

$themes = $noteService->getAllThemes();
$notes = $noteService->getAllNotes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes | Digital Garden</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main class="notes-page">
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
        
        <!-- Messages -->
        <?php if (isset($_SESSION['note_success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($_SESSION['note_success']) ?>
                <?php unset($_SESSION['note_success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['note_error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($_SESSION['note_error']) ?>
                <?php unset($_SESSION['note_error']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Statistiques -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon" style="background: #eef2ff; color: #7494ec;">
                    <i class="fas fa-sticky-note"></i>
                </div>
                <div class="stat-info">
                    <h3>24</h3>
                    <p>Notes totales</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #e8f5e9; color: #4CAF50;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h3>8</h3>
                    <p>Notes importantes</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff3e0; color: #FF9800;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Cette semaine</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #f3e5f5; color: #9C27B0;">
                    <i class="fas fa-palette"></i>
                </div>
                <div class="stat-info">
                    <h3>6</h3>
                    <p>Thèmes actifs</p>
                </div>
            </div>
        </div>
        
        <!-- Filtres -->
        <div class="filters-bar">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="themeFilter">Thème</label>
                    <select class="filter-select" id="themeFilter">
                        <option value="">Tous les thèmes</option>
                        <?php foreach($themes as $theme): ?>
                            <option value="<?= $theme['id'] ?>"><?= htmlspecialchars($theme['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label name = "important" for="importanceFilter">Importance</label>
                    <select class="filter-select" id="importanceFilter">
                        <option value="">Tous les niveaux</option>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="searchFilter">Recherche</label>
                    <input type="text" class="filter-select" id="searchFilter" placeholder="Rechercher...">
                </div>
                
                <div class="filter-group" style="display: flex; align-items: flex-end;">
                    <button class="btn-filter" onclick="resetFilters()">
                        <i class="fas fa-redo"></i> Réinitialiser
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Liste des notes -->
        <div class="notes-list">
            <?php if ($notes): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note-card">
                        <div class="note-header">
                            <div class="note-title-section">
                                <h3><?= htmlspecialchars($note['title']) ?></h3>
                                <div class="note-meta">
                                    <span class="note-theme"><?= htmlspecialchars($note['theme_name']) ?></span>
                                    <span class="note-date">
                                        <i class="far fa-calendar"></i> <?= date('d/m/Y H:i', strtotime($note['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="note-content">
                            <?= htmlspecialchars($note['content']) ?>
                        </div>
                        
                        <div class="note-footer">
                            <div class="note-importance">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?= $i <= $note['importance'] ? 'fas' : 'far' ?> fa-star"></i>
                                <?php endfor; ?>
                                <span style="color: #666; margin-left: 5px;">(<?= $note['importance'] ?>/5)</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-sticky-note"></i>
                    <p>Aucune note pour le moment</p>
                    <p style="font-size: 14px; color: #999;">Cliquez sur "Nouvelle note" pour commencer</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Modal de création de note -->
    <div class="modal-overlay" id="createModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-plus-circle"></i> Nouvelle note</h2>
            </div>
            <div class="modal-body">
                <form action="notes.php" method="POST" id="noteForm">
                    <div class="form-group">
                        <label for="noteTitle">Titre *</label>
                        <input type="text" name="noteTitle" class="form-input" id="noteTitle" 
                               placeholder="Donnez un titre à votre note">
                    </div>
                    
                    <div class="form-group">
                        <label for="noteTheme">Thème *</label>
                        <select name="noteTheme" class="form-input" id="noteTheme">
                            <option value="">Choisir un thème</option>
                            <?php foreach($themes as $theme): ?>
                                <option value="<?= $theme['id'] ?>"><?= htmlspecialchars($theme['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
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
                            <input type="hidden" name="importanceValue" id="importanceValue" value="3">
                            <span id="importanceText">Moyenne (3/5)</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="noteContent">Contenu *</label>
                        <textarea name="noteContent" class="form-input form-textarea" id="noteContent" 
                                  placeholder="Saisissez le contenu de votre note..." ></textarea>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn-filter" onclick="closeModal()">
                            Annuler
                        </button>
                        <button type="button" name="saveNote" class="btn-create" onclick="submitNoteForm()">
                            <i class="fas fa-check"></i> Enregistrer
                        </button>
                    </div>
                </form>
        </div>
    </div>

    <!-- Modal d'édition de note -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Modifier la note</h2>
            </div>
            <div class="modal-body">
                <form id="editNoteForm">
                    <div class="form-group">
                        <label for="editNoteTitle">Titre *</label>
                        <input type="text" class="form-input" id="editNoteTitle" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editNoteTheme">Thème *</label>
                        <select class="form-input" id="editNoteTheme" required>
                            <option value="productivity">Productivité</option>
                            <option value="travel">Voyage</option>
                            <option value="ideas">Idées</option>
                            <option value="learning">Apprentissage</option>
                            <option value="personal">Personnel</option>
                        </select>
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
                            <input type="hidden" id="editImportanceValue" value="3">
                            <span id="editImportanceText">Moyenne (3/5)</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editNoteContent">Contenu *</label>
                        <textarea class="form-input form-textarea" id="editNoteContent" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="editNoteTags">Tags</label>
                        <input type="text" class="form-input" id="editNoteTags">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-filter" onclick="closeModal()">
                    Annuler
                </button>
                <button class="btn-create" onclick="updateNote()">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal-overlay" id="deleteModal">
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
                <button class="btn-filter" onclick="closeModal()">
                    Annuler
                </button>
                <button class="btn-create" style="background: #f44336;" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </div>
    </div>

    <script src="public_assets/js/notes.js"></script>
</body>
</html>