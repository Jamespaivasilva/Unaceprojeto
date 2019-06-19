<?php


 require_once("../classes/grupo.php");
 require_once("../classes/conexao.php");
 
 //setar dados no objeto grupo e enviar ao método
 $grupo = new Grupo();
 //estabelecer conexão com o banco
 $conexao = new Conexao();

 $grupo->setNome(mysqli_real_escape_string($conexao->conectar(),$_POST['nome'])); 
 $grupo->setFundacao(mysqli_real_escape_string($conexao->conectar(),$_POST['fundacao'])); 
 
 
 
 //Inserir no banco de dados
 $resultado = $grupo->inserir($grupo);
 
 if($resultado==true){
     header('Location: ../interface/grupo.php?resultado=success');
 }




?>
