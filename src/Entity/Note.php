<?php 
class Note{
    private $id ;
    private $title ;
    private $importance ;
    private $content ;
    private $created_at ;
    private Theme $theme ;
    private User $user ;
    public function __construct($name,$color,$tags){
            $this->name=$name;
            $this->color=$color;
            $this->tags=$tags;
    }

    public function __get($name){
        return $this->$name;
    }
    public function setId($id){
        $this->id=$id;
    }
    
    public function setUser($user){
        $this->user=$user;
    }
    public function setTheme($user){
        $this->user=$user;
    }
}