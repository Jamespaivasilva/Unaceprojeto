<?php



class Validar{
    
    
    
    
    
public function sessao(){
session_start();
 if(!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['senha']) || !isset($_SESSION['ip'])){
     header('Location: ../interface/login.php');
}
//if($_SERVER['REMOTE_ADDR']!=$_SESSION['ip']){
  //  header('Location: ../interface/login.php');
//}
    
}
    
    
    
    
}

















?>