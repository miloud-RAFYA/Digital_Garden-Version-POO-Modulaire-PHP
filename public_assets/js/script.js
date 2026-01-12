/* =========================================================
   THEMES + NOTES SCRIPT (FINAL VERSION)
========================================================= */

document.addEventListener("DOMContentLoaded", () => {

  /* =========================================================
     THEMES
  ========================================================= */

  const themeForm = document.getElementById("themeForm");
  const btnAdd = document.getElementById("btn-add");
  const btnCancel = document.getElementById("btn-cancel");

  const formTitle = document.getElementById("formTitle");
  const submitText = document.getElementById("submitText");
  const formAction = document.getElementById("formAction");

  const themeId = document.getElementById("themeId");
  const themeName = document.getElementById("themeName");
  const themeColor = document.getElementById("themeColor");
  const themeTags = document.getElementById("themeTags");
  const colorPreview = document.getElementById("colorPreview");

  /* =====================
     CREATE THEME
  ===================== */
  btnAdd?.addEventListener("click", e => {
    e.preventDefault();
    resetThemeForm();
    openThemeForm();
  });

  /* =====================
     CANCEL
  ===================== */
  btnCancel?.addEventListener("click", () => {
    closeThemeForm();
  });

  /* =====================
     EDIT THEME
  ===================== */
  document.addEventListener("click", e => {
    const btnEdit = e.target.closest(".btn-edit");
    if (!btnEdit) return;

    e.preventDefault();

    themeId.value = btnEdit.dataset.id;
    themeName.value = btnEdit.dataset.name;
    themeColor.value = btnEdit.dataset.color;
    themeTags.value = btnEdit.dataset.tags || "";

    formTitle.textContent = "Modifier le Thème";
    submitText.textContent = "Modifier";
    formAction.value = "update";

    updateColorPreview();
    openThemeForm();
  });

  /* =====================
     COLOR PREVIEW
  ===================== */
  themeColor?.addEventListener("input", updateColorPreview);

  function openThemeForm() {
    themeForm.classList.add("active");
    themeName.focus();
  }

  function closeThemeForm() {
    themeForm.classList.remove("active");
    resetThemeForm();
  }

  function resetThemeForm() {
    themeId.value = "";
    themeName.value = "";
    themeColor.value = "#4CAF50";
    themeTags.value = "";

    formTitle.textContent = "Nouveau Thème";
    submitText.textContent = "Créer";
    formAction.value = "create";

    updateColorPreview();
  }

  function updateColorPreview() {
    const color = themeColor.value;
    colorPreview.textContent = color.toUpperCase();
    colorPreview.style.background = `${color}20`;
    colorPreview.style.border = `2px solid ${color}`;
  }

  /* =========================================================
     NOTES
  ========================================================= */

  initStars("importanceStars", "importanceValue", "importanceText");
  initStars("editImportanceStars", "editImportanceValue", "editImportanceText");

});

/* =========================================================
   NOTES MODALS
========================================================= */

function openCreateModal() {
  const modal = document.getElementById("createModal");
  if (!modal) return;

  document.getElementById("createNoteForm").reset();
  document.getElementById("importanceValue").value = "3";

  initStars("importanceStars", "importanceValue", "importanceText");

  modal.style.display = "flex";
  document.getElementById("noteTitle").focus();
}

function editNote(id, title, content, themeId, importance) {
  const modal = document.getElementById("editModal");
  if (!modal) return;

  document.getElementById("editNoteId").value = id;
  document.getElementById("editNoteTitle").value = title;
  document.getElementById("editNoteContent").value = content;
  document.getElementById("editImportanceValue").value = importance;

  setTimeout(() => {
    document.getElementById("editNoteTheme").value = themeId;
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
   STAR RATING SYSTEM
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
    stars.forEach((star, i) => {
      star.classList.toggle("fas", i < value);
      star.classList.toggle("far", i >= value);
    });
    if (text) text.textContent = labels[value - 1];
  }

  updateStars(parseInt(input.value) || 3);

  stars.forEach((star, i) => {
    star.addEventListener("click", () => {
      input.value = i + 1;
      updateStars(i + 1);
    });
  });
}

/* =========================================================
   FORM VALIDATION
========================================================= */

document.getElementById("createNoteForm")?.addEventListener("submit", e => {
  if (!document.getElementById("noteTitle").value.trim()) {
    alert("Veuillez saisir un titre");
    e.preventDefault();
  }
});

document.getElementById("editNoteForm")?.addEventListener("submit", e => {
  if (!document.getElementById("editNoteTitle").value.trim()) {
    alert("Veuillez saisir un titre");
    e.preventDefault();
  }
});
