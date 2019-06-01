<?php


// API para mostrar os dados do membro

require_once('../classes/membro.php');
require_once('../classes/conexao.php');

 $membro = new Membro();
 $conexao = new Conexao();
 
 if(isset($_GET['membroId'])){
 echo $resultado = $membro->mostrarMembro(mysqli_real_escape_string($conexao->conectar(),$_GET['membroId']));
 
 
}




















?>
