<?php
    
//Essa função é dedicada somente a realizar uma alteração de e-mail, essa ação vem da página 'minhaconta'.



require_once('../classes/conexao.php');
require_once('../classes/membro.php');


$conexao = new Conexao();
$membro = new Membro();





if($_POST['acao']=="editar"){

if($membro->mudarEmail(mysqli_real_escape_string($conexao->conectar(),$_POST['emailId']),mysqli_real_escape_string($conexao->conectar(),$_POST['email'])))
header('Location: ../interface/minhaconta.php?resultado=success');
else
header('Location: ../interface/minhaconta.php?resultado=fail');


}else if($_POST['acao']=="adicionar"){
    session_start();
 $id = $_SESSION['id'];
if(isset($_POST['email'])){
if($membro->adicionarEmail($id,mysqli_real_escape_string($conexao->conectar(),$_POST['email'])))
header('Location: ../interface/minhaconta.php?resultado=success');
else
header('Location: ../interface/minhaconta.php?resultado=fail');
}    
}else if($_POST['acao']=="excluir"){
if(isset($_POST['emailCod'])){
if($membro->excluirEmail(mysqli_real_escape_string($conexao->conectar(),$_POST['emailCod'])))
header('Location: ../interface/minhaconta.php?resultado=success');
else
header('Location: ../interface/minhaconta.php?resultado=fail');  

}
    
}






?>