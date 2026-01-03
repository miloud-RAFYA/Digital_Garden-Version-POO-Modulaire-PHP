<?php 

class User{
    private $id ;
    private $username ;
    private $fname ;
    private $password ;
    private $created_at ;
    private $Team =[];
    private role $role;
    public function __construct($username,$password){
            $this->username=$username;
            $this->password=$password;
    }

    public function __get($username){
        return $this->$username;
    }
    public function setFname($fname){
          $this->fname=$fname;
    }
    public function setRole($role){
          $this->role=$role;
    }
    public function setId($id){
          $this->id=$id;
    }
    public function setdate($date){
        $this->created_at=$date;
    }
    public  function addTeam($team){
        array_push($this->Team,$team);
    }
}