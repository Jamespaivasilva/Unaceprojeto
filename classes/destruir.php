<?php

//Finalizar uma sessão
class Destruir{
    
public function avaliar(){
    
    session_start();
    
    if(isset($_SESSION['id']) && isset($_SESSION['email'])){
        session_destroy();
    }
    
}
    
    
    
}











?>