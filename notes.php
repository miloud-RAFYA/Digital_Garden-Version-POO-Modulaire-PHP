<?php
session_start();
// require_once 'includes/auth.php';
require_once 'includes/header.php';
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
                        <option value="productivity">Productivité</option>
                        <option value="travel">Voyage</option>
                        <option value="ideas">Idées</option>
                        <option value="learning">Apprentissage</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="importanceFilter">Importance</label>
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
            <!-- Note 1 -->
            <div class="note-card">
                <div class="note-header">
                    <div class="note-title-section">
                        <h3>Idées pour le projet Digital Garden</h3>
                        <div class="note-meta">
                            <span class="note-theme">Productivité</span>
                            <span class="note-date">
                                <i class="far fa-calendar"></i> Aujourd'hui, 14:30
                            </span>
                        </div>
                    </div>
                    <div class="note-actions">
                        <button class="btn-note-action" onclick="editNote(1)" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-note-action delete" onclick="deleteNote(1)" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="note-content">
                    Réflexions sur l'architecture du nouveau projet et les technologies à utiliser. 
                    Penser à l'optimisation des performances et à la scalabilité. Intégrer un système 
                    de notifications en temps réel.
                </div>
                
                <div class="note-footer">
                    <div class="note-tags">
                        <span class="note-tag">travail</span>
                        <span class="note-tag">projet</span>
                        <span class="note-tag">planification</span>
                    </div>
                    <div class="note-importance">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <span style="color: #666; margin-left: 5px;">(3/5)</span>
                    </div>
                </div>
            </div>
            
            <!-- Note 2 -->
            <div class="note-card">
                <div class="note-header">
                    <div class="note-title-section">
                        <h3>Liste de destinations 2025</h3>
                        <div class="note-meta">
                            <span class="note-theme">Voyage</span>
                            <span class="note-date">
                                <i class="far fa-calendar"></i> Hier, 18:15
                            </span>
                        </div>
                    </div>
                    <div class="note-actions">
                        <button class="btn-note-action" onclick="editNote(2)" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-note-action delete" onclick="deleteNote(2)" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="note-content">
                    Japon - Tokyo, Kyoto, Osaka. Islande - Route circulaire et aurores boréales. 
                    Italie - Rome, Florence, Venise. Canada - Vancouver, Montréal, Toronto.
                </div>
                
                <div class="note-footer">
                    <div class="note-tags">
                        <span class="note-tag">voyage</span>
                        <span class="note-tag">planning</span>
                        <span class="note-tag">aventure</span>
                    </div>
                    <div class="note-importance">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <span style="color: #666; margin-left: 5px;">(2/5)</span>
                    </div>
                </div>
            </div>
            
            <!-- Note 3 -->
            <div class="note-card">
                <div class="note-header">
                    <div class="note-title-section">
                        <h3>Notes PHP avancé</h3>
                        <div class="note-meta">
                            <span class="note-theme">Apprentissage</span>
                            <span class="note-date">
                                <i class="far fa-calendar"></i> 15 déc. 2024
                            </span>
                        </div>
                    </div>
                    <div class="note-actions">
                        <button class="btn-note-action" onclick="editNote(3)" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-note-action delete" onclick="deleteNote(3)" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="note-content">
                    Nouveautés PHP 8 : attributes, union types, match expression, nullsafe operator. 
                    Design patterns à étudier : repository, strategy, observer. Performance : opcode 
                    caching avec OPcache, profiling avec Blackfire.
                </div>
                
                <div class="note-footer">
                    <div class="note-tags">
                        <span class="note-tag">php</span>
                        <span class="note-tag">programmation</span>
                        <span class="note-tag">étude</span>
                    </div>
                    <div class="note-importance">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span style="color: #666; margin-left: 5px;">(5/5)</span>
                    </div>
                </div>
            </div>
            
            <!-- Note 4 -->
            <div class="note-card">
                <div class="note-header">
                    <div class="note-title-section">
                        <h3>Réflexions du matin</h3>
                        <div class="note-meta">
                            <span class="note-theme">Idées</span>
                            <span class="note-date">
                                <i class="far fa-calendar"></i> 12 déc. 2024
                            </span>
                        </div>
                    </div>
                    <div class="note-actions">
                        <button class="btn-note-action" onclick="editNote(4)" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-note-action delete" onclick="deleteNote(4)" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="note-content">
                    L'innovation vient souvent des connexions inattendues entre des idées 
                    apparemment sans rapport. Prendre le temps de réfléchir sans pression est 
                    essentiel pour la créativité. La méditation quotidienne aide à clarifier 
                    les pensées.
                </div>
                
                <div class="note-footer">
                    <div class="note-tags">
                        <span class="note-tag">réflexion</span>
                        <span class="note-tag">inspiration</span>
                        <span class="note-tag">créativité</span>
                    </div>
                    <div class="note-importance">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span style="color: #666; margin-left: 5px;">(4/5)</span>
                    </div>
                </div>
            </div>
            
            <!-- Ajouter d'autres notes ici... -->
        </div>
    </main>

    <!-- Modal de création de note -->
    <div class="modal-overlay" id="createModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-plus-circle"></i> Nouvelle note</h2>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <div class="form-group">
                        <label for="noteTitle">Titre *</label>
                        <input type="text" class="form-input" id="noteTitle" 
                               placeholder="Donnez un titre à votre note" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="noteTheme">Thème *</label>
                        <select class="form-input" id="noteTheme" required>
                            <option value="">Choisir un thème</option>
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
                            <div class="note-importance" id="importanceStars" style="cursor: pointer;">
                                <i class="far fa-star" data-value="1"></i>
                                <i class="far fa-star" data-value="2"></i>
                                <i class="far fa-star" data-value="3"></i>
                                <i class="far fa-star" data-value="4"></i>
                                <i class="far fa-star" data-value="5"></i>
                            </div>
                            <input type="hidden" id="importanceValue" value="3">
                            <span id="importanceText">Moyenne (3/5)</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="noteContent">Contenu *</label>
                        <textarea class="form-input form-textarea" id="noteContent" 
                                  placeholder="Saisissez le contenu de votre note..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="noteTags">Tags (optionnel)</label>
                        <input type="text" class="form-input" id="noteTags" 
                               placeholder="Séparés par des virgules (ex: travail, projet, important)">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-filter" onclick="closeModal()">
                    Annuler
                </button>
                <button class="btn-create" onclick="saveNote()">
                    <i class="fas fa-check"></i> Enregistrer
                </button>
            </div>
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

    <script>
        // Gestion des modals
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'flex';
            initStars('importanceStars', 'importanceValue', 'importanceText');
        }
        
        function openEditModal(noteId) {
            // Remplir les champs avec les données de la note
            document.getElementById('editNoteTitle').value = 'Titre de la note ' + noteId;
            document.getElementById('editNoteContent').value = 'Contenu de la note ' + noteId;
            
            document.getElementById('editModal').style.display = 'flex';
            initStars('editImportanceStars', 'editImportanceValue', 'editImportanceText');
        }
        
        function openDeleteModal(noteId) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('deleteModal').dataset.noteId = noteId;
        }
        
        function closeModal() {
            document.getElementById('createModal').style.display = 'none';
            document.getElementById('editModal').style.display = 'none';
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        // Fermer les modals en cliquant en dehors
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal-overlay');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
        
        // Gestion des étoiles d'importance
        function initStars(starsId, valueId, textId) {
            const stars = document.getElementById(starsId);
            const valueInput = document.getElementById(valueId);
            const text = document.getElementById(textId);
            
            const starElements = stars.querySelectorAll('.fa-star');
            
            starElements.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    valueInput.value = value;
                    
                    // Mettre à jour l'affichage
                    starElements.forEach((s, index) => {
                        if (index < value) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                    
                    // Mettre à jour le texte
                    const texts = [
                        'Très faible (1/5)',
                        'Faible (2/5)',
                        'Moyenne (3/5)',
                        'Importante (4/5)',
                        'Très importante (5/5)'
                    ];
                    text.textContent = texts[value - 1];
                });
            });
            
            // Initialiser à 3 étoiles
            if (!valueInput.value || valueInput.value < 1 || valueInput.value > 5) {
                starElements[2].click();
            } else {
                starElements[valueInput.value - 1].click();
            }
        }
        
        // Gestion des notes
        function saveNote() {
            const title = document.getElementById('noteTitle').value;
            const theme = document.getElementById('noteTheme').value;
            const content = document.getElementById('noteContent').value;
            
            if (!title || !theme || !content) {
                alert('Veuillez remplir tous les champs obligatoires');
                return;
            }
            
            // Simulation d'enregistrement
            alert('Note enregistrée avec succès !');
            closeModal();
            document.getElementById('noteForm').reset();
        }
        
        function editNote(noteId) {
            openEditModal(noteId);
        }
        
        function updateNote() {
            // Simulation de mise à jour
            alert('Note mise à jour avec succès !');
            closeModal();
        }
        
        function deleteNote(noteId) {
            openDeleteModal(noteId);
        }
        
        function confirmDelete() {
            const noteId = document.getElementById('deleteModal').dataset.noteId;
            // Simulation de suppression
            alert('Note ' + noteId + ' supprimée !');
            closeModal();
        }
        
        // Gestion des filtres
        function resetFilters() {
            document.getElementById('themeFilter').value = '';
            document.getElementById('importanceFilter').value = '';
            document.getElementById('searchFilter').value = '';
            alert('Filtres réinitialisés');
        }
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Fermer les modals avec la touche Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>