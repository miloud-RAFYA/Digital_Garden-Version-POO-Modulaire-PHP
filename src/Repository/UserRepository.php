<?php
class UserRepository{
    
    private $pdo;
    
    public function __construct(){
        $this->pdo=new Database()->getConnection();
       
    }
     
    public function createUser (User $user,$psdconfig){
        $resultat = $this->pdo->query("select * from users where username='$user->name'");
    if (!$resultat) {
        if ($psdconfig == $user->password) {
            $password = password_hash($user->password, PASSWORD_DEFAULT);
            $stmt= $this->pdo->prepare("INSERT INTO users(username,password,fName) VALUES ('$$user->name','$password','$$user->fname')");
            $stmt->execute();
            header("location: login.php");
            exit();
        }
    }else{
         
    }
    }

}