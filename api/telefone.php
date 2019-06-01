<?php


require_once('../classes/conexao.php');
require_once('../classes/membro.php');

$conexao = new Conexao();
$membro =  new Membro();



if(isset($_GET['telefoneId'])){
 echo $membro->mostrarTelefone(mysqli_real_escape_string($conexao->conectar(),$_GET['telefoneId']));    
}else{
    echo "Não encontramos os dados solictados pelo o id";
}





















?>