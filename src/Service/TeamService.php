<?php
require_once __DIR__ . '/../Repository/ThemeRepository.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../Entity/User.php';

class TeamService
{
    private $TeamRepository;


    public function __construct()
    {
        $this->TeamRepository = new ThemeRepository();
    }
    //    <?php  
    //     $count_query = "SELECT COUNT(*) FROM notes WHERE theme_id = ? AND user_id = ?";
    //     $count_stmt = mysqli_prepare($cnx, $count_query);
    //     mysqli_stmt_bind_param($count_stmt, "ii", $theme['id'], $user_Id);
    //     mysqli_stmt_execute($count_stmt);
    //     mysqli_stmt_bind_result($count_stmt, $note_count);
    //     mysqli_stmt_fetch($count_stmt);
    //     mysqli_stmt_close($count_stmt);
    //     echo $note_count . " note" . ($note_count > 1 ? 's' : '');
    //     
    public function updateTheme($theme){
         $this->TeamRepository->update($theme);
    }
    public function deleteTheme($themeId,$userId){
         if ($themeId > 0) {
            $this->TeamRepository->delete($themeId,$userId);
        } 
    }
    public function insertTheme($theme){
        
            $this->TeamRepository->Insert($theme);
        
    }
    
    public function displayTeam($user_id)
    {
        //  $user_id=$_SESSION['user_id'];
        $teams = $this->TeamRepository->SelectedTeams($user_id); ?>
        <?php if ($teams) { ?>
            <div class="theme-list">
                <?php if ($teams): ?>
                    <?php foreach ($teams as $theme): ?>

                        <div class="theme-card" style="--theme-color: <?= htmlspecialchars($theme['color']) ?>">
                            <div class="theme-header">
                                <form action="notes.php" method="POST">
                                    <input type="hidden" name="theme_id" value="<?= $theme['id'] ?>">
                                    <button type="submit" name="note" id="form-note">
                                        <div class="theme-color" style="background: <?= htmlspecialchars($theme['color']) ?>"></div>
                                    </button>
                                </form>
                                <style>
                                    #form-note {
                                        background-color: white !important;
                                        color: black;
                                        cursor: pointer;
                                        padding: 0;
                                        margin: 0;
                                    }
                                </style>
                                <div class="theme-info">
                                    <h3><?= htmlspecialchars($theme['name']) ?></h3>
                                    <div class="theme-meta">
                                        <i class="fas fa-sticky-note"></i>
                                        <span>

                                        </span>
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
                                <!-- Bouton Modifier -->
                                <form method="POST" action="" class="form-inline">
                                    <input type="hidden" name="theme_id" value="<?= $theme['id'] ?>">
                                    <button type="button"
                                        class="btn btn-primary btn-edit"
                                        data-id="<?= $theme['id'] ?>"
                                        data-name="<?= htmlspecialchars($theme['name']) ?>"
                                        data-color="<?= htmlspecialchars($theme['color']) ?>"
                                        data-tags="<?= htmlspecialchars($theme['tags']) ?>">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                </form>
                                <!-- Formulaire de suppression -->
                                <form method="POST" action="" class="form-inline"
                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce thème ?');">
                                    <input type="hidden" name="theme_id" value="<?= $theme['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-secondary">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php else : ?>
                    <div class="empty-state">
                        <i class="fas fa-palette"></i>
                        <p>Aucun thème pour le moment</p>
                        <p style="font-size: 14px; color: #999;">Cliquez sur "Ajouter un thème" pour commencer</p>
                    </div>
                <?php endif ?>

            </div>

<?php }
    }
}




?>