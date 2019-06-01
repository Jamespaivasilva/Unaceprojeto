<?php


 require_once("../classes/empresagrupo.php");
 require_once("../classes/conexao.php");
 
 //conexão com o banco de dados
 $conexao = new Conexao();

 
 //set dados no objeto classe para enviar para o método
 $empresagrupo = new Empresagrupo();
 
 //verificar se o sub é nulo e trata-lo
 if(isset($_POST['sub'])){
 if($_POST['sub']!=null && $_POST['sub']!=""){
     $empresagrupo->setSubstituto(mysqli_real_escape_string($conexao->conectar(),$_POST['sub']));
}else{
$empresagrupo->setSubstituto(mysqli_real_escape_string($conexao->conectar(),0));
}
 }else{
     $empresagrupo->setSubstituto(mysqli_real_escape_string($conexao->conectar(),0));
 }


 $empresagrupo->setEmpresa(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa'])); 
 $empresagrupo->setGrupo(mysqli_real_escape_string($conexao->conectar(),$_POST['grupo']));
 $empresagrupo->setData(mysqli_real_escape_string($conexao->conectar(),$_POST['data'])); 
 $empresagrupo->setTitular(mysqli_real_escape_string($conexao->conectar(),$_POST['titular']));
 
 
 
 if($empresagrupo->verificarParticipacao($empresagrupo)==false){
     header('Location: ../interface/empresagrupo.php?resultado=fail');
 }else{
 
 //Inserir no banco de dados
 
 if($empresagrupo->inserir($empresagrupo)==true){
  header('Location: ../interface/empresagrupo.php?resultado=success');
 }
  
 }

 







?>
