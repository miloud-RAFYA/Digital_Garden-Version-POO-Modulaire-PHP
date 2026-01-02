<?php 
class Role{
    private $userRole;
    private User $user;
    public function __construct($user){
            $this->user=$user;
    }
    public function __get($name){
        return $this->$name;
    }
    public function setUserRole($userRole){
        $this->userRole=$userRole;
    }
    
}