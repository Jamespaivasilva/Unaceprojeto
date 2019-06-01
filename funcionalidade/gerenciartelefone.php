<?php

//Essa função é dedicada somente a realizar uma alteração de telefone, essa ação vem da página 'minhaconta'.



require_once('../classes/conexao.php');
require_once('../classes/membro.php');


$conexao = new Conexao();
$membro = new Membro();




if($_POST['acao']=="editar"){

$membro->setNumero2(mysqli_real_escape_string($conexao->conectar(),$_POST['num_tel']));
$membro->setDdd(mysqli_real_escape_string($conexao->conectar(),$_POST['ddd_tel']));
$membro->setTipo(mysqli_real_escape_string($conexao->conectar(),$_POST['tipo']));

if($membro->mudarTelefone(mysqli_real_escape_string($conexao->conectar(),$_POST['telefoneId']),$membro))
header('Location: ../interface/minhaconta.php?resultado=success');
else
header('Location: ../interface/minhaconta.php?resultado=fail');


}else if($_POST['acao']=="adicionar"){
    
 session_start();
 $id = $_SESSION['id'];
 
 $membro->setNumero2(mysqli_real_escape_string($conexao->conectar(),$_POST['numero']));
 $membro->setDdd(mysqli_real_escape_string($conexao->conectar(),$_POST['ddd']));
 $membro->setTipo(mysqli_real_escape_string($conexao->conectar(),$_POST['tipo']));
 
if($membro->adicionarTelefone($id,$membro))
header('Location: ../interface/minhaconta.php?resultado=success');
else
header('Location: ../interface/minhaconta.php?resultado=fail');
  
}else if($_POST['acao']=="excluir"){
if(isset($_POST['telefoneId'])){
if($membro->excluirTelefone(mysqli_real_escape_string($conexao->conectar(),$_POST['telefoneId'])))
header('Location: ../interface/minhaconta.php?resultado=success');
else
header('Location: ../interface/minhaconta.php?resultado=fail');  

}
    
}






?>