/*logic of notes :  */
<?php
require_once ".\src\Repository\NoteRepository.php";
class notesService {
    public $noteRepository;
    public function __construct (){
        $this->noteRepository = new NoteRepository();
    }
    public function createNote (){
        
    }
    
}