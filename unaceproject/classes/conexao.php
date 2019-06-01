<?php

//Conexão com o banco

class Conexao{

 private $mysqli;
 
 
 function conectar(){
    $mysqli = new mysqli("35.199.110.234","unace", "james56118992", "u253536359_nuwe") or die ("deu erro");
    
    $mysqli->set_charset('utf8');
    
    return $mysqli;
 }
 
      

  
  
  
  
}


?>
