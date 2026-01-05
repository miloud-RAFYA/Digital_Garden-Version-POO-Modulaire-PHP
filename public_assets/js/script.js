/* =========================================================
   THEMES + NOTES SCRIPT (VERSION CORRIGÉE ET STABLE)
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

  /* =========================
     RÉFÉRENCES THEMES
  ========================= */

  const elements = {
    themeForm: document.getElementById("themeForm"),
    btnAdd: document.getElementById("btn-add"),
    btnCancel: document.getElementById("btn-cancel"),
    themeFormElement: document.getElementById("themeFormElement"),
    formTitle: document.getElementById("formTitle"),
    submitText: document.getElementById("submitText"),
    themeId: document.getElementById("themeId"),
    themeName: document.getElementById("themeName"),
    themeColor: document.getElementById("themeColor"),
    themeTags: document.getElementById("themeTags"),
    formAction: document.getElementById("formAction"),
    colorPreview: document.getElementById("colorPreview"),
  };

  let isEditMode = false;
  let currentThemeId = null;

  /* =========================
     INIT THEMES
  ========================= */

  function initThemes() {
    if (!elements.themeForm) return;

    setupThemeEvents();
    updateColorPreview();

    if (document.querySelector(".form-container.active")) {
      openThemeForm();
    }
  }

  function setupThemeEvents() {

    if (elements.btnAdd) {
      elements.btnAdd.addEventListener("click", e => {
        e.preventDefault();
        resetThemeForm();
        openThemeForm();
      });
    }

    if (elements.btnCancel) {
      elements.btnCancel.addEventListener("click", e => {
        e.preventDefault();
        closeThemeForm();
      });
    }

    document.addEventListener("click", function (e) {

      const editBtn = e.target.closest(".btn-edit");
      if (editBtn) {
        e.preventDefault();
        enableEditMode(editBtn);
        openThemeForm();
      }

      const deleteBtn = e.target.closest('button[name="delete"]');
      if (deleteBtn) {
        if (!confirm("Voulez-vous supprimer ce thème ?")) {
          e.preventDefault();
        }
      }
    });

    if (elements.themeColor) {
      elements.themeColor.addEventListener("input", updateColorPreview);
    }

    if (elements.themeFormElement) {
      elements.themeFormElement.addEventListener("submit", function (e) {
        if (!validateThemeForm()) {
          e.preventDefault();
        }
      });
    }
  }

  function openThemeForm() {
    elements.themeForm.classList.add("active");
    elements.themeName?.focus();
  }

  function closeThemeForm() {
    elements.themeForm.classList.remove("active");
    resetThemeForm();
  }

  function resetThemeForm() {
    isEditMode = false;
    currentThemeId = null;

    elements.formTitle.textContent = "Nouveau Thème";
    elements.submitText.textContent = "Créer";
    elements.formAction.value = "Créer";

    elements.themeId.value = "";
    elements.themeName.value = "";
    elements.themeColor.value = "#4CAF50";
    elements.themeTags.value = "";

    updateColorPreview();
  }

  function enableEditMode(btn) {
    isEditMode = true;

    elements.formTitle.textContent = "Modifier le Thème";
    elements.submitText.textContent = "Modifier";
    elements.formAction.value = "Modifier";

    elements.themeId.value = btn.dataset.id;
    elements.themeName.value = btn.dataset.name;
    elements.themeColor.value = btn.dataset.color;
    elements.themeTags.value = btn.dataset.tags;

    updateColorPreview();
  }

  function updateColorPreview() {
    if (!elements.colorPreview || !elements.themeColor) return;

    const color = elements.themeColor.value;
    elements.colorPreview.textContent = color.toUpperCase();
    elements.colorPreview.style.background = `${color}20`;
    elements.colorPreview.style.border = `2px solid ${color}`;
  }

  function validateThemeForm() {
    if (!elements.themeName.value.trim()) {
      alert("Nom du thème requis");
      return false;
    }
    return true;
  }

  initThemes();
});

/* =========================================================
   NOTES SCRIPT (VERSION COMPLÈTE ET FONCTIONNELLE)
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    // Initialiser les étoiles pour les modals
    initStars("importanceStars", "importanceValue", "importanceText");
    initStars("editImportanceStars", "editImportanceValue", "editImportanceText");
});

/* =========================================================
   FONCTIONS DE GESTION DES NOTES
========================================================= */

