<?php


 require_once("../classes/categoria.php");
 require_once("../classes/conexao.php");
 
 //conexão com o banco de dados
 $conexao = new Conexao();
 
 //set dados no objeto classe para enviar para o método
 $categoria = new Categoria();

 $categoria->setPrimeira(mysqli_real_escape_string($conexao->conectar(),$_POST['pri_cat'])); 
 $categoria->setSegunda(mysqli_real_escape_string($conexao->conectar(),$_POST['sec_cat'])); 
 
 
 
 //Inserir no banco de dados
 $resultado = $categoria->inserir($categoria);
 
 if($resultado==true){
     header('Location: ../interface/categoria.php?resultado=success');
 }

 



























?>