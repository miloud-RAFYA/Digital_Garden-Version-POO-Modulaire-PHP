<?php
session_start();
require_once 'includes/header.php';
require_once 'src/Repository/ThemeRepository.php';
require_once 'src/Service/TeamService.php';
require_once 'src/Entity/Theme.php';

$user_Id = $_SESSION['user_id'];
$themeRepo = new ThemeRepository();
$themes = $themeRepo->getThemesByUser($user_Id);

$user_Id= $_SESSION['user_id'];

if (!$user_Id) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enregistrer']) ) {
    if($_POST['action']=="Créer"){
        
    try {    
        $nameTheme = $_POST['themeName'] ?? '';
        $themeColor = $_POST['themeColor'] ?? '';
        $themeTags = $_POST['themeTags'] ?? '';

        if (!empty($nameTheme) && !empty($themeColor)) {
               $theme = new Theme($nameTheme, $themeColor, $themeTags);
               $theme->setUser($user_Id);
               $themeRepo->isertTheme($theme);
            // header("Location: themes.php");
            // exit();
        } else {
            $_SESSION['error_message'] = "Veuillez remplir tous les champs obligatoires";
            header("Location: themes.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "erreur de conection post" . $e->getMessage();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $theme_id = $_POST["theme_id"] ?? 0;
    if ($theme_id > 0) {
        // Handle theme update logic here
        $_SESSION['success_message'] = 'Theme updated successfully';
        header('Location: themes.php');
        exit();
    }
}

// RÉCUPÉRATION DES THÈMES
// try {
//     $query = "SELECT * FROM themes WHERE user_id = ?";
//     $stmt = mysqli_prepare($cnx, $query);
//     mysqli_stmt_bind_param($stmt, "i", $user_Id);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);

// } catch (Exception $e) {
//     $result = false;
//     $_SESSION['error_message'] = "Erreur de connexion " . $e->getMessage();
// }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Thèmes | Digital Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public_assets\css\style.css">
    <style>
        /* Styles pour le mode édition */
    </style>
</head>

<body>
    <?php require_once 'includes/header.php'; ?>

    <main class="page">
        <div class="page-header">
            <h2><i class="fas fa-palette"></i> Mes Thèmes</h2>
            <button class="btn-add" id="btn-add">
                <i class="fas fa-plus"></i> Ajouter un thème
            </button>
        </div>

        <!-- Afficher les messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'ajout/modification -->
        <div class="form-container" id="themeForm">
            <h3><i class="fas fa-plus-circle"></i> <span id="formTitle">Nouveau Thème</span></h3>
            <form method="POST" action="themes.php" id="themeFormElement">
                <!-- Champ caché pour l'ID en mode édition -->
                <input type="hidden" id="themeId" name="theme_id" value="">
                <input type="hidden" id="formAction" name="action" value="create">

                <div class="form-group">
                    <label for="themeName">Nom du theme </label>
                    <input type="text" id="themeName" name="themeName" 
                        placeholder="Ex: Productivité, Voyage, Developpement..." required>
                </div>

                <div class="form-group">
                    <label for="themeColor">Couleur du theme </label>
                    <div class="color-picker-group">
                        <input type="color" id="themeColor" name="themeColor">

                        <div class="color-preview" id="colorPreview">#4CAF50</div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="enregistrer" class="btn-save" id="submitBtn">
                        <i class="fas fa-save"></i> <span id="submitText">Creer</span>
                        <?php unset($_POST["theme_id"])?>
                    </button>
                    <button type="button" class="btn-cancel" id="btn-cancel">
                        <?php unset($_POST["theme_id"])?>
                        Annuler
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des thèmes -->
        <div class="theme-list">
            <?php if ($themes): ?>
                <?php foreach ($themes as $theme): ?>
                    <div class="theme-card" style="--theme-color: <?= htmlspecialchars($theme['color']) ?>">
                        <div class="theme-header">
                            <div class="theme-color" style="background: <?= htmlspecialchars($theme['color']) ?>"></div>
                            <div class="theme-info">
                                <h3><?= htmlspecialchars($theme['name']) ?></h3>
                                <div class="theme-meta">
                                    <i class="fas fa-sticky-note"></i>
                                    <span>0 notes</span>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($theme['tags'])): ?>
                            <div class="theme-tags">
                                <?php
                                $tags = explode(',', $theme['tags']);
                                foreach ($tags as $tag):
                                    if (trim($tag)): ?>
                                        <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
                                    <?php endif;
                                endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="theme-actions">
                            <button class="btn btn-primary btn-edit" data-id="<?= $theme['id'] ?>" 
                                    data-name="<?= htmlspecialchars($theme['name']) ?>"
                                    data-color="<?= htmlspecialchars($theme['color']) ?>"
                                    data-tags="<?= htmlspecialchars($theme['tags']) ?>">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <button class="btn btn-secondary" onclick="deleteTheme(<?= $theme['id'] ?>)">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-palette"></i>
                    <p>Aucun thème pour le moment</p>
                    <p style="font-size: 14px; color: #999;">Cliquez sur "Ajouter un thème" pour commencer</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script src="public_assets/js/script.js"></script>
</body>
</html>
