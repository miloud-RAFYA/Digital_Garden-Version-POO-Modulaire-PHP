<?php 
class Role{
    private $userRole ;
    private User $user ;
    public function __construct($user){
            $this->user=$user;
    }

    public function __get($name){
        return $this->$name;
    }
    public function setId($id){
        $this->id=$id;
    }
    
}