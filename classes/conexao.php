<?php

//Conexão com o banco

class Conexao{

 private $mysqli;
 
 
 function conectar(){
    $mysqli = new mysqli("","unace", "", "") or die ();
    
    $mysqli->set_charset('utf8');
    
    return $mysqli;
 }
 
      

  
  
  
  
}


?>
