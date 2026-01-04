// Version corrigée du script
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
        colorPreview: document.getElementById('colorPreview'),
        submitBtn: document.getElementById('submitBtn')
    };
    
    // Variables d'état
    let isEditMode = false;
    let currentThemeId = null;
    
    // Initialisation
    function init() {
        console.log('Initialisation du script themes...');
        
        // Vérifier que les éléments essentiels existent
        const essentialElements = ['themeForm', 'btnAdd', 'themeFormElement', 'themeName', 'themeColor'];
        const missingElements = [];
        
        essentialElements.forEach(key => {
            if (!elements[key]) {
                missingElements.push(key);
            }
        });
        
        if (missingElements.length > 0) {
            console.error('Éléments essentiels manquants:', missingElements);
            return;
        }
        
        // Configurer les événements
        setupEventListeners();
        
        // Initialiser l'aperçu de couleur
        updateColorPreview();
        
        // Vérifier si on doit ouvrir le formulaire en mode édition (après rechargement POST)
        if (document.querySelector('.form-container.active')) {
            openForm();
        }
        
        console.log('Script themes initialisé avec succès');
    }

    function setupEventListeners() {
        // Bouton Ajouter
        elements.btnAdd.addEventListener('click', function(e) {
            e.preventDefault();
            resetForm();
            openForm();
        });

        // Bouton Annuler
        if (elements.btnCancel) {
            elements.btnCancel.addEventListener('click', function(e) {
                e.preventDefault();
                closeForm();
            });
        }

        // Boutons Modifier dans les cartes (event delegation)
        document.addEventListener('click', function(e) {
            // Gérer les clics sur les boutons "Modifier"
            const editBtn = e.target.closest('.btn-edit');
            if (editBtn && !editBtn.disabled) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Bouton Modifier cliqué', editBtn.dataset);
                
                // Récupérer les données du formulaire de bouton
                const form = editBtn.closest('form');
                if (form) {
                    const themeIdInput = form.querySelector('input[name="theme_id"]');
                    if (themeIdInput) {
                        currentThemeId = themeIdInput.value;
                        console.log('Theme ID récupéré:', currentThemeId);
                    }
                }
                
                // Activer le mode édition avec les données du bouton
                enableEditMode(editBtn);
                openForm();
            }
            
            // Gérer les soumissions de suppression
            const deleteBtn = e.target.closest('button[name="delete"]');
            if (deleteBtn) {
                const form = deleteBtn.closest('form');
                if (form) {
                    const confirmed = confirm('Voulez-vous vraiment supprimer ce thème ?');
                    if (!confirmed) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }
            }
        });

        // Changement de couleur
        elements.themeColor.addEventListener('input', updateColorPreview);

        // Validation du formulaire
        elements.themeFormElement.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            } else {
                // S'assurer que l'ID est bien défini en mode édition
                if (isEditMode && currentThemeId && elements.themeId) {
                    elements.themeId.value = currentThemeId;
                }
            }
        });

        // Touche Échap pour fermer le formulaire
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && elements.themeForm.classList.contains('active')) {
                closeForm();
            }
        });
    }

    function openForm() {
        console.log('Ouverture du formulaire');
        elements.themeForm.classList.add('active');
        
        // Scroll doux vers le formulaire
        elements.themeForm.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        
        // Focus sur le champ nom
        setTimeout(() => {
            elements.themeName.focus();
        }, 300);
    }

    function closeForm() {
        console.log('Fermeture du formulaire');
        elements.themeForm.classList.remove('active');
        resetForm();
    }

    function resetForm() {
        console.log('Réinitialisation du formulaire');
        
        isEditMode = false;
        currentThemeId = null;
        
        elements.themeFormElement.classList.remove('edit-mode');
        elements.formTitle.textContent = 'Nouveau Thème';
        elements.submitText.textContent = 'Créer';
        elements.formAction.value = 'Créer';
        
        if (elements.themeId) {
            elements.themeId.value = '';
        }
        
        elements.themeName.value = '';
        elements.themeColor.value = '#4CAF50';
        
        if (elements.themeTags) {
            elements.themeTags.value = '';
        }
        
        updateColorPreview();
    }

    function enableEditMode(editBtn) {
        console.log('Activation du mode édition', editBtn.dataset);
        
        isEditMode = true;
        elements.themeFormElement.classList.add('edit-mode');
        elements.formTitle.textContent = 'Modifier le Thème';
        elements.submitText.textContent = 'Modifier';
        elements.formAction.value = 'Modifier';
        
        // Récupérer les données des attributs data-
        const themeId = editBtn.dataset.id || '';
        const themeName = editBtn.dataset.name || '';
        const themeColor = editBtn.dataset.color || '#4CAF50';
        const themeTags = editBtn.dataset.tags || '';
        
        console.log('Données récupérées:', { themeId, themeName, themeColor, themeTags });
        
        // Mettre à jour les champs du formulaire
        if (elements.themeId) {
            elements.themeId.value = themeId;
        }
        
        elements.themeName.value = themeName;
        elements.themeColor.value = themeColor;
        
        if (elements.themeTags) {
            elements.themeTags.value = themeTags;
        }
        
        // Mettre à jour l'aperçu
        updateColorPreview();
    }

    function updateColorPreview() {
        if (!elements.colorPreview || !elements.themeColor) return;
        
        const color = elements.themeColor.value;
        
        // Vérifier que c'est une couleur hex valide
        if (!isValidHexColor(color)) {
            color = '#4CAF50'; // Valeur par défaut
        }
        
        // Mettre à jour le texte
        elements.colorPreview.textContent = color.toUpperCase();
        
        // Mettre à jour les styles
        elements.colorPreview.style.backgroundColor = `${color}20`; // 20 = 12.5% opacity
        elements.colorPreview.style.border = `2px solid ${color}`;
        elements.colorPreview.style.color = getContrastColor(color);
    }

    function isValidHexColor(color) {
        return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(color);
    }

    function getContrastColor(hexColor) {
        if (!hexColor || !hexColor.startsWith('#')) return '#000000';
        
        try {
            // Convertir hex en RGB
            let r, g, b;
            
            if (hexColor.length === 4) { // Format #RGB
                r = parseInt(hexColor[1] + hexColor[1], 16);
                g = parseInt(hexColor[2] + hexColor[2], 16);
                b = parseInt(hexColor[3] + hexColor[3], 16);
            } else if (hexColor.length === 7) { // Format #RRGGBB
                r = parseInt(hexColor.substr(1, 2), 16);
                g = parseInt(hexColor.substr(3, 2), 16);
                b = parseInt(hexColor.substr(5, 2), 16);
            } else {
                return '#000000';
            }
            
            // Calculer la luminance
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
            
            // Retourner noir ou blanc selon la luminance
            return luminance > 0.5 ? '#000000' : '#FFFFFF';
        } catch (error) {
            console.error('Erreur de conversion couleur:', error);
            return '#000000';
        }
    }

    function validateForm() {
        // Validation du nom
        if (!elements.themeName.value.trim()) {
            showError('Veuillez saisir un nom pour le thème');
            elements.themeName.focus();
            return false;
        }

        // Validation de la couleur
        if (!elements.themeColor.value || !isValidHexColor(elements.themeColor.value)) {
            showError('Veuillez choisir une couleur valide');
            elements.themeColor.focus();
            return false;
        }
        
        return true;
    }

    function showError(message) {
        // Supprimer les anciens messages d'erreur
        const existingErrors = document.querySelectorAll('.error-message');
        existingErrors.forEach(error => error.remove());
        
        // Créer une nouvelle alerte
        const alertDiv = document.createElement('div');
        alertDiv.className = 'error-message';
        alertDiv.textContent = message;
        
        // Styles
        alertDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff4444;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            animation: errorSlideIn 0.3s ease;
        `;
        
        // Ajouter l'animation CSS
        if (!document.querySelector('#error-animation-style')) {
            const style = document.createElement('style');
            style.id = 'error-animation-style';
            style.textContent = `
                @keyframes errorSlideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes errorFadeOut {
                    from {
                        opacity: 1;
                    }
                    to {
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(alertDiv);
        
        // Supprimer après 3 secondes
        setTimeout(() => {
            alertDiv.style.animation = 'errorFadeOut 0.3s ease';
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 300);
        }, 3000);
    }

    // Initialiser
    init();
});