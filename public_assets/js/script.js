// Version simplifiée et robuste
document.addEventListener('DOMContentLoaded', function() {
    // Références aux éléments
    const elements = {
        themeForm: document.getElementById('themeForm'),
        btnAdd: document.getElementById('btn-add'),
        btnCancel: document.getElementById('btn-cancel'),
        themeFormElement: document.getElementById('themeFormElement'),
        formTitle: document.getElementById('formTitle'),
        submitText: document.getElementById('submitText'),
        themeId: document.getElementById('themeId'),
        themeName: document.getElementById('themeName'),
        themeColor: document.getElementById('themeColor'),
        themeTags: document.getElementById('themeTags'),
        formAction: document.getElementById('formAction'),
        colorPreview: document.getElementById('colorPreview')
    };

    // Initialisation
    function init() {
        // Vérifier que tous les éléments existent
        Object.values(elements).forEach(el => {
            if (!el && el !== null) {
                console.warn('Élément non trouvé:', el);
            }
        });

        // Configurer les événements
        setupEventListeners();
        
        // Initialiser l'aperçu de couleur
        updateColorPreview();
    }

    function setupEventListeners() {
        // Bouton Ajouter
        if (elements.btnAdd) {
            elements.btnAdd.addEventListener('click', function(e) {
                e.preventDefault();
                resetForm();
                openForm();
            });
        }

        // Bouton Annuler
        if (elements.btnCancel) {
            elements.btnCancel.addEventListener('click', function(e) {
                e.preventDefault();
                closeForm();
            });
        }

        // Boutons Modifier dans les cartes (event delegation)
        document.addEventListener('click', function(e) {
            const editBtn = e.target.closest('.btn-edit');
            if (editBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                
                    enableEditMode(editBtn);
                    openForm();
                
            }
        });

        // Changement de couleur
        if (elements.themeColor) {
            elements.themeColor.addEventListener('input', updateColorPreview);
        }

        // Validation du formulaire
        if (elements.themeFormElement) {
            elements.themeFormElement.addEventListener('submit', validateForm);
        }

        // Touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && elements.themeForm.classList.contains('active')) {
                closeForm();
            }
        });
    }

    function openForm() {
        elements.themeForm.classList.add('active');
        elements.themeForm.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        elements.themeName.focus();
    }

    function closeForm() {
        elements.themeForm.classList.remove('active');
        resetForm();
    }

    function resetForm() {
        elements.themeFormElement.classList.remove('edit-mode');
        elements.formTitle.textContent = 'Nouveau Thème';
        elements.submitText.textContent = 'Créer';
         elements.formAction.value = 'Créer';
        elements.themeId.value = '';
        elements.themeName.value = '';
        elements.themeColor.value = '#4CAF50';
        elements.themeTags.value = '';
        updateColorPreview();
    }

    function enableEditMode(card) {
        elements.themeFormElement.classList.add('edit-mode');
        elements.formTitle.textContent = 'Modifier le Theme';
        elements.submitText.textContent = 'Modifier';
        elements.formAction.value = 'Créer';
        elements.themeName.value=card.getAttribute("data-name"); 
        elements.themeColor.value=card.getAttribute("data-color"); 
        elements.themeTags.value=card.getAttribute("data-tags");
        updateColorPreview();
    }

    function updateColorPreview() {
        if (elements.colorPreview && elements.themeColor) {
            const color = elements.themeColor.value;
            elements.colorPreview.textContent = color.toUpperCase();
            elements.colorPreview.style.background = color + '20';
            elements.colorPreview.style.border = '2px solid ' + color;
            elements.colorPreview.style.color = getContrastColor(color);
        }
    }

    function getContrastColor(hexColor) {
        // Convertir hex en RGB
        const r = parseInt(hexColor.substr(1, 2), 16);
        const g = parseInt(hexColor.substr(3, 2), 16);
        const b = parseInt(hexColor.substr(5, 2), 16);
        
        // Calculer la luminance
        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        
        // Retourner noir ou blanc selon la luminance
        return luminance > 0.5 ? '#000000' : '#FFFFFF';
    }

    function validateForm(e) {
        if (!elements.themeName.value.trim()) {
            e.preventDefault();
            showError('Veuillez saisir un nom pour le thème');
            elements.themeName.focus();
            return false;
        }

        if (!elements.themeColor.value) {
            e.preventDefault();
            showError('Veuillez choisir une couleur');
            return false;
        }
        
        return true;
    }

    function showError(message) {
        // Créer une alerte temporaire
        const alertDiv = document.createElement('div');
        alertDiv.className = 'error-message';
        alertDiv.textContent = message;
        alertDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff4444;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Démarrer l'application
    init();
});
