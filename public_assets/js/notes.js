// Notes Input Validation Module

// Modal management
function openCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
    initStars('importanceStars', 'importanceValue', 'importanceText');
}

function closeModal() {
    document.getElementById('createModal').style.display = 'none';
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('deleteModal').style.display = 'none';
}

// Stars management
function initStars(starsId, valueId, textId) {
    const stars = document.getElementById(starsId);
    const valueInput = document.getElementById(valueId);
    const text = document.getElementById(textId);
    
    const starElements = stars.querySelectorAll('.fa-star');
    
    starElements.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            valueInput.value = value;
            
            starElements.forEach((s, index) => {
                if (index < value) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
            
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
    
    if (!valueInput.value || valueInput.value < 1 || valueInput.value > 5) {
        starElements[2].click();
    } else {
        starElements[valueInput.value - 1].click();
    }
}

// Form validation functions
function validateTitle(title) {
    if (!title || title.trim().length === 0) {
        return 'Le titre est obligatoire';
    }
    if (title.trim().length < 3) {
        return 'Le titre doit contenir au moins 3 caractères';
    }
    if (title.trim().length > 100) {
        return 'Le titre ne peut pas dépasser 100 caractères';
    }
    return null;
}

function validateTheme(theme) {
    if (!theme || theme === '') {
        return 'Veuillez sélectionner un thème';
    }
    return null;
}

function validateContent(content) {
    if (!content || content.trim().length === 0) {
        return 'Le contenu est obligatoire';
    }
    if (content.trim().length < 10) {
        return 'Le contenu doit contenir au moins 10 caractères';
    }
    if (content.trim().length > 1000) {
        return 'Le contenu ne peut pas dépasser 1000 caractères';
    }
    return null;
}

// Main validation function
function validateNoteForm() {
    const title = document.getElementById('noteTitle').value;
    const theme = document.getElementById('noteTheme').value;
    const content = document.getElementById('noteContent').value;
    
    const titleError = validateTitle(title);
    if (titleError) {
        alert(titleError);
        document.getElementById('noteTitle').focus();
        return false;
    }
    
    const themeError = validateTheme(theme);
    if (themeError) {
        alert(themeError);
        document.getElementById('noteTheme').focus();
        return false;
    }
    
    const contentError = validateContent(content);
    if (contentError) {
        alert(contentError);
        document.getElementById('noteContent').focus();
        return false;
    }
    
    return true;
}

// Submit form after validation
function submitNoteForm() {
    if (validateNoteForm()) {
        // Add the saveNote parameter before submitting
        const form = document.getElementById('noteForm');
        const saveNoteInput = document.createElement('input');
        saveNoteInput.type = 'hidden';
        saveNoteInput.name = 'saveNote';
        saveNoteInput.value = '1';
        form.appendChild(saveNoteInput);
        
        form.submit();
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Form submission validation
    const noteForm = document.getElementById('noteForm');
    if (noteForm) {
        noteForm.addEventListener('submit', function(e) {
            if (!validateNoteForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    
    // Close modals by clicking outside
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
});