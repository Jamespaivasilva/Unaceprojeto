<?php

// Arquivo criado para executar a ação de bloquar e desbloquear o usuário

require_once('../classes/membro.php');



 $membro = new Membro();
 
 if(isset($_GET['membroId']) && isset($_GET['acao'])){
     
     
      
     
// bloquear o membro
 if($_GET['acao']=="bloquear"){
     
 $resultado = $membro->bloquearMembro($_GET['membroId']);
 
 if($resultado){
     header('Location: ../interface/gerenciarmembros.php?resultado=success');
 }else{
     header('Location: ../interface/gerenciarmembros.php?resultado=fail');
 }
 //Desbloquear o membro
}else if($_GET['acao']=="desbloquear"){
    $resultado = $membro->desbloquearMembro($_GET['membroId']);
     
 if($resultado){
     header('Location: ../interface/gerenciarmembros.php?resultado=success');
 }else{
     header('Location: ../interface/gerenciarmembros.php?resultado=fail');
 }
}

}








?>