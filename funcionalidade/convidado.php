<?php

 require_once("../classes/convidado.php");
 require_once("../classes/conexao.php");
 
 //conexão com o banco de dados
 $conexao = new Conexao();
 
 //set dados no objeto classe para enviar para o método
 $convidado = new Convidado();
 
 // tratar se o e-mail for nulo
 $email = "";
 if(isset($_POST['email'])){
    if($_POST['email']!="" && $_POST['email']!=null){
        $email = $_POST['email'];
    }else{
        $email ="";
    }
 }
 
 //definir a data que foi adicionado o convidado
 date_default_timezone_set('America/Sao_Paulo');
 $date = date('Y-m-d');

 ///
 if(isset($_POST['outro'])){
     $outro = mysqli_real_escape_string($conexao->conectar(),$_POST['outro']);
 }else{
     $outro = false;
 }

  echo $outro;
  $convidado->setConvidou(mysqli_real_escape_string($conexao->conectar(),$_POST['membro'])); 
  $convidado->setConvidado1(mysqli_real_escape_string($conexao->conectar(),$_POST['convidado'])); 
  $convidado->setData(mysqli_real_escape_string($conexao->conectar(),$date)); 
  $convidado->setEmpresa(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa'])); 
  $convidado->setCpfecnpj(mysqli_real_escape_string($conexao->conectar(),$_POST['cpfecnpj'])); 
  $convidado->setTelefone(mysqli_real_escape_string($conexao->conectar(),$_POST['telefone'])); 
  $convidado->setCategoria(mysqli_real_escape_string($conexao->conectar(),$_POST['categoria']));
  $convidado->setEmail(mysqli_real_escape_string($conexao->conectar(),$email));
 
	
 
 //Inserir no banco de dados
 $resultado = $convidado->inserir($convidado,$outro);
 
 if($resultado==true){
     echo "<script>window.location.assign('../interface/convidado.php?resultado=success')</script>";
     //header('Location: ../interface/convidado.php?resultado=success');
 }

 
 
 
 ?>
