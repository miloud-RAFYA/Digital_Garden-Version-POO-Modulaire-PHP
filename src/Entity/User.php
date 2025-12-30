<?php 
class User{
    private $id ;
    private $username ;
    private $fname ;
    private $password ;
    private $created_at ;
    public function __construct($fname,$username,$password){
            $this->fname=$fname;
            $this->username=$username;
            $this->password=$password;
    }

    public function __get($name){
        return $this->$name;
    }
    public function setId($id){
        $this->id=$id;
    }
    
    public function setdate($date){
        $this->created_at=$date;
    }
}