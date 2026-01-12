<?php
session_start();
// require_once 'includes/auth.php';
require_once '../includes/header.php';
require_once '../src/Repository/ThemeRepository.php';
require_once '../src/Service/TeamService.php';
require_once '../src/Entity/Theme.php';

// $themes=$display->displayThemes($user_Id);
$teamSer = new TeamService();

$userId = $_SESSION['user_id'];

if (!$userId) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enregistrer'])) {
    if ($_POST['action'] == "Créer") {

        try {
            $nameTheme = $_POST['themeName'] ?? '';
            $themeColor = $_POST['themeColor'] ?? '';
            $themeTags = $_POST['themeTags'] ?? '';

            if (!empty($nameTheme) && !empty($themeColor)) {
                $theme = new Theme($nameTheme, $themeColor, $themeTags);
                $theme->setUser($userId);
                $teamSer->insertTheme($theme);
                header("Location: themes.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Veuillez remplir tous les champs obligatoires";
                header("Location: themes.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "erreur de conection post" . $e->getMessage();
        }
    } elseif ($_POST['action'] == 'Modifier') {

        $id = $_POST['theme_id'];
        $name = $_POST['themeName'];
        $color = $_POST['themeColor'];
        $tags = $_POST['themeTags'];
        $theme=new Theme($name, $color, $tags);
        $theme->setId($id);
        $theme->setUser($userId);
        $teamSer->updateTheme($theme);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $themeId = $_POST["theme_id"] ?? 0;
    $teamSer->deleteTheme($themeId,$userId);
}

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
    <?php require_once '../includes/header.php'; ?>

    <main class="page">
        <div class="page-header">
            <div>
                <h1><i class="fas fa-layer-group"></i> Mes Thèmes</h1>
                <p class="page-description">Gérez et organisez vos thèmes</p>
            </div>
            <div class="main-actions">
                <button class="btn-add" id="btn-add">
                    <i class="fas fa-plus"></i> Ajouter un thème
                </button>
            </div>
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

                <div class="form-group">
                    <label for="themeTags">Tags (optionnel)</label>
                    <input type="text" id="themeTags" name="themeTags" placeholder="Séparés par des virgules">

                    <small class="form-text">Ex: travail,projet,important</small>
                </div>

                <div class="form-actions">
                    <button type="submit" name="enregistrer" class="btn-save" id="submitBtn">
                        <i class="fas fa-save"></i> <span id="submitText">Creer</span>
                        <?php unset($_POST["theme_id"]) ?>
                    </button>
                    <button type="button" class="btn-cancel" id="btn-cancel">
                        <?php unset($_POST["theme_id"]) ?>
                        Annuler
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des thèmes -->
        <?php $teamSer->displayTeam($userId); ?>

    </main>
    <script src="../public_assets/js/script.js"></script>
    <?php
    require_once '../includes/footer.php';
    ?>
</body>

</html>