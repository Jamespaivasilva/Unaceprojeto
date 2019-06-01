<?php

require_once("../classes/caracara.php");
require_once("../classes/conexao.php");

$caracara =  new Caracara();
$conexao = new Conexao();

$quem = $_POST['quem'];

$query = mysqli_query($conexao->conectar(),"SELECT * FROM membros where cod_membro='$quem'");
 
 $sql = mysqli_fetch_array($query);
 
 $empresa = $sql['cod_membro_empresa'];

$caracara->setQuem(mysqli_real_escape_string($conexao->conectar(),$_POST['quem']));
$caracara->setConversa(mysqli_real_escape_string($conexao->conectar(),$_POST['conversa']));
$caracara->setData(mysqli_real_escape_string($conexao->conectar(),$_POST['data']));
//$caracara->setEmpresa(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa']));
//$caracara->setBairro(mysqli_real_escape_string($conexao->conectar(),$_POST['bairro']));
//$caracara->setRua(mysqli_real_escape_string($conexao->conectar(),$_POST['rua']));
//$caracara->setCep(mysqli_real_escape_string($conexao->conectar(),$_POST['cep']));
//$caracara->setNumero(mysqli_real_escape_string($conexao->conectar(),$_POST['numero']));
//$caracara->setCidade(mysqli_real_escape_string($conexao->conectar(),$_POST['cidade']));
//$caracara->setEstado(mysqli_real_escape_string($conexao->conectar(),$_POST['estado']));
//$caracara->setComplemento(mysqli_real_escape_string($conexao->conectar(),$_POST['complemento']));
$caracara->setIniciou(mysqli_real_escape_string($conexao->conectar(),$_POST['registrou']));
$caracara->setEndereco1(mysqli_real_escape_string($conexao->conectar(),$_POST['endereco']));
$caracara->setEmpresa(mysqli_real_escape_string($conexao->conectar(),$empresa));



$resultado = $caracara->inserir($caracara);

if($resultado){
     echo "<script>window.location.assign('../interface/caracara.php?resultado=success')</script>";
    // echo "<script>../interface/caracara.php?resultado=success)</script>";
  //header('Location: ../interface/caracara.php?resultado=success');
}




?>