function openCreateModal() {
    const modal = document.getElementById("createModal");
    if (modal) {
      
        document.getElementById("createNoteForm").reset();
        document.getElementById("importanceValue").value = "3";
        
        
        initStars("importanceStars", "importanceValue", "importanceText");
        
       
        modal.style.display = "flex";
        
       
        document.getElementById("noteTitle").focus();
    }
}

function editNote(noteId, title, content, themeId, importance) {
    const modal = document.getElementById("editModal");
    if (!modal) return;

    document.getElementById("editNoteId").value = noteId;
    document.getElementById("editNoteTitle").value = title;
    document.getElementById("editNoteContent").value = content;
    document.getElementById("editImportanceValue").value = importance;

    setTimeout(() => {
        const themeSelect = document.getElementById("editNoteTheme");
        if (themeSelect) {
            themeSelect.value = themeId;
        }
    }, 100);
  
    initStars("editImportanceStars", "editImportanceValue", "editImportanceText");

    modal.style.display = "flex";
}

function confirmDelete(noteId) {
    const modal = document.getElementById("deleteModal");
    if (!modal) return;
    
    document.getElementById("deleteNoteId").value = noteId;
    modal.style.display = "flex";
}

function closeModal() {
    document.querySelectorAll(".modal-overlay").forEach(m => {
        m.style.display = "none";
    });
}

window.addEventListener("click", e => {
    if (e.target.classList.contains("modal-overlay")) {
        closeModal();
    }
});

document.addEventListener("keydown", e => {
    if (e.key === "Escape") {
        closeModal();
    }
});

/* =========================================================
   SYSTÈME D'ÉTOILES POUR L'IMPORTANCE
========================================================= */
function initStars(starsId, valueId, textId) {
    const container = document.getElementById(starsId);
    const input = document.getElementById(valueId);
    const text = document.getElementById(textId);
    
    if (!container || !input) return;
    
    const stars = container.querySelectorAll(".fa-star");
    const labels = [
        "Très faible (1/5)",
        "Faible (2/5)",
        "Moyenne (3/5)",
        "Importante (4/5)",
        "Très importante (5/5)"
    ];
    
    function updateStars(value) {
        stars.forEach((star, index) => {
            star.classList.toggle("fas", index < value);
            star.classList.toggle("far", index >= value);
        });
        
        if (text) {
            text.textContent = labels[value - 1] || labels[2];
        }
    }
    
    const currentValue = parseInt(input.value) || 3;
    updateStars(currentValue);
    
    stars.forEach((star, index) => {
        star.addEventListener("click", () => {
            const value = index + 1;
            input.value = value;
            updateStars(value);
        });
        
        star.addEventListener("mouseover", () => {
            stars.forEach((s, i) => {
                s.classList.toggle("fas", i <= index);
                s.classList.toggle("far", i > index);
                s.style.color = i <= index ? "#FF9800" : "#ccc";
            });
        });
        
        star.addEventListener("mouseout", () => {
            updateStars(parseInt(input.value));
            stars.forEach(s => s.style.color = "");
        });
    });
}



/*
   VALIDATION DES FORMULAIRES
========================================================= */
document.getElementById("createNoteForm")?.addEventListener("submit", function(e) {
    const title = document.getElementById("noteTitle").value.trim();
    const theme = document.getElementById("noteTheme").value;
    const content = document.getElementById("noteContent").value.trim();
    
    if (!title) {
        alert("Veuillez saisir un titre pour la note");
        e.preventDefault();
        return;
    }
    
    if (!theme) {
        alert("Veuillez sélectionner un thème");
        e.preventDefault();
        return;
    }
    
    if (!content) {
        alert("Veuillez saisir le contenu de la note");
        e.preventDefault();
        return;
    }
    
});

document.getElementById("editNoteForm")?.addEventListener("submit", function(e) {
    const title = document.getElementById("editNoteTitle").value.trim();
    const theme = document.getElementById("editNoteTheme").value;
    const content = document.getElementById("editNoteContent").value.trim();
    
    if (!title) {
        alert("Veuillez saisir un titre pour la note");
        e.preventDefault();
        return;
    }
    
    if (!theme) {
        alert("Veuillez sélectionner un thème");
        e.preventDefault();
        return;
    }
    
    if (!content) {
        alert("Veuillez saisir le contenu de la note");
        e.preventDefault();
        return;
    }
});